<?php

defined('BASEPATH') OR exit('No direct script access allowed');

require APPPATH . '/libraries/REST_Controller.php';

class HomeMeal extends REST_Controller {

    public $error = array();
    public $data = array();

    public function __construct() {
        parent::__construct();
        if($this->session->userdata('user_role')=='school' OR $this->session->userdata('user_role')=='schoolsubadmin'){
            $this->token->validate();
        }
        $this->load->model("admin/homeMeal_model");
    }
    
    public function index_get() {       	
        $res = $this->homeMeal_model->data();        
        $return['success'] = "true";
        $return['message'] = "Home Meal List.";
        $return['error'] = "";
        $return['data'] = $res;
        $this->response($return, REST_Controller::HTTP_OK);

    }
    public function index_post() {       	
        $postData = json_decode(file_get_contents('php://input'), true);
        $postData = $this->security->xss_clean($postData);
        $this->form_validation->set_data($postData);
        $this->form_validation->set_rules('name', 'Name', 'trim|required');
        
        $error = array();
        if ($this->form_validation->run() === False) {
            $error = $this->form_validation->error_array();
            $message = validation_errors();
            $this->response(["success" => "false", 'message'=>$message,'data'=>'',"error" => $error], REST_Controller::HTTP_BAD_REQUEST);
        } 
        else 
        {
            $schoolDetail 	= $this->session->all_userdata();
            $schoolID 	= $schoolDetail['user_data']['id'];
            $data = array(
                "name"=>$postData['name'],
                "school_id"=>$schoolID,
                "created_date"=> date("Y-m-d")
            );
            $res = $this->homeMeal_model->add($data);
            if($res)
            {
                $return['success'] = "true";
                $return['message'] = "Added Successfuly.";
                $return['error'] = $this->error;
                $return['data'] = $schoolDetail;
                $this->response($return, REST_Controller::HTTP_OK);
            }
            else
            {
                $this->response(["success" => "false", 'message'=>'','data'=>'',"error" => ''], REST_Controller::HTTP_INTERNAL_SERVER_ERROR);
            }
        }               
    }
    

}
