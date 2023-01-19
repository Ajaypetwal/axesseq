<?php

use App\Models\pushNotification; 
 
  function sendPushNotification ($request,$userId,$type,$title,$Desription,$device_token,$viewedUserId = '')
 {  

   //$device_token="cYX6mZDIRlaZy44d8TQj2L:APA91bHsujAOcdwd1t_VW0e4xxbsel337p80ewZU_LMeRa-B2knRFR0VenbzaDDG8l188OKkN_uZman_LvqZmXdcCUS9iVsuki3Y1m-ywZQRt19q7-lgIvrdFvFETVwODQXDSmLF1lOZ";
   
     $SERVER_API_KEY = 'AAAAsfWDpA4:APA91bGBldnQHWPfMU2x6bsKunMHBhDhD8Vl7f9zGrhDmsLpaQ3MwCLArLY838KTVRfYZm907s9m0LCYczkq1Fwbg8JAWeJqZ0htZjWdMvPm_Nu5kYlJx2UVg8t5e4aS0P9MqR-J7x1c'; 
      
    
     $data = [
      "registration_ids"=>[$device_token],
      
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

    // dd($dataString);
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
 
     $response = json_decode(curl_exec($ch),true); 
     //dd ($response);
     
     if($response['success']==1)
     { 
        Log::info('notification sent' . $device_token); 
        $followerNotification = pushNotification::create([
         'user_id' => $userId,
         'type' =>  isset($type) ? $type : '', 
         'title' =>  isset($title) ? $title : '', 
         'description' =>  isset($Desription) ? $Desription : '',
         'viewedUserId' =>  isset($viewedUserId) ? $viewedUserId : '', 
         ]);
       
     }
     else
     {
        Log::info('notification not sent' . $device_token);
     }
 }
 
 
?>