<?php

namespace App\Traits;
use App\Models\{UserStore,User};

trait SendNotificationFcm
{
	//sendnotification("Device_ID","Test Notification","Test Message","https://www.google.co.in/images/branding/googleg/1x/googleg_standard_color_128dp.png",array("ID"=>1));
    public function sendNotification($store_id,$title,$body,$image){

        $user_ids = UserStore::where('store_id',$store_id)
            ->pluck('user_id');
     	
        $firebaseTokens = User::whereIn('id',$user_ids)
            ->whereRaw('device_token IS NOT NULL')
            ->pluck('device_token');
          
        $SERVER_API_KEY = env('FIREBASE_SERVER_API_KEY');
  
        $data = [
            "registration_ids" => $firebaseTokens,
            "notification" => [
                "title" => $title,
                "body" => $body,
                "image" => $image 
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
               
        return $response = curl_exec($ch);
  
    }
}		
