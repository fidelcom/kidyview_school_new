<?php

defined('BASEPATH') OR exit('No direct script access allowed');
require APPPATH . '/libraries/REST_Controller.php';

class Driverdata extends REST_Controller {

    public $error = array();
    public $data = array();
    public $blank = array();
    

    public function __construct() {
        parent::__construct();
        $this->token->driver_validate();
        $this->load->library("security");
        $this->load->library('form_validation');
        $this->load->library('fcm');
        $this->load->model('driver/driver_model', 'user');
        $this->data = $this->user->getDriver($this->token->driver_id);
        
    }

    public function index_get() {
        $return['success'] = "true";
        $return['title'] = "success";
        $return['message'] = "Driver Data";
        $driverData  = $this->data;
        
        if(isset($driverData->driverLicenseExpire) && $driverData->driverLicenseExpire!="")
        $driverData->remain_day_license_expiry= $this->checkLicenceExpriry($driverData->driverLicenseExpire);
        
        
        $return['data'] = $driverData;
        
        
        $return['error'] = $this->error;
        $this->response($return, REST_Controller::HTTP_OK);
    }
    
     public function checkLicenceExpriry($expiryDate) {
         
       $remainDay = 0;  
       $currentDate  =  date('Y-m-d');
        
       if($currentDate>=$expiryDate){
         $remainDay=0; 
       }
       else 
       {
        $diff = strtotime($expiryDate) - strtotime($currentDate);
        $remainDay = abs(round($diff / 86400));
       }
       return $remainDay;  
         
     }

    public function changePassword_post() {

        $postData = json_decode(file_get_contents('php://input'), true);
        
        
        $postData = $this->security->xss_clean($postData);
        $this->form_validation->set_data($postData);
        $this->form_validation->set_error_delimiters('', '');

        $this->form_validation->set_rules('currentpassword', 'current password', 'trim|required');
        $this->form_validation->set_rules('newpassword', 'New password', 'trim|required');
        $this->form_validation->set_rules('confirmpassword', 'confirm Password', 'trim|required');


        if ($this->form_validation->run() === false) {
            $this->error = $this->form_validation->error_array();
            $message = validation_errors();
            $return['success'] = "false";
            $return['title'] = "error";
            $return['message'] = "$message";
            $return['error'] = $this->error;
            $this->response($return, REST_Controller::HTTP_BAD_REQUEST);
            exit;
        }
        
        

        if ((isset($postData['currentpassword']) || isset($postData['newpassword'])) && (isset($postData['confirmpassword']))) {
            
            if ($postData['currentpassword'] == $this->data->password) {

                if ($postData['newpassword'] == $postData['confirmpassword']) {
                    
                    $updatePass = array('password' => $postData['newpassword']);
                    $this->user->changePassword($this->token->driver_id, $updatePass);
                    $return['success'] = "true";
                    $return['title'] = "success";
                    $return['message'] = "Password Changed Successfully.";
                    $this->response($return, REST_Controller::HTTP_OK);
                } else {
                    $this->response(["status" => "false", "title" => "error", "message" => "Confirm Password Not Matched."], REST_Controller::HTTP_BAD_REQUEST);
                }
            } else {
                $this->response(["status" => "false", "title" => "error", "message" => "Your old Password Not matched."], REST_Controller::HTTP_BAD_REQUEST);
            }
        } else {
            $this->response(["status" => "false", "title" => "error", "message" => "Please fill all field."], REST_Controller::HTTP_BAD_REQUEST);
        }
    }
    
    
    
    public function driverStudents_get() {
        
        $postData = json_decode(file_get_contents('php://input'), true);
        if ($postData == '') {
            $postData = $_POST=$_GET;
        } 
       // print_r($_GET);die;
        $driverData = $this->data;
        $schoolID = $driverData->schoolId;
        $driverID = $this->token->driver_id;
        
        $journey_session = isset($_GET['journey_session']) ? $_GET['journey_session'] : "";
        if($journey_session == "morning" || $journey_session == "afternoon")
        {
            
            ############ Start And End Journey Status ##############################
            $startJourneyStatus   =  $this->user->checkStartJourneySession($driverID,$schoolID,$journey_session);
            $endJourneyStatus   =  $this->user->checkEndJourneySession($driverID,$schoolID,$journey_session);
            
             if($startJourneyStatus) {
                 if($journey_session == "morning") {
                     $startbutton = 'is_journey_start';
                     $startstatus = '1';
                 }
                 if($journey_session == "afternoon") {
                     $startbutton = 'is_journey_start';
                     $startstatus = '1';
                 }
             }
             else {
                 if($journey_session == "morning") {
                     $startbutton = 'is_journey_start';
                     $startstatus = '0';
                 }
                 if($journey_session == "afternoon") {
                     $startbutton = 'is_journey_start';
                     $startstatus = '0';
                 }
             }
             
             if($endJourneyStatus) {
                 if($journey_session == "morning") {
                     $endbutton = 'is_journey_end';
                     $endstatus = '1';
                 }
                 if($journey_session == "afternoon") {
                     $endbutton = 'is_journey_end';
                     $endstatus = '1';
                 }
             }
             else {
                 if($journey_session == "morning") {
                     $endbutton = 'is_journey_end';
                     $endstatus = '0';
                 }
                 if($journey_session == "afternoon") {
                     $endbutton = 'is_journey_end';
                     $endstatus = '0';
                 }
             }
            ############ End Start And End Journey Status ############################## 
            
                if($journey_session == "morning") 
                $result = $this->user->pickStudentList($schoolID, $driverID);
                
                if($journey_session == "afternoon") 
                $result = $this->user->dropStudentList($schoolID, $driverID);
                
                if ($result) {
                    $return['success'] = "true";
                    $return['title'] = "success";
                    $return['session'] = $journey_session;
                    $return[$startbutton] = $startstatus;
                    $return[$endbutton] = $endstatus;
                    $return['message'] = "Students Lists Found";
                    $return['data'] = $result;
                    $return['error'] = $this->error;
                    $this->response($return, REST_Controller::HTTP_OK);
                } else {
                    $return['success'] = "false";
                    $return['title'] = "error";
                    $return['session'] = $journey_session;
                    $return['message'] = "No list Found";
                    $return['error'] = $this->error;
                    $return['data'] = (object) $this->blank;
                    $this->response($return, REST_Controller::HTTP_BAD_REQUEST);
                }
         }
        else 
        {
        $return['success'] = "false";
        $return['title'] = "error";
        $return['session'] = $journey_session;
        $return['message'] = "Please pass the 'journey_session' parameter value as 'morning' OR 'afternoon'";
        $return['error'] = $this->error;
        $return['data'] = (object) $this->blank;
        $this->response($return, REST_Controller::HTTP_BAD_REQUEST);    
        }
        
    }
    
