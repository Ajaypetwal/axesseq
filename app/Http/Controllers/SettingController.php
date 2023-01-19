<?php

namespace App\Http\Controllers;
use App\Models\{User,Setting}; 
use Exception;
use Illuminate\Http\Request;
use App\Models\Follow;
use App\Models\pushNotification;
use App\Models\User_Subscription;
use App\Models\Subscription;
use Carbon\Carbon;
class SettingController extends Controller
{
   public function get_user_data(Request $request){ 
     $user=$request->user();
     $currentUserID= $user->_id;
    // $device_token = $user->device_token; 
     $userName = $user->name; 
     $userID = $request->user_id;  
   
    try { 
           $followers= Follow::where('follower_id',$userID)->count();  
          $following = Follow::where('user_id',$userID)->count();   
          $followerData = Follow::where('follower_id',$userID)->where('user_id',$currentUserID)->first(); 
          if ($followerData) {  
           $follow=true; 
        } else{
            $follow=false;   
        }  
      $data = User::with('work_info','userinfo','companyinfo','certificates','privacy_setting')->where ('_id',$userID)->first();  
      $push_notification_data = pushNotification::where('user_id','=',$userID)->where('type',"profileView")
                                                  ->where('viewedUserId',$currentUserID)
                                                    ->where('created_at', '>=', Carbon::now()->subDay())
                                                   ->first();
    
      if (($data)) {
            $requestedUserData = User::where('_id',$userID)->first(); 
            $device_token= $requestedUserData->device_token;
            $type="profileView";
            $title="Profile viewed";
            $Desription= $userName .' '. "viewed your profile recently";
            $data['followers'] = $followers;    
            $data['following'] = $following;    
            $data['is_followed'] = $follow;  

            if(empty($push_notification_data)){
                $sendNotification = sendPushNotification($request,$userID,$type,$title,$Desription,$device_token,$currentUserID);
            }  
            return response()->json(['success' => true, 'code' => 200,'message' => 'User data' , 'data' => $data], 200);
      }
      return response()->json(['success' => false, 'code' => 404, 'message' => 'No data found', ], 404);
    
  }
  catch(Exception $e) {
      return response()->json(['success' => false, 'code' => 404, 'message' => $e->getMessage()], 404);
  }  
   }

   public function update_privacy_setting(Request $request){ 
    try {  
        $user = $request->user(); 
        $userRole = $user->role;
        $userId = $user->_id;   

        $support = Setting::updateOrCreate([
            'user_id' => $userId,
        ],[
            'user_id'=>$userId,
            'name' => $request->name,
            'address' => $request->address,
            'started_date' => $request->started_date,
            'email_address' => $request->email_address,
            'phone_number' => $request->phone_number,
            'work_experience' => $request->work_experience,
            'certificates' => $request->certificates,
            'about_me' => $request->about_me 
        ]); 
        if ($support) {
            return response()->json(['success' => true, 'code' => 200, 'message' => 'User status', 'data' => $support], 200);
        } 
  }
  catch(Exception $e) {
      return response()->json(['success' => false, 'code' => 404, 'message' => $e->getMessage()], 404);
  } 

   }

   public function get_user_pricay_data(Request $request){ 
    try {  
        $user = $request->user();
        $userId = $user->_id;   
        $getuser = $request->user_id;
        
      $data = Setting::where('user_id','=',$userId)->first();  

        if (($data)) {
            return response()->json(['success' => true, 'code' => 200, 'message' => 'User status', 'data' => $data], 200);
        }  
            return response()->json(['success' => false, 'code' => 404, 'message' => 'User not found', 'data' => ''], 200);
        
  }
  catch(Exception $e) {
      return response()->json(['success' => false, 'code' => 404, 'message' => $e->getMessage()], 404);
  } 

   }

