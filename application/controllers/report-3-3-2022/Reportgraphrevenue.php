<?php

defined('BASEPATH') OR exit('No direct script access allowed');

require APPPATH . '/libraries/REST_Controller.php';

class Reportgraphrevenue extends REST_Controller {

    public $error = array();
    public $data = array();

    public function __construct() {
        parent::__construct();

        if ($this->session->userdata('user_role') == 'school' OR $this->session->userdata('user_role') == 'schoolsubadmin') {
            $this->token->validate();
        }
        $this->load->library('form_validation');
        $this->load->library("security");
        $this->load->library('settings');
       
    }

   

    public function graphData_post() {

        $postData = json_decode(file_get_contents('php://input'), true);
        if ($postData == '') {
            $postData = $_POST;
        }
        
        $graphData = array();
        
        ############## For Custom Search ######################
        if(isset($postData['manual']) && $postData['manual']!="")
        {
            $day = $postData['manual'];
            
            if($day==0){
            $endDate = date('Y-m-d'); 
            $startDate = date('Y-m-d');    
            }
            elseif($day==1){
            $endDate = date('Y-m-d',(strtotime ( '-1 day' , strtotime (date('Y-m-d')))));
            $startDate = date('Y-m-d',(strtotime ( '-1 day' , strtotime (date('Y-m-d')))));    
            }
            else {
            $endDate = date('Y-m-d'); 
            $startDate = date('Y-m-d',(strtotime ( '-' .$day. ' day' , strtotime ($endDate) ) ));
            }
            $graphData['with_day_revenue']  = $this->revenueByDateRange($startDate,$endDate);
            $graphData['current_month_revenue']  = $this->revenuecurrentMonth(); 
            $graphData['current_year_revenue']  = $this->revenuecurrentYear();
            $graphData['last_year_revenue']  = $this->revenueLastYear();
            $graphData['totalRevenue'] = $graphData['with_day_revenue'] + $graphData['current_month_revenue'] + $graphData['current_year_revenue'];
          
            $return['success'] = "true";
            $return['title'] = "success";
            $return['message'] = "Graph Data";
            $return['error'] = (object) $this->error;
            $return['data'] = $graphData;
            $this->response($return, REST_Controller::HTTP_OK);
           
        }
          
     }
     
     
      public function revenueByDateRange($startDate,$endDate) 
      {
        $total = 0;  
        $fessQuery = " Select sum(amount) as feesTotal  from student_fees where date(created_at)>='".$startDate."' And date(created_at)<='".$endDate."' And is_paid='paid'";   
        $feesResult = $this->db->query($fessQuery);  
        $fessData = $feesResult->row_array();
        
        $subQuery = " Select sum(amount) as subscriptionAmount  from school_subscription where date(created_date)>='".$startDate."' And date(created_date)<='".$endDate."'";   
        $subResult = $this->db->query($subQuery);  
        $subData = $subResult->row_array();
        
        
        $fees = ($fessData['feesTotal']>0) ? $fessData['feesTotal'] : 0; 
        $subAmount = ($subData['subscriptionAmount']>0) ? $subData['subscriptionAmount'] : 0; 
        $total = $fees+$subAmount; 
        return $total;
      }
      
      public function revenuecurrentMonth() 
      {
       $total = 0;  
       $fessQuery = " Select sum(amount) as feesTotal  from student_fees where MONTH(created_at)>=MONTH(now()) And is_paid='paid'";   
       $feesResult = $this->db->query($fessQuery);  
       $fessData = $feesResult->row_array();
     
        $subQuery = " Select sum(amount) as subscriptionAmount  from school_subscription where MONTH(created_date)>=MONTH(now())";   
        $subResult = $this->db->query($subQuery);  
        $subData = $subResult->row_array();
        
        $fees = ($fessData['feesTotal']>0) ? $fessData['feesTotal'] : '0.00';
        $subAmount = ($subData['subscriptionAmount']>0) ? $subData['subscriptionAmount'] : '0.00'; 
        $total = $fees+$subAmount; 
        return $total;
       
      }
      
      public function revenuecurrentYear() 
      {
       $total = 0;  
       $fessQuery = " Select sum(amount) as feesTotal  from student_fees where YEAR(created_at)>=YEAR(now()) And is_paid='paid'";   
       $feesResult = $this->db->query($fessQuery);  
       $fessData = $feesResult->row_array();
       
        $subQuery = " Select sum(amount) as subscriptionAmount  from school_subscription where YEAR(created_date)>=YEAR(now())";   
        $subResult = $this->db->query($subQuery);  
        $subData = $subResult->row_array();
        
        $fees = ($fessData['feesTotal']>0) ? $fessData['feesTotal'] : '0.00';
        $subAmount = ($subData['subscriptionAmount']>0) ? $subData['subscriptionAmount'] : '0.00'; 
        $total = $fees+$subAmount; 
        return $total;
      }
      
