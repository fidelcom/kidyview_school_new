<?php
defined('BASEPATH') OR exit('No direct script access allowed');
require APPPATH . '/libraries/REST_Controller.php';

class Result extends REST_Controller {

    public $error = array();
    public $data = array();

    function __construct() {
        parent::__construct();
        $this->token->validate();
        $this->load->library("security");
        $this->load->library('form_validation');
        $this->load->model('teachers/results_model','model');
        $this->load->model('studentAttendance_model','smodel');
        $this->load->model('admin/result_model','admin_model');
        $this->load->helper('common_helper');
    }


    public function terms_get(){
        $school_id = $this->token->school_id;
        $terms = $this->model->termsList($school_id);
        if($terms){
            $return['success'] = "true";
            $return['title'] = "success";
            $return['message'] = "Record found successfully.";
            $return['data'] = $terms;
            $return['error'] = $this->error;
            $this->response($return, REST_Controller::HTTP_OK);
        }else{
            $return['success'] = "false";
            $return['title'] = "failed";
            $return['message'] = "No term found.";
            $return['data'] = '';
            $return['total'] = '';
            $return['error'] = $this->error;
            $this->response($return, REST_Controller::HTTP_BAD_REQUEST);   
        }
    }
     public function teacherClasses_get(){

                $school_id =  $this->token->school_id;
                $user_id   =  $this->token->user_id;
     
        $classList = $this->smodel->classList($school_id,$user_id);
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
    public function assessment_get(){
       
        $assessment = array('exam'=>'Exam','test'=>'Test','assignment'=>'Assignment','project'=>'Project');
        if ($assessment) {
                    $return['success'] = "true";
                    $return['message'] = "Assessment List.";
                    $return['data'] = $assessment;
                    $return['error'] = $this->error;

                    $this->response($return, REST_Controller::HTTP_OK);
                    } else {
                    $return['success'] = "false";
                    $return['message'] = "Not found.";
                    $return['error'] = $this->error;
                    $return['data'] ='';

                    $this->response($return, REST_Controller::HTTP_BAD_REQUEST);
            }
    } 
    public function studentTermsResult_post()
    {
        $postData = json_decode(file_get_contents('php://input'), true);
         if ($postData == '') {
                $postData = $_POST;
        }
        $studentResult = $this->model->getStudentsTermsResult($postData);
       
        if (count($studentResult) > 0) {
            $return['success'] = "true";
            $return['message'] = "Student Result.";
            $return['GrandResult'] = $studentResult['grandResult'];
            $return['data'] = $studentResult['result'];
            $return['error'] = $this->error;

            $this->response($return, REST_Controller::HTTP_OK);
            } else {
            $return['success'] = "false";
            $return['message'] = "No result found.";
            $return['error'] = $this->error;
            $return['data'] ='';

            $this->response($return, REST_Controller::HTTP_BAD_REQUEST);
        }
    }
     public function resultIsApproved_post()
    {
      $postData = json_decode(file_get_contents('php://input'), true);
      if ($postData == '') {
          $postData = $_POST;
       }
      $result = $this->model->resultIsApproved($postData);
// prd($result);
          if($result) {
            
            $return['success'] = "true";
            $return['message'] = "Result has been ".$postData['resultStatus']." ";
            $return['data'] = $result;
            $return['error'] = $this->error;
            
            $this->response($return, REST_Controller::HTTP_OK);
          
            }else{
            $return['success'] = "false";
            $return['message'] = "Result status is already ".$postData['resultStatus'].".";
            $return['error'] = $this->error;
            $return['data'] = '';
            
            $this->response($return, REST_Controller::HTTP_BAD_REQUEST);
         }
    }
    public function generateStudentResult_post()
    {
     
      $school_id = $this->token->school_id;
      $postData = json_decode(file_get_contents('php://input'), true);
      if ($postData == '') {
          $postData = $_POST;
       }
       $postData['school_id'] = $school_id;
        $result = $this->model->generateStudentResult($postData['student_id']);  
    // echo $result;
        if($result == 1 || $result == 0 ) 
        {
            $generated = $this->admin_model->calculateStudentsResult($school_id);
        	$return['success'] = "true";
            $return['message'] = "Result has been generated successfully. ";
            $return['data'] = $result;
            $return['error'] = $this->error;
            
            $this->response($return, REST_Controller::HTTP_OK);

            }else{

            $return['success'] = "false";
            $return['message'] = "Something went wrong.";
            $return['error'] = $this->error;
            $return['data'] = '';
            
            $this->response($return, REST_Controller::HTTP_BAD_REQUEST);
            
         }
    }
}