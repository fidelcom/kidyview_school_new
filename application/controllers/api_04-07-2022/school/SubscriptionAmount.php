<?php
defined('BASEPATH') OR exit('No direct script access allowed');
require APPPATH . '/libraries/REST_Controller.php';
class SubscriptionAmount extends REST_Controller {

    public $error = array();
    public $data = array();

    public function __construct() {
        parent::__construct();
        if($this->session->userdata('user_role')=='school' OR $this->session->userdata('user_role')=='schoolsubadmin'){
            $this->token->validate();
        }
         $this->load->model("admin/SubscriptionAmount_model",'model');
         $this->load->helper('common_helper');
    }
    public function addFeesSubscription_post() 
    {  	 
         $postData = json_decode(file_get_contents('php://input'), true);
         if ($postData == '') {
            $postData = $_POST;
         }
          //print_r($postData);
          
       $query = $this->db->query("SELECT  * from  fee_suscription_amount where class_id = '".$postData['class_id']."' And school_id = '".$postData['school_id']."'");
      if ($query->num_rows() > 0) { 
        $return['success'] = "success";
        $return['message'] = "This Class is already  Added.";
        $return['data'] = '';
        $return['error'] = $this->error;
        $this->response($return, REST_Controller::HTTP_OK);  
        exit;
       }  
        
        $result = $this->model->addFeesSubscription($postData);
        if($result) 
        {
            $return['success'] = "success";
            $return['message'] = "Fee Subscription Amount Added successfully.";
            $return['data'] = $result;
            $return['error'] = $this->error;
            $this->response($return, REST_Controller::HTTP_OK);
          
     	}else{
            $return['success'] = "false";
            $return['message'] = "No record found.";
            $return['error'] = $this->error;
            $return['data'] = '';
            $this->response($return, REST_Controller::HTTP_BAD_REQUEST);
         }
    }
    public function feeSuscriptionList_post()
    {
        $postData = json_decode(file_get_contents('php://input'), true);
         if ($postData == '') {
            $postData = $_POST;
         }
         $result = $this->model->feeSuscriptionList($postData);
         // prd($result);
        if($result) 
        {
            $return['success'] = "success";
            $return['message'] = "Fee subscription amount list data.";
            $return['data'] = $result;
            $return['error'] = $this->error;
            
            $this->response($return, REST_Controller::HTTP_OK);
          
        }else{
            $return['success'] = "false";
            $return['message'] = "No record found.";
            $return['error'] = $this->error;
            $return['data'] = '';
            
            $this->response($return, REST_Controller::HTTP_BAD_REQUEST);
         }
    }
    public function subscriptionAmountDelete_post()
    {
        $postData = json_decode(file_get_contents('php://input'), true);
         if ($postData == '') {
            $postData = $_POST;
         }
         $result = $this->model->subscriptionAmountDelete($postData);
         // prd($result);
        if($result) 
        {
            $return['success'] = "success";
            $return['message'] = "Fee subscription amount deleted successfully.";
            $return['data'] = $result;
            $return['error'] = $this->error;
            
            $this->response($return, REST_Controller::HTTP_OK);
          
        }else{
            $return['success'] = "false";
            $return['message'] = "No record found.";
            $return['error'] = $this->error;
            $return['data'] = '';
            
            $this->response($return, REST_Controller::HTTP_BAD_REQUEST);
         }
    }


}