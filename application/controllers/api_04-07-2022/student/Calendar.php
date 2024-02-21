<?php
	
	defined('BASEPATH') OR exit('No direct script access allowed');
	
	require APPPATH . '/libraries/REST_Controller.php';
	
	class Calendar extends REST_Controller {
		
		public $error = array();
		public $data = array();
		
		public function __construct() {
			parent::__construct();
			
			//$this->token->validate();
			$this->load->library('form_validation');
			$this->load->library("security");
			$this->load->model('students/Calendar_model','model');
			$this->load->library('settings');
		}
	
		public function getAllCalendarData_post() {
			$postData = json_decode(file_get_contents('php://input'), true);
			if ($postData == '') {
				$postData = $_POST;
			}
			$sdata = $this->session->userdata('student_data');
			$studentID = $sdata['id'];
			$schoolID = $postData['id'];
			$classID = $postData['classID'];
			$calendardate = $postData['calendardate'];
			$iscalendardata = $postData['iscalendardata'];
			$result = $this->model->getAllCalendarData($schoolID,$calendardate,$iscalendardata,$classID,$studentID);
			//print_r($result); die;
			if ($result) {
				$return['success'] = "true";
				$return['message'] = "Calendar Data found.";
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