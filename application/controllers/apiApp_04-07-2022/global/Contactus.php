<?php
defined('BASEPATH') OR exit('No direct script access allowed');
require APPPATH . '/libraries/REST_Controller.php';

class Contactus extends REST_Controller {

    public $error = array();
    public $data = array();

    function __construct() {
        parent::__construct();
        $this->load->library("security");
        $this->load->library('form_validation');
        //$this->load->model('parent/assignment_model');
        $this->load->helper('common_helper');
    }

    public function index_post() {
        $postData = $_POST;
        $postData = $this->security->xss_clean($postData);
        $this->form_validation->set_error_delimiters('', '');
        $this->form_validation->set_data($postData);
        $this->form_validation->set_rules('name', 'Name', 'trim|required');
        $this->form_validation->set_rules('email', 'Email Address', 'trim|valid_email|required');
        $this->form_validation->set_rules('phone_number', 'Phone Number', 'trim|required|numeric');
        $this->form_validation->set_rules('subject', 'Subject', 'trim|required');
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
        $formData['fname'] = $postData['name'];
        $formData['lname'] = $postData['name'];
        $formData['email'] = $postData['email'];
        $formData['phone'] = $postData['phone_number'];
        $formData['subject'] = $postData['subject'];
        $formData['message'] = $postData['message'];
        //$to="hello@kidyview.com";
        //$to="nikhil51423@gmail.com";
        $to="hello@kidyview.com";
        //$to="yogendratomar.777@gmail.com";
       // $this->db->insert('assignment', $data);
        $message = $this->load->view('contactTemplate',$formData, true);
        $send=sendMail($to, $formData['subject'], $message,$formData['email']);
        if($send) {
            $return['success'] = "true";
            $return['title'] = "success";
            $return['message'] = "Thank you. We will get back to you shortly.";
            $return['error'] = (object) $this->error;
            $return['data'] = $this->data;
            $this->response($return, REST_Controller::HTTP_OK);
        }else{
        $return['success'] = "false";
        $return['title'] = "error";
        $return['message'] = "Error.Please try again.";
        $return['error'] = (object) $this->error;
        $return['data'] = (object) $this->data;

        $this->response($return, REST_Controller::HTTP_BAD_REQUEST);
    }
    
}
}
