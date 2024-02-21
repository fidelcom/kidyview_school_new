<?php
defined('BASEPATH') OR exit('No direct script access allowed');
require APPPATH . '/libraries/REST_Controller.php';
class Goal extends REST_Controller {

    public $error = array();
    public $data = array();

    function __construct() {
        parent::__construct();
        $this->load->library("security");
        $this->load->library('form_validation');
        $this->load->model('students/Goal_model','model');
        $this->load->helper('common_helper');
    }
    
    public function getGoalList_post(){
        $postData = json_decode(file_get_contents('php://input'), true);
		if ($postData == '') {
			$postData = $_POST;
        }
        $sdata = $this->session->userdata('student_data');
		$studentID = $sdata['id'];
        $schoolID=$postData['schoolID'];
        $classID=$postData['classID'];
        $data = $this->model->allData($schoolID,$classID,$studentID);
        $return['success'] = "true";
        $return['title'] = "success";
        $return['message'] = "Goal List.";
        $return['data'] = $data;
        $return['error'] = $this->error;
        $this->response($return, REST_Controller::HTTP_OK);
    }
    public function getGoalDetails_post(){
        $postData = json_decode(file_get_contents('php://input'), true);
		if ($postData == '') {
			$postData = $_POST;
        }
        $schoolID=$postData['schoolID'];
        $goalID=$postData['goalID'];

        $data = $this->model->getGoalDetails($schoolID,$goalID);
        $return['success'] = "true";
        $return['title'] = "success";
        $return['message'] = "Goal Details.";
        $return['data'] = $data;
        $return['error'] = $this->error;
        $this->response($return, REST_Controller::HTTP_OK);
    }
    
}
