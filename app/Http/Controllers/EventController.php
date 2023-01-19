<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\Event;
use App\Models\User;
use App\Models\Job;
use App\Models\Role;
use App\Models\User\CreateEvent;
use App\Models\Follow;
use App\Models\Applyevent;
use Carbon\Carbon;
use DB;
use DateTime;
use App\Models\pushNotification;

class EventController extends Controller
{
    public function createevent(Request $request)
    {
    $validator = Validator::make($request->all(), [

        'event_title' => 'required',
        'company_logo' => 'required',
        'job_description' => 'required',
        'attendees' => 'required',
        'date' => 'required',
        'address' =>'required', 
       
    ]);

    if ($validator->fails()) {
        return response()->json([
            'success' => false,
            'code' => 404,
            'message' => $validator->errors(),
        ], 404);
    }
 
    try { 

        $user = $request->user(); 
         $userID = $user->_id; 
         $userName = $user->name;
       if( $user->role == 'Organization' || $user->role == 'Recruiter' )
       {
        $eventTime= Carbon::parse($request->date)->format('Y-m-d H:i');
        $event = Event::create([
            'user_id'=>$user->id,
            'role' => isset($user->role) ? $user->role : '',
            'event_title' => isset($request->event_title) ? $request->event_title : '',
            'company_logo' => isset($request->company_logo) ? $request->company_logo : '',
            'job_description' => isset($request->job_description) ? $request->job_description : '',
            'attendees' => isset($request->attendees) ? $request->attendees : '',
            'date' => isset($eventTime) ? $eventTime : '',
            'address' => isset($request->address) ? $request->address : '', 
        ]);
       
        if ($event) {  
             $userFollowID = Follow::where('follower_id',$userID)->pluck('user_id')->toArray();
             if($userFollowID)
             {
               foreach($userFollowID as $foid){
                     $userDeviceToken = User::where('_id',$foid)->value('device_token');
                     if($userDeviceToken)
                     {
            
                         $userID = $foid; 
                         $device_token= $userDeviceToken; 
                         $type="eventCreatedbyFollowed";
                         $title="Event created by followed person";
                         $Desription=  "Event created by " .$userName;
                         $sendNotification = sendPushNotification($request,$userID,$type,$title,$Desription, $device_token);
                     } 
               }   
             }

            return response()->json([
                'success' => true,
                'code' => 200,
                'message' => 'Event created successfully',
                'data' => $event
            ], 200);
         }else {
            return response()->json([
                'success' => false,
                'code' => 404,
                'message' => 'There is an issue while creating the event',
            ], 404);
        }
    }
    else{

        return response()->json([
            'success' => false,
            'code' => 404,
            'message' => 'Role not authorized to create event',
        ], 404);

    
    } } catch (Exception $e) {
        return response()->json([
            'success' => false,
            'code' => 404,
            'message' => $e->get_Message(),
        ], 404);
    }
}


public function event_delete(Request $request){  
    

    $lastDayDate= Carbon::now()->subDays(1)->format('Y-m-d H:i');
    return  $getOldRecord = Event::whereDate('date','<=',$lastDayDate)->delete(); 
}

public function event_start(Request $request){ 

    $eventDate=  Carbon::now()->format('Y-m-d H:i');
    $eventStartDate = Event::whereDate('date', '<=', $eventDate)->get();

    if($eventStartDate) { 
        foreach($eventStartDate as $Data)
        {  
            $userID=  $Data->user_id; 
            $userName= User::where('_id',$userID)->value('name'); 
            $device_token= User::where('_id',$userID)->value('device_token');  
            $type="eventStart";
            $title="Event is going to start";
            $Desription=  "Event is going to start " .$userName;
            $sendNotification = $this->sendEventNotification($request,$userID,$type,$title,$Desription, $device_token);

        } 
    }     
    }
    public function event_start_fifteen_before(Request $request){ 

        $dateFifteenMinsBefore=  Carbon::now()->subMinute(15)->format('Y-m-d H:i');
        $eventStartDate = Event::whereDate('date', '<=', $dateFifteenMinsBefore)->get();
    
        if($eventStartDate) { 
            foreach($eventStartDate as $Data)
            {  
                $userID=  $Data->user_id; 
                $userName= User::where('_id',$userID)->value('name'); 
                $device_token= User::where('_id',$userID)->value('device_token');  
                $type="eventStart";
                $title="Event is going to start";
                $Desription=  "Event is going to start " .$userName;
                $sendNotification = $this->sendEventNotification($request,$userID,$type,$title,$Desription, $device_token);
    
            } 
        }     
        }


function sendEventNotification ($request,$userId,$type,$title,$Desription,$device_token)
{ 
    
    $SERVER_API_KEY = 'AAAA39y8o54:APA91bFjwHKf_vKoueVd8uERUL7juG4GnB966-ZxIzeYNRYDOaGAve1n347MNLBaMcroh0MrpimIO27hcpFhWSgg_L0QJ72Hk3Hbdy2m0oFMgs-8gOuf8Yqkke1lap7Ij8BnjJrjq3wE';
    
    $followerNotification = pushNotification::create([
        'user_id' => $userId,
        'type' =>  isset($type) ? $type : '', 
        'title' =>  isset($title) ? $title : '', 
        'description' =>  isset($Desription) ? $Desription : '', 
        ]);    
    //$notificationImage = '<img src="' . url("images/notification.svg") . '" alt="Image"/>'; 
    $data = [
        "to" =>$device_token, 
         "priority"  => "high",
         "collapse_key" => "type_a",
         "notification" =>
             [
                "body" => $Desription,
                 "title" => $title
             ],
             "data" =>
             [
                "body" => $Desription,
                 "title" => $title
             ] 
     ];
    $dataString = json_encode($data);

    $headers = [
         'Authorization: key=' . $SERVER_API_KEY,
        'Content-Type: application/json',
    ];

    $ch = curl_init();

    curl_setopt($ch, CURLOPT_URL, 'https://fcm.googleapis.com/fcm/send');
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $dataString);

