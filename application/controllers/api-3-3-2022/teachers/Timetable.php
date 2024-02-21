<?php

defined('BASEPATH') OR exit('No direct script access allowed');
require APPPATH . '/libraries/REST_Controller.php';
class Timetable extends REST_Controller {

    public $error = array();
    public $data = array();

    public function __construct() {
        parent::__construct();
        $this->load->model("teachers/Timetable_model",'model');
    }
   
    public function getClassScheduleList_post() {
		$postData = json_decode(file_get_contents('php://input'), true);
		if ($postData == '') {
			$postData = $_POST;
		}
		$data = $this->session->userdata('teacher_data');
		$teacherID = $data['id'];
		$schoolID=$postData['schoolID'];
		$classID=$postData['classID'];
		$result = $this->model->getClassScheduleList($teacherID,$schoolID,$classID);
		$return['success'] = "true";
		$return['message'] = $result?'Class Schedule Found.':'Class Schedule';
		$return['data'] = $result;
		$return['error'] = $this->error;
		$this->response($return, REST_Controller::HTTP_OK);
			
	}
	public function getTeacherClass_post() {
		$postData = json_decode(file_get_contents('php://input'), true);
		if ($postData == '') {
			$postData = $_POST;
		}
		$data = $this->session->userdata('teacher_data');
		$teacherID = $data['id'];
		$schoolID=$postData['schoolID'];
		$result = $this->model->getTeacherClass($teacherID,$schoolID);
		$return['success'] = "true";
		$return['message'] = $result?'Teacher Class Found.':'Teacher Class Not Found';
		$return['data'] = $result;
		$return['error'] = $this->error;
		$this->response($return, REST_Controller::HTTP_OK);
			
	}
   
}
