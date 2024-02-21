<?php
defined('BASEPATH') OR exit('No direct script access allowed');
require APPPATH . '/libraries/REST_Controller.php';

class Gifts extends REST_Controller {

    public $error = array();
    public $data = array();

    function __construct() {
        parent::__construct();
        $this->token->parent_validate();
        $this->load->library("security");
        $this->load->library('form_validation');
        $this->load->model('parent/gift_model');
        $this->load->helper('common_helper');
    }    
    public function index_get(){
        
        $school_id = $this->token->school_id;
        $currData = array();
        $query = $this->db->query("select
              s.currency_id as school_currency_id,
              ac.currency_name as school_currency_name,
              ac.currency_code as  school_currency_code,
              ac.currency_symbol as  school_currency_symbol
              from school as s 
              left join admin_currency as ac on ac.id = s.currency_id 
              where s.id = '$school_id'");
        //echo $this->db->last_query();exit;
         if($query->num_rows() > 0)
	   {
            $currData =  $query->row();
           }
        
        $data = $this->gift_model->data();
        $total = $this->gift_model->dataCount();
        
        $return['success'] = "true";
        $return['title'] = "success";
        $return['message'] = "Record found successfully.";
        $return['schoolcurrency'] = $currData;
        $return['classData'] = $data;
        $return['total'] = $total;
        $return['error'] = $this->error;
        $this->response($return, REST_Controller::HTTP_OK);
    }
    public function studentPointsData_get()
    {
        $totalPoints = $this->gift_model->pointsData();
        $allPointsData = $this->gift_model->allPointsData();
        // prd($totalPoints);
        // prd($totalPoints);
        if( count($allPointsData) > 0)
        {
            $return['success'] = "true";
            $return['title'] = "success";
            $return['message'] = "Record found successfully.";
            $return['total_points'] = (int)($totalPoints['totalPoints']);
            $return['data'] = $allPointsData;
            $return['error'] = $this->error;
            $this->response($return, REST_Controller::HTTP_OK);
        }else{
            $return['success'] = "false";
            $return['title'] = "failed";
            $return['message'] = "No record found.";
            $return['total_points'] = '';
            $return['data'] = '';
            $return['error'] = $this->error;
            $this->response($return, REST_Controller::HTTP_BAD_REQUEST);
        }
    }
    public function redeemPointsGifts_get()
    {
        $result = $this->gift_model->redeemPointsGifts();
        // echo "hi Nidhi"; die;
        // prd($result);
        if( count($result) > 0)
        {
            $return['success'] = "true";
            $return['title'] = "success";
            $return['message'] = "Record found successfully.";
            $return['data'] = $result;
            $return['error'] = $this->error;
            $this->response($return, REST_Controller::HTTP_OK);
        }else{
            $return['success'] = "false";
            $return['title'] = "failed";
            $return['message'] = "No record found.";
            $return['data'] = '';
            $return['error'] = $this->error;
            $this->response($return, REST_Controller::HTTP_BAD_REQUEST);
        }
    }
    public function giftRewardsPay_post()
    {
    	$postData = json_decode(file_get_contents('php://input'), true);
        if ($postData == '') {
                $postData = $_POST;
        }
        // prd($postData);
        $result = $this->gift_model->redeemPointsReward($postData);
        // prd($result);
        if( $result == 'exceed_points_limit' )
        {
        	$return['success'] = "false";
            $return['title'] = "failed";
            $return['message'] = "Your redeem points is not sufficient to purchase this gift.";
            $return['data'] = '';
            $return['error'] = $this->error;
            $this->response($return, REST_Controller::HTTP_BAD_REQUEST);
        
        }else if( $result == 'insuficient_qty' )
        {
        	$return['success'] = "false";
            $return['title'] = "failed";
            $return['message'] = "Your selected gift quantity is not available.";
            $return['data'] = '';
            $return['error'] = $this->error;
            $this->response($return, REST_Controller::HTTP_BAD_REQUEST);
        
        }else if( $result )
        {
            $return['success'] = "true";
            $return['title'] = "success";
            $return['message'] = "Gifts rewards achieved successfully.";
            $return['data'] = '';
            $return['error'] = $this->error;
            $this->response($return, REST_Controller::HTTP_OK);
        }else{
            $return['success'] = "false";
            $return['title'] = "failed";
            $return['message'] = "No reward found.";
            $return['data'] = '';
            $return['error'] = $this->error;
            $this->response($return, REST_Controller::HTTP_BAD_REQUEST);
        }
    }
}