    $response = curl_exec($ch);
  
   // dd($response);
}

public function job_one_year(Request $request){  
    $lastOneYear = Job::where('created_at','<=',Carbon::now()->subdays(365))->get(['name','created_at','user_id']); 

    foreach($lastOneYear as $lastOneYear){   
         $userID= $lastOneYear["user_id"]; 
           
         $User= User::where('_id',$userID)->get();
         foreach($User as $userData){   
        $device_token= $userData->device_token;
        $userName = $userData->name;
        $type="job has completed one year";
        $title="job has completed one year";
        $Desription= $userName . " has completed one year"; 
         
       $sendNotification = $this->sendJobNotification($request,$userID,$type,$title,$Desription,$device_token);
    } }
     }
function sendJobNotification ($request,$userID,$type,$title,$Desription,$device_token)
{  
    $SERVER_API_KEY = 'AAAA39y8o54:APA91bFjwHKf_vKoueVd8uERUL7juG4GnB966-ZxIzeYNRYDOaGAve1n347MNLBaMcroh0MrpimIO27hcpFhWSgg_L0QJ72Hk3Hbdy2m0oFMgs-8gOuf8Yqkke1lap7Ij8BnjJrjq3wE';
    
    $followerNotification = pushNotification::create([
        'user_id' => $userID,
        'type' =>  isset($type) ? $type : '', 
        'title' =>  isset($title) ? $title : '', 
        'description' =>  isset($Desription) ? $Desription : '', 
        ]);    
    //$notificationImage = '<img src="' . url("images/notification.svg") . '" alt="Image"/>'; 
    $data = [
        "to" =>$device_token, 
         "priority"  => "high",
         "collapse_key" => "type_a",
         "notification" =>
             [
                "body" => $Desription,
                 "title" => $title
             ],
             "data" =>
             [
                "body" => $Desription,
                 "title" => $title
             ] 
     ];
    $dataString = json_encode($data);

    $headers = [
         'Authorization: key=' . $SERVER_API_KEY,
        'Content-Type: application/json',
    ];

    $ch = curl_init();

    curl_setopt($ch, CURLOPT_URL, 'https://fcm.googleapis.com/fcm/send');
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $dataString);

    $response = curl_exec($ch);
  
   // dd($response);
}

