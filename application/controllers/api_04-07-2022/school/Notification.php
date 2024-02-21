<?php
	
	defined('BASEPATH') OR exit('No direct script access allowed');
	
	require APPPATH . '/libraries/REST_Controller.php';
	
	class Notification extends REST_Controller {
		
		public $error = array();
		public $data = array();
		
		public function __construct() {
			parent::__construct();
			
			//$this->token->validate();
			$this->load->library('form_validation');
			$this->load->library("security");
			$this->load->model('schools/Notification_model','model');
			$this->load->library('settings');
		}
		public function getLatestNotification_post() {
		$postData = json_decode(file_get_contents('php://input'), true);
		if ($postData == '') {
		$postData = $_POST;
		}
		$data = $this->session->userdata('school_data');
		$teacherID = '';
		$schoolID = $postData['schoolID'];
		$limit=3;
		$countUnReadData = $this->model->getNotification('count',$teacherID,$schoolID,'','');
		$countReadData = $this->model->getNotification('count',$teacherID,$schoolID,'','All');
		$result = $this->model->getNotification('data',$teacherID,$schoolID,$limit,'');

		if ($result) {
			$return['success'] = "true";
			$return['message'] = "Notification found.";
			$return['data'] = $result;
			$return['countUnReadData'] = $countUnReadData;
			$return['countReadData'] = $countReadData;
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
		public function updateNotification_post() {
			$postData = json_decode(file_get_contents('php://input'), true);
			if ($postData == '') {
			$postData = $_POST;
			}
			$where = array('id'=>$postData['id']);
			$data['is_read']='1';
			$result = $this->model->updateNotification($where,$data);
			if ($result) {
				$return['success'] = "true";
				$return['message'] = "Notification updated.";
				$return['data'] = $result;
				$return['error'] = $this->error;
				$this->response($return, REST_Controller::HTTP_OK);
				} else {
				$return['success'] = "false";
				$return['message'] = "Not found.";
				$return['error'] = $this->error;
				$this->response($return, REST_Controller::HTTP_BAD_REQUEST);
				}
	}
	public function getAllNotification_post() {
		$postData = json_decode(file_get_contents('php://input'), true);
		if ($postData == '') {
		$postData = $_POST;
		}
		$data = $this->session->userdata('teacher_data');
		$teacherID = $data['id'];
		$schoolID = $postData['schoolID'];
		$limit=100;
		$result = $this->model->getNotification('data',$teacherID,$schoolID,$limit,'All');
		if ($result) {
			$return['success'] = "true";
			$return['message'] = "Notification found.";
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
	public function deleteNotification_post() {
		$sdata = $this->session->userdata('school_data');
		$schoolID = "S-".$sdata['id'];
		$where=array('receiver_id'=>$schoolID);
		$data['is_delete']=1;
		$result = $this->model->updateNotification($where,$data);
		if ($result) {
			$return['success'] = "true";
			$return['message'] = "Notification Deleted.";
			$return['data'] = $result;
			$return['error'] = $this->error;
			$this->response($return, REST_Controller::HTTP_OK);
			} else {
			$return['success'] = "false";
			$return['message'] = "Not deleted.";
			$return['error'] = $this->error;
			$this->response($return, REST_Controller::HTTP_BAD_REQUEST);
		}
	}
}
