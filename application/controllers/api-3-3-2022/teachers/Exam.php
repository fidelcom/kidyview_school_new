<?php
defined('BASEPATH') OR exit('No direct script access allowed');
require APPPATH . '/libraries/REST_Controller.php';
class Exam extends REST_Controller {

    public $error = array();
    public $data = array();

    function __construct() {
        parent::__construct();
        $this->load->library("security");
        $this->load->library('form_validation');
        $this->load->model('teachers/Exam_model','model');
        $this->load->helper('common_helper');
    }
    
    public function getExamList_post(){
        $postData = json_decode(file_get_contents('php://input'), true);
		if ($postData == '') {
			$postData = $_POST;
        }
        $data = $this->session->userdata('teacher_data');
		$tid = $data['id'];
        $schoolID=$postData['schoolID'];
        $classID=$postData['classID'];
        $subjectID=$postData['subject_id'];
        $status=$postData['status'];
        $result = $this->model->getExamList($schoolID,$tid,$classID,$subjectID,$status);
        $return['success'] = "true";
        $return['title'] = "success";
        $return['message'] = "Exam List.";
        $return['data'] = $result;
        $return['error'] = $this->error;
        $this->response($return, REST_Controller::HTTP_OK);
    }
    public function getExamDetails_post(){
        $postData = json_decode(file_get_contents('php://input'), true);
		if ($postData == '') {
			$postData = $_POST;
        }
        $schoolID=$postData['schoolID'];
        $examID=$postData['examID'];
        $data = $this->model->getExamDetails($examID,$schoolID);
        $return['success'] = "true";
        $return['title'] = "success";
        $return['message'] = "Exam Details.";
        $return['data'] = $data;
        $return['error'] = $this->error;
        $this->response($return, REST_Controller::HTTP_OK);
    }
    public function getSubmittedExamList_post(){
        $postData = json_decode(file_get_contents('php://input'), true);
		if ($postData == '') {
			$postData = $_POST;
        }
        $data = $this->session->userdata('teacher_data');
		$tid = $data['id'];
        $schoolID=$postData['schoolID'];
        $result = $this->model->getSubmittedExamList($schoolID,$tid);
        $return['success'] = "true";
        $return['title'] = "success";
        $return['message'] = "Exam List.";
        $return['data'] = $result;
        $return['error'] = $this->error;
        $this->response($return, REST_Controller::HTTP_OK);
    }
    public function getSubmittedExamDetails_post(){
        $postData = json_decode(file_get_contents('php://input'), true);
		if ($postData == '') {
			$postData = $_POST;
        }
        $schoolID=$postData['schoolID'];
        $examID=$postData['examID'];
        $data = $this->model->getSubmittedExamDetails($examID,$schoolID);
        $return['success'] = "true";
        $return['title'] = "success";
        $return['message'] = "Exam Details.";
        $return['data'] = $data;
        $return['error'] = $this->error;
        $this->response($return, REST_Controller::HTTP_OK);
    }
    
}
