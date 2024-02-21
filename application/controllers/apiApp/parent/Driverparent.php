<?php
defined('BASEPATH') OR exit('No direct script access allowed');
require APPPATH . '/libraries/REST_Controller.php';

class DriverParent extends REST_Controller {

    public $error = array();
    public $data = array();
    public $schoolID = array();
    public $studentID = array();
    public $driverID = array();
    public $journey_session = array();
    public $journeyStops = array();
    public $student_journey_status = array();
  

    function __construct() {
        parent::__construct();
        $this->token->parent_validate();
        $this->load->library("security");
        $this->load->library('form_validation');
        $this->load->model('parent/Parentdriver_model','parentdriver');
        //$this->token->parent_id;
        //$this->token->class_id;
        $this->load->library('fcm');
        $this->load->helper('common_helper');
        $this->schoolID = $this->token->school_id;
        $this->studentID = $this->token->student_id;
        $this->driverData = $this->parentdriver->studentDriver($this->studentID,$this->schoolID);
        
       
        
        if(isset($this->driverData['driverID']) && (!empty($this->driverData['driverID'])) && (!empty($this->schoolID))){
        $this->journey_session = $this->parentdriver->get_current_journey_session($this->driverData['driverID'],$this->schoolID);
        }
      
        if(isset($this->driverData['driverID']) && isset($this->journey_session['driver_journey_session']) && (!empty($this->driverData['driverID'])) && (!empty($this->journey_session['driver_journey_session']))){
          $this->journeyStops = $this->parentdriver->journeyRemainingStops($this->driverData['driverID'],$this->schoolID,$this->journey_session['driver_journey_session']); 
        }
        
       
        
      if(isset($this->driverData['driverID']) && isset($this->journey_session['driver_journey_session']) && (!empty($this->driverData['driverID'])) && (!empty($this->journey_session['driver_journey_session']))){
         $this->student_journey_status = $this->parentdriver->get_student_journey_status($this->driverData['driverID'],$this->journey_session['driver_journey_session'],$this->studentID,$this->schoolID);
       }
        
    }
    
    
    public function getJourneyStatus_get()
    {
      $student_journey_status = $this->student_journey_status;
      $driver_journey_session = isset($this->journey_session['driver_journey_session']) ? $this->journey_session['driver_journey_session'] : '';
      $driver_journey_status = isset($this->journey_session['driver_journey_status']) ? $this->journey_session['driver_journey_status'] : ''; 
      
     $jType = "";
     $sMessage=""; 
     $completedJourney = "";
     $endJourneyMsg = "";
     $school_data= get_school($this->schoolID);
     if($driver_journey_session == "" || $driver_journey_session=="morning"){
          $jType = 'pick up';
          $sMessage = 'picked up';
          $completedJourney = "Student picked up successfully";
          $endJourneyMsg = 'Student dropped to '. $school_data['school_name'];
      }
      
      if($driver_journey_session=="afternoon"){
          $jType = 'drop';
          $sMessage = 'Dropped';
          $completedJourney = "Student dropped at stop";
          $endJourneyMsg = 'Driver drop journey completed';
      }       
      
      
      if(empty($this->journey_session)) {
       $return['success'] = "false";
       $return['title'] = "error";
       $return['message'] = "Driver has not started the ".$jType." ride yet";
       $return['error'] = $this->error;
       $this->response($return, REST_Controller::HTTP_BAD_REQUEST);      
      }
     
      
      if((!empty($this->journey_session)) && $driver_journey_status=='1') {
       $return['success'] = "true";
       $return['title'] = "success";
       $return['journey_session'] = $driver_journey_session;
       $return['journey_status'] = 2;
       $return['message'] = $endJourneyMsg;
       $return['error'] = $this->error;
       $this->response($return, REST_Controller::HTTP_BAD_REQUEST);      
      }
     
    
      
       if( (!empty($student_journey_status)) && isset($student_journey_status['journey_status']))
       {
           $driverCurrentLocation = $this->parentdriver->driverCurrentLocation($this->driverData['driverID'],$this->schoolID,$driver_journey_session);
            if(!empty($driverCurrentLocation)) {
             $this->driverData['current_latitude'] =  $driverCurrentLocation['latitude']; 
             $this->driverData['current_longitude'] =  $driverCurrentLocation['longitude'];
             $this->driverData['location_title'] =  $driverCurrentLocation['location'];
             $this->driverData['time'] =  $driverCurrentLocation['datetime'];
            }
            else {
            $this->driverData['current_latitude'] =  "0.0"; 
            $this->driverData['current_longitude'] =  "0.0";
            $this->driverData['location_title'] =  "";
            $this->driverData['time'] =  "";    
            }
           
         
           if($this->student_journey_status['journey_status']=='0')
           {
            $return['success'] = "true";
            $return['title'] = "success";
            $return['journey_session'] = $driver_journey_session;
            $return['journey_status'] = 0;
            $return['driver'] = $this->driverData;
            $return['stops'] = $this->journeyStops;
            $return['message'] = "Driver started ".$jType." journey";
            $return['error'] = $this->error;
            $this->response($return, REST_Controller::HTTP_OK);    
           }
           else 
           {
           $return['success'] = "true";
           $return['title'] = "success";
           $return['journey_session'] = $driver_journey_session;
           $return['journey_status'] = 1;
           $return['driver'] =  $this->driverData;
           $return['stops'] =   array();
           $return['message'] = $completedJourney;
           $return['error'] = $this->error;
           $this->response($return, REST_Controller::HTTP_OK);    
           }
       }
       else {
        $return['success'] = "false";
        $return['title'] = "error";
        $return['message'] = "No Student Journey Found";
        $return['error'] = $this->error;
        $this->response($return, REST_Controller::HTTP_BAD_REQUEST);   
       }
        
    }
    
    
    public function nearestLocation_post()
    {
      $journeyStops = $this->journeyStops;  
      $student_journey_status = $this->student_journey_status;
      
      $driver_journey_session = isset($this->journey_session['driver_journey_session']) ? $this->journey_session['driver_journey_session'] : '';
      $driver_journey_status = isset($this->journey_session['driver_journey_status']) ? $this->journey_session['driver_journey_status'] : ''; 
      
      
      
      
     $jType = "";
     $sMessage=""; 
     $completedJourney = "";
     $endJourneyMsg = "";
     
     if($driver_journey_session == "" || $driver_journey_session=="morning"){
          $jType = 'pick up';
          $sMessage = 'picked up';
          $completedJourney = "Student picked up successfully";
          $endJourneyMsg = 'Student Dropped successfully to school';
      }
      
      if($driver_journey_session=="afternoon"){
          $jType = 'drop';
          $sMessage = 'Dropped';
          $completedJourney = "Student dropped successfully at stop";
          $endJourneyMsg = 'Driver drop journey completed';
      } 
      
     
      
      if(empty($this->journey_session)) {
       $return['success'] = "false";
       $return['title'] = "error";
       $return['message'] = "Driver not started the ".$jType." ride yet";
       $return['error'] = $this->error;
       $this->response($return, REST_Controller::HTTP_BAD_REQUEST);      
      }
     
      
      if((!empty($this->journey_session)) && $driver_journey_status=='1') {
       $return['success'] = "true";
       $return['title'] = "success";
       $return['journey_session'] = $driver_journey_session;
       $return['journey_status'] = 2;
       $return['message'] = $endJourneyMsg;
       $return['error'] = $this->error;
       $this->response($return, REST_Controller::HTTP_BAD_REQUEST);      
      }
      
      
       if((!empty($student_journey_status)) && isset($student_journey_status['journey_status']) && $student_journey_status['journey_status']!="")
       {
            $postData = json_decode(file_get_contents('php://input'), true);
            if ($postData == '') {
            $postData = $_POST;
            } 
            $current_latitude   = isset($postData['current_latitude']) ? $postData['current_latitude'] : "" ;
            $current_longitude   = isset($postData['current_longitude']) ? $postData['current_longitude'] : "" ;

            $driverCurrentLocation = $this->parentdriver->driverCurrentLocation($this->driverData['driverID'],$this->schoolID,$driver_journey_session);
            if(!empty($driverCurrentLocation)) {
             $this->driverData['current_latitude'] =  $driverCurrentLocation['latitude']; 
             $this->driverData['current_longitude'] =  $driverCurrentLocation['longitude'];
             $this->driverData['location_title'] =  $driverCurrentLocation['location'];
             $this->driverData['time'] =  $driverCurrentLocation['datetime'];
            }
            else {
            $this->driverData['current_latitude'] =  "0.0"; 
            $this->driverData['current_longitude'] =  "0.0";
            $this->driverData['location_title'] =  "";
            $this->driverData['time'] =  "";    
            }
           
           
            if($student_journey_status['journey_status']=='0') 
            {
                
                if(!empty($journeyStops) && (!empty($current_latitude)) && (!empty($current_longitude)))
                {
                    $arrayData = array(
                    'current_latitude' =>$current_latitude, 
                    'current_longitude' =>$current_longitude, 
                    'journeyStops' =>$journeyStops, 
                     );
                    
                    $nearestLocation = $this->nearestLocation($arrayData);
                    
                    
                    $this->driverData['distance_from_nearest_stop'] = "";
                    ############ Find the distance between driver and parent nearby stops ############### 
                    if(isset($nearestLocation['stop_latitude']) &&  isset($nearestLocation['stop_longitude']) && isset($driverCurrentLocation['latitude']) && isset($driverCurrentLocation['longitude']))
                    {
                        $location1 = $nearestLocation['stop_latitude'];
                        $location2 = $nearestLocation['stop_longitude'];
                        $location3 = $driverCurrentLocation['latitude'];
                        $location4 = $driverCurrentLocation['longitude'];
                        
                       $miles  = $this->getDistanceBetweenPointsNew($location1, $location2, $location3, $location4);
                       $kilometers = $miles * 1.609344;
                       $meter = $miles *1609.344;
         
                        $distance = array(
                        'miles'=>$miles,
                        'kilometers'=>$kilometers,
                        'meter'=>$meter,
                        );
                        
                        
                       $this->driverData['distance_from_nearest_stop'] =  $distance;
                       if(isset($distance['meter']) && (isset($this->token->parent_id)) && (!empty($distance['meter'])) && ($distance['meter']>'0') && ($distance['meter']<'500')){
                           $this->sendNotification($this->token->parent_id,$driver_journey_session);
                       }
                    }
                    ############ End Find the distance between driver and parent nearby stops ############### 
                    
                    
                    $return['success'] = "true";
                    $return['title'] = "success";
                    $return['journey_session'] = $driver_journey_session;
                    $return['journey_status'] = 0;
                    $return['nearest_location'] = $nearestLocation;
                    $return['driver'] = $this->driverData;
                    $return['stops'] = $this->journeyStops;
                    $return['message'] = "Nearest Loaction Found";
                    $return['error'] = $this->error;
                    $this->response($return, REST_Controller::HTTP_OK); 
                }
                else 
                {
                    $return['success'] = "true";
                    $return['title'] = "success";
                    $return['journey_session'] = $driver_journey_session;
                    $return['journey_status'] = 0;
                    $return['nearest_location'] = array();
                    $return['driver'] = $this->driverData;
                    $return['stops'] = $this->journeyStops;
                    $return['message'] = "Nearest Loaction Not Found";
                    $return['error'] = $this->error;
                    $this->response($return, REST_Controller::HTTP_OK);  
                }
                
            }
            else {
           $return['success'] = "true";
           $return['title'] = "success";
           $return['journey_session'] = $driver_journey_session;
           $return['journey_status'] = 1;
           $return['driver'] =  $this->driverData;
           $return['stops'] =   array();
           $return['message'] = $completedJourney;
           $return['error'] = $this->error;
           $this->response($return, REST_Controller::HTTP_OK); 
            }
       }
       else 
       {
        $return['success'] = "false";
        $return['title'] = "error";
        $return['message'] = "No Student Journey Found";
        $return['error'] = $this->error;
        $this->response($return, REST_Controller::HTTP_BAD_REQUEST);       
       }
    }
    
    
    public  function nearestLocation($arrayData) 
    {
        $returnArray = array(); 
        
        //if(empty($arrayData))
        //return $returnArray;
        
        //print_r($arrayData);
        //exit;
        
        $current_latitude   = isset($arrayData['current_latitude']) ? $arrayData['current_latitude'] : "" ;
        $current_longitude   = isset($arrayData['current_longitude']) ? $arrayData['current_longitude'] : "" ;
        $journeyStops   = isset($arrayData['journeyStops']) ? $arrayData['journeyStops'] : "" ;
        
        
        foreach ($journeyStops as $key => $location)
        {
        $a = $current_latitude - $location['stop_latitude'];
        $b = $current_longitude - $location['stop_longitude'];
        $distance = sqrt(($a**2) + ($b**2));
        $distances[$key] = $distance;
        }
        asort($distances);
        $closest = $journeyStops[key($distances)];
       
        $nearestLoaction = array(
            'stop_title'=>$closest['stop_title'],
            'stop_latitude'=>$closest['stop_latitude'],
            'stop_longitude'=>$closest['stop_longitude'],
        );
        
         $miles  = $this->getDistanceBetweenPointsNew($current_latitude, $current_longitude, $nearestLoaction['stop_latitude'], $nearestLoaction['stop_longitude']);
         $kilometers = $miles * 1.609344;
         $meter = $miles *1609.344;
         
         $distance = array(
            'miles'=>$miles,
            'kilometers'=>$kilometers,
            'meter'=>$meter,
        );
       $nearestLoaction['distance'] =  $distance;
       return $nearestLoaction;     
        
    }         
    
    
    
