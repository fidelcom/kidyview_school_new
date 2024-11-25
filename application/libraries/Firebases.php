<?php

defined('BASEPATH') OR exit('No direct script access allowed');

use Kreait\Firebase\Factory;
use Kreait\Firebase\Messaging\CloudMessage;

class Firebases {
    private $messaging;

    public function __construct() {
        $config = &get_config();
        $serviceAccount = $config['firebase_credentials'];

        // Instantiate the Firebase Factory with the Service Account
        $this->messaging = (new Factory)
            ->withServiceAccount($serviceAccount)
            ->createMessaging(); // Create the Messaging instance directly
    }

    public function sendNotification($tokens, $title, $body) {
        // Create a CloudMessage with the notification details
        $message = CloudMessage::withTarget('token', $tokens)
            ->withNotification(['title' => $title, 'body' => $body]);

        // Send the message
        $this->messaging->send($message);
    }
}
