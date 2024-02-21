<?php

defined('BASEPATH') OR exit('No direct script access allowed');

require APPPATH . '/libraries/REST_Controller.php';

class Classes extends REST_Controller {

    public $error = array();
    public $data = array();

    public function __construct() {
        parent::__construct();
        if($this->session->userdata('user_role')=='school' OR $this->session->userdata('user_role')=='schoolsubadmin'){
            $this->token->validate();
        }
        $this->load->model("admin/classes_model");
    }
    
    public function index_get() {       	
        $res = $this->classes_model->data();        
        $return['success'] = "true";
        $return['message'] = "Class List.";
        $return['error'] = "";
        $return['data'] = $res;
        $this->response($return, REST_Controller::HTTP_OK);
    }   
}
