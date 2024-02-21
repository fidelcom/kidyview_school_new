<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class FireBase {

    public function notify($fcmToken, $title, $body, $message = '', $device = null) {
        //
        $path_to_firebase_cm = 'https://fcm.googleapis.com/fcm/send';
        $fields = array(
            'to' => $fcmToken,
            'notification' => array(
                'title' => $title,
                'body' => $body,
                "sound" => "default"
            ),
            'data' => $message
        );

         $headers = array(
            'Authorization:key=AIzaSyCEB4qP7nzFFsiGdvf2IBsZ-QytRLgw1T4',
            'Content-Type:application/json'
        );  



        $ch = curl_init();

        curl_setopt($ch, CURLOPT_URL, $path_to_firebase_cm);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_IPRESOLVE, CURL_IPRESOLVE_V4);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($fields));
        curl_setopt($ch, CURLOPT_ENCODING, 'gzip');

        $result = curl_exec($ch);

        curl_close($ch);

        return $result;
    }

    

}
