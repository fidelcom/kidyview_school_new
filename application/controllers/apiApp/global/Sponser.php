<?php

defined('BASEPATH') OR exit('No direct script access allowed');
require APPPATH . '/libraries/REST_Controller.php';

class Sponser extends REST_Controller {

    public $error = array();
    public $data = array();
    public $blank = array();
    

    public function __construct() {
        parent::__construct();
    }

     public function getAllSponser_get() 
     {
        $this->data =$this->allsponser();
        if ($this->data) {
            $return['success'] = "true";
            $return['message'] = "Sponser List found.";
            $return['data'] = $this->data;
            $return['error'] = $this->error;
            $this->response($return, REST_Controller::HTTP_OK);
        } else {
            $return['success'] = "true";
            $return['message'] = "No Sponser Found.";
            $return['data'] = $this->data;
            $return['error'] = $this->error;
            $this->response($return, REST_Controller::HTTP_OK);
        }
    }
    
    public function allsponser() 
    {
        $this->db->select("*");
        $this->db->where('status',1);
        $this->db->order_by("id desc");
        $query = $this->db->get('sponser'); 
       if($query->num_rows() > 0)
          return $query->result_array();
         else
         return false;
   }

    

}
