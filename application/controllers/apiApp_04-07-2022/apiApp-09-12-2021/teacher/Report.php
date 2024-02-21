<?php
defined('BASEPATH') OR exit('No direct script access allowed');
require APPPATH . '/libraries/REST_Controller.php';

class Report extends REST_Controller {

    public $error = array();
    public $data = array();

    function __construct() {
        parent::__construct();
        $this->token->validate();
        $this->load->library("security");
        $this->load->library('form_validation');
        $this->load->model('report_model');
        $this->load->helper('common_helper');
    }    
    public function index_get(){
        $data = $this->report_model->data();
        $total = $this->report_model->dataCount();
        
        $return['success'] = "true";
        $return['title'] = "success";
        $return['message'] = "Record found successfully.";
        $return['classData'] = $data;
        $return['total'] = $total;
        $return['error'] = $this->error;
        $this->response($return, REST_Controller::HTTP_OK);        
    }   

    public function daily_post() {
        $postData = json_decode(file_get_contents('php://input'), true);
                                
        $postData = $this->security->xss_clean($postData);
        $this->form_validation->set_error_delimiters('', '');
        $this->form_validation->set_data($postData);
        $this->form_validation->set_rules('report_type', 'Report Type', 'trim|required');
        $this->form_validation->set_rules('options', 'Answer', 'trim');
        $this->form_validation->set_rules('other', 'other', 'trim');
        $this->form_validation->set_rules('message', 'Message', 'trim');
        $this->form_validation->set_rules('student_id', 'Student', 'trim|required');

        if ($this->form_validation->run() === false) {
            $this->error = $this->form_validation->error_array();
            $message = validation_errors();
            $return['success'] = "false";
            $return['title'] = "error";
            $return['message'] = "$message";
            $return['error'] = $this->error;
            $return['data'] = (object) $this->data;
            $this->response($return, REST_Controller::HTTP_BAD_REQUEST);
        }
        
        $exist = $this->report_model->dailyReportExist($postData['report_type'],$postData['student_id'],date('Y-m-d'));
        
        if($exist)
        {
            $return['success'] = "false";
            $return['title'] = "error";
            $return['message'] = "Report already exist.";
            $return['error'] = (object) $this->error;
            $return['data'] = (object) $this->data;
            $this->response($return, REST_Controller::HTTP_OK);
        }
        else
        {        
            $formData = array();
            $formData['report_type'] = $postData['report_type'];
            if($postData['options'] != '')
            {
                $formData['options'] = $postData['options'];
            }
            if($postData['other'] != '')
            {
                $formData['other'] = $postData['other'];
            }
            if($postData['message'] != '')
            {
                $formData['message'] = $postData['message'];
            }

            $formData['student_id'] = $postData['student_id'];
            $formData['school_id'] = $this->token->school_id;
            $formData['created_by'] = "T-".$this->token->user_id;
            $formData['on_date'] = date("Y-m-d");

            $dataid = $this->report_model->add($formData);
            $this->data = $dataid;
            if ($dataid) {

                $return['success'] = "true";
                $return['title'] = "success";
                $return['message'] = "Report added successfully.";
                $return['error'] = (object) $this->error;
                $return['data'] = $this->data;
                $this->response($return, REST_Controller::HTTP_OK);

            }
            $return['success'] = "false";
            $return['title'] = "error";
            $return['message'] = "Report not added.";
            $return['error'] = (object) $this->error;
            $return['data'] = (object) $this->data;
            $this->response($return, REST_Controller::HTTP_BAD_REQUEST);
        }
        
    }
    public function daily_put() {
        $postData = json_decode(file_get_contents('php://input'), true);
                                   
        $postData = $this->security->xss_clean($postData);
        $this->form_validation->set_error_delimiters('', '');
        $this->form_validation->set_data($postData);
        $this->form_validation->set_rules('id', 'Report ID', 'trim|required');
        $this->form_validation->set_rules('options', 'Answer', 'trim');
        $this->form_validation->set_rules('other', 'other', 'trim');
        $this->form_validation->set_rules('message', 'Message', 'trim');

        if ($this->form_validation->run() === false) {
            $this->error = $this->form_validation->error_array();
            $message = validation_errors();
            $return['success'] = "false";
            $return['title'] = "error";
            $return['message'] = "$message";
            $return['error'] = $this->error;
            $return['data'] = (object) $this->data;
            $this->response($return, REST_Controller::HTTP_BAD_REQUEST);
        }
        
        $id = $postData['id'];
        
        $data = array(
            'options'=>$postData['options'],
            'other'=>$postData['other'],
            'message'=>$postData['message'],
        );
        
        $exist = $this->report_model->update($id,$data);        
        
        $return['success'] = "true";
        $return['title'] = "success";
        $return['message'] = "Report updated successfully.";
        $return['error'] = (object) $this->error;
        $return['data'] = $this->data;
        $this->response($return, REST_Controller::HTTP_OK);                       
        
        
    }
    public function daily_get() {    
        $report_type =  $this->input->get('report_type');
        $student_id =  $this->input->get('student_id');
        $date =  $this->input->get('date');
        if($date == '')
        {
            $date = date("y-m-d");
        }
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
        $return['success'] = "false";
        $return['title'] = "error";
        $return['message'] = "Report not exist.";
        $return['error'] = (object) $this->error;
        $return['data'] = (object) $this->data;
        $this->response($return, REST_Controller::HTTP_OK);
    }
    
