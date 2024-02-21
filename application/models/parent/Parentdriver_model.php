<?php
if (!defined('BASEPATH'))
exit('No direct script access allowed');

class Parentdriver_model extends CI_Model {


     public function studentDriver($studentID,$schoolID){
        
       $this->db->select(
       'd.id as driverID,         
       CONCAT(d.driverfname," ",d.driverlname) AS drivername,
       d.driverphone as driverphone,
       d.driveremail as driveremail,
       d.driverphoto as driverphoto,
       p.is_call_enable as is_call_enable,
       ');
       $this->db->from('driver_student_assignment as dsa');
       $this->db->join('driver as d', ' d.id = dsa.driverid','left');
       $this->db->join('child as c', 'c.id = '.$studentID.'','left');
       $this->db->join('parent as p', ' p.id = c.parent_id','left');
       $this->db->where("dsa.studentid",$studentID);
       $this->db->where("dsa.schoolid",$schoolID);
      
       $query = $this->db->get();
       //$this->db->last_query();exit;
        if ($query->num_rows() == 1) {
           return json_decode(json_encode($query->row()), true);
        } else {
            return false;
        }
        
    }
    
    
    public function get_current_journey_session($driverID,$schoolID) {
       
        $this->db->select('*');
        $this->db->from('daily_driver_journey as ddj');
        $this->db->where('ddj.driverId', $driverID);
        $this->db->where('ddj.schoolid', $schoolID);
        $this->db->where('date(ddj.created_date)', date('Y-m-d'));
        $query = $this->db->get();
        //echo $this->db->last_query();exit;
        $JourneyData = array();
        if ($query->num_rows() > 0) {
          $jData   = $query->row();
         
          if($jData->afternoon_start_status=='1' && $jData->afternoon_end_status=='0'){
             $JourneyData['driver_journey_session'] = 'afternoon';
             $JourneyData['driver_journey_status'] = '0';
             return $JourneyData;
          }
          elseif($jData->afternoon_start_status=='1' && $jData->afternoon_end_status=='1'){
             $JourneyData['driver_journey_session'] = 'afternoon';
             $JourneyData['driver_journey_status'] = '1';
             return $JourneyData;
          }
          elseif($jData->morning_start_status=='1' && $jData->morning_end_status=='0'){
             $JourneyData['driver_journey_session'] = 'morning';
             $JourneyData['driver_journey_status'] = '0';
             return $JourneyData;
          }
           elseif($jData->morning_start_status=='1' && $jData->morning_end_status=='1'){
             $JourneyData['driver_journey_session'] = 'morning';
             $JourneyData['driver_journey_status'] = '1';
             return $JourneyData;
          }
          else {
            return $JourneyData;  
          }
          
        } 
        else {
           return $JourneyData; 
        }
     }
     
     
     public function get_student_journey_status($driverID,$session,$studentID,$schoolID) {
       
        $this->db->select('*');
        $this->db->from('daily_student_journey as dsj');
        $this->db->where('dsj.driverId', $driverID);
        $this->db->where('dsj.schoolid', $schoolID);
        $this->db->where('dsj.studentid', $studentID);
        $this->db->where('date(dsj.created_date)', date('Y-m-d'));
        $query = $this->db->get();
        //echo $this->db->last_query();exit;
        $JourneyData = array();
        $returnData = array();
        if ($query->num_rows() > 0) 
        {
          $JourneyData   = json_decode(json_encode( $query->row()), true);
         
          if($session=="morning")
          {
              if(isset($JourneyData['pick_status']) && $JourneyData['pick_status']=='1') {
                 $returnData['journey_status'] = '1'; 
              }
              if(isset($JourneyData['pick_status']) && ($JourneyData['pick_status']=='0' || $JourneyData['pick_status']=='')) {
                 $returnData['journey_status'] = '0'; 
              }
              
          }
          
          if($session=="afternoon")
          {
              if(isset($JourneyData['drop_status']) && $JourneyData['drop_status']=='1') {
                 $returnData['journey_status'] = '1'; 
              }
              if(isset($JourneyData['drop_status']) && ($JourneyData['drop_status']=='0' || $JourneyData['drop_status']=='')) {
                 $returnData['journey_status'] = '0'; 
              }
              
          }
          return $returnData;
       } 
        else 
        {
            $returnData['journey_status'] = '0';
            return $returnData;
        }
     }
     
     
     
     
     public function journeyRemainingStops($driverID,$schoolID,$session) {
       
        $this->db->select('*');
        $this->db->from('journey_status as ds');
        $this->db->where('ds.driverid', $driverID);
        $this->db->where('ds.schoolid', $schoolID);
        $this->db->where('ds.status', 0);
        $this->db->where('ds.session', $session);
        $this->db->where('date(ds.created_date)', date('Y-m-d'));
        $query = $this->db->get();
        //echo $this->db->last_query();exit;
        $JourneyData = array();
        if ($query->num_rows() > 0) {
          $JourneyData   = json_decode(json_encode($query->result()), true);
        }
       return $JourneyData;
     }
    
    
      public function driverCurrentLocation($driverID,$schoolID,$session) {
      
          
       $currentData = array();
       $query = $this->db->query("SELECT  * FROM `latlong_log` WHERE id=(SELECT MAX(id) FROM latlong_log where schoolid = '".$schoolID."' And driverid = '".$driverID."' And session = '".$session."' And date(datetime)='".date('Y-m-d')."')");
        if ($query->num_rows() > 0) {   
          $currentData   = json_decode(json_encode( $query->row()), true);
         }
         return $currentData;
      }
      
      
      public function journeyLogStudents($schoolID,$driverID,$studentID){
        
        
       if((!empty($schoolID)) && (!empty($driverID)) && (!empty($studentID))) {
           
            if(date('D')!='Mon'){    
            $dateStart = date('Y-m-d',strtotime('last Monday'));    
            }else{
            $dateStart = date('Y-m-d');   
            }

            if(date('D')!='Sat'){
            $dateEnd = date('Y-m-d',strtotime('next Saturday'));
            }
            else{
            $dateEnd = date('Y-m-d');
            }  
            
            $selectData = "SELECT * FROM `daily_student_journey` as `dsj` WHERE dsj.studentid = '".$studentID."' And dsj.driverid = '".$driverID."' And dsj.schoolid = '".$schoolID."' And date(dsj.created_date) >= '".$dateStart."' And date(dsj.created_date) <= '".$dateEnd."' order by id desc";
            $query = $this->db->query($selectData);
            //echo $this->db->last_query(); exit;
            if ($query->num_rows() > 0) {
                $newArray = array();
                $data_user =  $query->result_array();  
                for($i=0;$i<count($data_user);$i++){
                    
                    $newArray[$i]['created_date'] = date('Y-m-d', strtotime($data_user[$i]['created_date']));
                    
                    $selectData = "SELECT * FROM `daily_driver_journey` where driverId = '".$driverID."' And schoolid = '".$schoolID."' And date(created_date) = '".date('Y-m-d', strtotime($data_user[$i]['created_date']))."'";
                    $query = $this->db->query($selectData);
                    $driverData  = json_decode(json_encode($query->row()), true);
                    
                    if($data_user[$i]['pick_status']==1){ 
                    $newArray[$i]['pickup_starttime'] = date('h:i A', strtotime($data_user[$i]['pick_time'])); 
                     
                    if($driverData['morning_end_status']==1)
                    $newArray[$i]['pickup_endtime'] = date('h:i A', strtotime($driverData['morning_end_time'])); 
                    else
                    $newArray[$i]['pickup_endtime'] = "";     
                    }
                    else{ 
                    $newArray[$i]['pickup_starttime'] = "";
                    $newArray[$i]['pickup_endtime'] = ""; 
                    }
                        
                   if($data_user[$i]['drop_status']==1){ 
                     $newArray[$i]['dropoff_endtime'] = date('h:i A', strtotime($data_user[$i]['drop_time'])); 
                     
                    if($driverData['afternoon_start_status']==1)
                    $newArray[$i]['dropoff_starttime'] = date('h:i A', strtotime($driverData['afternoon_start_time'])); 
                    else
                    $newArray[$i]['dropoff_starttime'] = ""; 
                     
                   }
                    else{ 
                    $newArray[$i]['dropoff_endtime'] = ""; 
                    $newArray[$i]['dropoff_starttime'] = "";
                    }
                    
                     
                    
                }
                
              return $newArray;  
            } else {
            return false;
        }
       }
       else {
         return false;  
       }
        
    }
    
}

?>