<?php
defined('BASEPATH') OR exit('No direct script access allowed');
require APPPATH . '/libraries/REST_Controller.php';
class Result extends REST_Controller {

    public $error = array();
    public $data = array();

    public function __construct() {
        parent::__construct();
        if($this->session->userdata('user_role')=='school' OR $this->session->userdata('user_role')=='schoolsubadmin'){
          $this->token->validate();
        }
        $this->load->model("admin/result_model",'model');
    }
    
    public function calculateStudentsResult_post() {  	
        $postData = json_decode(file_get_contents('php://input'), true);
     if ($postData == '') {
        $postData = $_POST;
     }
     //print_r($postData);die;
      $school_id = $postData['school_id'];

      $result = $this->model->calculateStudentsResult($school_id,$postData['session_id']);
// prd($result);
        	if($result) {
            
            $return['success'] = "true";
            $return['message'] = "Student result saved successfully.";
            $return['data'] = $result;
            $return['error'] = $this->error;
            
            $this->response($return, REST_Controller::HTTP_OK);
          
          	}else{
            $return['success'] = "false";
            $return['message'] = "No record found.";
            $return['error'] = $this->error;
            $return['data'] = '';
            
            $this->response($return, REST_Controller::HTTP_BAD_REQUEST);
         }
    }
    public function getStudentsResultList_post()
    {
      $postData = json_decode(file_get_contents('php://input'), true);
      if ($postData == '') {
        $postData = $_POST;
      }
      $result = $this->model->getStudentResult($postData);
          if($result) {
            
            $return['success'] = "true";
            $return['message'] = "Student result list data.";
            $return['data'] = $result;
            $return['error'] = $this->error;
            
            $this->response($return, REST_Controller::HTTP_OK);
          
            }else{
            $return['success'] = "false";
            $return['message'] = "No record found.";
            $return['error'] = $this->error;
            $return['data'] = '';
            
            $this->response($return, REST_Controller::HTTP_BAD_REQUEST);
         }
    }
    public function getStudentExamDetails_post()
    {
      $postData = json_decode(file_get_contents('php://input'), true);
      if ($postData == '') {
          $postData = $_POST;
      }
      $school_id = $postData['school_id']; 
      $student_id = $postData['student_id']; 

      $result = $this->model->getStudentExamDetails($student_id,$school_id,$postData['session_id']);
// prd($result);
          if($result) {
            
            $return['success'] = "true";
            $return['message'] = "Student result list data.";
            $return['data'] = $result;
            $return['error'] = $this->error;
            
            $this->response($return, REST_Controller::HTTP_OK);
          
            }else{
            $return['success'] = "false";
            $return['message'] = "No record found.";
            $return['error'] = $this->error;
            $return['data'] = '';
            
            $this->response($return, REST_Controller::HTTP_BAD_REQUEST);
         }
    }
    public function calculateSubjectTermResult_post()
    {
      $postData = json_decode(file_get_contents('php://input'), true);
      if ($postData == '') {
          $postData = $_POST;
       }
       $school_id = $postData['school_id']; 
       $student_id = $postData['student_id']; 

      $result = $this->model->calculateSubjectTermResult($student_id,$school_id,$postData['session_id']);
// prd($result);
          if($result) {
            
            $return['success'] = "true";
            $return['message'] = "Student subject wise term result list data.";
            $return['data'] = $result;
            $return['error'] = $this->error;
            
            $this->response($return, REST_Controller::HTTP_OK);
          
            }else{
            $return['success'] = "false";
            $return['message'] = "No record found.";
            $return['error'] = $this->error;
            $return['data'] = '';
            
            $this->response($return, REST_Controller::HTTP_BAD_REQUEST);
         }
    }
    public function getSubjectGrandsResult_post()
    {
      $postData = json_decode(file_get_contents('php://input'), true);
      if ($postData == '') {
          $postData = $_POST;
       }
       $school_id = $postData['school_id']; 
       $student_id = $postData['student_id']; 

      $result = $this->model->getSubjectGrandsResult($student_id,$school_id,$postData['session_id']);
//prd($result);die;
          if($result) {
            
            $return['success'] = "true";
            $return['message'] = "Student final result list data.";
            $return['data'] = $result;
            $return['error'] = $this->error;
            
            $this->response($return, REST_Controller::HTTP_OK);
          
            }else{
            $return['success'] = "false";
            $return['message'] = "No record found.";
            $return['error'] = $this->error;
            $return['data'] = '';
            
            $this->response($return, REST_Controller::HTTP_BAD_REQUEST);
         }
    }
    public function resultIsApproved_post()
    {
      $postData = json_decode(file_get_contents('php://input'), true);
      if ($postData == '') {
          $postData = $_POST;
       }
       //prd($postData);
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
      $postData = json_decode(file_get_contents('php://input'), true);
      if ($postData == '') {
          $postData = $_POST;
       }
// prd($postData);
      $result = $this->model->generateStudentResult($postData);
// prd($result);
          if($result) {
            
            $return['success'] = "true";
            $return['message'] = "Result has been generated successfully. ";
            $return['data'] = $result;
            $return['error'] = $this->error;
            
            $this->response($return, REST_Controller::HTTP_OK);
          
            }else{
            $return['success'] = "false";
            $return['message'] = "No record found.";
            $return['error'] = $this->error;
            $return['data'] = '';
            
            $this->response($return, REST_Controller::HTTP_BAD_REQUEST);
         }
    }
}