     public function driverJourneyStart_post() 
     {
        $postData = json_decode(file_get_contents('php://input'), true);
        if ($postData == '') {
            $postData = $_POST;
        } 
        
        $journey_start_type = isset($postData['journey_start_type']) ? $postData['journey_start_type'] : "";
        $driverData = $this->data;
        $schoolID = $driverData->schoolId;
        $driverID = $this->token->driver_id;
        $currentDateTime = date('Y-m-d H:i:s');
        
        $driverEntry = $this->user->checkDriverEntry($schoolID,$driverID,date('Y-m-d'));
        if(!$driverEntry) {
          $entryData = array('driverId' => $driverID,'schoolid' => $schoolID,'created_date' => $currentDateTime);  
          $journeyID = $this->user->makeDriverEntry($entryData); 
        }
        else {
          $journeyID  = $driverEntry->id;
        }
        
        if($journey_start_type =="morning") {
        $journeyData  = array('morning_start_status' => '1','morning_start_time' => $currentDateTime);   
        }
        if($journey_start_type =="afternoon") {
        $journeyData  = array('afternoon_start_status' => '1','afternoon_start_time' => $currentDateTime);   
        } 
        
        ################## For morning journey ##########################
       if($journey_start_type =="morning") 
       {
          $dataresult   =  $this->user->startJourneyStatus($journeyID,$journey_start_type);
          if ($dataresult) {
          $return['success'] = "true";
          $return['title'] = "success";
          $return['status'] = "done";
          $return['session'] = $journey_start_type;
          $return['message'] = "You are already started your journey";
          $return['data'] = $dataresult;
          $return['error'] = $this->error;
          $this->response($return, REST_Controller::HTTP_OK);     
          }
          else
          {
            $startJourney = $this->user->startJourney($journeyData,$journeyID);
            ############# Entry driver stops ##############
            if($startJourney){
             $this->user->makeJourneyStops('morning',$driverID,$schoolID);    
            }
            ############# Entry driver stops ##############
            $dataresult   =  $this->user->startJourneyStatus($journeyID,$journey_start_type);
            if($startJourney) {
            $return['success'] = "true";
            $return['title'] = "success";
            $return['status'] = "done";
            $return['session'] = $journey_start_type;
            $return['message'] = "journey started successfully";
            $return['data'] = $dataresult;
            $return['error'] = $this->error;
            $this->response($return, REST_Controller::HTTP_OK);  
            }
            else {
            $return['success'] = "false";
            $return['title'] = "error";
            $return['status'] = "";
            $return['session'] = $journey_start_type;
            $return['message'] = "Something went wrong while started the journey";
            $return['error'] = $this->error;
            $return['data'] = (object) $this->blank;
            $this->response($return, REST_Controller::HTTP_BAD_REQUEST);   
            }    
          }
        }
        
        ################## For afternoon journey ##########################
        else if($journey_start_type =="afternoon") 
        {
          $dataresult   =  $this->user->startJourneyStatus($journeyID,$journey_start_type);
          if ($dataresult) {
          $return['success'] = "true";
          $return['title'] = "success";
          $return['status'] = "done";
          $return['session'] = $journey_start_type;
          $return['message'] = "You are already started your journey";
          $return['data'] = $dataresult;
          $return['error'] = $this->error;
          $this->response($return, REST_Controller::HTTP_OK);     
          }
          else
          {
            $startJourney = $this->user->startJourney($journeyData,$journeyID);
            if($startJourney){
             $this->user->makeJourneyStops('afternoon',$driverID,$schoolID);    
            }
            $dataresult   =  $this->user->startJourneyStatus($journeyID,$journey_start_type);
            if($startJourney) {
            $return['success'] = "true";
            $return['title'] = "success";
            $return['status'] = "done";
            $return['session'] = $journey_start_type;
            $return['message'] = "journey started successfully";
            $return['data'] = $dataresult;
            $return['error'] = $this->error;
            $this->response($return, REST_Controller::HTTP_OK);  
            }
            else {
            $return['success'] = "false";
            $return['title'] = "error";
            $return['status'] = "";
            $return['session'] = $journey_start_type;
            $return['message'] = "Something went wrong while started the journey";
            $return['error'] = $this->error;
            $return['data'] = (object) $this->blank;
            $this->response($return, REST_Controller::HTTP_BAD_REQUEST);   
            }    
          } 
        
        }
        
        else
        {
        $return['success'] = "false";
        $return['title'] = "error";
        $return['message'] = "Please pass the 'journey_start_type' parameter value as 'morning' OR 'afternoon'";
        $return['error'] = $this->error;
        $return['data'] = (object) $this->blank;
        $this->response($return, REST_Controller::HTTP_BAD_REQUEST);    
        }
     }
     
     
     
