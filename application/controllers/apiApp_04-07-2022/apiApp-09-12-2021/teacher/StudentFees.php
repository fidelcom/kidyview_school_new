<?php
defined('BASEPATH') OR exit('No direct script access allowed');
require APPPATH . '/libraries/REST_Controller.php';

class StudentFees extends REST_Controller {

    public $error = array();
    public $data = array();

    function __construct() {
        parent::__construct();
        $this->token->validate();
        $this->load->library("security");
        $this->load->library('form_validation');
        $this->load->library('fcm');
        $this->load->model('teachers/studentFees_model','model');
        $this->load->helper('common_helper');
    }

    public function studentsFeeDetails_post(){
       
        $postData = json_decode(file_get_contents('php://input'), true);
        if ($postData == '') {
            $postData = $_POST;
        }
        $studentFeeDetails = $this->model->getStudentsFeesDetails($postData);
        // prd($studentFeeDetails);
        if ($studentFeeDetails) {
                    $return['success'] = "true";
                    $return['message'] = "Class-wise students fees details.";
                    $return['data'] = $studentFeeDetails;
                    $return['error'] = $this->error;

                    $this->response($return, REST_Controller::HTTP_OK);
                    } else {
                    $return['success'] = "false";
                    $return['message'] = "No record found.";
                    $return['error'] = $this->error;
                    $return['data'] = $studentFeeDetails;

                    $this->response($return, REST_Controller::HTTP_BAD_REQUEST);
            }
    }
    public function pendingFeeNotify_post()
    {
        $postData = json_decode(file_get_contents('php://input'), true);
        if ($postData == '') {
            $postData = $_POST;
        }
        // Setup Push notification
        $result = $this->model->parentFCMID($postData);
        //print_r($result);die;
        // $response =  array_filter($result,function($d){
        //      return $d['fcm_key'] !== ' ';  });
        $result = array_filter($result, function($value) { return !is_null($value['fcm_key']) && $value['fcm_key'] !== ''; });
        	// prd($result); die;
        // $uniqueParents = array_unique($result);
       // lq();
      // prd($uniqueParents); die;

        if(!empty($result))
        {
        		$count=0;
		        foreach ($result as $fcm) {
		        $token = !empty($fcm['fcm_key']) ? $fcm['fcm_key'] : '';

		             // $token = 'duBAMvUko_M:APA91bFvFa715CyBacJ75OWfEPiW8-OKFfMRJOu7CBFjhcWW54dkp0tGHsDRddsyfTYDu5k1WpQ7Dj9h4o3kPepCsjhiy7c5MlwLEkgnXEbn2Gr5fh1pFuzNUypRDgyt_u-iG6pIR58n'; 
		              
		             // $token = 'fw9rtgWmXeo:APA91bFjpDqfu3Vnh8CzPORt5-2Hh9sJls4R2xt8uRzMXm0Ph3VQsBLWFE8bPhGfcYhb4Nlj8Kas02VZCeMjcPhKSr3qYt5gsPmmuqjKXNNJ46SclrmUWME9QuY90RHluM5ls_RoG00p';  
		             
		             // $token = 'duBAMvUko_M:APA91bFvFa715CyBacJ75OWfEPiW8-OKFfMRJOu7CBFjhcWW54dkp0tGHsDRddsyfTYDu5k1WpQ7Dj9h4o3kPepCsjhiy7c5MlwLEkgnXEbn2Gr5fh1pFuzNUypRDgyt_u-iG6pIR58n'; 
		                // $token ='epKp4FOLIUjFpKipXkxVHT:APA91bF2_CtZR08uFbpVrGBhiE_KSBhTb1EZB3RPJi5AM_eq1AArcTHD39SaZfWzgtUnQy1QOY5pCTukuYcgDhaxoFu3YjWxwSa5kYfJYrqIJ5qaUXWU2w66Q42Hd_GHEEDG_G9sbMTQ';  // iOS 

		            //$message = "Your student fees is due. Please paid the fees.";
                    $message="You Child fees is due. Child Name - '".$fcm['childname']."'. kindly make payment";
                    $title = "Fee Pending";
		            // echo $token; die;
		            $notifyJson =  $this->fcm->sendPushNotification($token, $title, $message);
		            // echo $notifyJson; die;
		            $count++;
		        }
		        $notify =  json_decode($notifyJson);
		        // prd($notify);
		        if( ($notify->success > 0) && ($count > 0) )
		        {
		                    $return['success'] = "true";
		                    $return['message'] = "Pending fee notification sent successfully.";
		                    $return['data'] = $notifyJson;
		                    $return['error'] = $this->error;

		                    $this->response($return, REST_Controller::HTTP_OK);
		                    } else {
		                    $return['success'] = "false";
		                    $return['message'] = "Pending fee notification sent successfully.";
		                    $return['error'] = $this->error;
		                    $return['data'] = $notifyJson;

		                    $this->response($return, REST_Controller::HTTP_BAD_REQUEST);
		        }
        }else{
        	$return['success'] = "false";
            $return['message'] = "Pending fee notification sent successfully.";
            $return['error'] = $this->error;
            $return['data'] = $result;
		    $this->response($return, REST_Controller::HTTP_BAD_REQUEST);
        }
       
    }
}