   public function get_notification(Request $request){ 
    try {  
        $user = $request->user();
        $userId = $user->_id;  
        
        $getSubscriptionOrNot = pushNotification::with('user:image')->where('user_id','=',$userId)->whereNotIn('type',['profileView'])->get();  
        if ($getSubscriptionOrNot) {     
            return response()->json(['success' => true, 'code' => 200, 'message' => 'User notifications', 'data' => $getSubscriptionOrNot], 200);
         }  
            return response()->json(['success' => false, 'code' => 404, 'message' => 'User notifications do not exist', 'data' => ''], 200); 
  }
  catch(Exception $e) {
      return response()->json(['success' => false, 'code' => 404, 'message' => $e->getMessage()], 404);
  }  
   }

   public function profile_view_notifications(Request $request){

    $notificationArr = [];

    try { 
        $user = $request->user();
        $userId = $user->_id;   
        $getSubscriptionOrNot = User_Subscription::where('user_id','=',$userId)->first();  
     
        if(isset($getSubscriptionOrNot) && !empty($getSubscriptionOrNot)){
            if(!empty($getSubscriptionOrNot->subscription_id)){
                    $getsubsPlan = Subscription::where('_id', $getSubscriptionOrNot->subscription_id)->first(); 
                    $subsdATA = $getsubsPlan->type; 
                }
        } 

    
            $notificationList = pushNotification::where('user_id','=',$userId)->where('type',"profileView")->whereNotNull('viewedUserId')->get();   
            if($notificationList){
                foreach($notificationList as $lst){
                    $notificationArr[] = array(
                        "_id" => $lst->_id,
                        "user_id" => $lst->user_id,
                        "type" => $lst->type,
                        "title" => $lst->title,
                        "description" => $lst->description,
                        "user" => User::findOrFail($lst->viewedUserId),
                        "plan" => isset($subsdATA) ? $subsdATA : '' .' Member', 
                        "updated_at" => $lst->updated_at,
                        "created_at" => $lst->created_at
                    );
                }
                return response()->json(['success' => true, 'code' => 200, 'message' => 'User notifications', 'data' => $notificationArr], 200);
            }
            
    }
            // return response()->json(['success' => false, 'code' => 404, 'message' => 'User notifications do not exist', 'data' => ''], 200);
        
  
  catch(Exception $e) {
      return response()->json(['success' => false, 'code' => 404, 'message' => $e->getMessage()], 404);
  }  
   }


   public function termConditions(Request $request){ 
    try {  
        $user = $request->user(); 
        $termsConditions = TermsCondition::all();  
        if ($termsConditions) {     
            return response()->json(['success' => true, 'code' => 200, 'message' => 'Terms & Conditions', 'data' => $termsConditions], 200);
         }  
            return response()->json(['success' => false, 'code' => 404, 'message' => 'Do not exist', 'data' => ''], 200); 
  }
  catch(Exception $e) {
      return response()->json(['success' => false, 'code' => 404, 'message' => $e->getMessage()], 404);
  }  
   }

   public function faq(Request $request){ 
    try {  
        $user = $request->user(); 
        $faq = Faq::all();  
        if ($faq) {     
            return response()->json(['success' => true, 'code' => 200, 'message' => 'FAQS', 'data' => $faq], 200);
         }  
            return response()->json(['success' => false, 'code' => 404, 'message' => 'Do not exist', 'data' => ''], 200); 
  }
  catch(Exception $e) {
      return response()->json(['success' => false, 'code' => 404, 'message' => $e->getMessage()], 404);
  }  
   }


   public function privacyPolicy(Request $request){ 
    try {  
        $user = $request->user(); 
        $privacyPolicy = PrivacyPolicy::all();   
        if ($privacyPolicy) {     
            return response()->json(['success' => true, 'code' => 200, 'message' => 'Privacy Polocy', 'data' => $privacyPolicy], 200);
         }  
            return response()->json(['success' => false, 'code' => 404, 'message' => 'Do not exist', 'data' => ''], 200); 
  }
  catch(Exception $e) {
      return response()->json(['success' => false, 'code' => 404, 'message' => $e->getMessage()], 404);
  }  
   }

}