     public function driverJourneyEnd_post() 
     {
        $postData = json_decode(file_get_contents('php://input'), true);
        if ($postData == '') {
            $postData = $_POST;
        } 
        $journey_end_type = isset($postData['journey_end_type']) ? $postData['journey_end_type'] : "";
        $driverData = $this->data;
        $schoolID = $driverData->schoolId;
        $driverID = $this->token->driver_id;
        $currentDateTime = date('Y-m-d H:i:s');
        
        $journeyID = "";
        $driverEntry = $this->user->checkDriverEntry($schoolID,$driverID,date('Y-m-d'));
        if(!$driverEntry) {
          $return['success'] = "false";
          $return['title'] = "error";
          $return['session'] = $journey_end_type;
          $return['message'] = "This driver is invalid for the end journey";
          $return['error'] = $this->error;
          $this->response($return, REST_Controller::HTTP_BAD_REQUEST);   
        }
        else
        {
            $journeyID = $driverEntry->id;
            if($journey_end_type =="morning") {
            $journeyData  = array('morning_end_status' => '1','morning_end_time' => $currentDateTime);   
            }
            if($journey_end_type =="afternoon") {
            $journeyData  = array('afternoon_end_status' => '1','afternoon_end_time' => $currentDateTime);   
            } 

            ################## For morning journey ##########################
           if($journey_end_type =="morning") 
           {
              $dataresult   =  $this->user->endJourneyStatus($journeyID,$journey_end_type);
              if ($dataresult) {
              $return['success'] = "true";
              $return['title'] = "success";
              $return['status'] = "done";
              $return['session'] = $journey_end_type;
              $return['message'] = "You are already ended your journey";
              $return['data'] = $dataresult;
              $return['error'] = $this->error;
              $this->response($return, REST_Controller::HTTP_OK);     
              }
              else
              {
                $startJourneyStatus = $this->user->startJourneyStatus($journeyID,$journey_end_type); 
                if(!$startJourneyStatus) {
                $return['success'] = "false";
                $return['title'] = "error";
                $return['status'] = "";
                $return['session'] = $journey_end_type;
                $return['message'] = "You can't end the journey before start it";
                $return['error'] = $this->error;
                $return['data'] = (object) $this->blank;
                $this->response($return, REST_Controller::HTTP_BAD_REQUEST);  
                }
                else 
                {
                    $endJourney = $this->user->endJourney($journeyData,$journeyID);
                    $dataresult   =  $this->user->endJourneyStatus($journeyID,$journey_end_type);
                    $this->user->removeStopsDetail($schoolID,$driverID);
                    if($endJourney) {
                    $return['success'] = "true";
                    $return['title'] = "success";
                    $return['status'] = "done";
                    $return['session'] = $journey_end_type;
                    $return['message'] = "journey ended successfully";
                    $return['data'] = $dataresult;
                    $return['error'] = $this->error;
                    $this->response($return, REST_Controller::HTTP_OK);  
                    }
                    else {
                    $return['success'] = "false";
                    $return['title'] = "error";
                    $return['status'] = "";
                    $return['session'] = $journey_end_type;
                    $return['message'] = "Something went wrong while end the journey";
                    $return['error'] = $this->error;
                    $return['data'] = (object) $this->blank;
                    $this->response($return, REST_Controller::HTTP_BAD_REQUEST);   
                    }
                }
              }
            }

            ################## For afternoon journey ##########################
            else if($journey_end_type =="afternoon") 
            {
              $dataresult   =  $this->user->endJourneyStatus($journeyID,$journey_end_type);
              if ($dataresult) {
              $return['success'] = "true";
              $return['title'] = "success";
              $return['status'] = "done";
              $return['session'] = $journey_end_type;
              $return['message'] = "You are already ended your journey";
              $return['data'] = $dataresult;
              $return['error'] = $this->error;
              $this->response($return, REST_Controller::HTTP_OK);     
              }
              else
              {
                $startJourneyStatus = $this->user->startJourneyStatus($journeyID,$journey_end_type); 
                if(!$startJourneyStatus) {
                $return['success'] = "false";
                $return['title'] = "error";
                $return['status'] = "";
                $return['session'] = $journey_end_type;
                $return['message'] = "You can't end the journey before start it";
                $return['error'] = $this->error;
                $return['data'] = (object) $this->blank;
                $this->response($return, REST_Controller::HTTP_BAD_REQUEST);  
                }
                else 
                {
                $this->user->removeStopsDetail($schoolID,$driverID);    
                $endJourney = $this->user->endJourney($journeyData,$journeyID);
                $dataresult   =  $this->user->endJourneyStatus($journeyID,$journey_end_type);
                if($endJourney) {
                $return['success'] = "true";
                $return['title'] = "success";
                $return['status'] = "done";
                $return['session'] = $journey_end_type;
                $return['message'] = "journey ended successfully";
                $return['data'] = $dataresult;
                $return['error'] = $this->error;
                $this->response($return, REST_Controller::HTTP_OK);  
                }
                else {
                $return['success'] = "false";
                $return['title'] = "error";
                $return['status'] = "";
                $return['session'] = $journey_end_type;
                $return['message'] = "Something went wrong while end the journey";
                $return['error'] = $this->error;
                $return['data'] = (object) $this->blank;
                $this->response($return, REST_Controller::HTTP_BAD_REQUEST);   
                }    
               } 
              }
            }
            else
            {
            $return['success'] = "false";
            $return['title'] = "error";
            $return['message'] = "Please pass the 'journey_end_type' parameter value as 'morning' OR 'afternoon'";
            $return['error'] = $this->error;
            $return['data'] = (object) $this->blank;
            $this->response($return, REST_Controller::HTTP_BAD_REQUEST);    
            }
         }
     }
     
     
     
