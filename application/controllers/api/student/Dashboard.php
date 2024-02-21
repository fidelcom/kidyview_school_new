<?php
	
	defined('BASEPATH') OR exit('No direct script access allowed');
	
	require APPPATH . '/libraries/REST_Controller.php';
	
	class Dashboard extends REST_Controller {
		public $error = array();
		public $data = array();
		
		public function __construct() {
			parent::__construct();
			
			//$this->token->validate();
			$this->load->library('form_validation');
			$this->load->library("security");
			$this->load->model('students/Dashboard_model','model');
			$this->load->library('settings');
		}
	
	public function getSubjectList_post() {
		$postData = json_decode(file_get_contents('php://input'), true);
		if ($postData == '') {
			$postData = $_POST;
		}
		$classID=$postData['classID'];
		$schoolID=$postData['schoolID'];
		$result = $this->model->getSubjectList($schoolID,$classID);
		$return['success'] = "true";
		$return['message'] = $result?'Subject found.':'Not Found';
		$return['data'] = $result;
		$return['error'] = $this->error;
		$this->response($return, REST_Controller::HTTP_OK);
			
	}
	public function getAllToDoDataList_post() {
		$postData = json_decode(file_get_contents('php://input'), true);
		if ($postData == '') {
			$postData = $_POST;
		}
		$data = $this->session->userdata('student_data');
		$id = $data['id'];
		$classID=$postData['classID'];
		$schoolID=$postData['schoolID'];
		$result = $this->model->getAllToDoDataList($id,$schoolID,$classID);
		$removeData = $this->model->countRemoveToDoDaTA($id);
		$return['success'] = "true";
		$return['message'] = $result?'To Do found.':'Not Found';
		$return['data'] = $result;
		$return['removeData'] = $removeData;
		$return['error'] = $this->error;
		$this->response($return, REST_Controller::HTTP_OK);	
	}

	public function getSubjectDetails_post() {
		$postData = json_decode(file_get_contents('php://input'), true);
		if ($postData == '') {
			$postData = $_POST;
		}
		$subjectID=$postData['id'];
		$classID=$postData['classID'];
		$result = $this->model->getSubjectDetails($subjectID,$classID);
		$return['success'] = "true";
		$return['message'] = $result?'Subject found.':'Not Found';
		$return['data'] = $result;
		$return['error'] = $this->error;
		$this->response($return, REST_Controller::HTTP_OK);
			
	}
	public function deleteToDo_post() {
		$postData = json_decode(file_get_contents('php://input'), true);
		if ($postData == '') {
			$postData = $_POST;
		}
		$udata = $this->session->userdata('student_data');
	
		$data['to_do_id'] = $postData['id'];
		$data['type'] = $postData['type'];
		$data['user_id'] = "ST-".$udata['id'];
		$tbl_name='to_do_remove_data';
		$add = $this->model->add($data,$tbl_name);
		//echo $this->db->last_query();
		if ($add) {
			$return['success'] = "true";
			$return['message'] = "To Do deleted successfully.";
			$return['data'] = $add;
			$return['error'] = $this->error;
			
			$this->response($return, REST_Controller::HTTP_OK);
			} else {
			$return['success'] = "false";
			$return['message'] = "Something went wrong.";
			$return['error'] = $this->error;
			$return['data'] = $add;
			$this->response($return, REST_Controller::HTTP_BAD_REQUEST);
		}
	}
	public function showToDoRemoveData_post() {
		$postData = json_decode(file_get_contents('php://input'), true);
		if ($postData == '') {
			$postData = $_POST;
		}
		$udata = $this->session->userdata('student_data');
		$user_id = "ST-".$udata['id'];
		$tbl_name='to_do_remove_data';
		$where=array(
			'user_id'=>$user_id
		);
		$delete = $this->model->delete($where,$tbl_name);
		if ($delete) {
			$return['success'] = "true";
			$return['message'] = "To Do Data successfully.";
			$return['data'] = $delete;
			$return['error'] = $this->error;
			
			$this->response($return, REST_Controller::HTTP_OK);
			} else {
			$return['success'] = "false";
			$return['message'] = "Something went wrong.";
			$return['error'] = $this->error;
			$return['data'] = $delete;
			$this->response($return, REST_Controller::HTTP_BAD_REQUEST);
		}
	}
	
}
