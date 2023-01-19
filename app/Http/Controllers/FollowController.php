<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use App\Models\Follow; 
use App\Models\User; 
use App\Models\pushNotification; 


class FollowController extends Controller
{
   public function Follower(Request $request){

      $validator = Validator::make($request->all(), [  
         'follower_id' => 'required', 
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
            $followerID= $request->follower_id;  
            $userName = $user->name; 
            $followerUser = Follow::where('follower_id',$followerID)->first();
            if(!empty($followerUser)){
                return response()->json([
                    'success' => false,
                    'code' => 200,
                    'message' => 'user already followed ',
                    'data' => $followerUser,
                ], 200);
                // return "user already follow!";

            }else {
                    $follower = Follow::create([
                    'user_id' => $userId,
                    'follower_id' =>  isset($followerID) ? $followerID : '', 
                    ]);     
        
                    if ($follower) {  
                        $followUserData = User::where('_id',$followerID)->first(); 
                        $viewedUserId =$followerID; 
                        $device_token=$followUserData->device_token;
            
                        $type="Follow";
                        $title="You have been followed";
                        $Desription="You have been followed by ".$userName;
            
                        //send push notification
                        $sendNotification = sendPushNotification($request,$viewedUserId,$type,$title,$Desription,$device_token,$viewedUserId);
                    
                        return response()->json([
                            'success' => true,
                            'code' => 200,
                            'message' => 'Successfully followed',
                            'data' => $follower
                        ], 200);
                    }else {
                            return response()->json([
                                'success' => false,
                                'code' => 404,
                                'message' => 'There is an issue while follow the user',
                                 ], 404);
                           }
                }
        } catch (Exception $e) {
                return response()->json([
                'success' => false,
                'code' => 404,
                'message' => $e->getMessage(),
                 ], 404);
       }
   }


   
   public function unfollow(Request $request){

    
    $validator = Validator::make($request->all(), [  
       'follower_id' => 'required', 
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
      $followID= $request->follower_id;
      $unfollowUser = Follow::where('follower_id',$followID)->delete();
      
      if ($unfollowUser) {
        return response()->json([
            'success' => true,
            'code' => 200,
            'message' => 'Successfully unfollowed',
            'data' => ''
        ], 200);
    } else {
        return response()->json([
            'success' => false,
            'code' => 404,
            'message' => 'There is an issue while unfollow the user',
        ], 404);
    } 
   }
   catch (Exception $e) {
    return response()->json([
        'success' => false,
        'code' => 404,
        'message' => $e->getMessage(),
    ], 404);
}
}


public function testNotification(Request $request){

return $sendNotification = sendPushNotification(1,'632d67190826dc71db03eade','follow','Testing new notification','Working or not','c2XEmmWLSj6JecEtTeEaKy:APA91bHH_ajdoTa3UNc6Q1ORN4465u-XHhqWYkfbf5EH9lhoxMDVTkVnsqfEBqPz7jV1vfaaTP3FMIGdL5PNnA-9Rd-Z6dlggYYoiYfwoHEeqIMmAgcQQ6aWBtN2tQyFE-eic2l2pfzm');

}
}