    public  function getDistanceBetweenPointsNew($latitude1, $longitude1, $latitude2, $longitude2, $unit = 'miles') 
    {
          $theta = $longitude1 - $longitude2; 
          $distance = (sin(deg2rad($latitude1)) * sin(deg2rad($latitude2))) + (cos(deg2rad($latitude1)) * cos(deg2rad($latitude2)) * cos(deg2rad($theta))); 
          $distance = acos($distance); 
          $distance = rad2deg($distance); 
          $distance = $distance * 60 * 1.1515; 
          switch($unit) { 
            case 'miles': 
              break; 
            case 'kilometers' : 
              $distance = $distance * 1.609344; 
          } 
          return $distance; 
    }
    
    
    
    public function sendNotification($parent_id,$session)
     {
         if((!empty($parent_id)) &&  ($session!=""))
         {
             $query = $this->db->query("SELECT  * FROM `driver_pre_notification` WHERE parent_id= '".trim($parent_id)."' and session = '".$session."' And date(created_date) = '".date('Y-m-d')."'");
             if ($query->num_rows() == 0) 
             {   
                  $parent  =  $this->getParentFCM($parent_id);  
                  $token = isset($parent['fcm_key']) ? $parent['fcm_key'] : '';
                  $message= 'Please reach your nearest stop.driver will arive there shortly.';
                  $title = "Driver Notification";
                  $notifyJson =  $this->fcm->sendPushNotification($token, $title, $message);
                  $notify =  json_decode($notifyJson);
                  if($notify->success > 0){
                   $logdata = array(
                    'parent_id' => $parent_id,
                    'session' => $session,
                    'created_date' => date('Y-m-d H:i:s'),     
                    );
                  $this->db->insert('driver_pre_notification', $logdata);   
                  }
                    
            } 
             
         }    
     }
     
     
      public function getParentFCM($parent_id)
      {
            $where = array('user_type'=>'Parent', 'user_id' => $parent_id);
            $this->db->select('user_id,fcm_key');
            $this->db->from('user_token');
            $this->db->where($where);
            $this->db->order_by('id','desc');
            $query =  $this->db->get();
            return $query->row_array();
      }
      
      
      public function journeyLogStudents_get(){
    
        
        $schoolid = isset($this->schoolID) ? $this->schoolID : "";
        $driverID = isset($this->driverData['driverID']) ? $this->driverData['driverID'] : "";
        $studentID = isset($this->studentID) ? $this->studentID : "";
        $result = $this->parentdriver->journeyLogStudents($schoolid,$driverID,$studentID);
        if ($result) {
            $return['success'] = "true";
            $return['message'] = "Student Journey Log Found";
            $return['data'] = $result;
            $return['error'] = $this->error;
            $this->response($return, REST_Controller::HTTP_OK);
        } else {
            $return['success'] = "false";
            $return['message'] = "No Student Journey Log Found.";
            $return['data'] = $result;
            $return['error'] = $this->error;
            $this->response($return, REST_Controller::HTTP_BAD_REQUEST);      
        }
     }
    
}

 

    
    ?>