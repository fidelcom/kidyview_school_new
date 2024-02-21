<?php

defined('BASEPATH') OR exit('No direct script access allowed');
require APPPATH . '/libraries/REST_Controller.php';
class TimeTable extends REST_Controller {

    public $error = array();
    public $data = array();

    public function __construct() {
        parent::__construct();
        if($this->session->userdata('user_role')=='school' OR $this->session->userdata('user_role')=='schoolsubadmin'){
			$this->token->validate();
		}
        $this->load->model("admin/scheduler_model");
        $this->load->model('User_model');
    }
    
    public function schoolType_get() {  

        $res = $this->scheduler_model->schoolTypeList();  
        $return['success'] = "true";
        $return['message'] = "School Type List.";
        $return['error'] = "";
        $return['data'] = $res;
        $this->response($res, REST_Controller::HTTP_OK);
    }

    public function getAllClassForSchool_post() {
            $postData = json_decode(file_get_contents('php://input'), true);
            if ($postData == '') {
                $postData = $_POST;
            }
            $id = $postData['id'];
            $result = $this->User_model->getAllClassForSchool($id);
            
            if ($result) {
                $return['success'] = "true";
                $return['message'] = "All Classes details found.";
                $return['data'] = $result;
                $return['error'] = $this->error;
                
                $this->response($return, REST_Controller::HTTP_OK);
                } else {
                $return['success'] = "false";
                $return['message'] = "Not found.";
                $return['error'] = $this->error;
                $return['data'] = '';
                
                $this->response($return, REST_Controller::HTTP_BAD_REQUEST);
            }
    }
    public function getLectures_post()
    {
            $postData = json_decode(file_get_contents('php://input'), true);
            if ($postData == '') {
                $postData = $_POST;
            }
            $school_type = $postData['schoolTyp'];
            if($school_type !=''){
              $result = $this->scheduler_model->getLecturesData($school_type);

                if ($result) {
                        $return['success'] = "true";
                        $return['message'] = "All Classes details found.";
                        $return['data'] = $result;
                        $return['error'] = $this->error;
                        
                        $this->response($return, REST_Controller::HTTP_OK);
                    } else {
                        $return['success'] = "false";
                        $return['message'] = "Not found.";
                        $return['error'] = $this->error;
                        $return['data'] = '';
                        
                        $this->response($return, REST_Controller::HTTP_BAD_REQUEST);
                }
            }
    }
    public function getClasses_post()
    {
         $postData = json_decode(file_get_contents('php://input'), true);
            if ($postData == '') {
                $postData = $_POST;
            }
            $school_type = $postData['school_type'];
            if($school_type !=''){
              $result = $this->scheduler_model->getClasses($postData);
              // lq();
                if ($result) {
                        $return['success'] = "true";
                        $return['message'] = "All Classes List.";
                        $return['data'] = $result;
                        $return['error'] = $this->error;
                        
                        $this->response($return, REST_Controller::HTTP_OK);
                    } else {
                        $return['success'] = "false";
                        $return['message'] = "Not found.";
                        $return['error'] = $this->error;
                        $return['data'] = '';
                        
                        $this->response($return, REST_Controller::HTTP_BAD_REQUEST);
                }
            }
    }
    public function index_post()
    {
         $postData = json_decode(file_get_contents('php://input'), true);
        if ($postData == '') {
                $postData = $_POST;
        }
           $result = $this->scheduler_model->checkClassTimeTable($postData);
           // lq();
             // prd($result);
                if ($result=='schedule_required' ) {
                    $return['success'] = "false";
                    $return['message'] = "schedule_required";
                    $return['data'] = $result;
                    $return['error'] = $this->error;
                    
                    $this->response($return, REST_Controller::HTTP_OK); 
                }else if ($result=='deleted' ) {
                    $return['success'] = "false";
                    $return['message'] = "deleted";
                    $return['data'] = $result;
                    $return['error'] = $this->error;
                    
                    $this->response($return, REST_Controller::HTTP_OK);
                }else if($result){
                    $return['success'] = "true";
                    $return['message'] = "Lecture List";
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
    public function getAllTeacherForSchool_post() {
            $postData = json_decode(file_get_contents('php://input'), true);
            if ($postData == '') {
                $postData = $_POST;
            }
            $id = $postData['id'];
            $result = $this->User_model->getAllTeacherForSchool($id);
            
            if ($result) {
                $return['success'] = "true";
                $return['message'] = "All Teachers details found.";
                $return['data'] = $result;
                $return['error'] = $this->error;
                
                $this->response($return, REST_Controller::HTTP_OK);
                } else {
                $return['success'] = "false";
                $return['message'] = "Not found.";
                $return['error'] = $this->error;
                $return['data'] = '';
                
                $this->response($return, REST_Controller::HTTP_BAD_REQUEST);
            }
        }
        public function getAllSubjectForClass_post()
        {
             $postData = json_decode(file_get_contents('php://input'), true);
            if ($postData == '') {
                $postData = $_POST;
            }
            $result = $this->scheduler_model->getAllSubjectForClass($postData);
            // prd($result);
            if ($result) {
                $return['success'] = "true";
                $return['message'] = "All Subject List.";
                $return['data'] = $result;
                $return['error'] = $this->error;
                
                $this->response($return, REST_Controller::HTTP_OK);
                } else {
                $return['success'] = "false";
                $return['message'] = "Not found.";
                $return['error'] = $this->error;
                $return['data'] = '';
                
                $this->response($return, REST_Controller::HTTP_BAD_REQUEST);
            }
        }
        public function updateTimeTable_post()
        {
            $postData = json_decode(file_get_contents('php://input'), true);
            if ($postData == '') {
                $postData = $_POST;
            }
            $checkAssigned = $postData;
            // prd($postData);
            $postData = array(
                    'id'                    =>$postData['id'],
                    'subject_id'            =>$postData['subject_id'],
                    'teacher_id'            =>$postData['teacher_id'],
                    'zoom_link'             =>$postData['zoom_link'],
                    'other_info'            =>$postData['other_info'],
                    'updated_at'            => date('Y-m-d H:i:s')
                );
            $result = $this->scheduler_model->updateTimeTable($postData,$checkAssigned);
// prd($result);
            if ($result==1) {
                $return['success'] = true;
                $return['message'] = "Time-table has been updated.";
                $return['data'] = $result;
                $return['error'] = $this->error;
                
                $this->response($return, REST_Controller::HTTP_OK);
//                } else if($result==2){
//                $return['success'] = true;
//                $return['message'] = "You selected teacher already assigned.";
//                $return['error'] = $this->error;
//                $return['data'] = $result;
//                $this->response($return, REST_Controller::HTTP_OK);
            }else{
                $return['success'] = "false";
                $return['message'] = "Not found.";
                $return['error'] = $this->error;
                $return['data'] = '';
                
                $this->response($return, REST_Controller::HTTP_BAD_REQUEST);
            }
        }

    public function index_get() {       	
        $res = $this->scheduler_model->data();        
         // prd($res);
        $return['success'] = "true";
        $return['message'] = "Scheduler List.";
        $return['error'] = "";
        $return['data'] = $res;
        
        $this->response($res, REST_Controller::HTTP_OK);
    }
    public function details_post() { 

            $postData = json_decode(file_get_contents('php://input'), true);
            if ($postData == '') {
                $postData = $_POST;
            }
            $scheduleID = $postData['scheduleID'];
            $result = $this->scheduler_model->detail($scheduleID);  
            if ($result) {
                $return['success'] = "true";
                $return['message'] = "Class Schedule found.";
                $return['data'] = $result;
                $return['error'] = $this->error;
                
                $this->response($return, REST_Controller::HTTP_OK);
                } else {
                $return['success'] = "false";
                $return['message'] = "Not found.";
                $return['error'] = $this->error;
                $return['data'] = '';
                
                $this->response($return, REST_Controller::HTTP_BAD_REQUEST);
            }
        $return['success'] = "true";
        $return['message'] = "Class Schedule Detail.";
        $return['error'] = "";
        $return['data'] = $res;
        $this->response($res, REST_Controller::HTTP_OK);
    }
}
