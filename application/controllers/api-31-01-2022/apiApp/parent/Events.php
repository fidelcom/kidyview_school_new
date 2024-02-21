<?php
defined('BASEPATH') OR exit('No direct script access allowed');
require APPPATH . '/libraries/REST_Controller.php';

class Events extends REST_Controller {

    public $error = array();
    public $data = array();

    function __construct() {
        parent::__construct();
        $this->token->parent_validate();
        $this->load->library("security");
        $this->load->library('form_validation');
        $this->load->model('parent/event_model','model');
        $this->load->helper('common_helper');
    }
            
    public function index_get(){
        $schoolId = $this->token->school_id;
        $cresult = $this->model->getpasteventsList($schoolId);
        $cresult1 = $this->model->getupcomingeventsList($schoolId);
        if ($cresult != '' || $cresult1 != '') {
            $return['success'] = "true";
            $return['title'] = "success";
            $return['message'] = "List get successfully";
            $return['pastEventdata'] = $cresult;
            $return['upcomingEventdata'] = $cresult1;
            $return['error'] = $this->error;
            $this->response($return, REST_Controller::HTTP_OK);
        }
        $return['data'] = $this->data;
        $return['success'] = "false";
        $return['title'] = "error";
        $return['message'] = "Something went wrong.";
        $return['error'] = $this->error;
        $this->response($return, REST_Controller::HTTP_BAD_REQUEST);        
    }
    public function detail_get($id){
        $eventId = $id;
        $eventResult = $this->model->getEventById($eventId);

        if (!empty($eventResult)) {
            $return['success'] = "true";
            $return['title'] = "success";
            $return['message'] = "Record found successfully.";
            $return['eventData'] = $eventResult;
            $return['error'] = $this->error;
            $this->response($return, REST_Controller::HTTP_OK);
        }
        $return['data'] = $this->data;
        $return['success'] = "false";
        $return['title'] = "error";
        $return['message'] = "No record found";
        $return['error'] = $this->error;
        $this->response($return, REST_Controller::HTTP_BAD_REQUEST);      
    }
}
