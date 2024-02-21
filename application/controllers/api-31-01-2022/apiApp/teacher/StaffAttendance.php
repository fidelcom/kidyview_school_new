<?php
defined('BASEPATH') OR exit('No direct script access allowed');
require APPPATH . '/libraries/REST_Controller.php';

class StaffAttendance extends REST_Controller {

    public $error = array();
    public $data = array();

    function __construct() {
        parent::__construct();
        $this->token->validate();
        $this->load->library("security");
        $this->load->library('form_validation');
        $this->load->model('teachers/Attendance_model','attendance');
        $this->load->helper('common_helper');
        $this->load->library('fcm');
    }
    
    public function checkin_post()
    {
        $postData = json_decode(file_get_contents('php://input'), true);
                if ($postData == '') {
                    $postData = $_POST;
                }

        $postData['user_id'] = $this->token->user_id; 
        $postData['school_id'] = $this->token->school_id; 
        $postData['created_by'] = $this->token->user_id; 
        $postData['user_type'] = $this->token->user_type; 
        
        // Validate user already checkin or not for current date
        $numrows = $this->attendance->isAlreadyCheckin($postData['user_id']);
        // $numrows=0;
        if($numrows>0)
        {
	        		$return['success'] = "false";
					$return['message'] = "You have already checked-in today.";
					$return['error'] = $this->error;
					// $return['data'] = $result;
					$this->response($return, REST_Controller::HTTP_OK);

        }else{
        		 $result = $this->attendance->teacherCheckin($postData);
             
		        if($result){
		       		$return['success'] = "true";
			        $return['title'] = "success";
			        $return['message'] = "You have been checked-in successfully.";
			        $return['data'] = $result;
			        $return['error'] = $this->error;
			        
			        $this->response($return, REST_Controller::HTTP_OK);
		        }else{
					$return['success'] = "false";
					$return['message'] = "Not found.";
					$return['error'] = $this->error;
					$return['data'] = $result;

					$this->response($return, REST_Controller::HTTP_BAD_REQUEST);
				}
        }
    }
    public function checkout_post()
    {
        $postData = json_decode(file_get_contents('php://input'), true);
                if ($postData == '') {
                    $postData = $_POST;
                }

        $user_id = $this->token->user_id; 
        
                $result = $this->attendance->teacherCheckout($postData,$user_id);
                if($result){
                    $return['success'] = "true";
                    $return['title'] = "success";
                    $return['message'] = "You have been checked-out successfully.";
                    $return['data'] = $result;
                    $return['error'] = $this->error;
                    
                    $this->response($return, REST_Controller::HTTP_OK);
                }else{
                    $return['success'] = "false";
                    $return['message'] = "You need to checked-in first.";
                    $return['error'] = $this->error;
                    $return['data'] = $result;

                    $this->response($return, REST_Controller::HTTP_BAD_REQUEST);
                }
    }
    public function attendance_get()
    {
    	$result = 	$this->attendance->allAttendance();
        // prd($result);
    	if($result){
                    $return['success'] = "true";
                    $return['title'] = "success";
                    $return['total_work_days'] = $result['total_work_days'];
                    $return['message'] = "Attendance List Data.";
                    $return['data'] = $result['myAttendance'];
                    $return['error'] = $this->error;
                    
                    $this->response($return, REST_Controller::HTTP_OK);
        }else{
            $return['success'] = "false";
            $return['message'] = "No attendance data found.";
            $return['error'] = $this->error;
            $return['data'] = $result;

            $this->response($return, REST_Controller::HTTP_BAD_REQUEST);
        }
    	// prd($res);
    }
    private function sendPushNotification($token,$message,$title)
    {
             /**
         * Send to a single device
         */

            $this->load->library('fcm');
            $this->fcm->setTitle($title);
            $this->fcm->setMessage($message);

            /**
             * set to true if the notificaton is used to invoke a function
             * in the background
             */
            // $this->fcm->setIsBackground(false);

            /**
             * payload is userd to send additional data in the notification
             * This is purticularly useful for invoking functions in background
             * -----------------------------------------------------------------
             * set payload as null if no custom data is passing in the notification
             */
            $payload = array('notification' => '');
            $this->fcm->setPayload($payload);

            /**
             * Send images in the notification
             */
            // $this->fcm->setImage('https://firebase.google.com/_static/9f55fd91be/images/firebase/lockup.png');

            /**
             * Get the compiled notification data as an array
             */
            $json = $this->fcm->getPush();

            return $p = $this->fcm->send($token, $json);

            // print_r($p);
        
    }
}