public function get_all_events(Request $request)
{ 
    $user = $request->user(); 
    $userID = $user->_id; 
    $geteventsArr = []; 
    try  {  
      $getevents = Event::orderBy('_id', 'DESC')->get();
    if($getevents){
        foreach($getevents as $lst){ 
         $eventApplied= Applyevent::where('user_id',$userID)->where('event_id',$lst->_id)->first();
            $geteventsArr[] = array(
                "_id" => $lst->_id,
                "user_id" => $lst->user_id,
                "role" => $lst->role,
                "event_title" => $lst->event_title,
                "company_logo" => $lst->company_logo,
                "job_description" => $lst->job_description,
                "attendees" => $lst->attendees,
                "date" => $lst->date,
                "address" => $lst->address,
                "applyEvent" => isset($eventApplied) ? true : false,
                "updated_at" => $lst->updated_at,
                "created_at" => $lst->created_at
            );
        } 
        return response()->json([
            'success' => true,
            'code' => 200,
            'message' => 'Events',
            'data' =>  $geteventsArr  
        ], 200); 
   
    } else {
        return response()->json([
            'success' => false,
            'code' => 404,
            'message' => 'There is an issue while fetching the events',
        ], 404);
    }
} 
catch (Exception $e) {
return response()->json([
    'success' =>  false,
    'code' => 404, 
    'message' => $e->getMessage()
],404);
}
}

public function event(Request $request,$id)
   {    
      
            $eventID = Event::where('_id','=', $id)->first(); 
            // return $JobID;
            try
            { 
            if(($eventID))
            {
            return response()->json(['success'=>true,'code' => 200,'data'=>$eventID,'message' => 'Event Description']); 

            }
            else
            {
            return response()->json(['success'=>false,'data'=>'','message' => 'Event not found','code' => 404]);
            }  

            }

            catch (Exception $e) {
            return response()->json([
                'success' =>  false,
                'code' => 404, 
                'message' => 'Something went wrong'
            ],404);
            }

            
}

public function eventApply(Request $request)
   {      
    $validator = Validator::make($request->all(), [
        'event_id' => 'required',
    ]);

    if ($validator->fails()) {
        return response()->json([
            'success' => false,
            'code' => 404,
            'message' => $validator->errors(),
        ], 404);
    }

            try
            { 
                $user = $request->user();
                $userID = $user->id;
                $userName = $user->name;
              
            $eventExist = Applyevent::where('event_id',$request->event_id)->first(); 
            if(($eventExist))
            {
            return response()->json(['success'=>false,'code' => 200,'data'=>$eventExist,'message' => 'Already applied to event']);  
            }
            else
            {
                $applyEvent= Applyevent::create([
                    'user_id' => $userID, 
                    'event_id' => isset($request->event_id) ? $request->event_id : '',  
                ]);  

                if( $applyEvent)
               { 
                 $eventAppliedUser = Event::where('_id',$request->event_id)->pluck('user_id')->toArray();
                 if($eventAppliedUser)
                 {
                   foreach($eventAppliedUser as $eoid){
                         $userDeviceToken = User::where('_id',$eoid)->value('device_token');
                         if($userDeviceToken)
                         { 
                             $userID= $eoid; 
                             $device_token= $userDeviceToken; 
                             $type="applyEvent";
                             $title="User has apply event";
                             $Desription= $userName . " has applied for Event";
                             $sendNotification = sendPushNotification($request,$userID,$type,$title,$Desription, $device_token);
                         } 
                   }   
                 } 
                return response()->json(['success'=>true,'code' => 200,'data'=>$applyEvent,'message' => 'applied to Event']); 
            }  
            } 
            }
            catch (Exception $e) {
            return response()->json([
                'success' =>  false,
                'code' => 404, 
                'message' => $e->getMessage()
            ],404);
            } 
}


public function search_event(Request $request)
   {    

    $validator = Validator::make($request->all(), [ 
        'event_title' => 'required', 
    ]); 
    if ($validator->fails()) {
        return response()->json([
            'success' => false,
            'code' => 404,
            'message' => $validator->errors(),
        ], 404);
    } 
    try {    
        $event_title= $request->event_title;
     
        
            $eventpost = Event::where('event_title', 'like', '%' . $event_title . '%') 
            ->get(); 
            // return $JobID;
          
            if(count($eventpost) >=1)
            {
            return response()->json(['success'=>true,'code' => 200,'data'=>$eventpost,'message' => 'Searched Results']); 

            }
            else
            {
            return response()->json(['success'=>false,'data'=>'','message' => 'Event not found','code' => 404]);
            }  
        }
            catch (Exception $e) {
            return response()->json([
                'success' =>  false,
                'code' => 404, 
                'message' => 'Something went wrong'
            ],404);
            } 
}

