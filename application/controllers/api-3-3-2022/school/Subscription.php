<?php
defined('BASEPATH') OR exit('No direct script access allowed');
require APPPATH . '/libraries/REST_Controller.php';
class Subscription extends REST_Controller {

    public $error = array();
    public $data = array();

    public function __construct() {
        parent::__construct();
        $this->load->model("Subscription_model",'model');
    }              
    public function getSchoolSubscription_get($school_id) { 
		if(!$school_id){
		return;
		}
		$schoolData=get_school($school_id);
                $currency_id = $schoolData['currency_id'];
                $currencyData = $this->getCurrencyData($currency_id);
            	$subscription_id=$schoolData['subscription_id'];
                $res = $this->model->data($school_id,$subscription_id);
                if(count($res)>0 && (!empty($currencyData))) {
                    for($i=0;$i<count($res);$i++){
                        if($i!=0){
                           $newAmount = ($res[$i]['amount']>0) ? ($res[$i]['amount']/$currencyData['currency_rate']):$res[$i]['amount']; 
                           $res[$i]['user_currency_id'] = $currency_id;
                           $res[$i]['user_currency_code'] = $currencyData['currency_code']; 
                           $res[$i]['user_currency_symbol'] = $currencyData['currency_symbol'];
                           $res[$i]['user_currency_amount'] = number_format($newAmount,2);
                        }
                        
                    }
                }
                
                
        $return['success'] = "true";
        $return['message'] = "Subscription List.";
        $return['error'] = "";
        $return['data'] = $res;
        $this->response($return, REST_Controller::HTTP_OK);
    }
    
    
    public function getCurrencyData($id){
        
          $this->db->select("*");
          $this->db->where('id',$id);
          $query = $this->db->get('admin_currency'); 
          $newArray = array();  
          if($query->num_rows() > 0){
          $newArray  = json_decode(json_encode($query->row()), true);  
          }
          return $newArray;
    }
   
}
