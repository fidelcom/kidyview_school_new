<?php
	
	defined('BASEPATH') OR exit('No direct script access allowed');
	
	require APPPATH . '/libraries/REST_Controller.php';
	
	class Activityperformance extends REST_Controller {
		
		public $error = array();
		public $data = array();
		
		public function __construct() {
			parent::__construct();
			
			//$this->token->validate();
			$this->load->library('form_validation');
			$this->load->library("security");
			$this->load->model('schools/Activityperformance_model','model');
			$this->load->library('settings');
		}
		public function getActivityPerformance_post() {
		$postData = json_decode(file_get_contents('php://input'), true);
		if ($postData == '') {
		$postData = $_POST;
		}
		$schoolID = $postData['schoolID'];
		$result = $this->model->getActivityPerformance($schoolID);
		if ($result) {
			$return['success'] = "true";
			$return['message'] = "Activity performance found.";
			$return['data'] = $result;
			$return['error'] = $this->error;

			$this->response($return, REST_Controller::HTTP_OK);
			} else {
			$return['success'] = "false";
			$return['message'] = "Not found.";
			$return['error'] = $this->error;
			$return['data'] = $result;
			$return['countData'] = 0;

			$this->response($return, REST_Controller::HTTP_BAD_REQUEST);
			}
		}
		public function updateActivityPerformance_post() {
			$postData = json_decode(file_get_contents('php://input'), true);
			if ($postData == '') {
			$postData = $_POST;
			}
			//print_r(json_decode($postData['data']));die;
			$data=array();
			$postData['updated_at']=date('Y-m-d H:i:s');
			$where=array('id'=>$postData['id'],'school_id'=>$postData['schoolID']);
			$tbl_name="activities_performance";
			unset($postData['schoolID']);
			unset($postData['id']);
			$update = $this->model->update($postData,$tbl_name,$where);
			if ($update) {
				$return['success'] = "true";
				$return['message'] = "Activity performance updated.";
				$return['data'] = $update;
				$return['error'] = $this->error;
				$this->response($return, REST_Controller::HTTP_OK);
				} else {
				$return['success'] = "false";
				$return['message'] = "Not found.";
				$return['error'] = $this->error;
				$this->response($return, REST_Controller::HTTP_BAD_REQUEST);
			}
	}

}
