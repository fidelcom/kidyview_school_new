<?php
	
	defined('BASEPATH') OR exit('No direct script access allowed');
	
	require APPPATH . '/libraries/REST_Controller.php';
	
	class Lessonsnote extends REST_Controller {
		
		public $error = array();
		public $data = array();
		
		public function __construct() {
			parent::__construct();
                       
			if($this->session->userdata('user_role')=='school' OR $this->session->userdata('user_role')=='schoolsubadmin'){
			$this->token->validate();
			}
			$this->load->library('form_validation');
			$this->load->library("security");
			$this->load->model('teachers/Lesson_model','lesson');
			$this->load->model('team_model');
			$this->load->library('settings');
		}
                
                
    public function lessonnotelist_post() 
    {
    
       $postData = json_decode(file_get_contents('php://input'), true);
        if ($postData == '') {
            $postData = $_POST;
        }
        $schoolID = $postData['schoolID'];
        //$subclass = $postData['subclass'];
        $result = $this->lesson->alllessonnotelist($schoolID);

        if ($result) {
            $return['success'] = "true";
            $return['message'] = "Teacher Lesson Note List Found";
            $return['data'] = $result;
            $return['error'] = $this->error;

            $this->response($return, REST_Controller::HTTP_OK);
        } else {
            $return['success'] = "false";
            $return['message'] = "No Teacher Lesson Note List Found.";
            $return['error'] = $this->error;
            $return['data'] = '';
            $this->response($return, REST_Controller::HTTP_BAD_REQUEST);
        } 
        
    }  
             
    
    public function viewnote_post() 
    {
    
       $postData = json_decode(file_get_contents('php://input'), true);
        if ($postData == '') {
            $postData = $_POST;
        }
        
        
        $schoolID = $postData['schoolID'];
        $noteid = $postData['noteid'];
        $result = $this->lesson->viewdetailsharednote($schoolID,$noteid);

        if ($result) {
            $return['success'] = "true";
            $return['message'] = "Notes Detail Found";
            $return['data'] = $result;
            $return['error'] = $this->error;

            $this->response($return, REST_Controller::HTTP_OK);
        } else {
            $return['success'] = "false";
            $return['message'] = "No Detail Found";
            $return['error'] = $this->error;
            $return['data'] = '';
            $this->response($return, REST_Controller::HTTP_BAD_REQUEST);
        } 
        
    }
    
    
    public function notedisabled_post() 
    {
    $postData = json_decode(file_get_contents('php://input'), true);
    if ($postData == '') {
    $postData = $_POST;
    }
    $id = $postData['id'];
    $status = $postData['status'];

    $updateArr = array(
    'status' => $status,
    );

    $update = $this->lesson->notedisabled($updateArr, $id);


    if ($update) {
    $return['success'] = "true";
    $return['message'] = "Note Status Disabled Now.";
    $return['error'] = $this->error;
    $return['data'] = $updateArr;

    $this->response($return, REST_Controller::HTTP_OK);
    } else {
    $return['success'] = "false";
    $return['message'] = "Something went wrong.";
    $return['error'] = $this->error;
    $return['data'] = $this->data;

    $this->response($return, REST_Controller::HTTP_BAD_REQUEST);
    }
    }
                
}  