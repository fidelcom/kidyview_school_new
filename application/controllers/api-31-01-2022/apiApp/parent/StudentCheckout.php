<?php
defined('BASEPATH') OR exit('No direct script access allowed');
require APPPATH . '/libraries/REST_Controller.php';
include APPPATH . 'third_party/plivo/vendor/autoload.php';
require APPPATH . '/libraries/phpqrcode/qrlib.php';

use Plivo\RestClient;

class StudentCheckout extends REST_Controller {

    public $error = array();
    public $data = array();

    function __construct() {
        parent::__construct();
        $this->token->parent_validate();
        $this->load->library("security");
        $this->load->library('form_validation');
        $this->load->model('studentAttendance_model','model');
        $this->load->model('parent/Parent_model');
        $this->load->helper('common_helper');
         $this->load->library('fcm');
    }
    
    public function guardiansList($parent_id){

    	$guardianList = $this->Parent_model->guardianDetail($parent_id);
	        if($guardianList) {
				$return['success'] = "true";
				$return['message'] = "Guardian list.";
				$return['data'] = $guardianList;
				$return['error'] = $this->error;

				$this->response($return, REST_Controller::HTTP_OK);
				} else {
				$return['success'] = "false";
				$return['message'] = "No Guardian Found.";
				$return['error'] = $this->error;
				$return['data'] = $guardianList;

				$this->response($return, REST_Controller::HTTP_BAD_REQUEST);
			}
    }
    public function sendOTP_post()
    {
    	 $postData = json_decode(file_get_contents('php://input'), true);
         if ($postData == '') {
                $postData = $_POST;
         }
        $type 			= $postData['type'];
 		$parent_id 		= $this->token->parent_id;
        $student_id 	= $this->token->student_id;
        $studentDetails = $this->model->getChildDetails($student_id);
		$childName 		= !empty($studentDetails['child']) ? $studentDetails['child'] : false;
		$childRegisterId= !empty($studentDetails['childRegisterId'])? $studentDetails['childRegisterId'] : false;
		$otp 			= $this->generateRandomString(4);
        // Send Guardian List parent-wise
        if($type == 'guardian-list')
 		{
	 		$this->guardiansList($parent_id);	
 		}
      	
		  $guardian_id 	= $postData['id'];
		  
        if(($type == 'sendOTP')  && $guardian_id>0)
        {
        	$guardianDetails = $this->model->guardianDetails($guardian_id);
        	$guardianEmail 	 = $guardianDetails['email'];
        	$guardianPhone 	 = $guardianDetails['phone'];
		        	if(!empty($guardianPhone))
		        	{
		        		$currentDateTime = date('Y-m-d H:i:s');
		        		$expiredDateTime = date("Y-m-d H:i:s", strtotime('+10 hours', strtotime($currentDateTime)));
		        		
			       		$insertOtpArr = array('otp' =>$otp,'student_id'=>$student_id,'guardian_id'=>$guardian_id,'created_on'=>$currentDateTime,'expired_on'=>$expiredDateTime);
			        	$result = $this->model->saveGuardianOTPDetails($insertOtpArr,$student_id);
         // prd($result);
			        
				        if($result){
				        		$apiId= false;
				        		// Setup Push notification
						        $result = $this->Parent_model->parentFCMID($guardian_id);
						        $token = !empty($result->fcm_key) ? $result->fcm_key : '';
						             // $token = 'duBAMvUko_M:APA91bFvFa715CyBacJ75OWfEPiW8-OKFfMRJOu7CBFjhcWW54dkp0tGHsDRddsyfTYDu5k1WpQ7Dj9h4o3kPepCsjhiy7c5MlwLEkgnXEbn2Gr5fh1pFuzNUypRDgyt_u-iG6pIR58n'; 
						            // $token = 'fa2yIM1s1Bw:APA91bEdNUahbuy7xwmrFWl7psj-s0o2Dx4fAqUBr5U5UMkelp6BjrI92Z1jkOga6bTP34JS9AhvRdJVm9y3cSFgBrUzbQBQtpYgDdt5j32ek-1hGp6im6iKJ67TB37TRKOo5RptQcfZ'; 
						               // $token = 'e_XuB0zl9EsKpsuGMUUcgD:APA91bGJ7OVHdk4aU2vprokUGrbDSkHjM0L84dxs4d2H5bSJkhn3cHd4a8IqUVvlYeb5jmVJxAWeqqaEWIitrP4yHfUPOuUxCit1hsNFXRTTSMV9msZQ7kJKszYV19KQPgGuxew7PYR4';  // iOS 
						            $message = $otp . " is your otp checkout code for $childName ($childRegisterId). OTP is confidential.";
						            $title = "Student checkout notification";
						            $notify =  $this->fcm->sendPushNotification($token, $title, $message);
						        // echo $notify;
						        // prd($notify);  die;

						       			//$client = new RestClient("MANMVKN2MWZMFMMTEYMD", "MTVkNDdkNzBlNWM2NTM2YjllOGE4NWYwMzBkNTE1");
										   $client = new RestClient(PLIVO_AUTH_ID, PLIVO_AUTH_TOKEN);
										   $response = $client->messages->create('+19709844629', array($guardianPhone), $otp . " is your otp checkout code for $childName ($childRegisterId). OTP is confidential.", array("url" => "http://foo.com/sms_status/"));

						        // echo $response; die;
				               // echo  $apiId = $response->apiId ? $response->apiId : false; die;
						       // if($apiId)
						       // {
						       		 if(!empty($guardianEmail))
					                {
					                	$mailsent = false;
					                    // $maildata = array('otp' => $otp);
					               		$maildata = array('otp' => $otp,'childName'=>$childName,'childRegisterId'=>$childRegisterId);
					                    /* codeigniter mail  */
					                    $message = $this->load->view('app/checkout-otp.php', $maildata, TRUE);
					                    if ($this->sendMail($guardianEmail, 'Kidyview - Checkout OTP', $message)) {
					                        $mailsent = true;
					                    }
					                }
					                $return['success'] = "true";
					                $return['title'] = "success";
					                $return['message'] = "Please check your phone and email.";
					                $return['error'] = (object) $this->error;
					                $return['data'] = $otp;
					                $return['status'] = "success";

					                $this->response($return, REST_Controller::HTTP_ACCEPTED);
						       // }else{
						       //      $return['success'] = "false";
					        //         $return['title'] = "failed";
					        //         $return['message'] = "Mobile no is not valid. please check mobile no";
					        //         $return['error'] = (object) $this->error;
					        //         $return['data'] = $guardianPhone;
					        //         // $return['status'] = "success";

					        //         $this->response($return, REST_Controller::HTTP_ACCEPTED);
						       // }
				               
				        }else{
				        		$return['success'] = "false";
								$return['message'] = "OTP Can`t save this moment. Please try again later !!";
								$return['error'] = $this->error;
								$return['data'] = $guardianDetails;

								$this->response($return, REST_Controller::HTTP_BAD_REQUEST);	
				        }
					}else{
		        		$return['success'] = "false";
						$return['message'] = "No Phone is found.";
						$return['error'] = $this->error;
						$return['data'] = $guardianDetails;

						$this->response($return, REST_Controller::HTTP_BAD_REQUEST);
		        	}
	    }else{
	    	$parentDetail 	   = $this->Parent_model->parentDetail($parent_id);
	    	$parentfatheremail = !empty($parentDetail->fatheremail) ? $parentDetail->fatheremail : null; 
	    	$parentfatherphone = !empty($parentDetail->fatherphone) ? $parentDetail->fatherphone : null; 
	    	$parentmotheremail = !empty($parentDetail->motheremail) ? $parentDetail->motheremail : null; 
	    	$parentmotherphone = !empty($parentDetail->motherphone) ? $parentDetail->motherphone : null; 
	    	
	    	
	    				$currentDateTime = date('Y-m-d H:i:s');
		        		$expiredDateTime = date("Y-m-d H:i:s", strtotime('+10 hours', strtotime($currentDateTime)));
		        		
			       		$insertOtpArr = array('otp' =>$otp,'student_id'=>$student_id,'guardian_id'=>$parent_id,'created_on'=>$currentDateTime,'expired_on'=>$expiredDateTime);
			        	$result = $this->model->saveGuardianOTPDetails($insertOtpArr,$student_id);
			        
				        if($result){

				        	// Setup Push notification
						        $result = $this->Parent_model->parentFCMID($parent_id);
						        $token = !empty($result->fcm_key) ? $result->fcm_key : '';
						             // $token = 'duBAMvUko_M:APA91bFvFa715CyBacJ75OWfEPiW8-OKFfMRJOu7CBFjhcWW54dkp0tGHsDRddsyfTYDu5k1WpQ7Dj9h4o3kPepCsjhiy7c5MlwLEkgnXEbn2Gr5fh1pFuzNUypRDgyt_u-iG6pIR58n'; 
						            // $token = 'fa2yIM1s1Bw:APA91bEdNUahbuy7xwmrFWl7psj-s0o2Dx4fAqUBr5U5UMkelp6BjrI92Z1jkOga6bTP34JS9AhvRdJVm9y3cSFgBrUzbQBQtpYgDdt5j32ek-1hGp6im6iKJ67TB37TRKOo5RptQcfZ'; 
						               // $token = 'e_XuB0zl9EsKpsuGMUUcgD:APA91bGJ7OVHdk4aU2vprokUGrbDSkHjM0L84dxs4d2H5bSJkhn3cHd4a8IqUVvlYeb5jmVJxAWeqqaEWIitrP4yHfUPOuUxCit1hsNFXRTTSMV9msZQ7kJKszYV19KQPgGuxew7PYR4';  // iOS 
						            $message = $otp . " is your otp checkout code for $childName ($childRegisterId). OTP is confidential.";
						            $title = "Student checkout notification";
						            $notify =  $this->fcm->sendPushNotification($token, $title, $message);
						        // echo $notify; die;
						        // prd($notify);
				        		
				        		if(!empty($parentfatherphone))
				        		{
				        			//$client = new RestClient("MANMVKN2MWZMFMMTEYMD", "MTVkNDdkNzBlNWM2NTM2YjllOGE4NWYwMzBkNTE1");
									$client = new RestClient(PLIVO_AUTH_ID, PLIVO_AUTH_TOKEN);
									$response = $client->messages->create('+19709844629', array($parentfatherphone), $otp . " is your otp checkout code for $childName ($childRegisterId). OTP is confidential.", array("url" => "http://foo.com/sms_status/"));
				        		}
				        		if(!empty($parentmotherphone))
				        		{
				        			//$client = new RestClient("MANMVKN2MWZMFMMTEYMD", "MTVkNDdkNzBlNWM2NTM2YjllOGE4NWYwMzBkNTE1");
									$client = new RestClient(PLIVO_AUTH_ID, PLIVO_AUTH_TOKEN);
									$response = $client->messages->create('+19709844629', array($parentmotherphone), $otp . " is your otp checkout code for $childName ($childRegisterId). OTP is confidential.", array("url" => "http://foo.com/sms_status/"));
				        		}

				                if(!empty($parentfatheremail))
				                {
				                	$mailsent = false;
				                    $maildata = array('otp' => $otp,'childName'=>$childName,'childRegisterId'=>$childRegisterId);
				                    /* codeigniter mail  */
				                    $message = $this->load->view('app/checkout-otp.php', $maildata, TRUE);
				                    if ($this->sendMail($parentfatheremail, 'Kidyview - Checkout OTP', $message)) {
				                        $mailsent = true;
				                    }
				                } 
				                if(!empty($parentmotheremail))
				                {
				                	$mailsent = false;
				                   	$maildata = array('otp' => $otp,'childName'=>$childName,'childRegisterId'=>$childRegisterId);
				                    /* codeigniter mail  */
				                    $message = $this->load->view('app/checkout-otp.php', $maildata, TRUE);
				                    if ($this->sendMail($parentmotheremail, 'Kidyview - Checkout OTP', $message)) {
				                        $mailsent = true;
				                    }
				                }
				                $return['success'] = "true";
				                $return['title'] = "success";
				                $return['message'] = "Please check your phone and email.";
				                $return['error'] = (object) $this->error;
				                $return['data'] = $otp;
				                $return['status'] = "success";

				                $this->response($return, REST_Controller::HTTP_ACCEPTED);
						}
	}
}
    public function generateRandomString($length) 
    {
        if (!$length) {
            return false;
        }

        $characters = '01M2A3N456GX78F9ZKLPTNS';
        $charactersLength = strlen($characters);
        $randomString = '';

        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }
        return $randomString;
    }
    private function sendMail($to, $subject, $message) {
        $headers = 'MIME-Version: 1.0' . "\r\n";
        $headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
        $headers .= 'From: admin@kidyview.com' . "\r\n";
        return mail($to, $subject, $message, $headers);
    }
    public function generateQRCode_get()
    {
    	$parent_id = $this->token->parent_id;
    	$student_id = $this->token->student_id;
    	
		$qrCodeData = $this->model->getQRCodeValidate($parent_id,$student_id);
	// prd($qrCodeData);
    	if(!empty($parent_id) && ($qrCodeData['status'] == 'qrcode_expired') )
		{
			$qrcode_id = $this->dynamicQRCodeGenerate($parent_id,$student_id);
			if($qrcode_id)
			{
				$qrDetails = $this->model->getQRCodeDetails($qrcode_id);

				unset($qrCodeData['data']['qr_code']);
				$return['success'] 	= "true";
	            $return['status'] 	= "success";
	            $return['title'] 	= "success";
	            $return['message'] 	= "Your QR Code has been generated now.";
	            $return['data'] 	= $qrCodeData['data'];
	            $return['error'] 	= (object) $this->error;

            $this->response($return, REST_Controller::HTTP_OK);	
			}else{
				$return['success'] 	= "failed";
	            $return['status'] 	= "false";
	            $return['message'] 	= "Something went wrong!!";
	            $return['data'] 	= array();
	            $return['error'] 	= (object) $this->error;

	            $this->response($return, REST_Controller::HTTP_OK);	
			}

		}else if(!empty($parent_id) && ($qrCodeData['status'] == 'qrcode_valid') )
		{
			unset($qrCodeData['data']['qr_code']);
			$return['success'] 	= "true";
            $return['status'] 	= "success";
            $return['title'] 	= "success";
            $return['message'] 	= "Your QR Code is not expired yet.";
            $return['data'] 	= $qrCodeData['data'];
            $return['error'] 	= (object) $this->error;

            $this->response($return, REST_Controller::HTTP_OK);	
		}else if(!empty($parent_id) && ($qrCodeData['status'] == 'parent_not_found'))
		{
			$qrcode_id = $this->dynamicQRCodeGenerate($parent_id,$student_id);
			if($qrcode_id)
			{
				$qrDetails = $this->model->getQRCodeDetails($qrcode_id);
				unset($qrDetails->qr_code);
				$return['success'] 	= "true";
	            $return['status'] 	= "success";
	            $return['title'] 	= "success";
	            $return['message'] 	= "Your QR Code has been generated now.";
	            $return['data'] 	= $qrDetails;
	            $return['error'] 	= (object) $this->error;

            $this->response($return, REST_Controller::HTTP_OK);	
			}else{
				$return['success'] 	= "failed";
	            $return['status'] 	= "false";
	            $return['message'] 	= "Something went wrong!!";
	            $return['data'] 	= array();
	            $return['error'] 	= (object) $this->error;

	            $this->response($return, REST_Controller::HTTP_OK);	
			}	
		}
    }
    private function dynamicQRCodeGenerate($parent_id,$student_id)
    {
    	$token = $this->settings->encryptString($this->generateRandomString(12));
    	$currentDateTime = date('Y-m-d H:i:s');
		$expiredDateTime = date("Y-m-d H:i:s", strtotime('+10 hours', strtotime($currentDateTime)));
    	
    		$_SERVER['DOCUMENT_ROOT'];
			//file path for store images
		    $SERVERFILEPATH = $_SERVER['DOCUMENT_ROOT'].'/school/asset/images/parentQRCode/';
		    $text = $token;
			
			$folder = $SERVERFILEPATH;
			$file_name1 = time() ."_".$parent_id.".png";
			$file_name = $folder.$file_name1;
			QRcode::png($text,$file_name);

			// QR-Code Data save to datable
			$qrcodeDataArr = array(
					'parent_id'  		=> $parent_id,
					'student_id' 		=> $student_id,
					'qr_code' 	 		=> $token,
					'qrcode_filename' 	=> $file_name1,
					'created_on'		=> $currentDateTime,
					'expired_on'		=> $expiredDateTime
			);
		return	$qrcode_id = $this->model->saveParentQRCodeDetails($qrcodeDataArr);
    }
    public function getAttendanceData_get()
    {
    	// echo $this->token->parent_id; die;
    	$data = $this->model->getStudentAttendanceData();
    	// lq();
		if($data)
		{
				$return['success'] 	      = "true";
	            $return['title'] 	      = "success";
	            $return['message'] 	      = "Attendance List Data.";
	            $return['total_work_days']= $data['total_work_days'] ? $data['total_work_days'] : 0;
	            $return['attended_days']  = $data['attended_days'] ? $data['attended_days'] : 0;
	            $return['absent_days']    = $data['absent_days'] ? $data['absent_days'] :0;
	            $return['data'] 	      = $data['studentAttendance'];
	            $return['error'] 	      = (object) $this->error;

            $this->response($return, REST_Controller::HTTP_OK);	
			}else{
				$return['success'] 	= "failed";
	            $return['status'] 	= "false";
	            $return['message'] 	= "Something went wrong!!";
	            $return['data'] 	= array();
	            $return['error'] 	= (object) $this->error;

	            $this->response($return, REST_Controller::HTTP_OK);	
			}	
	}
}
