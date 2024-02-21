<?php

defined('BASEPATH') OR exit('No direct script access allowed');
require APPPATH . '/libraries/REST_Controller.php';
class Faq extends REST_Controller {

    public $error = array();
    public $data = array();

    public function __construct() {
        parent::__construct();
        $this->load->model("students/Faq_model",'model');
    }
   
    public function getFaqList_post() {
		$postData = json_decode(file_get_contents('php://input'), true);
		if ($postData == '') {
			$postData = $_POST;
		}
		$schoolID=$postData['schoolID'];
		$userType="Student";
		$result = $this->model->getFaqList($schoolID,$userType);
		$return['success'] = "true";
		$return['message'] = $result?'Faq Found.':'Faq Not found';
		$return['data'] = $result;
		$return['error'] = $this->error;
		$this->response($return, REST_Controller::HTTP_OK);
			
	}
   
}
