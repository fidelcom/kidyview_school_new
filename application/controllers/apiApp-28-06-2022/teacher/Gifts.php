<?php
defined('BASEPATH') OR exit('No direct script access allowed');
require APPPATH . '/libraries/REST_Controller.php';

class Gifts extends REST_Controller {

    public $error = array();
    public $data = array();

    function __construct() {
        parent::__construct();
        $this->token->validate();
        $this->load->library("security");
        $this->load->library('form_validation');
        $this->load->model('gift_model');
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
}