    public function monthly_post() {
        $postData = json_decode(file_get_contents('php://input'), true);
                                
        $postData = $this->security->xss_clean($postData);
        $this->form_validation->set_error_delimiters('', '');
        $this->form_validation->set_data($postData);
        $this->form_validation->set_rules('detail', 'Detail', 'trim|required');
        $this->form_validation->set_rules('student_id', 'Student', 'trim|required');

        if ($this->form_validation->run() === false) {
            $this->error = $this->form_validation->error_array();
            $message = validation_errors();
            $return['success'] = "false";
            $return['title'] = "error";
            $return['message'] = "$message";
            $return['error'] = $this->error;
            $return['data'] = (object) $this->data;
            $this->response($return, REST_Controller::HTTP_BAD_REQUEST);
        }
        
        $exist = $this->report_model->monthlyReportExist($postData['student_id'],date('Y-m'));
        
        if($exist)
        {
            $return['success'] = "false";
            $return['title'] = "error";
            $return['message'] = "Report already exist.";
            $return['error'] = (object) $this->error;
            $return['data'] = (object) $this->data;
            $this->response($return, REST_Controller::HTTP_OK);
        }
        else
        {        
            $formData = array();
            $formData['detail'] = $postData['detail'];            
            $formData['for_month'] = date("Y-m");            
            $formData['student_id'] = $postData['student_id'];
            $formData['school_id'] = $this->token->school_id;
            $formData['created_by'] = "T-".$this->token->user_id;
            $formData['created_date'] = date("Y-m-d");

            $dataid = $this->report_model->addMonthly($formData);
            $this->data = $dataid;
            if ($dataid) {

                $return['success'] = "true";
                $return['title'] = "success";
                $return['message'] = "Monthly report added successfully.";
                $return['error'] = (object) $this->error;
                $return['data'] = $this->data;
                $this->response($return, REST_Controller::HTTP_OK);

            }
            $return['success'] = "false";
            $return['title'] = "error";
            $return['message'] = "Report not added.";
            $return['error'] = (object) $this->error;
            $return['data'] = (object) $this->data;
            $this->response($return, REST_Controller::HTTP_BAD_REQUEST);
        }
        
    }
    public function monthly_put() {
        $postData = json_decode(file_get_contents('php://input'), true);
                                   
        $postData = $this->security->xss_clean($postData);
        $this->form_validation->set_error_delimiters('', '');
        $this->form_validation->set_data($postData);
        $this->form_validation->set_rules('id', 'Report ID', 'trim|required');
        $this->form_validation->set_rules('detail', 'Detail', 'trim|required');

        if ($this->form_validation->run() === false) {
            $this->error = $this->form_validation->error_array();
            $message = validation_errors();
            $return['success'] = "false";
            $return['title'] = "error";
            $return['message'] = "$message";
            $return['error'] = $this->error;
            $return['data'] = (object) $this->data;
            $this->response($return, REST_Controller::HTTP_BAD_REQUEST);
        }
        
        $id = $postData['id'];
        
        $data = array(
            'detail'=>$postData['detail'],
            'updated_by'=>"T-".$this->token->user_id,
            'updated_date'=>date('Y-m-d'),
            
        );
        
        $res = $this->report_model->updateMonthly($id,$data);        
        $return['success'] = "true";
        $return['title'] = "success";
        $return['message'] = "Monthly report updated successfully.";
        $return['error'] = (object) $this->error;
        $return['data'] = $this->data;
        $this->response($return, REST_Controller::HTTP_OK);        
    }
    public function monthly_get() {    
        $student_id =  $this->input->get('student_id');
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
        $return['success'] = "false";
        $return['title'] = "error";
        $return['message'] = "Report does not exist.";
        $return['error'] = (object) $this->error;
        $return['data'] = (object) $this->data;
        $this->response($return, REST_Controller::HTTP_BAD_REQUEST);
    }
    