public function user_create_events(Request $request)
{
    $validator = Validator::make($request->all(), [

        'event_title' => 'required',
        'company_logo' => 'required',
        'job_description' => 'required',
        'attendees' => 'required',
        'date' => 'required',
        'address' =>'required', 
    ]);

    if ($validator->fails()) {
        return response()->json([
            'success' => false,
            'code' => 404,
            'message' => $validator->errors(),
        ], 404);
    }
 
    try { 

        $user = $request->user(); 

       if( $user->role == 'Organization' || $user->role == 'Recruiter' )
       {

        $userevent= Event::create([
             'user_id'=>$user->id,
            'role' => isset($user->role) ? $user->role : '',
            'event_title' => isset($request->event_title) ? $request->event_title : '',
            'company_logo' => isset($request->company_logo) ? $request->company_logo : '',
            'job_description' => isset($request->job_description) ? $request->job_description : '',
            'attendees' => isset($request->attendees) ? $request->attendees : '',
            'date' => isset($request->date) ? $request->date : '',
            'address' => isset($request->address) ? $request->address : '',
           
        ]);
     
        if ($userevent) {
            return response()->json([
                'success' => true,
                'code' => 200,
                'message' => 'Event created successfully',
                'data' => $userevent
            ], 200);
        } else {
            return response()->json([
                'success' => false,
                'code' => 404,
                'message' => 'There is an issue while creating the event',
            ], 404);
        }
    }
    else{

        return response()->json([
            'success' => false,
            'code' => 404,
            'message' => 'Role not authorized to create event',
        ], 404);

    }
    } catch (Exception $e) {
        return response()->json([
            'success' => false,
            'code' => 404,
            'message' => $e,
        ], 404);
    }
}

public function get_user_events(Request $request){

    $user = $request->user();    
    $userID= $user->id;
   // return $userID;
     $usergetallevents = Event::where('user_id',$userID)->get();
    
    if (($usergetallevents)) {
     return response()->json([
         'success' => true,
         'code' => 200,
         'message' => 'Fetch User Events',
         'data' => $usergetallevents
     ], 200);
 } else {
     return response()->json([
         'success' => false,
         'code' => 404,
         'message' => 'No event found',
     ], 404);
 }

}

public function hide_user_events(Request $request){

    $validator = Validator::make($request->all(), [ 
        'user_id' => 'required', 
    ]); 
    if ($validator->fails()) {
        return response()->json([
            'success' => false,
            'code' => 404,
            'message' => $validator->errors(),
        ], 404);
    } 
    try {    
        $userID= $request->user_id;
        $is_hide= $request->is_hide;

        $userid = Event::where('_id',$userID)->first();
            if((!$userid))
            {
                return response()->json([
                    'success' => false,
                    'code' => 404, 
                    'message' => 'User ID is not valid',
                ], 404);
            }  

     if ($userid) {
            $userid->is_hide = $is_hide;
            $userid->save();
            $userid->fresh();
        }   
        if($is_hide==0)
        {
        return response()->json(['success' => true, 'code' => 200, 'data' => $is_hide, 'message' => 'Event post has been enabled']);
        }
        if($is_hide==1)
        {
        return response()->json(['success' => true, 'code' => 200, 'data' => $is_hide, 'message' => 'Event post has been disabled']);
        }
            } 
            catch (Exception $e) {
            return response()->json([
                'success' =>  false,
                'code' => 404, 
                'message' => 'Something went wrong'
            ],404);
            }

}
public function deleteEvent(Request $request) {
    $validator = Validator::make($request->all(), ['event_id' => 'required']);
    if ($validator->fails()) {
        return response()->json(['success' => false, 'code' => 404, 'message' => $validator->errors(), ], 404);
    }
    try {
        $user = $request->user(); 
        $userID= $user->_id;
        if ($user->role == 'Organization' || $user->role == 'Recruiter') {
           
            $delete =  Event::where('_id', $request->event_id)->where('user_id',$userID)->delete();
            if($delete){
                return response()->json(['success' => true, 'code' => 200, 'message' => 'Event deleted successfully', 'data' => $delete], 200);
        } else{
            return response()->json(['success' => false, 'code' => 404, 'message' =>'Error occured'], 404);
        }
    }
         else {
            return response()->json(['success' => false, 'code' => 404, 'message' => 'Role not authorized to delete event', ], 404);
        }
    }
    catch(Exception $e) {
        return response()->json(['success' => false, 'code' => 404, 'message' => $e->get_Message() ], 404);
    }
}


}
