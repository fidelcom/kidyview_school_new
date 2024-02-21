<?php
	
	defined('BASEPATH') OR exit('No direct script access allowed');
	require APPPATH . '/libraries/REST_Controller.php';
	class Result extends REST_Controller {
		
		public $error = array();
		public $data = array();
		
		public function __construct() {
			parent::__construct();
			//$this->token->validate();
			$this->load->library('form_validation');
			$this->load->library("security");
			$this->load->model(array('students/Result_model'));
			$this->load->library('settings');
		}
		
	public function getResultList_post() {
		$postData = json_decode(file_get_contents('php://input'), true);
		if ($postData == '') {
			$postData = $_POST;
		}
		$data = $this->session->userdata('student_data');
		$id = $data['id'];
		$class_id=$postData['classID'];
		//$subject_id=$postData['subject_id'];
		//$category=$postData['category'];
		$schoolID=$postData['schoolID'];
		$result = $this->Result_model->getResultList($schoolID,$id,$filterbydate='',$class_id,$subject_id='',$category='');

			if ($result) {
					$return['success'] = "true";
					$return['message'] = "Result found.";
					$return['data'] = $result;
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
	

	public function getStudentExamDetails_post()
    {
        $postData = json_decode(file_get_contents('php://input'), true);
        if ($postData == '') {
          $postData = $_POST;
       }
       $school_id = $postData['school_id']; 
       $student_id = $postData['student_id']; 

      $result = $this->Result_model->getStudentExamDetails($student_id,$school_id);
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

      $result = $this->Result_model->calculateSubjectTermResult($student_id,$school_id);
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

      $result = $this->Result_model->getSubjectGrandsResult($student_id,$school_id);
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
}
