<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Revenue_model extends CI_Model {
    
   public function getAllSchool($countryID)
    {
       if(empty($countryID)){
         return array();
       }
        
        $this->db->select("s.id as id,s.phone as phone, s.school_name as school");
        $this->db->from("school s");
        $this->db->where("s.status",1);
        $this->db->where("s.country IN (".implode(',',$countryID).")",NULL, false);
        $query = $this->db->get();
         //echo $this->db->last_query();die;
        if($query->num_rows() >0)
        {
            return $query->result_array();
         }
        
        else
        {
            return array();
        }
    }
    
    public function getAllSectionClass($schoolid){
        $this->db->select("c.*");
        $this->db->from("class c");
        $this->db->where("c.status",1);
        $this->db->where("c.schoolId IN (".implode(',',$schoolid).")",NULL, false);
        $query = $this->db->get();
        
        if($query->num_rows() >0)
        {
            return $query->result_array();
        }
        else
        {
            return false;
        }
    }
    
     public function getCountryList(){
        $this->db->select("code.id as id, CONCAT('+',code.phonecode) as code, code.name as country");
        $this->db->from("country_codes code");
        $query = $this->db->get();
        
        if($query->num_rows() >0)
        {
            return $query->result_array();
        }
        else
        {
            return false;
        }
    }
    
      public function getCountryCodes($countryid){
          
        $dataQuery = " Select CONCAT('+',code.phonecode) as code  from country_codes as code where id IN(".implode(',',$countryid).")" ; 
        $query = $this->db->query($dataQuery);  
        //echo$this->db->last_query();die();
        if($query->result_id->num_rows!=0)
        {
            $data =  $query->result_array();
            return $data;  
         }
        else
        {
            return false;
        }
        
    }
   
    public function getRevenueReport($searchingArray){
        
        $whereDate = "";
        $whereCode = "";
        
         if(isset($searchingArray['classSectionList_id']) && (!empty($searchingArray['classSectionList_id'])>0))
        $whereIn = "class.id IN (".implode(',',$searchingArray['classSectionList_id']).") And ";
        else
        $whereIn = "";
        
        if(isset($searchingArray['fromdate']) && isset($searchingArray['todate']) && $searchingArray['fromdate']!="" && $searchingArray['todate']=="")
          $whereDate = "And  date(school.created_date)>='".date('Y-m-d', strtotime($searchingArray['fromdate']))."'"; 
        
        if(isset($searchingArray['fromdate']) && isset($searchingArray['todate']) && $searchingArray['fromdate']=="" && $searchingArray['todate']!="")
         $whereDate = "And date(school.created_date)>='".date('Y-m-d')."' And date(school.created_date)<='".date('Y-m-d', strtotime($searchingArray['todate']))."'"; 
        
        
        if(isset($searchingArray['fromdate']) && isset($searchingArray['todate']) && $searchingArray['fromdate']!="" && $searchingArray['todate']!="")
         $whereDate = "And date(school.created_date)>='".date('Y-m-d', strtotime($searchingArray['fromdate']))."' And date(school.created_date)<='".date('Y-m-d', strtotime($searchingArray['todate']))."'"; 
            
       
        if(isset($searchingArray['schoolLists_id'])) {
            
           $dataQuery = "Select 
               school.id as schoolid,
               school.school_name as school_name,
               school.email as email,
               school.location as location,
               school.city as city,
               school.pincode as pincode,
               school.city as city,
               school.pincode as pincode,
               sub.name as subTitle,
               sub.amount as amount,
               school.currency_id as currency_id,
               CONCAT(DATE_FORMAT(sub.start_date, '%d %b %Y'), ' To ', DATE_FORMAT(sub.end_date, '%d %b %Y') ) AS period, 
               sub.amount as amount,
               DATE_FORMAT(sub.end_date, '%d %b %Y') as validity
               from school_subscription as sub
               left join school as school on sub.school_id = school.id
               left join class as class on class.schoolId =school.id
               where " .$whereIn. "  school.id IN (".implode(',',$searchingArray['schoolLists_id']).")"  .$whereDate." group by sub.id" ;  
      
        }
        //echo $dataQuery;die;
        $query = $this->db->query($dataQuery);  
        if($query->result_id->num_rows!=0)
        {
           $result=$query->result_array();
           for($i=0;$i<count($result);$i++){
            $totalNgnAmount=0;
            $currency_id=$result[$i]['currency_id'];
            
            $getCurrencyAmmount=getCurrencyAmmount($currency_id);
            if($currency_id==1 || $currency_id==0){
                $totalNgnAmount=$totalNgnAmount+$result[$i]['amount'];
            }else{
                $totalNgnAmount=$totalNgnAmount+($result[$i]['amount']*$getCurrencyAmmount['currency_rate']);
            }
            $result[$i]['amount']=$totalNgnAmount;
        }
         return $result;          
         }
        else
        {
            return false;
        }
        
    }
        
    
}
