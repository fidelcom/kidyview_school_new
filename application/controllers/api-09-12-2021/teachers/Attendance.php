<?php	
	defined('BASEPATH') OR exit('No direct script access allowed');
	require APPPATH . '/libraries/REST_Controller.php';
	class Attendance extends REST_Controller {
		
		public $error = array();
		public $data = array();
		
		public function __construct() {
			parent::__construct();
			//$this->token->validate();
			$this->load->library('form_validation');
			$this->load->library("security");
			$this->load->model('teachers/Attendance_model','attendance');
			$this->load->library('settings');
		}
		
	public function getTeachersBySchoolType_post() {
		$postData = json_decode(file_get_contents('php://input'), true);
		if ($postData == '') {
			$postData = $_POST;
		}
		$result = $this->attendance->getTeachersBySchoolType($postData);
// prd($result);
			if ($result) {
					$return['success'] = "true";
					$return['message'] = "Teacher list found.";
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
	public function teacherAttendanceBySchool_post()
	{
		$postData = json_decode(file_get_contents('php://input'), true);
		if ($postData == '') {
			$postData = $_POST;
		}
// prd($postData);
		$result = $this->attendance->teacherAttendanceBySchool($postData);
			if ($result) {
					$return['success'] = "true";
					$return['message'] = "Teacher attendance punched successfully.";
					$return['data'] = $result;
					$return['error'] = $this->error;

					$this->response($return, REST_Controller::HTTP_OK);
					} else {

					$attendance_date =	!empty($postData['attendance_date']) ? $postData['attendance_date'] : '';
					$return['success'] = "false";
					$return['message'] = "Attendance already available on this date: $attendance_date.";
					$return['error'] = $this->error;
					$return['data'] = $result;
					$this->response($return, REST_Controller::HTTP_BAD_REQUEST);
			}	
	}	
}
