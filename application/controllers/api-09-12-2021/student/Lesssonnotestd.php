<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Lesssonnotestd extends  REST_Controller {

    public $stdclass = "";
    public $student_id = "";
    public $error = array();
    
    public function __construct() {
        
        parent::__construct();
        $this->load->library('form_validation');
        $this->load->library("security");
        $this->load->library('settings');
        $this->load->helper('common_helper');
        $this->load->model('students/Studentnotes_model','lesson');
        $data = $this->session->userdata('student_data');
        $this->student_id = $data['id'];
        $stddata = $this->lesson->studentdata($this->student_id);
        if($stddata){
         $this->stdclass = $stddata->childclass;  
        }
      
    }
    
  public function studentlessonlist_post() 
    {
       $postData = json_decode(file_get_contents('php://input'), true);
        if ($postData == '') {
            $postData = $_POST;
        }
        
        $class_id= $this->stdclass;
        $schoolID= $postData['schoolID'];
        $result = $this->lesson->studentlessonlist($schoolID,$class_id);

        if ($result) {
            $return['success'] = "true";
            $return['message'] = "Lesson Note List Found";
            $return['data'] = $result;
            $return['error'] = $this->error;
            $this->response($return, REST_Controller::HTTP_OK);
        } else {
            $return['success'] = "false";
            $return['message'] = "No Lesson Note Found.";
            $return['error'] = $this->error;
            $return['data'] = '';
            $this->response($return, REST_Controller::HTTP_BAD_REQUEST);
        } 
        
    } 
    
    
    public function viewdetailsharednote_post() 
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
    
    
    public function addcomment_post() 
    {
       $postData = json_decode(file_get_contents('php://input'), true);
        if ($postData == '') {
            $postData = $_POST;
        }
        
        $student_id = $this->student_id;
        $schoolID = $postData['schoolID'];
        $noteid = $postData['noteid'];
        $comment = $postData['comment'];
        
        $datarray = array(
          'noteid' => $noteid, 
          'schoolid' => $schoolID,
          'commentId' => $student_id,
          'commentFrom' => 'student',  
          'comment' => $comment,
          'status'=>'0', 
          'created_date' => date('Y-m-d H:i:s') 
        );
        
        $result = $this->lesson->addcomment($datarray);
        if ($result) {
            $return['success'] = "true";
            $return['message'] = "Comment Added Successfully";
            $return['data'] = $result;
            $return['error'] = $this->error;
            $this->response($return, REST_Controller::HTTP_OK);
        } else {
            $return['success'] = "false";
            $return['message'] = "Error occured while adding Comment";
            $return['error'] = $this->error;
            $return['data'] = '';
            $this->response($return, REST_Controller::HTTP_BAD_REQUEST);
        }
        
    }
    
    
    public function commentlist_post() 
    {
    
       $postData = json_decode(file_get_contents('php://input'), true);
        if ($postData == '') {
            $postData = $_POST;
        }
        
        
        $schoolID = $postData['schoolID'];
        $noteid = $postData['noteid'];
        $student_id = $this->student_id;
        $result = $this->lesson->commentlist($schoolID,$noteid,$student_id);

        if ($result) {
            $return['success'] = "true";
            $return['message'] = "Comment List Found";
            $return['data'] = $result;
            $return['error'] = $this->error;

            $this->response($return, REST_Controller::HTTP_OK);
        } else {
            $return['success'] = "false";
            $return['message'] = "No Comment Found";
            $return['error'] = $this->error;
            $return['data'] = '';
            $this->response($return, REST_Controller::HTTP_BAD_REQUEST);
        } 
        
    }
    
    
}   