     public function pickStudent_post() 
     {
        $postData = json_decode(file_get_contents('php://input'), true);
        if ($postData == '') {
            $postData = $_POST;
        } 
        $student_id = isset($postData['student_id']) ? $postData['student_id'] : "";
        $driverData = $this->data;
        $schoolID = $driverData->schoolId;
        $driverID = $this->token->driver_id;
        $journeyData = array(
            'studentid' =>$student_id,
            'driverid' =>$driverID,
            'schoolid' =>$schoolID,
            'pick_status' =>'1',
            'pick_time' => date('Y-m-d H:i:s')
         );
        
        if($student_id==0 || $student_id=="") {
          $return['success'] = "false";
          $return['title'] = "error";
          $return['session'] = 'pick';
          $return['message'] = "Please Pass the valid student_id value or parameter";
          $return['error'] = $this->error;
          $this->response($return, REST_Controller::HTTP_BAD_REQUEST);     
        }
        
       $startStatus  = $this->user->checkDriverJourneyStartStatus($driverID,$schoolID,'morning');
        if(!$startStatus) {
          $return['success'] = "false";
          $return['title'] = "error";
          $return['session'] = 'pick';
          $return['message'] = "You can't pick the student without starting the pickup service";
          $return['error'] = $this->error;
          $this->response($return, REST_Controller::HTTP_BAD_REQUEST);     
        }
        
        $journeyID = "";
        $studentEntry = $this->user->checkStudentjourney($schoolID,$driverID,$student_id);
        if(!$studentEntry) {
           $journeyID = $this->user->makeStudentJourney(array('schoolid'=>$schoolID,'driverid'=>$driverID,'studentid'=>$student_id,'created_date' => date('Y-m-d H:i:s')));
        }
        else {
          $journeyID = $studentEntry->id; 
        }
        
        $pickEntry = $this->user->checkPickDropEntry($schoolID,$driverID,$student_id,'pick');
        if(!$pickEntry) 
        {
            
            $entryData = $this->user->addPick($journeyData,$journeyID);
            if($entryData)
            {
            $driverLog = $this->user->makeDriverLog($schoolID,$journeyID,$driverID,'pick');
            $this->sendNotification($student_id,$driverID,'pick');
            $return['success'] = "true";
            $return['title'] = "success";
            $return['status'] = "done";
            $return['session'] = 'pick';
            $return['message'] = "Student picked successfully";
            $return['error'] = $this->error;
            $this->response($return, REST_Controller::HTTP_OK);  
            }
            else {
            $return['success'] = "false";
            $return['title'] = "error";
            $return['session'] = 'pick';
            $return['message'] = "Error occured while pick the student";
            $return['error'] = $this->error;
            $this->response($return, REST_Controller::HTTP_BAD_REQUEST);   
            }
        }
        else {
          $return['success'] = "true";
          $return['title'] = "success";
          $return['status'] = "done";
          $return['session'] = 'pick';
          $return['message'] = "This student already picked";
          $return['error'] = $this->error;
          $this->response($return, REST_Controller::HTTP_OK);   
        }
     }
     
     
     
