<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Driver_model extends CI_Model {
    
    
    public function getAllSchool($countryID)
    {
       
        
        $this->db->select("s.id as id,s.phone as phone, s.school_name as school");
        $this->db->from("school s");
        $this->db->where("s.status",1);
        $this->db->where("s.country IN (".implode(',',$countryID).")",NULL, false);
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
   
    public function getSchoolDriver($searchingArray){
        
        $whereDate = "";
        $whereCode = "";
        
        if(isset($searchingArray['classSectionList_id']) && (!empty($searchingArray['classSectionList_id'])>0))
        $whereIn = "dsa.classid IN (".implode(',',$searchingArray['classSectionList_id']).") And ";
        else
        $whereIn = ""; 
           
        
        
        if(isset($searchingArray['fromdate']) && isset($searchingArray['todate']) && $searchingArray['fromdate']!="" && $searchingArray['todate']=="")
          $whereDate = "And  date(d.created_date)>='".date('Y-m-d', strtotime($searchingArray['fromdate']))."'"; 
        
        if(isset($searchingArray['fromdate']) && isset($searchingArray['todate']) && $searchingArray['fromdate']=="" && $searchingArray['todate']!="")
         $whereDate = "And date(d.created_date)>='".date('Y-m-d')."' And date(d.created_date)<='".date('Y-m-d', strtotime($searchingArray['todate']))."'"; 
        
        
        if(isset($searchingArray['fromdate']) && isset($searchingArray['todate']) && $searchingArray['fromdate']!="" && $searchingArray['todate']!="")
         $whereDate = "And date(d.created_date)>='".date('Y-m-d', strtotime($searchingArray['fromdate']))."' And date(d.created_date)<='".date('Y-m-d', strtotime($searchingArray['todate']))."'"; 
            
       
        if(isset($searchingArray['schoolLists_id'])) {
            
          $dataQuery = "Select 
               school.id as schoolid,
               school.school_name as school_name,
               d.driverfname as driverfname,
               d.driverlname as driverlname,
               d.driveremail as driveremail,
               d.driverphone as driverphone,
               d.dpincode as dpincode,
               d.driveraddress as driveraddress
               from school as school
               inner join driver_student_assignment as dsa on dsa.schoolid =school.id 
               left join driver as d on d.id = dsa.driverid
               where  " .$whereIn. "  school.id IN (".implode(',',$searchingArray['schoolLists_id']).")" .$whereDate." group by dsa.driverid" ;  
        }
        
        $query = $this->db->query($dataQuery);  
        //echo$this->db->last_query();die();
        if($query->result_id->num_rows!=0)
        {
           return  $query->result_array();
                         
         }
        else
        {
            return false;
        }
        
    }
        
    
}
