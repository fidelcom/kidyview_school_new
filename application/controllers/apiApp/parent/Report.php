<?php
defined('BASEPATH') OR exit('No direct script access allowed');
require APPPATH . '/libraries/REST_Controller.php';

class Report extends REST_Controller {

    public $error = array();
    public $data = array();

    function __construct() {
        parent::__construct();
        $this->token->parent_validate();
        $this->load->library("security");
        $this->load->library('form_validation');
        $this->load->model('parent/report_model');
        $this->load->helper('common_helper');
    }    
    
    public function daily_get() {    
        $report_type =  $this->input->get('report_type');
        $date =  $this->input->get('date');
        if($date == '')
        {
            $date = date("y-m-d");
        }
        $student_id =  $this->token->student_id;
        $data = $this->report_model->dailyReportExist($report_type,$student_id,$date);
        $this->data = $data;
        if ($data) {

            $return['success'] = "true";
            $return['title'] = "success";
            $return['message'] = "Report data.";
            $return['error'] = (object) $this->error;
            $return['data'] = $this->data;
            $this->response($return, REST_Controller::HTTP_OK);
        }
        else
        {
            $return['success'] = "true";
            $return['title'] = "success";
            $return['message'] = "No data found.";
            $return['error'] = (object) $this->error;
            $return['data'] = array();
            $this->response($return, REST_Controller::HTTP_OK);
        }
        
    }
    
    public function monthly_get() {    
        $student_id =  $this->token->student_id;
        $month =  $this->input->get('month');
        if($month != '')
        {
            $tmp = strtotime($month);
            $month = (date("Y-m",$tmp));
        }
        else
        {
            $month = date("Y-m");
        }
        $data = $this->report_model->monthlyReportExist($student_id,$month);
        $this->data = $data;
        if ($data) {

            $return['success'] = "true";
            $return['title'] = "success";
            $return['message'] = "Monthly report data.";
            $return['error'] = (object) $this->error;
            $return['data'] = $this->data;
            $this->response($return, REST_Controller::HTTP_OK);

        }
        else
        {
            $return['success'] = "true";
            $return['title'] = "success";
            $return['message'] = "No data found.";
            $return['error'] = (object) $this->error;
            $return['data'] = array();
            $this->response($return, REST_Controller::HTTP_OK);
        }
    }
    
    public function term_get() {    
        $student_id =  $this->token->student_id;
        $term_id =  $this->input->get('term_id');
        $data = $this->report_model->termReportExist($student_id,$term_id);
        $this->data = $data;
        if ($data) {

            $return['success'] = "true";
            $return['title'] = "success";
            $return['message'] = "Term report data.";
            $return['error'] = (object) $this->error;
            $return['data'] = $this->data;
            $this->response($return, REST_Controller::HTTP_OK);

        }
        else
        {
            $return['success'] = "true";
            $return['title'] = "success";
            $return['message'] = "No data found.";
            $return['error'] = (object) $this->error;
            $return['data'] = array();
            $this->response($return, REST_Controller::HTTP_OK);
        }
    }
    
    
    public function monthList_get() {    
        $data = $this->report_model->monthsInSession();
        $this->data = $data;
        if ($data) {
            $return['success'] = "true";
            $return['title'] = "success";
            $return['message'] = "Monthly report data.";
            $return['error'] = (object) $this->error;
            $return['data'] = $this->data;
            $this->response($return, REST_Controller::HTTP_OK);
        }
        $return['success'] = "false";
        $return['title'] = "error";
        $return['message'] = "Report does not exist.";
        $return['error'] = (object) $this->error;
        $return['data'] = (object) $this->data;
        $this->response($return, REST_Controller::HTTP_OK);
    }
    
    public function termList_get() {    
        $data = $this->report_model->termList();
        $this->data = $data;
        if ($data) {

            $return['success'] = "true";
            $return['title'] = "success";
            $return['message'] = "Term report data.";
            $return['error'] = (object) $this->error;
            $return['data'] = $this->data;
            $this->response($return, REST_Controller::HTTP_OK);

        }
        $return['success'] = "false";
        $return['title'] = "error";
        $return['message'] = "Report does not exist.";
        $return['error'] = (object) $this->error;
        $return['data'] = (object) $this->data;
        $this->response($return, REST_Controller::HTTP_OK);
    }
    public function termList2_get() {    
        $data = $this->report_model->termList2();
        $this->data = $data;
        if ($data) {

            $return['success'] = "true";
            $return['title'] = "success";
            $return['message'] = "Term report data.";
            $return['error'] = (object) $this->error;
            $return['data'] = $this->data;
            $this->response($return, REST_Controller::HTTP_OK);

        }
        $return['success'] = "false";
        $return['title'] = "error";
        $return['message'] = "Report does not exist.";
        $return['error'] = (object) $this->error;
        $return['data'] = (object) $this->data;
        $this->response($return, REST_Controller::HTTP_OK);
    }
    
    public function studentsCheckInCheckOut_post()
    {
    	 $postData = json_decode(file_get_contents('php://input'), true);
         if ($postData == '') {
                $postData = $_POST;
         }
    	 $school_id   =  $this->token->school_id;
         $studentID   =  $postData['student_id'];
         if(isset($postData['checkdate']) && $postData['checkdate']!="")
         $date  = date('Y-m-d',strtotime($postData['checkdate']));
         else 
         $date  = date('Y-m-d');
    	
         $studentList = $this->report_model->getStudentsCheckInCheckOut($school_id,$studentID,$date);
        if ($studentList) {
        $return['success'] = "true";
        $return['message'] = "Check In Check out Data";
        $return['data'] = $studentList;
        $return['error'] = $this->error;
        $this->response($return, REST_Controller::HTTP_OK);
        } else {
        $return['success'] = "false";
        $return['message'] = "Not found.";
        $return['error'] = $this->error;
        $return['data'] = $studentList;

        $this->response($return, REST_Controller::HTTP_BAD_REQUEST);
        }
    }
        
}
