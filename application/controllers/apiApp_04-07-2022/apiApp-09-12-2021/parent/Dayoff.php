<?php
defined('BASEPATH') OR exit('No direct script access allowed');
require APPPATH . '/libraries/REST_Controller.php';

class Dayoff extends REST_Controller {

    public $error = array();
    public $data = array();

    function __construct() {
        parent::__construct();
        $this->token->parent_validate();
        $this->load->library("security");
        $this->load->library('form_validation');
        $this->load->model('parent/dayoff_model');
        $this->load->helper('common_helper');
    }
    
    public function index_get(){
        $data = $this->dayoff_model->allData();
        
        $return['success'] = "true";
        $return['title'] = "success";
        $return['message'] = "Record found successfully.";
        $return['data'] = $data;
        $return['error'] = $this->error;
        $this->response($return, REST_Controller::HTTP_OK);
        
    }
    
    public function index_post() {
        $postData = json_decode(file_get_contents('php://input'), true);
                                       
        $postData = $this->security->xss_clean($postData);
        $this->form_validation->set_error_delimiters('', '');
        $this->form_validation->set_data($postData);
        $this->form_validation->set_rules('from_date', 'From Date', 'trim|required');
        $this->form_validation->set_rules('to_date', 'To Date', 'trim|required');
        // $this->form_validation->set_rules('number_of_days', 'Number Of Days', 'trim|required');
        $this->form_validation->set_rules('reason', 'Reason', 'trim|required');

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
        
        $formData = array();
        $formData['from_date'] = $postData['from_date'];
        $formData['to_date'] = $postData['to_date'];
        
        $number_of_daysCount = $this->requestDaysOffCount($postData['from_date'],$postData['to_date']);
        $formData['number_of_days'] = ($number_of_daysCount['number_of_days'] > 0) ? $number_of_daysCount['number_of_days'] : 0;
        $formData['working_days']  = ($number_of_daysCount['working_days'] > 0) ? $number_of_daysCount['working_days'] : 0;
        
        $formData['reason'] = $postData['reason'];
        $formData['school_id'] = $this->token->school_id;
        $formData['student_id'] = $this->token->student_id;
        $formData['created_by'] = $this->token->user_id;
        $formData['created_date'] = date("Y-m-d");
       // prd($formData);
                       
        $dataid = $this->dayoff_model->add($formData);
        $this->data = $dataid;
        if ($dataid) {                        
            $return['success'] = "true";
            $return['title'] = "success";
            $return['message'] = "Day off request sent.";
            $return['error'] = (object) $this->error;
            $return['data'] = $this->data;
            $this->response($return, REST_Controller::HTTP_OK);
        }
        $return['success'] = "false";
        $return['title'] = "error";
        $return['message'] = "Day off not created.";
        $return['error'] = (object) $this->error;
        $return['data'] = (object) $this->data;

        $this->response($return, REST_Controller::HTTP_BAD_REQUEST);
    }

    public function detail_get($id = '') {
        $detailData = $this->dayoff_model->getDetail($id);
        $return['success'] = "true";
        $return['title'] = "success";
        $return['message'] = $detailData ? "Day off request detail" : "No data found";
        $return['data'] = $detailData;
        $return['error'] = $this->error;
        $this->response($return, REST_Controller::HTTP_OK);
    }

    public function getLeave_get() {
        
        $data = $this->dayoff_model->getLeave();
       // prd($data);
        if( count($data) > 0) {
            $return['success'] = "true";
            $return['title'] = "success";
            $return['message'] = "Leave data found";
            $return['data'] = $data;
            $return['error'] = $this->error;
            $this->response($return, REST_Controller::HTTP_OK);
        }else{
            $return['success'] = "failed";
            $return['title'] = "false";
            $return['message'] = "No leave data found";
            $return['error'] = (object) $this->error;
            $return['data'] = (object) $this->data;
            $this->response($return, REST_Controller::HTTP_BAD_REQUEST);   
        }
    }
    
    public function index_put() {
        $postData = $_POST;
        $dataid = '';
                                       
        $postData = $this->security->xss_clean($postData);
        $this->form_validation->set_error_delimiters('', '');
        $this->form_validation->set_data($postData);
        $this->form_validation->set_rules('from_date', 'From Date', 'trim|required');
        $this->form_validation->set_rules('to_date', 'To Date', 'trim|required');
        // $this->form_validation->set_rules('number_of_days', 'Number Of Days', 'trim|required');
        $this->form_validation->set_rules('reason', 'Reason', 'trim|required');

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
        
        $formData = array();
        $formData['from_date'] = $postData['from_date'];
        $formData['to_date'] = $postData['to_date'];

        $number_of_daysCount = $this->requestDaysOffCount($postData['from_date'],$postData['to_date']);
        $formData['number_of_days'] = ($number_of_daysCount['number_of_days'] > 0) ? $number_of_daysCount['number_of_days'] : 0;
        $formData['working_days']  = ($number_of_daysCount['working_days'] > 0) ? $number_of_daysCount['working_days'] : 0;
        // $formData['number_of_days'] = $postData['number_of_days'];
        
        $formData['reason'] = $postData['reason'];
        $formData['school_id'] = $this->token->school_id;
        $formData['student_id'] = $this->token->student_id;
        $formData['updated_by'] = $this->token->user_id;
        $formData['updated_date'] = date("Y-m-d");
        $formData['status'] = "created";
                       
        $dataid = $this->dayoff_model->update($formData);
        $this->data = $dataid;
        if ($dataid) {                        
            $return['success'] = "true";
            $return['title'] = "success";
            $return['message'] = "Day off request sent.";
            $return['error'] = (object) $this->error;
            $return['data'] = $this->data;
            $this->response($return, REST_Controller::HTTP_OK);
        }
        $return['success'] = "false";
        $return['title'] = "error";
        $return['message'] = "Day off not created.";
        $return['error'] = (object) $this->error;
        $return['data'] = (object) $this->data;

        $this->response($return, REST_Controller::HTTP_BAD_REQUEST);
    }
    public function requestDaysOffCount($startDate,$endDate)
    {
        if($startDate)
        {
            $holidays   =  getDaysOffDays($startDate,$endDate);
            $dates      =  date_range($startDate,$endDate);
            $matched = 0;
        
            foreach ($holidays as  $date) {
                if(in_array($date , $dates) )
                {
                    $matched++;
                }
            }

            $dayOffDaysArr = array(
                                'number_of_days' =>  count($dates),
                                'working_days' =>  (count($dates) - $matched)
                            );
             return $dayOffDaysArr;
           }else{
            return false;    
        }
    }
}
