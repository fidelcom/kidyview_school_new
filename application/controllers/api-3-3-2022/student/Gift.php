<?php
defined('BASEPATH') OR exit('No direct script access allowed');
require APPPATH . '/libraries/REST_Controller.php';
class Gift extends REST_Controller {

    public $error = array();
    public $data = array();

    function __construct() {
        parent::__construct();
        $this->load->library("security");
        $this->load->library('form_validation');
        $this->load->model('students/Gift_model','model');
        $this->load->helper('common_helper');
    }
    
    public function getGiftList_post(){
        $postData = json_decode(file_get_contents('php://input'), true);
		if ($postData == '') {
			$postData = $_POST;
        }
        $data = $this->model->data();
        $return['success'] = "true";
        $return['title'] = "success";
        $return['message'] = "Gift List.";
        $return['data'] = $data;
        $return['error'] = $this->error;
        $this->response($return, REST_Controller::HTTP_OK);
    }
    public function getGiftDetails_post(){
        $postData = json_decode(file_get_contents('php://input'), true);
		if ($postData == '') {
			$postData = $_POST;
        }
        $giftID=$postData['giftID'];

        $data = $this->model->details($giftID);
        $return['success'] = "true";
        $return['title'] = "success";
        $return['message'] = "Gift Details.";
        $return['data'] = $data;
        $return['error'] = $this->error;
        $this->response($return, REST_Controller::HTTP_OK);
    }
    
}