     public function dropStudent_post() 
     {
        $postData = json_decode(file_get_contents('php://input'), true);
        if ($postData == '') {
            $postData = $_POST;
        } 
        $student_id = isset($postData['student_id']) ? $postData['student_id'] : "";
        $driverData = $this->data;
        $schoolID = $driverData->schoolId;
        $driverID = $this->token->driver_id;
        $journeyData = array(
            'studentid' =>$student_id,
            'driverid' =>$driverID,
            'schoolid' =>$schoolID,
            'drop_status' =>'1',
            'drop_time' => date('Y-m-d H:i:s')
         );
        
        if($student_id==0 || $student_id=="") {
          $return['success'] = "false";
          $return['title'] = "error";
          $return['session'] = 'drop';
          $return['message'] = "Please Pass the valid student_id value or parameter";
          $return['error'] = $this->error;
          $this->response($return, REST_Controller::HTTP_BAD_REQUEST);     
        }
        
        $startStatus  = $this->user->checkDriverJourneyStartStatus($driverID,$schoolID,'afternoon');
        if(!$startStatus) {
          $return['success'] = "false";
          $return['title'] = "error";
          $return['session'] = 'pick';
          $return['message'] = "You can't drop the student without starting the drop service";
          $return['error'] = $this->error;
          $this->response($return, REST_Controller::HTTP_BAD_REQUEST);     
        }
        
        
        
        $journeyID = "";
        $studentEntry = $this->user->checkStudentjourney($schoolID,$driverID,$student_id);
        if(!$studentEntry) {
           $journeyID = $this->user->makeStudentJourney(array('schoolid'=>$schoolID,'driverid'=>$driverID,'studentid'=>$student_id,'created_date' => date('Y-m-d H:i:s')));
        }
        else {
          $journeyID = $studentEntry->id; 
        }
        
        $pickEntry = $this->user->checkPickDropEntry($schoolID,$driverID,$student_id,'drop');
        if(!$pickEntry) 
        {
            
            $entryData = $this->user->addDrop($journeyData,$journeyID);
            if($entryData)
            {
            $driverLog = $this->user->makeDriverLog($schoolID,$journeyID,$driverID,'drop');  
            $this->sendNotification($student_id,$driverID,'drop');
            $return['success'] = "true";
            $return['title'] = "success";
            $return['status'] = "done";
            $return['session'] = 'drop';
            $return['message'] = "Student drop successfully";
            $return['error'] = $this->error;
            $this->response($return, REST_Controller::HTTP_OK);  
            }
            else {
            $return['success'] = "false";
            $return['title'] = "error";
            $return['session'] = 'drop';
            $return['message'] = "Error occured while pick the student";
            $return['error'] = $this->error;
            $this->response($return, REST_Controller::HTTP_BAD_REQUEST);   
            }
        }
        else {
          $return['success'] = "true";
          $return['title'] = "success";
          $return['status'] = "done";
          $return['session'] = 'drop';
          $return['message'] = "This student already dropped";
          $return['error'] = $this->error;
          $this->response($return, REST_Controller::HTTP_OK);   
        }
     }
     
     
     
     public function pickdropStudentList_post() 
     {
        $postData = json_decode(file_get_contents('php://input'), true);
        if ($postData == '') {
            $postData = $_POST;
        } 
        
        $dataArray = array(); 
        $driverData = $this->data;
        $schoolID = $driverData->schoolId;
        $driverID = $this->token->driver_id;
        
        $journey_type = isset($postData['journey_type']) ? $postData['journey_type'] : "";
        $journey_date = isset($postData['journey_date']) ? $postData['journey_date'] : date('Y-m-d');
        $journeyParam = array(
            'schoolID' => $schoolID,
            'driverID'=> $driverID,
            'date'=>$journey_date
        );
       
        
        if($schoolID =="" || $driverID=="" || $journey_date=="" || $journey_type==""){
            $return['success'] = "false";
            $return['title'] = "error";
            $return['message'] = "Please pass all the valid inputs";
            $return['data'] =  (object) $this->blank;
            $return['error'] = (object) $this->error;
            $this->response($return, REST_Controller::HTTP_BAD_REQUEST); 
        }
        
       switch($journey_type)
       {
        case "pick":
            $this->get_pick_journey($journeyParam);
            break;
        case "drop":
            $this->get_drop_journey($journeyParam);
            break;
        case "all":
            $this->get_all_journey($journeyParam);
            break;
        
        default:
            $this->invalid_journey();
            break;
        }
     }
     
    public function invalid_journey()
    {
        $return['success'] = "false";
        $return['title'] = "error";
        $return['message'] = "invalid parameter";
        $return['data'] =  (object) $this->blank;
        $return['error'] = (object) $this->error;
        $this->response($return, REST_Controller::HTTP_BAD_REQUEST); 
    }
     
     public function get_pick_journey($param)
     {
       
        $data_pick_journey   = $this->user->get_pick_journey($param); 
        if($data_pick_journey) 
        {
            $return['success'] = "true";
            $return['title'] = "success";
            $return['message'] = "Picked Student List";
            $return['data'] =  $data_pick_journey;
            $return['error'] = $this->error;
            $this->response($return, REST_Controller::HTTP_OK);  
         }
        else 
        {
            $return['success'] = "false";
            $return['title'] = "error";
            $return['message'] = "No data found from picked list";
            $return['data'] =  (object) $this->blank;
            $return['error'] = $this->error;
            $this->response($return, REST_Controller::HTTP_BAD_REQUEST);   
        }
         
    }
     