      public function revenueLastYear() 
      {
           
        $monthwise = array();
        $i=0;
        $sum = 0;
        $lastYear =  date("Y",strtotime("-1 year"));
        $month = strtotime(''.$lastYear.'-01-01');
        $end = strtotime(''.$lastYear.'-12-31');
        while($month < $end)
        {
        $startDate = date('Y-m-d',$month);   
        $endDate  = date('Y-m-t',$month);
        $revenue = $this->revenueByDateRange($startDate,$endDate);
        $monthwise['month_wise'][$i] = ($revenue>0) ? $revenue : '0.00';
        $sum += $revenue;
        $month = strtotime("+1 month", $month);
        $i++;
        }
        $monthwise['total_month_wise'] = $sum;
        return $monthwise;
      }
      
      public function schoolByDateRange($startDate=Null,$endDate=Null) {
        
         $data_user = array(); 
         if($startDate!="" && $endDate!="" ) 
         $this->db->where(['created_date>=' => $startDate,'created_date<='=>$endDate]);
         $query = $this->db->get('school');
         
         //echo $this->db->last_query(); exit;
         $rowsData = $query->num_rows();

         if($rowsData > 0){
            $data_user = $query->result_array();
            return $data_user;
        } else
            return $data_user;
    }
    
  
    public function revenueTransaction($startDate,$endDate) 
      {
        $whereInFees = "";
        $wheresINSchool = "";
        if($startDate!="" && $endDate!="" ) {
        $whereInFees = "date(created_at)>='".$startDate."' And date(created_at)<='".$endDate."' And ";  
        $wheresINSchool = "where date(created_date)>='".$startDate."' And date(created_date)<='".$endDate."'";  
        }
          
        $transaction = array();  
        $fessQuery = " Select count(*) as feesTransaction, sum(amount) as feesTotal  from student_fees where ".$whereInFees." is_paid='paid'";   
        $feesResult = $this->db->query($fessQuery);
        $fessData = $feesResult->row_array();
        
        $subQuery = " Select count(*) as subsTransaction, sum(amount) as subscriptionAmount  from school_subscription  " .$wheresINSchool. "";   
        $subResult = $this->db->query($subQuery);
        //echo $this->db->last_query();exit;
        $subData = $subResult->row_array();
        
        
        $fees = ($fessData['feesTotal']>0) ? $fessData['feesTotal'] : 0; 
        $subAmount = ($subData['subscriptionAmount']>0) ? $subData['subscriptionAmount'] : 0; 
        $transaction['revenue'] = $fees+$subAmount; 
        $transaction['transaction'] = $fessData['feesTransaction']+$subData['subsTransaction']; 
        return $transaction;
      }
    

    public function getAllForDashboard_post() {

        $postData = json_decode(file_get_contents('php://input'), true);
        if ($postData == '') {
            $postData = $_POST;
        }
        
        $graphData = array();
        
        ############## For Custom Search ######################
        if(isset($postData['search']) && $postData['search']!="")
        {
            $day = $postData['search'];
            if($day=="all"){
            $endDate = ""; 
            $startDate = "";   
            }
            elseif($day==0){
            $endDate = date('Y-m-d'); 
            $startDate = date('Y-m-d');    
            }
            elseif($day==1){
            $endDate = date('Y-m-d',(strtotime ( '-1 day' , strtotime (date('Y-m-d')))));
            $startDate = date('Y-m-d',(strtotime ( '-1 day' , strtotime (date('Y-m-d')))));    
            }
            else {
            $endDate = date('Y-m-d'); 
            $startDate = date('Y-m-d',(strtotime ( '-' .$day. ' day' , strtotime ($endDate) ) ));
            }
            
            $revenue  = $this->revenueTransaction($startDate,$endDate);
            $graphData['no_of_school']  = $this->schoolByDateRange($startDate,$endDate);
            $graphData['revenue'] = $revenue['revenue'];
            $graphData['transaction'] = $revenue['transaction'];
          
            $return['success'] = "true";
            $return['title'] = "success";
            $return['message'] = "Dashboard Data";
            $return['error'] = (object) $this->error;
            $return['data'] = $graphData;
            $this->response($return, REST_Controller::HTTP_OK);
           
        }
          
     }
     
     
     
      
      
      
      
}
