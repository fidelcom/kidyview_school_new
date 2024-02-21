<?php
defined('BASEPATH') or exit('No direct script access allowed');

/**
 * FCM simple server side implementation in PHP
 *
 * @author Abhishek
 */
class Fcm
{

    /** @var string     push message title */
    private $title;

    /** @var string     message */
    private $message;
    
    /** @var string     URL String */
    private $image;

    /** @var array     Custom payload */
    private $data;

    /**
     * flag indicating whether to show the push notification or not
     * this flag will be useful when perform some opertation
     * in background when push is recevied
     */

    /** @var bool     set background or not */
    private $is_background;

    /**
     * Function to set the title
     *
     * @param string    $title  The title of the push message
     */
    public function setTitle($title)
    {
        $this->title = $title;
    }

    /**
     * Function to set the message
     *
     * @param string    $message    Message
     */
    public function setMessage($message)
    {
        $this->message = $message;
    }

    /**
     * Function to set the image (optional)
     *
     * @param string    $imageUrl    URI string of image
     */
    public function setImage($imageUrl)
    {
        $this->image = $imageUrl;
    }

    /**
     * Function to set the custom payload (optional)
     *
     * eg:
     *      $payload = array('user' => 'user1');
     *
     * @param array    $data    Custom data array
     */
    public function setPayload($data)
    {
        $this->data = $data;
    }

    /**
     * Function to specify if is set background (optional)
     *
     * @param bool    $is_background
     */
    public function setIsBackground($is_background)
    {
        $this->is_background = $is_background;
    }

    /**
     * Generating the push message array
     *
     * @return array  array of the push notification data to be send
     */
    public function getPush()
    {
        $res = array();
        $res['data']['title']      = $this->title;
        //$res['data']['is_background'] = $this->is_background;
        $res['data']['body']       = $this->message;
        $res['data']['sound']      = "default";
        // $res['data']['image']   = $this->image;
        // $res['data']['payload'] = $this->data;
        //$res['data']['timestamp']  = date('Y-m-d G:i:s');
        return $res;
    }

    /**
     * Function to send notification to a single device
     *
     * @param   string   $to     registration id of device (device token)
     * @param   array   $message    push notification array returned from getPush()
     *
     * @return  array   array of notification data and to address
     */
    public function send($to, $message)
    {
        $fields = array(
            'to' => $to,
            'data' => $message,
        );
        return $this->sendPushNotification($fields);
    }

    /**
     * Function to send notification to a topic by topic name
     *
     * @param   string   $to     topic
     * @param   array   $message    push notification array returned from getPush()
     * 
     * @return  array   array of notification data and to address (topic)
     */
    // public function sendToTopic($to, $message)
    // {
    //     $fields = array(
    //         'to' => '/topics/' . $to,
    //         'data' => $message,
    //     );
    //     return $this->sendPushNotification($fields);
    // }

    /**
     * Function to send notification to multiple users by firebase registration ids
     *
     * @param   array   $to         array of registration ids of devices (device tokens)
     * @param   array   $message    push notification array returned from getPush()
     * 
     * @return  array   array of notification data and to addresses
     */
    // public function sendMultiple($registration_ids, $message)
    // {
    //     $fields = array(
    //         'registration_ids' => $registration_ids,
    //         'data' => $message,
    //     );

    //     return $this->sendPushNotification($fields);
    // }

    /**
     * Function makes curl request to firebase servers
     *
     * @param   array   $fields    array of registration ids of devices (device tokens)
     * 
     * @return  string   returns result from FCM server as json
     */
    // private function sendPushNotification($fields)
    // {
    //     // Set POST variables
    //     $url = fcm_url;

    //     $headers = array(
    //         'Authorization: key=' . FCM_SECRET_KEY,
    //         'Content-Type: application/json',
    //     );
    //     // Open connection
    //     $ch = curl_init();

    //     // Set the url, number of POST vars, POST data
    //     curl_setopt($ch, CURLOPT_URL, $url);

    //     curl_setopt($ch, CURLOPT_POST, true);
    //     curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
    //     curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

    //     // Disabling SSL Certificate support temporarly
    //     curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);

    //     curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($fields));

    //     // Execute post
    //     $result = curl_exec($ch);
    //     if ($result === false) {
    //         die('Curl failed: ' . curl_error($ch));
    //     }

    //     // Close connection
    //     curl_close($ch);

    //     return $result;
    // }
    public static function sendPushNotification($fcm_token, $title, $message)
    {
    // Set POST variables
    $url = fcm_url;
    $header = array("authorization: key=".FCM_SECRET_KEY,
        "content-type: application/json"
    );

    $postdata = '{
        "to" : "' . $fcm_token . '",
            "notification" :{
                    "title":"' . $title .'",
                    "body" : "' . $message .'"
                     
                },
                "data" :{
                        "title":"' . $title .'",
                        "body" : "' . $message .'",
                        }
                        }';

    $ch = curl_init();
    $timeout = 120;
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, $timeout);
    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
    curl_setopt($ch, CURLOPT_POSTFIELDS, $postdata);
    curl_setopt($ch, CURLOPT_HTTPHEADER, $header);

    // Get URL content
    $result = curl_exec($ch);
    // close handle to release resources
    curl_close($ch);
//info('pushresponseios'.$result.'response'.$postdata);
    return $result;
  }

}
