<?php
defined('BASEPATH') OR exit('No direct script access allowed');
require APPPATH . '/libraries/REST_Controller.php';

class Teacherdriver extends REST_Controller {

    public $error = array();
    public $data = array();
    
    public $school_id = "";
    public $teacher_id = "";
    public $driversId = "";
    public $callstatus = "";

    function __construct() {
        parent::__construct();
        $this->token->validate();
        $this->load->library("security");
        $this->load->library('form_validation');
        $this->load->model('teachers/Teacherdriver_model', 'teacherdriver');
        $this->load->helper('common_helper');
        $this->teacher_id = $this->token->user_id;
        $this->school_id = $this->token->school_id;
        
        $teacherData = $this->teacherdriver->teacherDetail($this->school_id,$this->teacher_id);
        if(isset($teacherData['is_call_enable']))
        $this->callstatus = $teacherData['is_call_enable']; 
        else
        $this->callstatus = "0";
        
        //echo $this->token->user_id.'-----'.$this->token->school_id;
    }
    
    
    public function driver_post() 
    {
       
       $postData = json_decode(file_get_contents('php://input'), true);
        if ($postData == '') {
        $postData = $_POST;
        } 
       
        $driverid   = isset($postData['driverid']) ? $postData['driverid'] : "" ; 
        
        
        
       if($driverid != "" || $driverid!='0')
       {
            $drivers = $this->teacherdriver->driver($this->school_id,$driverid);
            if($drivers) 
            {
            $return['success'] = "true";
            $return['title'] = "success";
            $return['message'] = "Drievr Found.";
            $return['data'] = $drivers;
            $return['is_call_enable'] = $this->callstatus;
            $return['error'] = $this->error;
            $this->response($return, REST_Controller::HTTP_OK);    
            }
            else 
            {
            $return['success'] = "false";
            $return['title'] = "error";
            $return['message'] = "No Driver Found.";
            $return['error'] = $this->error;
            $this->response($return, REST_Controller::HTTP_BAD_REQUEST);      
            }
           
       }
       else 
       {
        $return['success'] = "false";
        $return['title'] = "error";
        $return['message'] = "Please pass the valid 'driverid' as input";
        $return['error'] = $this->error;
        $this->response($return, REST_Controller::HTTP_BAD_REQUEST);    
       }
    }
    
    
    
    public function studentlist_post() 
    {
        $postData = json_decode(file_get_contents('php://input'), true);
        if ($postData == '') {
        $postData = $_POST;
        } 
        $classid   = isset($postData['classid']) ? $postData['classid'] : "" ;
        if($classid == "" || $classid=='0')
        {
        $return['success'] = "false";
        $return['title'] = "error";
        $return['message'] = "No student assigned for this class";
        $return['error'] = $this->error;
        $this->response($return, REST_Controller::HTTP_BAD_REQUEST);    
        }
        
        $students = $this->teacherdriver->studentlist($classid,$this->school_id);
        
        if($students)
         {
            $return['success'] = "true";
            $return['title'] = "success";
            $return['message'] = "Student List Found.";
            $return['data'] = $students;
            $return['is_call_enable'] = $this->callstatus;
            $return['error'] = $this->error;
            $this->response($return, REST_Controller::HTTP_OK);    
          }
            else 
          {
            $return['success'] = "false";
            $return['title'] = "error";
            $return['message'] = "No Student Found For This Driver";
            $return['error'] = $this->error;
            $this->response($return, REST_Controller::HTTP_BAD_REQUEST);      
           }
        
     }
     
     
     
     public function journeyLogStudents_post(){
    
        $postData = json_decode(file_get_contents('php://input'), true);
        if ($postData == '') {
            $postData = $_POST;
        }
        $schoolid = isset($this->school_id) ? $this->school_id : "";
        $driverID = isset($postData['driverID']) ? $postData['driverID'] : "";
        $studentID = isset($postData['studentID']) ? $postData['studentID'] : "";
        $result = $this->teacherdriver->journeyLogStudents($schoolid,$driverID,$studentID);
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
