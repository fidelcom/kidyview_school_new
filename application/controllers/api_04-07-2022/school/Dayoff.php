<?php
defined('BASEPATH') OR exit('No direct script access allowed');
require APPPATH . '/libraries/REST_Controller.php';
class Dayoff extends REST_Controller {

    public $error = array();
    public $data = array();

    public function __construct() {
        parent::__construct();
        if($this->session->userdata('user_role')=='school' OR $this->session->userdata('user_role')=='schoolsubadmin'){
                $this->token->validate();
        }
        $this->load->model("admin/dayoff_model",'model');
    }
    
    public function allDayoff_post()
    {
         $postData = json_decode(file_get_contents('php://input'), true);
         if ($postData == '') {
                $postData = $_POST;
         }
         // prd($postData);
        $result = $this->model->getAllDayoff($postData['school_id']);
        $allDayOff = array();
        $i=0;
        foreach ($result as $value) {
          $allDayOff[$i] = $value;
          $allDayOff[$i]['concat_id'] = $value['id'].'@@'.$value['user_type'];
          $i++;
        }
        
        if($allDayOff)
        {
                $return['success']  = "true";
                $return['status']   = "success";
                $return['title']    = "success";
                $return['message']  = "Request days off data.";
                $return['data']     = $allDayOff;
                $return['error']    = (object) $this->error;

                $this->response($return, REST_Controller::HTTP_OK); 
        }else{
                $return['success']  = "failed";
                $return['status']   = "false";
                $return['message']  = "No request day off data found .";
                $return['data']     = array();
                $return['error']    = (object) $this->error;

                $this->response($return, REST_Controller::HTTP_BAD_REQUEST);    
        }
         // prd($allDayOff);
    }
    public function getDayoffDetails_post()
    {
       $postData = json_decode(file_get_contents('php://input'), true);
         if ($postData == '') {
                $postData = $_POST;
         }
        $result = $this->model->getDayoffDetails($postData['concat_id']);
         // prd($result);
        if($result)
        {
                $return['success']  = "true";
                $return['status']   = "success";
                $return['title']    = "success";
                $return['message']  = "Request days off data.";
                $return['data']     = $result;
                $return['error']    = (object) $this->error;

                $this->response($return, REST_Controller::HTTP_OK); 
        }else{
                $return['success']  = "failed";
                $return['status']   = "false";
                $return['message']  = "No request day off data found .";
                $return['data']     = array();
                $return['error']    = (object) $this->error;

                $this->response($return, REST_Controller::HTTP_BAD_REQUEST);    
        }
    }
    public function dayoffStatus_post()
    {
       $postData = json_decode(file_get_contents('php://input'), true);
         if ($postData == '') {
                $postData = $_POST;
         }
         // prd($postData);
        $result = $this->model->dayoffStatus($postData);
        if($result)
        {
                $return['success']  = "true";
                $return['status']   = "success";
                $return['title']    = "success";
                $return['message']  = "Request days off data.";
                $return['data']     = $result;
                $return['error']    = (object) $this->error;

                $this->response($return, REST_Controller::HTTP_OK); 
        }else{
                $return['success']  = "failed";
                $return['status']   = "false";
                $return['message']  = "";
                $return['data']     = array();
                $return['error']    = (object) $this->error;

                $this->response($return, REST_Controller::HTTP_BAD_REQUEST);    
        }
    }
}