    public function term_post() {
        $postData = json_decode(file_get_contents('php://input'), true);
                                
        $postData = $this->security->xss_clean($postData);
        $this->form_validation->set_error_delimiters('', '');
        $this->form_validation->set_data($postData);
        $this->form_validation->set_rules('detail', 'Detail', 'trim|required');
        $this->form_validation->set_rules('student_id', 'Student', 'trim|required');
        $this->form_validation->set_rules('term_id', 'Term', 'trim|required');

        if ($this->form_validation->run() === false) {
            $this->error = $this->form_validation->error_array();
            $message = validation_errors();
            $return['success'] = "false";
            $return['title'] = "error";
            $return['message'] = "$message";
            $return['error'] = $this->error;
            $return['data'] = (object) $this->data;
            $this->response($return, REST_Controller::HTTP_BAD_REQUEST);
        }
        
        $exist = $this->report_model->termReportExist($postData['student_id'],$postData['term_id']);
        
        if($exist)
        {
            $return['success'] = "false";
            $return['title'] = "error";
            $return['message'] = "Report already exist.";
            $return['error'] = (object) $this->error;
            $return['data'] = (object) $this->data;
            $this->response($return, REST_Controller::HTTP_OK);
        }
        else
        {        
            $formData = array();
            $formData['detail'] = $postData['detail'];            
            $formData['term_id'] = $postData['term_id'];            
            $formData['student_id'] = $postData['student_id'];
            $formData['school_id'] = $this->token->school_id;
            $formData['created_by'] = "T-".$this->token->user_id;
            $formData['created_date'] = date("Y-m-d");

            $dataid = $this->report_model->addTerm($formData);
            $this->data = $dataid;
            if ($dataid) {

                $return['success'] = "true";
                $return['title'] = "success";
                $return['message'] = "Term report added successfully.";
                $return['error'] = (object) $this->error;
                $return['data'] = $this->data;
                $this->response($return, REST_Controller::HTTP_OK);

            }
            $return['success'] = "false";
            $return['title'] = "error";
            $return['message'] = "Report not added.";
            $return['error'] = (object) $this->error;
            $return['data'] = (object) $this->data;
            $this->response($return, REST_Controller::HTTP_BAD_REQUEST);
        }
        
    }
    public function term_put() {
        $postData = json_decode(file_get_contents('php://input'), true);
                                   
        $postData = $this->security->xss_clean($postData);
        $this->form_validation->set_error_delimiters('', '');
        $this->form_validation->set_data($postData);
        $this->form_validation->set_rules('id', 'Report ID', 'trim|required');
        $this->form_validation->set_rules('detail', 'Detail', 'trim|required');

        if ($this->form_validation->run() === false) {
            $this->error = $this->form_validation->error_array();
            $message = validation_errors();
            $return['success'] = "false";
            $return['title'] = "error";
            $return['message'] = "$message";
            $return['error'] = $this->error;
            $return['data'] = (object) $this->data;
            $this->response($return, REST_Controller::HTTP_BAD_REQUEST);
        }
        
        $id = $postData['id'];
        
        $data = array(
            'detail'=>$postData['detail'],
            'updated_by'=>"T-".$this->token->user_id,
            'updated_date'=>date('Y-m-d'),
            
        );
        
        $res = $this->report_model->updateTerm($id,$data);        
        $return['success'] = "true";
        $return['title'] = "success";
        $return['message'] = "Term report updated successfully.";
        $return['error'] = (object) $this->error;
        $return['data'] = $this->data;
        $this->response($return, REST_Controller::HTTP_OK);
    }
    public function term_get() {    
        $student_id =  $this->input->get('student_id');
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
        $return['success'] = "false";
        $return['title'] = "error";
        $return['message'] = "Report does not exist.";
        $return['error'] = (object) $this->error;
        $return['data'] = (object) $this->data;
        $this->response($return, REST_Controller::HTTP_BAD_REQUEST);
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
        $this->response($return, REST_Controller::HTTP_BAD_REQUEST);
    }
    
    public function termList_get() {    
        $data = $this->report_model->termList();
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
        $this->response($return, REST_Controller::HTTP_BAD_REQUEST);
    }
        
}
