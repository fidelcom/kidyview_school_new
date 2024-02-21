<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Teacher_model extends CI_Model {
    
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
   
    public function getTeacherReport($searchingArray){
        
        $whereDate = "";
        $whereCode = "";  
        
        if(isset($searchingArray['classSectionList_id']) && (!empty($searchingArray['classSectionList_id'])>0))
        $whereIn = 'CONCAT(",", `assignclassteacher`, ",") REGEXP ",('.implode('|',$searchingArray['classSectionList_id']).')," And';
        else
        $whereIn = ""; 
       
        
        if(isset($searchingArray['fromdate']) && isset($searchingArray['todate']) && $searchingArray['fromdate']!="" && $searchingArray['todate']=="")
          $whereDate = "And  date(t.created_date)>='".date('Y-m-d', strtotime($searchingArray['fromdate']))."'"; 
        
        if(isset($searchingArray['fromdate']) && isset($searchingArray['todate']) && $searchingArray['fromdate']=="" && $searchingArray['todate']!="")
         $whereDate = "And date(t.created_date)>='".date('Y-m-d')."' And date(t.created_date)<='".date('Y-m-d', strtotime($searchingArray['todate']))."'"; 
        
        
        if(isset($searchingArray['fromdate']) && isset($searchingArray['todate']) && $searchingArray['fromdate']!="" && $searchingArray['todate']!="")
         $whereDate = "And date(t.created_date)>='".date('Y-m-d', strtotime($searchingArray['fromdate']))."' And date(t.created_date)<='".date('Y-m-d', strtotime($searchingArray['todate']))."'"; 
            
       
        if(isset($searchingArray['schoolLists_id'])) {
            
             $dataQuery = "Select 
               school.id as schoolid,
               t.teacherfname as teacherfname,
               t.teachermname as teachermname,
               t.teacherlname as teacherlname,
               t.teacheremail as teacheremail,
               t.teacheraddress as teacheraddress,
               t.tcity as tcity,
               t.tpincode as tpincode
               from school as school
               inner join  teacher as t on t.schoolid =school.id
               where " .$whereIn. "  school.id IN (".implode(',',$searchingArray['schoolLists_id']).")"  .$whereDate."" ;  
           
              
        }
        
        $query = $this->db->query($dataQuery);  
        //echo $this->db->last_query();die();
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
