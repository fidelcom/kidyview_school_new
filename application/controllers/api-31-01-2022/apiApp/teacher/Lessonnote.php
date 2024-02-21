<?php
defined('BASEPATH') OR exit('No direct script access allowed');
require APPPATH . '/libraries/REST_Controller.php';

class Lessonnote extends REST_Controller {

    public $error = array();
    public $data = array();

    function __construct() {
        parent::__construct();
        $this->token->validate();
        $this->load->library("security");
        $this->load->library('form_validation');
        $this->load->model('lessonnote_model');
        $this->load->helper('common_helper');
    }
    
    public function index_get(){
        $data = $this->lessonnote_model->allData();
        $total = $this->lessonnote_model->allDataCount();
        $return['success'] = "true";
        $return['title'] = "success";
        $return['message'] = "Record found successfully.";
        $return['data'] = $data;
        $return['total'] = $total;
        $return['error'] = $this->error;
        $this->response($return, REST_Controller::HTTP_OK);
        
    }
    public function sharedlist_get(){
        $data = $this->lessonnote_model->allSharedData();
        $total = $this->lessonnote_model->allSharedDataCount();
        $return['success'] = "true";
        $return['title'] = "success";
        $return['message'] = "Record found successfully.";
        $return['data'] = $data;
        $return['total'] = $total;
        $return['error'] = $this->error;
        $this->response($return, REST_Controller::HTTP_OK);
        
    }
    
    

    public function detail_get($id = '') {
        $detailData = $this->lessonnote_model->getDetail($id);
        $return['success'] = "true";
        $return['title'] = "success";
        $return['message'] = $detailData ? "Lesson& Note detail" : "No data found";
        $return['data'] = $detailData;
        $return['error'] = $this->error;
        $this->response($return, REST_Controller::HTTP_OK);
    }
}