     public function get_drop_journey($param)
     {
       $data_drop_journey   = $this->user->get_drop_journey($param); 
        if($data_drop_journey) 
        {
            $return['success'] = "true";
            $return['title'] = "success";
            $return['message'] = "Dropped Student List";
            $return['data'] =  $data_drop_journey;
            $return['error'] = $this->error;
            $this->response($return, REST_Controller::HTTP_OK);  
         }
        else 
        {
            $return['success'] = "false";
            $return['title'] = "error";
            $return['message'] = "No data found from dropped list";
            $return['data'] =  (object) $this->blank;
            $return['error'] = $this->error;
            $this->response($return, REST_Controller::HTTP_BAD_REQUEST);   
        }  
     }
     
     public function get_all_journey($param)
     {
        $data_all_journey   = $this->user->get_all_journey($param); 
        if($data_all_journey) 
        {
            $return['success'] = "true";
            $return['title'] = "success";
            $return['message'] = "Pick and Drop Student List";
            $return['data'] =  $data_all_journey;
            $return['error'] = $this->error;
            $this->response($return, REST_Controller::HTTP_OK);  
         }
        else 
        {
            $return['success'] = "false";
            $return['title'] = "error";
            $return['message'] = "No data found from Pick and Drop Student List";
            $return['data'] =  (object) $this->blank;
            $return['error'] = $this->error;
            $this->response($return, REST_Controller::HTTP_BAD_REQUEST);   
        } 
         
     }
     
    
     
     public function driverLog_post()
     {
        $postData = json_decode(file_get_contents('php://input'), true);
        if ($postData == '') {
            $postData = $_POST;
        } 
         $journey_type = isset($postData['journey_type']) ? $postData['journey_type'] : "";
         $journey_id = isset($postData['journey_id']) ? $postData['journey_id'] : "";
         
       if($journey_id=="" || $journey_type=="") {
        $return['success'] = "false";
        $return['title'] = "error";
        $return['message'] = "Journey Id or journey type not found...";
        $return['data'] =  (object) $this->blank;
        $return['error'] = $this->error;
        $this->response($return, REST_Controller::HTTP_BAD_REQUEST);      
       }
       else 
       {
            $data_driver_log   = $this->user->get_driver_log($journey_id,$journey_type); 
            if($data_driver_log) 
            {
                $return['success'] = "true";
                $return['title'] = "success";
                $return['message'] = "Diver Data Found";
                $return['data'] =  $data_driver_log;
                $return['error'] = $this->error;
                $this->response($return, REST_Controller::HTTP_OK);  
             }
            else 
            {
                $return['success'] = "false";
                $return['title'] = "error";
                $return['message'] = "No data found from Pick and Drop Student List";
                $return['data'] =  (object) $this->blank;
                $return['error'] = $this->error;
                $this->response($return, REST_Controller::HTTP_BAD_REQUEST);   
            }  
       }
       
         
     }
     
     public function completestop_post()
     {
        $postData = json_decode(file_get_contents('php://input'), true);
        if ($postData == '') {
            $postData = $_POST;
        } 
        
        $stopid = isset($postData['stopid']) ? $postData['stopid'] : "";
       if($stopid=="" || $stopid=="0") {
        $return['success'] = "false";
        $return['title'] = "error";
        $return['message'] = "unable to change the status of the stop...";
        $return['data'] =  (object) $this->blank;
        $return['error'] = $this->error;
        $this->response($return, REST_Controller::HTTP_BAD_REQUEST);      
       }
       else 
       {
            $completestop   = $this->user->completestop($stopid); 
            if($completestop) 
            {
                $return['success'] = "true";
                $return['title'] = "success";
                $return['message'] = "Status of this stop has been updated succssfully";
                $return['error'] = $this->error;
                $this->response($return, REST_Controller::HTTP_OK);  
             }
            else 
            {
                $return['success'] = "false";
                $return['title'] = "error";
                $return['message'] = "No data found from Pick and Drop Student List";
                $return['error'] = $this->error;
                $this->response($return, REST_Controller::HTTP_BAD_REQUEST);   
            }  
       }
       
         
     }
     
     
     public function getdistance_post()
     {
        $postData = json_decode(file_get_contents('php://input'), true);
        if ($postData == '') {
            $postData = $_POST;
        } 
        
        
      
      $session   = isset($postData['session']) ? $postData['session'] : "" ;    
      $journeyid   = isset($postData['journeyid']) ? $postData['journeyid'] : "" ;  
      $current_latitude   = isset($postData['current_latitude']) ? $postData['current_latitude'] : "" ;
      $current_longitude   = isset($postData['current_longitude']) ? $postData['current_longitude'] : "" ;
      $upcomig_latitude   = isset($postData['upcomig_latitude']) ? $postData['upcomig_latitude'] : "" ;
      $upcomig_longitude   = isset($postData['upcomig_longitude']) ? $postData['upcomig_longitude'] : "" ;
      $current_location   = isset($postData['current_location']) ? $postData['current_location'] : "" ;
       
       if($current_latitude=="" ||  $current_latitude=="0.0" || $current_latitude=="0" || $current_longitude==""  || $current_longitude=="0" || $current_longitude=="0.0" || $upcomig_latitude=="" || $upcomig_longitude=="")  {
        $return['success'] = "false";
        $return['title'] = "error";
        $return['message'] = "unable to count the distance...";
        $return['data'] =  (object) $this->blank;
        $return['error'] = $this->error;
        $this->response($return, REST_Controller::HTTP_BAD_REQUEST);      
       }
       else 
       {
           $driverID = $this->token->driver_id;
           $school_id = $this->token->school_id;
           $arrayData = array(
              'schoolid' =>$school_id,
              'driverid' =>$driverID,
              'latitude' =>$current_latitude, 
              'longitude' =>$current_longitude, 
              'location' =>$current_location, 
              'session'=> $session,
              'datetime' =>date('Y-m-d H:i:s'),
           );
           
           $distance = array();
           $miles  = $this->getDistanceBetweenPointsNew($current_latitude, $current_longitude, $upcomig_latitude, $upcomig_longitude);
           $kilometers = $miles * 1.609344;
           $meter = $miles *1609.344;
           
           $distance['miles'] = round($miles,2);
           $distance['kilometers'] = round($kilometers,2);
           $distance['meter'] = round($meter,2);
           $completestop   = $this->user->saveCurrentLog($arrayData); 
            if($completestop) 
            {
                $return['success'] = "true";
                $return['title'] = "success";
                $return['message'] = "Log Added Successfully";
                $return['data'] = $distance;
                $return['error'] = $this->error;
                $this->response($return, REST_Controller::HTTP_OK);  
             }
            else 
            {
                $return['success'] = "false";
                $return['title'] = "error";
                $return['message'] = "unable to add log";
                $return['data'] = "";
                $return['error'] = $this->error;
                $this->response($return, REST_Controller::HTTP_BAD_REQUEST);   
            }  
       }
       
         
     }
     

