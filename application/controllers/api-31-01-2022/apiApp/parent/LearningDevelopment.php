<?php
defined('BASEPATH') OR exit('No direct script access allowed');
require APPPATH . '/libraries/REST_Controller.php';

class LearningDevelopment extends REST_Controller {

    public $error = array();
    public $data = array();

    function __construct() {
        parent::__construct();
        $this->token->parent_validate();
        $this->load->library("security");
        $this->load->library('form_validation');
        $this->load->model('parent/learning_model');
        $this->load->helper('common_helper');
    }
    
    public function index_get() {        
        $res = $this->learning_model->learningDevelopmentList();
        if ($res) {
            
            for($i =0; $i < count($res); $i++)
            {
                $res[$i]->options = json_decode($res[$i]->options);
            }
            
            $return['success'] = "true";
            $return['title'] = "success";
            $return['message'] = "Success";
            $return['data'] = $res;
            $return['error'] = $this->error;
            $this->response($return, REST_Controller::HTTP_OK);
        }
        $return['success'] = "true";
            $return['title'] = "success";
            $return['message'] = "No Data Found";
            $return['data'] = array();
            $return['error'] = $this->error;
            $this->response($return, REST_Controller::HTTP_OK);
    } 
    
    public function category_get() {   
        
        $class_id = $this->learning_model->studentClass();        
        $res = $this->learning_model->learningDevelopmentCategory($class_id);
        if ($res) {
            $return['success'] = "true";
            $return['title'] = "success";
            $return['message'] = "Success";
            $return['data'] = $res;
            $return['error'] = $this->error;
            $this->response($return, REST_Controller::HTTP_OK);
        }
        $return['success'] = "false";
        $return['title'] = "error";
        $return['message'] = "No data found.";
        $return['error'] = (object) $this->error;
        $return['data'] = (object) $this->data;
        $this->response($return, REST_Controller::HTTP_BAD_REQUEST);
    }
    public function question_get() {   
        $category_id = $this->input->get('category_id');
        $res = $this->learning_model->learningDevelopmentQuestion($category_id);
        if ($res) {
            $return['success'] = "true";
            $return['title'] = "success";
            $return['message'] = "Success";
            $return['data'] = $res;
            $return['error'] = $this->error;
            $this->response($return, REST_Controller::HTTP_OK);
        }
        $return['success'] = "false";
        $return['title'] = "error";
        $return['message'] = "No Data Found";
        $return['error'] = (object) $this->error;
        $return['data'] = (object) $this->data;
        $this->response($return, REST_Controller::HTTP_BAD_REQUEST);
    }
    public function info_get() {   
        $category_id = $this->input->get('category_id');
        $res = $this->learning_model->learningDevelopmentInfo($category_id);
        if ($res) {
            $return['success'] = "true";
            $return['title'] = "success";
            $return['message'] = "Success";
            $return['data'] = $res;
            $return['error'] = $this->error;
            $this->response($return, REST_Controller::HTTP_OK);
        }
        $return['success'] = "true";
            $return['title'] = "success";
            $return['message'] = "No Data Found";
            $return['data'] = array();
            $return['error'] = $this->error;
            $this->response($return, REST_Controller::HTTP_OK);
    }
}
