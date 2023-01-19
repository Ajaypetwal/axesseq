<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use App\Models\Messages;
use App\Models\User;
use Carbon\Carbon;

class MessagesController extends Controller
{
   public function scheduleInterview(Request $request)
   {
    $validator = Validator::make($request->all(), [
        'interviewUserID' => 'required'
        
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
        $userId = $user->_id;
       
         $interviewScheduleData = Messages::create([
            'user_id' => $userId,
            'startTime' =>isset($request->startTime) ? $request->startTime : '',
            'interviewUserID' =>isset($request->interviewUserID) ? $request->interviewUserID : '',
            'endTime' =>isset($request->endTime) ? $request->endTime : '',
            'date' =>isset($request->date) ? $request->date : '',
            'note' =>isset($request->note) ? $request->note : '',
            'timezone' =>isset($request->timezone) ? $request->timezone : '',
            
        ]); 
        if ($interviewScheduleData) {  

            $getUserData = User::where('_id',$request->interviewUserID)->first();  
            $userName= $getUserData->name;
            $device_token=$getUserData->device_token;
            $interviewUserID=$getUserData->interviewUserID;
            $type="successfullyApplied";
            $title="You have successfully applied";
            $Desription="You have successfully applied ".$userName;
            $sendNotification = sendPushNotification($request,$userId,$type,$title,$Desription,$device_token,$request->interviewUserID);

            return response()->json([
                'success' => true,
                'code' => 200,
                'message' => 'Interview schedule successfully',
                'data' => $interviewScheduleData
            ], 200); 

        } else {
            return response()->json([
                'success' => false,
                'code' => 404,
                'message' => 'There is an issue while schedule interivew',
            ], 404);
        }
    } catch (Exception $e) {
        return response()->json([
            'success' => false,
            'code' => 404,
            'message' => $e->getMessage(),
        ], 404);
    }
   }
   
   public function interview_start_fifteen_before(Request $request){ 

       $dateFifteenMinsBefore=  Carbon::now()->format('Y-m-d');
       $dateFifteenTimeBefore=  Carbon::now()->subMinute(15)->format('H:i');
      // $dateTime= $dateFifteenMinsBefore . ' '  .$dateFifteenTimeBefore;
       $interviewStartDate = Messages::whereDate('date', '<=', $dateFifteenMinsBefore)->get(); 
       $interviewStartTime = Messages::whereTime('startTime', '<=', $dateFifteenTimeBefore)->get(); 

        $dateTimeGet= $interviewStartDate . ' '  .$interviewStartTime;
       if($interviewStartDate) { 
        foreach($interviewStartDate as $Data)
        {  
            $userID=  $Data->user_id; 
            $userName= User::where('_id',$userID)->value('name'); 
            $device_token= User::where('_id',$userID)->value('device_token');  
            $type="15minutestoStartInterview";
            $title="Interview is going to start within 15 minutes";
            $Desription=  "Interview is going to start " .$userName;
            $sendNotification = sendEventNotification($request,$userID,$type,$title,$Desription, $device_token);

        } 
    }     
    }


   public function getScheduledInterviews(Request $request){ 
    try {  
        $user = $request->user();
         $userId = $user->_id; 
         $getScheduledInterviewArr =[]; 
        $todayDate=  Carbon::now()->format('Y-m-d');
       
           $getScheduledInterview =  Messages::where('user_id','=',$userId)->where('date','>=', $todayDate)->get();  
        //       foreach($getScheduledInterview as $getInterview)
        //       {
        //         $getInerviewID=  $getInterview->interviewUserID;
        //       }
        //   $getUserInfo =  User::where('_id','=',$getInerviewID)->first(); 

          if($getScheduledInterview){
            foreach($getScheduledInterview as $lst){
                $getScheduledInterviewArr[] = array(
                    "_id" => $lst->_id,
                    "user_id" => $lst->user_id,
                    "startTime" => $lst->startTime,
                    "interviewUserID" => $lst->interviewUserID,
                    "endTime" => $lst->endTime, 
                    "date" => $lst->date,
                    "note" => $lst->note,
                    "timezone" =>$lst->timezone,
                    "updated_at" => $lst->updated_at,
                    "created_at" => $lst->created_at,
                    "userinfo" => User::findOrFail($lst->interviewUserID),
                );
            } 
        }
        if (($getScheduledInterviewArr)) {
            return response()->json(['success' => true, 'code' => 200, 'message' => 'Scheduled Interview Data', 'data' => $getScheduledInterviewArr], 200);
        }  
            return response()->json(['success' => false, 'code' => 404, 'message' => 'Data not found', 'data' => ''], 200);
        
  }
  catch(Exception $e) {
      return response()->json(['success' => false, 'code' => 404, 'message' => $e->getMessage()], 404);
  } 

   }

   public function deleteInterview(Request $request) {
    $validator = Validator::make($request->all(), ['interview_id' => 'required']);
    if ($validator->fails()) {
        return response()->json(['success' => false, 'code' => 404, 'message' => $validator->errors(), ], 404);
    }
    
    try {
        $user = $request->user(); 
        $userID= $user->_id;
        if ($user->role == 'Organization' || $user->role == 'Recruiter') {
           
            $delete =  Messages::where('_id', $request->interview_id)->where('user_id',$userID)->delete();
            if($delete){
                return response()->json(['success' => true, 'code' => 200, 'message' => 'Interview deleted successfully', 'data' => $delete], 200);
        } else{
            return response()->json(['success' => false, 'code' => 404, 'message' =>'Error occured'], 404);
        }
    }
         else {
            return response()->json(['success' => false, 'code' => 404, 'message' => 'Role not authorized to delete interview', ], 404);
        }
    }
    catch(Exception $e) {
        return response()->json(['success' => false, 'code' => 404, 'message' => $e->get_Message() ], 404);
    }
}


}
