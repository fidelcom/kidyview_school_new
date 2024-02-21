<?php
defined('BASEPATH') OR exit('No direct script access allowed');
require APPPATH . '/libraries/REST_Controller.php';

class Dayoff extends REST_Controller {

    public $error = array();
    public $data = array();

    function __construct() {
        parent::__construct();
        $this->token->validate();
        $this->load->library("security");
        $this->load->library('form_validation');
        $this->load->model('dayoff_model');
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
    
    public function index_put() {
        $postData = json_decode(file_get_contents('php://input'), true);
                                       
        $postData = $this->security->xss_clean($postData);
        $this->form_validation->set_error_delimiters('', '');
        $this->form_validation->set_data($postData);
        $this->form_validation->set_rules('id', 'ID', 'trim|required');
        $this->form_validation->set_rules('status', 'Status', 'trim|required');
        $this->form_validation->set_rules('reject_reason', 'Reject Reason', 'trim');

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
        $id = $postData['id'];
        $formData['status'] = $postData['status'];
        $formData['reject_reason'] = $postData['reject_reason'];
        $formData['updated_by'] = $this->token->user_id;
        $formData['updated_date'] = date("Y-m-d");
                       
        $res = $this->dayoff_model->updateData($id,$formData);
        
        if ($res) {                        
            $return['success'] = "true";
            $return['title'] = "success";
            $return['message'] = "Day off request updated.";
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
}
