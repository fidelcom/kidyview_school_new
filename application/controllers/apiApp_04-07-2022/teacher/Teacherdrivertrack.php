<?php
defined('BASEPATH') OR exit('No direct script access allowed');
require APPPATH . '/libraries/REST_Controller.php';

class Teacherdrivertrack extends REST_Controller {

    public $error = array();
    public $data = array();
    public $schoolID = array();
    public $studentID = array();
    public $driverID = "";
    public $journey_session = array();
    public $journeyStops = array();
    public $student_journey_status = array();
    public $callstatus = "";
    public $teacher_id = "";
    

    function __construct() {
        parent::__construct();
        $this->token->validate();
        $this->load->library("security");
        $this->load->library('form_validation');
        $this->load->model('teachers/Teacherdriver_model', 'teacherdriver');
        $this->load->helper('common_helper');
        
        $postData = json_decode(file_get_contents('php://input'), true);
        if ($postData == '') {
        $postData = $_POST;
        }
        
        $driverID   = isset($postData['driverid']) ? $postData['driverid'] : "" ;
        
        if(empty($driverID)  || $driverID=='0')
        {
        $return['success'] = "false";
        $return['title'] = "error";
        $return['message'] = "please pass the valid 'driverid' input";
        $return['error'] = $this->error;
        $this->response($return, REST_Controller::HTTP_BAD_REQUEST);  
        }
        $this->teacher_id = $this->token->user_id;
        $this->schoolID = $this->token->school_id;
        //$this->studentID = $studentID;
        $this->driverID = $driverID;
        
        $this->driverData = $this->teacherdriver->studentDriver($this->driverID,$this->schoolID);
        
        if(isset($this->driverData['driverID']) && (!empty($this->driverData['driverID'])) && (!empty($this->schoolID))){
        $this->journey_session = $this->teacherdriver->get_current_journey_session($this->driverData['driverID'],$this->schoolID);
        }
      
        if(isset($this->driverData['driverID']) && isset($this->journey_session['driver_journey_session']) && (!empty($this->driverData['driverID'])) && (!empty($this->journey_session['driver_journey_session']))){
          $this->journeyStops = $this->teacherdriver->journeyRemainingStops($this->driverData['driverID'],$this->schoolID,$this->journey_session['driver_journey_session']); 
        }
        
        ///if(isset($this->driverData['driverID']) && isset($this->journey_session['driver_journey_session']) && (!empty($this->driverData['driverID'])) && (!empty($this->journey_session['driver_journey_session']))){
        // $this->student_journey_status = $this->teacherdriver->get_student_journey_status($this->driverData['driverID'],$this->journey_session['driver_journey_session'],$this->studentID,$this->schoolID);
        //}
        
        $teacherData = $this->teacherdriver->teacherDetail($this->schoolID,$this->teacher_id);
        if(isset($teacherData['is_call_enable']))
        $this->callstatus = $teacherData['is_call_enable']; 
        else
        $this->callstatus = "0";
    }
    
    
   
    public function getJourneyStatus_post()
    {
      //$student_journey_status = $this->student_journey_status;
      $driver_journey_session = isset($this->journey_session['driver_journey_session']) ? $this->journey_session['driver_journey_session'] : '';
      $driver_journey_status = isset($this->journey_session['driver_journey_status']) ? $this->journey_session['driver_journey_status'] : ''; 
      
     $jType = "";
     $sMessage=""; 
     $completedJourney = "";
     $endJourneyMsg = "";
     if($driver_journey_session == "" || $driver_journey_session=="morning"){
          $jType = 'pick up';
          $sMessage = 'picked up';
          $completedJourney = "Student picked up successfully";
          $endJourneyMsg = 'Student Dropped successfully to school';
      }
      
      if($driver_journey_session=="afternoon"){
          $jType = 'drop';
          $sMessage = 'Dropped';
          $completedJourney = "Student dropped successfully at stop";
          $endJourneyMsg = 'Driver drop journey completed';
      }       
      
      
      if(empty($this->journey_session)) {
       $return['success'] = "false";
       $return['title'] = "error";
       $return['message'] = "Driver not started the ".$jType." ride yet";
       $return['is_call_enable'] = $this->callstatus;
       $return['error'] = $this->error;
       $this->response($return, REST_Controller::HTTP_BAD_REQUEST);      
      }
     
      
      if((!empty($this->journey_session)) && $driver_journey_status=='1') {
       $return['success'] = "true";
       $return['title'] = "success";
       $return['journey_session'] = $driver_journey_session;
       $return['journey_status'] = 2;
       $return['message'] = $endJourneyMsg;
       $return['is_call_enable'] = $this->callstatus;
       $return['error'] = $this->error;
       $this->response($return, REST_Controller::HTTP_BAD_REQUEST);      
      }
      else 
      {
            $driverCurrentLocation = $this->teacherdriver->driverCurrentLocation($this->driverData['driverID'],$this->schoolID,$driver_journey_session);
            if(!empty($driverCurrentLocation)) {
             $this->driverData['current_latitude'] =  $driverCurrentLocation['latitude']; 
             $this->driverData['current_longitude'] =  $driverCurrentLocation['longitude'];
             $this->driverData['location_title'] =  $driverCurrentLocation['location'];
             $this->driverData['time'] =  $driverCurrentLocation['datetime'];
            }
            else {
            $this->driverData['current_latitude'] =  "0.0"; 
            $this->driverData['current_longitude'] =  "0.0";
            $this->driverData['location_title'] =  "";
            $this->driverData['time'] =  "";    
            }
            
            $return['success'] = "true";
            $return['title'] = "success";
            $return['journey_session'] = $driver_journey_session;
            $return['journey_status'] = 0;
            $return['driver'] = $this->driverData;
            $return['stops'] = $this->journeyStops;
            $return['message'] = "Driver started ".$jType." journey";
            $return['is_call_enable'] = $this->callstatus;
            $return['error'] = $this->error;
            $this->response($return, REST_Controller::HTTP_OK);  
            
          
          
      }
       
    }
   
}
