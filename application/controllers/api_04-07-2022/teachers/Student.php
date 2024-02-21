<?php
	
	defined('BASEPATH') OR exit('No direct script access allowed');
	
	require APPPATH . '/libraries/REST_Controller.php';
	
	class Student extends REST_Controller {
		
		public $error = array();
		public $data = array();
		
		public function __construct() {
			parent::__construct();
			
			//$this->token->validate();
			$this->load->library('form_validation');
			$this->load->library("security");
			$this->load->model('teachers/Teacher_model','model');
			$this->load->library('settings');
		}
	public function getStudentList_post() {
		$postData = json_decode(file_get_contents('php://input'), true);
		if ($postData == '') {
			$postData = $_POST;
		}
		$data = $this->session->userdata('teacher_data');
		$id = $data['id'];
		$result = $this->model->getStudentList($id);
			if ($result) {
					$return['success'] = "true";
					$return['message'] = "Student found.";
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
	
	public function getStudentDetailsById_post() {
		$postData = json_decode(file_get_contents('php://input'), true);
		if ($postData == '') {
			$postData = $_POST;
		}
		$id=$postData['id'];
		$result = $this->model->getStudentDetailsById($id);;
			if ($result) {
					$return['success'] = "true";
					$return['message'] = "Student details found.";
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
	public function deleteSubmitAttachData_post() {
		$postData = json_decode(file_get_contents('php://input'), true);
		if ($postData == '') {
			$postData = $_POST;
		}
		$id = $postData['id'];
		$where=array(
		'id'=>$id
		);
		$tbl_name='submission_attachment';
		$result = $this->model->delete($where,$tbl_name);
		if ($result) {
			$filePath='img/submitassignment/'.$postData['filename'];
			if (file_exists($filePath)) 
            {
			unlink($filePath);
			 }
			$return['success'] = "true";
			$return['message'] = "Deleted successfully.";
			$return['data'] = $result;
			$return['error'] = $this->error;
			
			$this->response($return, REST_Controller::HTTP_OK);
			} else {
			$return['success'] = "false";
			$return['message'] = "Something went wrong.";
			$return['error'] = $this->error;
			$return['data'] = $result;
			$this->response($return, REST_Controller::HTTP_BAD_REQUEST);
		}
	}
}
