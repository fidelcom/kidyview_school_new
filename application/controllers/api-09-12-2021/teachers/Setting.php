<?php
	
	defined('BASEPATH') OR exit('No direct script access allowed');
	
	require APPPATH . '/libraries/REST_Controller.php';
	
	class Setting extends REST_Controller {
		
		public $error = array();
		public $data = array();
		
		public function __construct() {
			parent::__construct();
			
			//$this->token->validate();
			$this->load->library('form_validation');
			$this->load->library("security");
			$this->load->model('teachers/Setting_model','model');
			$this->load->library('settings');
		}
		public function getNotificationSetting_post() {
		$postData = json_decode(file_get_contents('php://input'), true);
		if ($postData == '') {
		$postData = $_POST;
		}
		$data = $this->session->userdata('teacher_data');
		$userID = "T-".$data['id'];
		$schoolID = $postData['schoolID'];
		$result = $this->model->getNotificationSetting($userID,$schoolID);
		if ($result) {
			$return['success'] = "true";
			$return['message'] = "Notification Settings found.";
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
		public function updateNotificationSetting_post() {
			$postData = json_decode(file_get_contents('php://input'), true);
			if ($postData == '') {
			$postData = $_POST;
			}
			//print_r(json_decode($postData['data']));die;
			$data=array();
			$data[]=$postData['data'];
			$tbl_name="notification_settings";
			$update = $this->model->update($data,$tbl_name);
			if ($update) {
				$return['success'] = "true";
				$return['message'] = "Settings updated.";
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
