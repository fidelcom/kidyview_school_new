<?php

defined('BASEPATH') OR exit('No direct script access allowed');

require APPPATH . '/libraries/REST_Controller.php';

class Teacher extends REST_Controller {

    public $error = array();
    public $data = array();

    public function __construct() {
        parent::__construct();
        if($this->session->userdata('user_role')=='school' OR $this->session->userdata('user_role')=='schoolsubadmin'){
			$this->token->validate();
			}
        $this->load->model("admin/teacher_model");
    }              
    public function index_get() { 
        $schoolID =  $this->input->get('school_id');
        $res = $this->teacher_model->data($schoolID);        
        $return['success'] = "true";
        $return['message'] = "Teacher List.";
        $return['error'] = "";
        $return['data'] = $res;
        $this->response($return, REST_Controller::HTTP_OK);
    }       
}