     public  function getDistanceBetweenPointsNew($latitude1, $longitude1, $latitude2, $longitude2, $unit = 'miles') {
          $theta = $longitude1 - $longitude2; 
          $distance = (sin(deg2rad($latitude1)) * sin(deg2rad($latitude2))) + (cos(deg2rad($latitude1)) * cos(deg2rad($latitude2)) * cos(deg2rad($theta))); 
          $distance = acos($distance); 
          $distance = rad2deg($distance); 
          $distance = $distance * 60 * 1.1515; 
          switch($unit) { 
            case 'miles': 
              break; 
            case 'kilometers' : 
              $distance = $distance * 1.609344; 
          } 
          return $distance; 
        } 

        
     public function updateprofilepic_post()
     {
        $postData = $_POST;
        $driverID = $this->token->driver_id;
        $school_id = $this->token->school_id;
        
        $postData = $this->security->xss_clean($postData);
        $this->form_validation->set_error_delimiters('', '');
        $this->form_validation->set_data($postData);
        
        
        if (!empty($_FILES['pic']))
        {
            $uploadPath = 'img/driver/';
            $config['upload_path'] = $uploadPath;
            $config['allowed_types'] = '*';
            $config['max_size'] = 50000;
            $config['encrypt_name'] = TRUE;
            $this->load->library('upload', $config);
            $this->upload->initialize($config);

            if (!$this->upload->do_upload('pic')){
                $uploaderror = $this->upload->display_errors();
                $return['success'] = "false";
                $return['message'] = $uploaderror;
                $return['error'] = $this->error;
                $return['data'] = $this->data;
                $this->response($return, REST_Controller::HTTP_BAD_REQUEST);
            } 
            else 
            {
                $uplodimg1 = $this->upload->data();
                $pic = $uplodimg1['file_name'];
                $updateArr = array(
                    'driverphoto' => $pic
                );
                 $update = $this->user->editDriver($updateArr, $driverID, $school_id);
                 if ($update) 
                 { 
                   $return['success'] = "true";
                   $return['title'] = "success";
                   $return['message'] = "Profile Pic Updated Successfully";
                   $return['error'] = $this->error;
                   $this->response($return, REST_Controller::HTTP_OK);  
                 }
                 else 
                 {
                   $return['success'] = "false";
                   $return['title'] = "error";
                   $return['message'] = "Error In update";
                   $return['error'] = $this->error;
                   $this->response($return, REST_Controller::HTTP_BAD_REQUEST);       
                 }
            }
        
        }
        else {
                   $return['success'] = "false";
                   $return['title'] = "error";
                   $return['message'] = "Please select a image to upload";
                   $return['error'] = $this->error;
                   $this->response($return, REST_Controller::HTTP_BAD_REQUEST); 
        }
        
     }   
     
     
     public function updatefcm_post()
     {
           
         $postData = json_decode(file_get_contents('php://input'), true);
            if ($postData == '') {
            $postData = $_POST;
            } 
         $fcm_key = isset($postData['fcm_key']) ? $postData['fcm_key'] : "";  
        
         if($fcm_key=="") {
         $return['success'] = "false";
         $return['title'] = "error";
         $return['message'] = "Enter FCM key";
         $return['error'] = $this->error;
         $this->response($return, REST_Controller::HTTP_BAD_REQUEST);    
         }
         
         $currentToken = $this->input->server('HTTP_TOKEN');
         if($currentToken!="") 
         {
            $query = $this->db->query("SELECT * FROM user_token WHERE user_type = 'Driver' And token = '".$currentToken."'");
            if ($query->num_rows() > 0) 
            {
             $userdata =  $query->row();
             $this->db->where('id', $userdata->id);
             $this->db->update('user_token', array('fcm_key'=>$fcm_key));
             $return['success'] = "true";
             $return['title'] = "success";
             $return['message'] = "FCM Key Updated Successfully";
             $return['error'] = $this->error;
             $this->response($return, REST_Controller::HTTP_OK); 
            } 
            else 
            {
            $return['success'] = "false";
            $return['title'] = "error";
            $return['message'] = "Token Not Matched";
            $return['error'] = $this->error;
            $this->response($return, REST_Controller::HTTP_BAD_REQUEST);
            } 
         }
         else 
         {
         $return['success'] = "false";
         $return['title'] = "error";
         $return['message'] = "Token Not Found";
         $return['error'] = $this->error;
         $this->response($return, REST_Controller::HTTP_BAD_REQUEST);
         }   
         
     }
     
     
     public function sendNotification($student_id,$driverID,$session)
     {
        $driverData = $this->data;
        $schoolID = $driverData->schoolId;
        $school_data= get_school($schoolID);
         if((!empty($student_id)) &&  (!empty($driverID)) && $session!="")
         {
             $childName = "";
             $messageData = "";
             
             $query = $this->db->query("SELECT  * FROM `child` WHERE id= '".trim($student_id)."'");
             if ($query->num_rows() > 0) 
             {   
                 $currentData   = json_decode(json_encode( $query->row()), true);
                 $childName = $currentData['childfname'] . ' '. $currentData['childmname'] . ' '.$currentData['childlname'];
                 
                 if($session=='pick')
                 $messageData = 'Your Child '.$childName.' Picked up Successfully'; 
        
                 if($session=='drop')
                 $messageData = 'Your Child '.$childName.' dropped to '.$school_data['school_name']; 
               
                   if(isset($currentData['parent_id']) && (!empty($currentData['parent_id'])))
                   { 
                      $parent  =  $this->getParentFCM($currentData['parent_id']);  
                      $token = isset($parent['fcm_key']) ? $parent['fcm_key'] : '';
                      $message=$messageData;
                      $title = "Driver Notification";
                      $notifyJson =  $this->fcm->sendPushNotification($token, $title, $message);
                      $notify =  json_decode($notifyJson); 
                   }  
            } 
             
         }    
     }
     
     
      public function getParentFCM($parent_id)
      {
            $where = array('user_type'=>'Parent', 'user_id' => $parent_id);
            $this->db->select('user_id,fcm_key');
            $this->db->from('user_token');
            $this->db->where($where);
            $this->db->order_by('id','desc');
            $query =  $this->db->get();
            return $query->row_array();
      }
      
      
      
