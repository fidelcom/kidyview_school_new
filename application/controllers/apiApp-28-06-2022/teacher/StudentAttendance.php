<?php
defined('BASEPATH') OR exit('No direct script access allowed');
require APPPATH . '/libraries/REST_Controller.php';
include APPPATH . 'third_party/plivo/vendor/autoload.php';

use Plivo\RestClient;

class StudentAttendance extends REST_Controller {

    public $error = array();
    public $data = array();

    function __construct() {
        parent::__construct();
        $this->token->validate();
        $this->load->library("security");
        $this->load->library('form_validation');
        $this->load->model('studentAttendance_model','model');
        $this->load->helper('common_helper');
    }
    
    public function getClassByTeacher_get(){

                $school_id =  $this->token->school_id;
                $user_id   =  $this->token->user_id;
     
        $classList = $this->model->classList($school_id,$user_id);
                // prd($classList);
       	if ($classList) {
					$return['success'] = "true";
					$return['message'] = "Teacher-wise all class list.";
					$return['data'] = $classList;
					$return['error'] = $this->error;

					$this->response($return, REST_Controller::HTTP_OK);
					} else {
					$return['success'] = "false";
					$return['message'] = "Not found.";
					$return['error'] = $this->error;
					$return['data'] = $classList;

					$this->response($return, REST_Controller::HTTP_BAD_REQUEST);
			}
    }
    public function getStudentsByClass_post(){
    	 $postData = json_decode(file_get_contents('php://input'), true);
         if ($postData == '') {
                $postData = $_POST;
         }
    	 $school_id   =  $this->token->school_id;
    	 $classID     =  $postData['class_id'];
    	 $search      =  $postData['search'];
         $studentList = $this->model->getStudentsByClass($classID,$school_id,$search);
        if ($studentList) {
					$return['success'] = "true";
					$return['message'] = "Class-wise students list.";
					$return['data'] = $studentList;
					$return['error'] = $this->error;

					$this->response($return, REST_Controller::HTTP_OK);
					} else {
					$return['success'] = "false";
					$return['message'] = "Not found.";
					$return['error'] = $this->error;
					$return['data'] = $studentList;

					$this->response($return, REST_Controller::HTTP_BAD_REQUEST);
			}
	}
	public function checkinStudentAttendance_post()
	{
		 $postData = json_decode(file_get_contents('php://input'), true);
         if ($postData == '') {
                $postData = $_POST;
         }
         $school_id   =  $this->token->school_id;
         $user_id   =  $this->token->user_id;
         $studentAttendance = array();
         $alreadyCheckIn = array();
         $i=0;
         foreach ($postData as $value) {
         	if(!empty($value['check_in'] && $value['check_in'] == "true") ){
         		$session = getSessionByClass($value['class_id']);
         	   
         	    if(isCheckinExist($value['student_id']))
         	    {
         	    	$alreadyCheckIn[$i]['student_id'] = $value['student_id'];
         	    	$result=array();
	         		$i++;

         	    }else{
	         	    $studentAttendance[$i]['student_id'] 		= $value['student_id'];
		         	$studentAttendance[$i]['class_id']   		= $value['class_id'];
		         	$studentAttendance[$i]['check_in']   		= $value['check_in'];
		         	$studentAttendance[$i]['check_out']   		= "false";
		         	$studentAttendance[$i]['teacher_id'] 		= $user_id;
		         	$studentAttendance[$i]['school_id']  		= $school_id;
		         	$studentAttendance[$i]['session'] 			= $session->academicsession;
		         	$studentAttendance[$i]['created_by']   		= $user_id;
		         	$studentAttendance[$i]['created_at']   		= date('Y-m-d H:i:s');
		         	$studentAttendance[$i]['date']   			= date('Y-m-d');
	         		$i++;
         	    }
	       }
         }
         $result  = $this->model->checkinStudentAttendance($studentAttendance);
           if ($result || (count($alreadyCheckIn)>0)) {
					$return['success'] = "true";
					$return['message'] = "Attendance has been check-in successfully.";
					$return['data'] = $result;
					$return['already-checkin'] = $alreadyCheckIn;
					$return['error'] = $this->error;

					$this->response($return, REST_Controller::HTTP_OK);
					} else {
					$return['success'] = "false";
					$return['message'] = "Not found.";
					$return['error'] = $this->error;
					$return['data'] = $result;

					$this->response($return, REST_Controller::HTTP_BAD_REQUEST);
			}

	}
	public function manualCheckout_put()
	{
		 $postData = json_decode(file_get_contents('php://input'), true);
         if ($postData == '') {
            $postData = $_POST;
         }
         $updateArr = array();
         foreach ($postData as $checkout) {
         	if(!empty($checkout['check_out']=="true")  && !empty($checkout['student_id']) && !empty($checkout['checkout_type']=='manual') ){
	         	$updateArr['student_id'] = $checkout['student_id']; 
	         	$updateArr['checkout_type'] = $checkout['checkout_type']; 
	         	$updateArr['check_out'] = $checkout['check_out']; 
	         	$updateArr['updated_at'] = date('Y-m-d H:i:s'); 
	         	$updateArr['updated_by'] = $this->token->user_id; 
	         
	         	$result  = $this->model->manualCheckout($updateArr);
         	}else{
	         		$return['success'] = "false";
					$return['message'] = "All field are mandatory!!";
					$return['error'] = $this->error;
					$this->response($return, REST_Controller::HTTP_BAD_REQUEST);
         	}
         }
            if ($result) {
					$return['success'] = "true";
					$return['message'] = "Student manual check-out has been done successfully.";
					$return['data'] = $result;
					$return['error'] = $this->error;

					$this->response($return, REST_Controller::HTTP_OK);
					} else {
					$return['success'] = "false";
					$return['message'] = "You need to checked-in first.";
					$return['error'] = $this->error;
					$return['data'] = $result;

					$this->response($return, REST_Controller::HTTP_BAD_REQUEST);
			}

    }
    public function checkoutByOtp_post()
    {
    	$postData = json_decode(file_get_contents('php://input'), true);
        if ($postData == '') {
            $postData = $_POST;
        }
        $student_id = $postData['student_id'];
        $otp = $postData['otp'];
        // Check-out verify otp and save checkout request. 
        if(!empty($student_id) && !empty($otp) )
        {
	        	$otpDetails = getOTPDetails($otp,$student_id);
	        	if(!empty($otpDetails->otp) == $otp)
	        	{
	        		$isOtpExpired  = $this->model->isOtpExpired($otp,$student_id);

	        		if($isOtpExpired == 'otp_expired')
	        		{
	        			$return['success'] = "false";
			            $return['message'] = "Your OTP has been expired. Please generate again.";
			            $return['error'] = $this->error;
			            $return['data'] = $otp;
			            
			            $this->response($return, REST_Controller::HTTP_BAD_REQUEST);
		        		
	        		}else if($isOtpExpired == 'student_mismatched'){

	        			$return['success'] = "false";
			            $return['message'] = "Student-wise token Mismatched. Please Checkout with valid student token.";
			            $return['error'] = $this->error;
			            $return['data'] = $otp;
			            
			            $this->response($return, REST_Controller::HTTP_BAD_REQUEST);
	        			
	        		}else{

	        				$updateOtpChechout = array(
			        			'check_out' 	=> "true",
			        			'checkout_type' => 'otp',
			        			'updated_at' => date('Y-m-d H:i:s')
		        			);
		        			$res = $this->model->saveOtpCheckout($student_id,$updateOtpChechout);
			        	    if($res)
			        		{
			        		 	$return['success'] = "true";
			                    $return['message'] = "OTP checkout has been save successfully.";
			                    $return['error'] =  $this->error;
			                    $return['data'] = 'success';
			                    $this->response($return, REST_Controller::HTTP_OK);
			        		}else{
			        		 	$return['success'] = "false";
								$return['message'] = "Oops !! You need to checked-in first.";
								$return['error'] = $this->error;
								$return['data'] = $otp;

								$this->response($return, REST_Controller::HTTP_BAD_REQUEST);
			        		}
	        		}
	        	
	        	}else{
	        	    $return['success'] = "false";
		            $return['message'] = "Incorrect OTP.";
		            $return['error'] = $this->error;
		            $return['data'] = $otp;
		            
		            $this->response($return, REST_Controller::HTTP_BAD_REQUEST);
	        	}
        }
    }
    public function generateRandomString($length) {
        if (!$length) {
            return false;
        }

        $characters = '01M2A3N456GX78F9';
        $charactersLength = strlen($characters);
        $randomString = '';

        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }
        return $randomString;
    }
    public function checkoutByQRCode_post()
    {
    	$postData = json_decode(file_get_contents('php://input'), true);
        if ($postData == '') {
            $postData = $_POST;
        }
        $student_id = $postData['student_id'];
        $qrcode = $postData['qrcode'];
        // Check-out verify otp and save checkout request. 
        if(!empty($student_id) && !empty($qrcode) )
        {
	        	 $qrcodeDetails = $this->model->getDetailsByQRCode($qrcode,$student_id);
	        	if($qrcodeDetails == 0)
	        	{
	        			$return['success'] = "false";
			            $return['message'] = "Student and QR-Code Mismatched. Please Checkout with valid student QR-Code.";
			            $return['error'] = $this->error;
			            $return['data'] = array();
			            
			            $this->response($return, REST_Controller::HTTP_BAD_REQUEST);

	        	
	        	}else if(!empty($qrcodeDetails['qr_code']) == $qrcode){

	        		
	        		$isQrCodeExpired  = $this->model->isQRCodeExpired($qrcode,$student_id);
	        		if($isQrCodeExpired == 'qrcode_expired')
	        		{
	        			$return['success'] = "false";
			            $return['message'] = "Your QR Code has been expired. Please generate again.";
			            $return['error'] = $this->error;
			            $return['data'] = $qrcode;
			            
			            $this->response($return, REST_Controller::HTTP_BAD_REQUEST);
		        		
	        		}else if($isQrCodeExpired == 'student_mismatched'){

	        			$return['success'] = "false";
			            $return['message'] = "Student and QR-Code Mismatched. Please Checkout with valid student QR-Code.";
			            $return['error'] = $this->error;
			            $return['data'] = array();
			            
			            $this->response($return, REST_Controller::HTTP_BAD_REQUEST);
	        			
	        		}else{

	        	// prd($isQrCodeExpired);
	        				$updateQRCodeCheckout = array(
			        			'check_out' 	=> "true",
			        			'checkout_type' => 'qrcode',
			        			'updated_at' => date('Y-m-d H:i:s')
		        			);
		        			$res = $this->model->saveQRCodeCheckout($student_id,$updateQRCodeCheckout);
			        	    if($res)
			        		{
			        		 	$return['success'] = "true";
			                    $return['message'] = "QR-Code checkout has been save successfully.";
			                    $return['error'] =  $this->error;
			                    $return['data'] = 'success';
			                    $this->response($return, REST_Controller::HTTP_OK);
			        		}else{
			        		 	$return['success'] = "false";
								$return['message'] = "Oops !! You should be check-in firstly.";
								$return['error'] = $this->error;
								$return['data'] = $qrcode;

								$this->response($return, REST_Controller::HTTP_BAD_REQUEST);
			        		}
	        		}
	        			
	        	}else{
	        	    $return['success'] = "false";
		            $return['message'] = "Incorrect QR-Code.";
		            $return['error'] = $this->error;
		            $return['data'] = $qrcode;
		            
		            $this->response($return, REST_Controller::HTTP_BAD_REQUEST);
	        	}
        }
    }
    
    
    public function studentsCheckInCheckOut_post()
    {
    	 $postData = json_decode(file_get_contents('php://input'), true);
         if ($postData == '') {
                $postData = $_POST;
         }
    	 $school_id   =  $this->token->school_id;
    	 $teacherId   =  $this->token->user_id;
         $classID     =  $postData['class_id'];
         $studentID   =  $postData['student_id'];
         if(isset($postData['checkdate']) && $postData['checkdate']!="")
         $date  = date('Y-m-d',strtotime($postData['checkdate']));
         else 
         $date  = date('Y-m-d');
    	
         $studentList = $this->model->getStudentsCheckInCheckOut($school_id,$teacherId,$classID,$studentID,$date);
        if ($studentList) {
        $return['success'] = "true";
        $return['message'] = "Check In Check out Data";
        $return['data'] = $studentList;
        $return['error'] = $this->error;
        $this->response($return, REST_Controller::HTTP_OK);
        } else {
        $return['success'] = "false";
        $return['message'] = "Not found.";
        $return['error'] = $this->error;
        $return['data'] = $studentList;

        $this->response($return, REST_Controller::HTTP_BAD_REQUEST);
        }
    }
    
}
