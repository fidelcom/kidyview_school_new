<?php
defined('BASEPATH') OR exit('No direct script access allowed');
require APPPATH . '/libraries/REST_Controller.php';

class Feedback extends REST_Controller {

    public $error = array();
    public $data = array();

    function __construct() {
        parent::__construct();
        $this->token->validate();
        $this->load->library("security");
        $this->load->library('form_validation');
        $this->load->model('driver/feedback_model','feedback_model');
        $this->load->helper('common_helper');
    }
    
    public function index_post() {
        $postData = json_decode(file_get_contents('php://input'), true);

        $postData = $this->security->xss_clean($postData);
        $this->form_validation->set_error_delimiters('', '');
        $this->form_validation->set_data($postData);

        $this->form_validation->set_rules('message_for', 'Message For', 'trim|required');
        $this->form_validation->set_rules('message', 'Message', 'trim|required');
        

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
        $formData['message_for'] = $postData['message_for'];
        $formData['message'] = $postData['message'];
        $formData['school_id'] = $this->token->school_id;
        $formData['user_id'] = "D-".$this->token->user_id;
        $formData['user_type'] = "driver";
        $formData['created'] = date("Y-m-d H:i:s");
        $formData['status'] = 1;
        $dataid = $this->feedback_model->add($formData);
        $this->data = $dataid;
        if ($dataid) {            
            $return['success'] = "true";
            $return['title'] = "success";
            $return['message'] = "Added successfully.";
            $return['error'] = (object) $this->error;
            $return['data'] = $this->data;
            $this->response($return, REST_Controller::HTTP_OK);
        }
        $return['success'] = "false";
        $return['title'] = "error";
        $return['message'] = "Some Error Happen.";
        $return['error'] = (object) $this->error;
        $return['data'] = (object) $this->data;

        $this->response($return, REST_Controller::HTTP_BAD_REQUEST);
    }         
}