      public function getdriverstudents_get()
      {
         
        $driverData = $this->data;
        $schoolid = $driverData->schoolId;
        $driverID = $this->token->driver_id;
        
        if($driverID!="" && $driverID!=0)
        {
        $result = $this->user->getDriverAssignList($schoolid,$driverID);
        $students  = array();
        for($j=0;$j<count($result);$j++) {
        $students[$j]['driverID'] =   $result[$j]['driverID'];     
        $students[$j]['student_id'] =   $result[$j]['student_id']; 
        $students[$j]['student'] =   $result[$j]['student'];
        $students[$j]['classsection'] =   $result[$j]['classsection'];
        $students[$j]['photo'] =   $result[$j]['childphoto'];
        $students[$j]['gender'] =   $result[$j]['childgender'];
        $students[$j]['email'] =   $result[$j]['childemail'];
        }
        if ($result) {
            $return['success'] = "true";
            $return['message'] = "All Student list";
            $return['data'] = $students;
            $return['error'] = $this->error;
            $this->response($return, REST_Controller::HTTP_OK);
        } else {
            $return['success'] = "false";
            $return['message'] = "No Student found.";
            $return['error'] = $this->error;
            $return['data'] = '';
            $this->response($return, REST_Controller::HTTP_BAD_REQUEST);
        }
          
      }
      else {
        $return['success'] = "false";
        $return['message'] = "No Student found.";
        $return['error'] = $this->error;
        $return['data'] = '';
        $this->response($return, REST_Controller::HTTP_BAD_REQUEST);    
      }
    }
    
    public function journeyLogStudents_post(){
    
        $postData = json_decode(file_get_contents('php://input'), true);
        if ($postData == '') {
            $postData = $_POST;
        }
        
        $driverData = $this->data;
        $schoolid = isset($driverData->schoolId) ? $driverData->schoolId : "";
        $driverID = isset($this->token->driver_id) ? $this->token->driver_id : "";
        $studentID = isset($postData['studentID']) ? $postData['studentID'] : "";
        $result = $this->user->journeyLogStudents($schoolid,$driverID,$studentID);
        if ($result) {
            $return['success'] = "true";
            $return['message'] = "Student Journey Log Found";
            $return['data'] = $result;
            $return['error'] = $this->error;
            $this->response($return, REST_Controller::HTTP_OK);
        } else {
            $return['success'] = "false";
            $return['message'] = "No Student Journey Log Found.";
            $return['data'] = $result;
            $return['error'] = $this->error;
            $this->response($return, REST_Controller::HTTP_BAD_REQUEST);   
        }
     }
     
}
