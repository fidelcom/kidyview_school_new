<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Driver_model extends CI_Model {

    public function validate($email, $pass) {
        $this->db->from('driver u');
        //$this->db->where('u.status', 1);

        if ($email != '' && $pass != "") {
            $this->db->where("((u.driveremail = '$email' And  u.password = '$pass'))");
        }

        $query = $this->db->get();
        //echo $this->db->last_query();die;

        if ($query->num_rows() == 1) {
            return $query->row();
        } else {
            return false;
        }
    }

    public function getDriver($id) {
       
        $this->db->select(
       'd.drivercode as drivercode,
       d.driverfname as driverfname,
       d.driverlname as driverlname,
       d.driveremail as driveremail,
       d.password as password,
       d.drivercode as drivercode,
       d.driverphone as driverphone,
       d.driveraddress as driveraddress,
       d.driverphoto as driverphoto,
       d.dcity as dcity,
       d.dstate as dstate,
       d.dcountry as dcountry,
       d.dpincode as dpincode,
       d.driverlicense as driverlicense,
       d.driverLicenseExpire as driverLicenseExpire,
       d.schoolId as schoolId,
       CONCAT(v.vehicle_name," (",v.vcode,")") AS vehicle_name,
       v.vehicle_number as vehicle_number,
       v.plate_number as vehicle_plate_number,
       v.photo as vehicle_photo,
       v.vehicle_type as vehicle_type,
       v.model as vehicle_model,
       r.route_title as route_title,
       r.route_code as route_code,
       CONCAT(r.route_start," To ",r.route_end) AS routepath,
       r.stops as enc_stops,
       r.lat_long as enc_latlong
       ');
       $this->db->from('driver as d');
       $this->db->join('vehicle as v', ' v.id = d.drivervehicle','left');
       $this->db->join('route as r', ' r.id = v.route','left');
       $this->db->join('school as school ', ' school.id = d.schoolId');
        
       if ($id != '') {
            $this->db->where("(d.id = '$id')");
        }

        $query = $this->db->get();
        if ($query->num_rows() == 1) {
            $newArray = array();
            $data_user = $query->row();
             $data_user->stopDetails = $this->getStopsStatus($data_user->schoolId,$id);
            //$data_user->stopDetails = $this->stopsDetails($data_user->enc_stops,$data_user->enc_latlong);
            unset($data_user->enc_stops); 
            unset($data_user->enc_latlong);
            return $data_user;
           
        } else {
            return false;
        }
    }
    
    
    
    
    
    public function getStopsStatus($schoolid,$driverid) {
        $stopsData = array();
        $this->db->from('journey_status');
        $this->db->where("((schoolid = '".$schoolid."' And  driverid = '".$driverid."' And date(created_date) = '".date('Y-m-d')."'))");
        $this->db->where('schoolid', $schoolid);
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            $data_user =  $query->result_array();  
             for($i=0;$i<count($data_user);$i++){
                 $stopsData[$i]['id'] = $data_user[$i]['id'];
                 $stopsData[$i]['stop_title'] = $data_user[$i]['stop_title'];
                 $stopsData[$i]['stop_latitude'] = $data_user[$i]['stop_latitude'];
                 $stopsData[$i]['stop_longitude'] = $data_user[$i]['stop_longitude'];
                 $stopsData[$i]['status'] = $data_user[$i]['status'];
                 $stopsData[$i]['status_time'] = $data_user[$i]['status_time'];
                 $stopsData[$i]['session'] = $data_user[$i]['session'];
                
                
             }
             return $stopsData;
        }
        else {
            return  $stopsData;
        }
    }
    
     public function completestop($id) { 
       $this->db->where('id', $id);
       $userdata = array('status' => '1','status_time'=>date('Y-m-d H:i:s'));
       $this->db->update('journey_status', $userdata);
       return true;
     }
    
    
    public function makeJourneyStops($journey_start_type,$driverID,$schoolID) { 
        
       $this->db->select('
        d.id as id,
        d.driverfname as driverfname,
        r.stops as enc_stops,
        r.lat_long as enc_latlong,
        d.driverlname as driverlname');
       $this->db->select('d.id as id');
       $this->db->from('driver as d');
       $this->db->join('vehicle as v', ' v.id = d.drivervehicle','left');
       $this->db->join('route as r', ' r.id = v.route','left');
       $this->db->join('school as school ', ' school.id = d.schoolId');
       $this->db->where("(d.id = '$driverID')");
       $query = $this->db->get();
          if ($query->num_rows() > 0) {
             $data_user = $query->row();  
             if(!empty($data_user->enc_stops) && (!empty($data_user->enc_latlong)))
             {    
             $data_user->stopDetails = $this->stopsDetails($data_user->enc_stops,$data_user->enc_latlong);
             unset($data_user->enc_stops); unset($data_user->enc_latlong);
             $stops = $data_user->stopDetails;
             $journeydata =  array();
             if($journey_start_type=='morning')
             {
                 $deleteArray = array('driverid' => $driverID,'schoolid'=>$schoolID,'session'=>$journey_start_type,'date(created_date)'=>date('Y-m-d'));
                 @$this->db->delete('journey_status',$deleteArray);
                
                for($i=0;$i<count($stops);$i++)
                {
                    
                    $journeydata[] = array(
                     'schoolid' => $schoolID,
                     'driverid' => $driverID,
                     'stop_title' => $stops[$i]['stoptitle'],
                     'stop_latitude' => $stops[$i]['latitude'],
                     'stop_longitude' => $stops[$i]['longitude'],   
                     'status' => '0',
                     'session' => 'morning',
                     'created_date' => date('Y-m-d H:i:s'),     
                    );
                     
                }
                $this->db->insert_batch('journey_status', $journeydata); 
             }
            else 
            {
             $deleteArray = array('driverid' => $driverID,'schoolid'=>$schoolID,'session'=>$journey_start_type,'date(created_date)'=>date('Y-m-d'));
             @$this->db->delete('journey_status',$deleteArray);   
             $stops = array_reverse($stops);    
                for($i=0;$i<count($stops);$i++)
                {
                    
                    $journeydata[] = array(
                     'schoolid' => $schoolID,
                     'driverid' => $driverID,
                     'stop_title' => $stops[$i]['stoptitle'],
                     'stop_latitude' => $stops[$i]['latitude'],
                     'stop_longitude' => $stops[$i]['longitude'],   
                     'status' => '0',
                     'session' => 'afternoon',
                     'created_date' => date('Y-m-d H:i:s'),     
                    );
                     //$this->db->insert('journey_status', $journeydata);
                }
                $this->db->insert_batch('journey_status', $journeydata);
                 
             }
              
            
          }
       }
       
    }
    
     public function stopsDetails($stops,$latlong) {
      $stopsArray  =  unserialize($stops);
      $latLongArray  =  unserialize($latlong);
      $stopDetails = array();  
      if(!empty($stopsArray)) {
          for($i=0;$i<count($stopsArray);$i++){
             $stopDetails[$i]['stoptitle'] = $stopsArray[$i];
             $stopDetails[$i]['latitude'] = $latLongArray['latLong']['latitude'][$i]; 
             $stopDetails[$i]['longitude'] = $latLongArray['latLong']['longitude'][$i]; 
          }
          
      }
     
        return $stopDetails; 
     }

    public function checkuser($email) {
        $this->db->from('driver u');
        //$this->db->where('u.status', 1);

        if ($email != '') {
            $this->db->where("(u.driveremail = '$email')");
        }

        $query = $this->db->get();
        if ($query->num_rows() == 1) {
            return $query->row();
        } else {
            return false;
        }
    }

    public function changePassword($driverID, $userdata) {

        if ($driverID != '') {
            $this->db->where('id', $driverID);
            $this->db->update('driver', $userdata);
        }
    }

    public function addToken($data) {
        $this->db->insert('user_token', $data);
    }

    public function routeExist($route, $id = Null) {
        $this->db->select("id`");
        if ($id != Null && $id > 0) {
            $this->db->where('route_title', $route);
            $this->db->where('id!=', $id);
        } else {
            $this->db->where('route_title', $route);
        }
        $query = $this->db->get('route');
        if ($query->num_rows() > 0) {
            return $query->row();
        } else {
            return false;
        }
    }

    public function addRoute($data) {
        $this->db->insert('route', $data);
        $id = $this->db->insert_id();
        return $id;
    }

    public function getAllRoute($schoolId) {
        $this->db->from('route');
        $this->db->where('schoolId', $schoolId);
        $query = $this->db->get();
        if ($query->result_id->num_rows != 0) {
            $newArray = array();
            $data_user = $query->result_array();
            for ($i = 0; $i < count($data_user); $i++) {
                $newArray[$i]['id'] = $data_user[$i]['id'];
                $newArray[$i]['route_code'] = $data_user[$i]['route_code'];
                $newArray[$i]['route_title'] = $data_user[$i]['route_title'];
                $newArray[$i]['route_start'] = $data_user[$i]['route_start'];
                $newArray[$i]['route_end'] = $data_user[$i]['route_end'];
                $newArray[$i]['stops'] =  unserialize($data_user[$i]['stops']);
            }
            return $newArray;
        } else
            return false;
    }

    public function getRoute($id) {
        $this->db->from('route');
        $this->db->where('id', $id);
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            $mydata = array();
            $result = $query->row();
            $mydata['id'] = $result->id;
            $mydata['schoolId'] = $result->schoolId;
            $mydata['route_title'] = $result->route_title;
            $mydata['route_code'] = $result->route_code;
            $mydata['route_start'] = $result->route_start;
            $mydata['route_end'] = $result->route_end;
            $mydata['stops'] = unserialize($result->stops);
            $mydata['lat_long'] = unserialize($result->lat_long);
            return $mydata;
        } else {
            return false;
        }
    }

    public function updateRoute($data, $id) {
        $this->db->where('id', $id);
        $this->db->update('route', $data);
        return true;
    }

    public function vehicleNumberExist($postData, $id = Null) {
        $this->db->select("id`");
        if ($id != Null && $id > 0) {
            $this->db->where("((vehicle_number = '" . $postData['vehicle_number'] . "' OR  plate_number =  '" . $postData['plate_number'] . "'))");
            $this->db->where('id!=', $id);
        } else {
            $this->db->where("((vehicle_number = '" . $postData['vehicle_number'] . "' OR  plate_number =  '" . $postData['plate_number'] . "'))");
        }
        $query = $this->db->get('vehicle');
        if ($query->num_rows() > 0) {
            return $query->row();
        } else {
            return false;
        }
    }

    public function addVehicle($data) {
        $this->db->insert('vehicle', $data);
        $id = $this->db->insert_id();
        return $id;
    }

    public function getAllvehicle($schoolId) {
        $this->db->select('v.*,r.route_title as route_title,r.route_code as route_code,CONCAT(route_start," To ",route_end) AS routepath');
        $this->db->from('vehicle as v');
        $this->db->join('route as r', 'r.id = v.route');
        $this->db->where('v.schoolId', $schoolId);
        $query = $this->db->get();

        if ($query->result_id->num_rows != 0) {
            return $query->result_array();
        } else
            return false;
    }

    public function getVehicle($id) {
        $this->db->select('v.*,r.route_title as route_title,r.route_code as route_code');
        $this->db->from('vehicle as v');
        $this->db->join('route as r', 'r.id = v.route');
        $this->db->where('v.id', $id);
        $query = $this->db->get();

        if ($query->num_rows() > 0) {
            return $query->row();
        } else
            return false;
    }

    public function updatevehicle($data, $id) {
        $this->db->where('id', $id);
        $this->db->update('vehicle', $data);
        return true;
    }

    public function driverExist($email, $phone) {
        $this->db->select("id`");
        $this->db->where('driveremail', $email);
        $this->db->or_where('driverphone', $phone);

        $query = $this->db->get('driver');
        if ($query->num_rows() > 0) {
            return $query->row();
        } else {
            return false;
        }
    }

    public function driverExistInEditCase($email, $phone, $driverId) {
        $query = $this->db->query("SELECT id FROM driver WHERE (driveremail = '$email' OR driverphone = '$phone') AND id NOT IN($driverId)");
        if ($query->num_rows() > 0) {
            return $query->row();
        } else {
            return false;
        }
    }

    public function addDriver($data) {
        $this->db->insert('driver', $data);
        $id = $this->db->insert_id();
        return $id;
    }
    public function editDriver($data, $driverID, $schoolId) {
        $this->db->where('id', $driverID);
        $this->db->where('schoolId', $schoolId);
        $this->db->update('driver', $data);
        //echo $this->db->last_query(); die;
        return true;
    }

    public function getAllDriverForSchool($id) {
        
        $this->db->select('d.*,v.vcode as vcode,v.vehicle_name as vehicle_name ,v.vehicle_number as vehicle_number,CONCAT(r.route_start," To ",r.route_end) AS routepath');
        $this->db->from('driver as d');
        $this->db->join('vehicle as v', 'v.id = d.drivervehicle','LEFT');
        $this->db->join('route as r', 'r.id = v.route','LEFT');
        $this->db->where('d.schoolId', $id);
        $this->db->order_by('d.id', 'DESC');
        $query = $this->db->get();
        //echo $this->db->last_query(); die;

        if ($query->result_id->num_rows != 0) {
            $data_user = $query->result_array();
            return $data_user;
        } else
            return false;
    }
    
     public function VehicleUsed($vehicleId,$schoolId, $id = Null) {
        $this->db->from('driver');
        if ($id != Null && $id > 0) {
            $this->db->where("(drivervehicle = '" . $vehicleId . "')");
            $this->db->where('schoolId=', $schoolId);
            $this->db->where('id!=', $id);
            $this->db->where('status=','1');
            
            
        } else {
            $this->db->where("(drivervehicle = '" . $vehicleId . "')");
            $this->db->where('schoolId=', $schoolId);
            $this->db->where('status=','1');
        }
       $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->row();
        } else {
            return false;
        }
    }
    
    public function getDriverDetails($id) {
        $this->db->select('d.*,s.school_name as school_name,v.vcode as vcode,v.vehicle_name as vehicle_name ,v.vehicle_number as vehicle_number,CONCAT(r.route_title," (",r.route_code,") ") AS routeTitle ,CONCAT(r.route_start," To ",r.route_end) AS routepath,r.stops as stops');
        $this->db->from('driver d');
        $this->db->join('vehicle as v', 'v.id = d.drivervehicle');
        $this->db->join('route as r', 'r.id = v.route');
        $this->db->join('school s', 'd.schoolId = s.id', 'LEFT');
        $this->db->where('d.id', $id);
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            $data_user =  json_decode(json_encode($query->row()), true);
            $data_user['stops'] = implode(", ", unserialize($data_user['stops']));
            return $data_user;
        } else {
            return false;
        }
    }
    
    public function driverDisabled($data, $id) {
        $this->db->where('id', $id);
        $this->db->update('driver', $data);
        //echo $this->db->last_query(); die;
        if ($this->db->affected_rows()) {
            return true;
        } else {
            return false;
        }
    }
    
     public function getAllSectionClass($schoolid){
        $this->db->select("c.*");
        $this->db->from("class c");
        $this->db->where("c.status",1);
        $this->db->where("c.schoolId",$schoolid);
        $query = $this->db->get();
        //echo $this->db->last_query(); exit;
        if($query->num_rows() >0)
        {
            return $query->result_array();
        }
        else
        {
            return false;
        }
    }
    
    public function getAllStudents($schoolid,$classSection){
        $this->db->select("ch.*");
        $this->db->from("child ch");
        $this->db->where("ch.status",1);
        $this->db->where("ch.schoolId",$schoolid);
        $this->db->where("ch.childclass",$classSection);
        $query = $this->db->get();
        //echo $this->db->last_query(); exit;
        if($query->num_rows() >0)
        {
            return $query->result_array();
        }
        else
        {
            return false;
        }
    }
    
    public function getStudents($conArray)
    {
      if(isset($conArray['schoolid']) &&  $conArray['schoolid']!="" && isset($conArray['driver']) &&  $conArray['driver']!="")
      {
        $this->db->select("dsa.*");
        $this->db->from("driver_student_assignment as dsa");
        $this->db->where("dsa.schoolid",$conArray['schoolid']);
        $this->db->where("dsa.driverid",$conArray['driver']);
        $this->db->where("dsa.classid",$conArray['classSection']);
       
        $query = $this->db->get();
        //echo $this->db->last_query(); exit;
        if($query->num_rows() >0)
        {
            return $query->result_array();
        }
        else
        {
            return array();
        }
      }
    }
    
     public function assignStudents($data) {
        $this->db->insert('driver_student_assignment', $data);
        $id = $this->db->insert_id();
        return $id;
    }
    
    public function getDriverAssignList($schoolid,$driver){
        $this->db->select('
         dsa.id as id,
         DATE_FORMAT(dsa.created_date, "%d %b %Y") as created,
         CONCAT(class.class, " ",class.section) as classsection,
         d.id as driverID,CONCAT(d.driverfname, " ",d.driverlname, " (",d.drivercode,")") as driver,
         c.id as student_id,
         c.childgender as childgender,
         c.childdob as childdob,
         c.childemail as childemail,
         CONCAT(c.childfname, " ",c.childmname, " ", c.childlname," (",c.childRegisterId,")") as student,
         c.childphoto as childphoto, 
         r.route_title as routeTitle,CONCAT(r.route_start," To ",r.route_end) AS routepath,
         r.stops as stops,
         v.vehicle_name as vehicle_name,
         v.vcode as vcode');
        $this->db->from("driver_student_assignment as  dsa");
        $this->db->join('driver as d', 'd.id = dsa.driverid');
        $this->db->join('child as c', 'c.id = dsa.studentid');
        $this->db->join('class as class', 'class.id = c.childclass');
        $this->db->join('vehicle as v', 'v.id = d.drivervehicle');
        $this->db->join('route as r', 'r.id = v.route');
        $this->db->where("dsa.schoolId",$schoolid);
        $this->db->where("dsa.driverid",$driver);
        $this->db->order_by("dsa.id", "desc");
        $query = $this->db->get();
        //echo $this->db->last_query(); exit;
       if ($query->num_rows() > 0) {
            $data_user =  $query->result_array();
            foreach ($data_user as $key => $value){
            $data_user[$key]['routeStops'] =  unserialize($value['stops']); 
            $data_user[$key]['vehicleWithCode'] =  $value['vehicle_name'] .' ('.$value['vcode'].')';
            }
            return $data_user;
        } else {
            return false;
        }       
    }
    
     public function routeUsed($RouteID,$schoolid){
        $this->db->select('CONCAT(v.vehicle_name,"(",v.vcode,")") as usedvehicle');
        $this->db->from("route as  r");
        $this->db->join('vehicle as v', 'v.route = r.id');
        $this->db->where("r.schoolId",$schoolid);
        $this->db->where("r.id",$RouteID);
        $query = $this->db->get();
        //echo $this->db->last_query(); exit;
        if($query->num_rows() >0)
        {
            return $query->result_array();
        }
        else
        {
            return false;
        }
    }
    
    
    
     public function deleteVehicle($schoolid,$driver)
     { 
        
         $dataArray = array('id' => $driver,'schoolId'=>$schoolid);
         if($this->db->delete('vehicle',$dataArray))
         return true;
         else
         return false;    
     }
     
     public function deleteRoute($schoolid,$driver)
     { 
        
         $dataArray = array('id' => $driver,'schoolId'=>$schoolid);
         if($this->db->delete('route',$dataArray))
         return true;
         else
         return false;    
     }
     
     public function deleteAssignStudent($schoolid,$assignId)
     { 
       
         $this->db->where("schoolid",$schoolid); 
         $this->db->where("id IN (".$assignId.")",NULL, false);
         $respoonse = $this->db->delete('driver_student_assignment');
         //echo $this->db->last_query(); exit;
         if($respoonse)
         return true;
         else
         return false;    
     }
     
     public function getdriverDetail($driverid,$schoolid)
     { 
       
        $this->db->select('*');
        $this->db->from("driver as  d");
        $this->db->where("d.id",$driverid);
        $this->db->where("d.schoolId",$schoolid);
        $query = $this->db->get();
        //echo $this->db->last_query(); exit;
        if($query->num_rows() >0)
        {
            return $query->row();
        }
        else
        {
            return false;
        }  
     }
    
    
     
      public function pickStudentList($schoolID,$driverID) {
        $selectData = '';
           $selectData .= "SELECT 
             `c`.`id` as `id`, 
             `c`.`child_login_id` as `child_login_id`, 
              CONCAT(c.childfname, ' ', `c`.`childmname`, ' ', c.childlname) AS childname, 
              CONCAT(class.class, '-', class.section) as class, 
             `c`.`childRegisterId` as `childRegisterId`, 
             `c`.`childgender` as `childgender`, 
             `c`.`childphoto` as `childphoto`, 
             `c`.`childdob` as `childdob`, 
             `c`.`childemail` as `childemail`, 
             `c`.`healthdetail` as `healthdetail`, 
             `c`.`allergy` as `allergy`, 
             `c`.`childaddress` as `childaddress`, 
             `c`.`specialneed` as `specialneed`, 
             `c`.`specialneed` as `specialneed`, 
             `c`.`specialneed` as `specialneed`, 
             `c`.`specialneed` as `specialneed`, 
             `c`.`schoolId` as `schoolId`, 
             `c`.`status` as `status`,
             `p`.`fatherfname` as `fatherfname`,
             `p`.`fatherlname` as `fatherlname`,
             `p`.`fatheroccupation` as `fatheroccupation`,
             `p`.`fatheremail` as `fatheremail`,
             `p`.`fatherphone` as `fatherphone`,
             `p`.`fatheraddress` as `fatheraddress`,
             `p`.`fcity` as `fcity`,
             `p`.`fstate` as `fstate`,
             `p`.`fcountry` as `fcountry`,
             `p`.`fpincode` as `fpincode`,
             `p`.`motherfname` as `motherfname`,
             `p`.`motherlname` as `motherlname`,
             `p`.`motheremail` as `motheremail`,
             `p`.`motherphone` as `motherphone`,
             `p`.`motheraddress` as `motheraddress`,
             `p`.`emergencyfname` as `emergencyfname`,
             `p`.`emergencylname` as `emergencylname`,
             `p`.`emergencyemail` as `emergencyemail`,
             `p`.`emergencyphone` as `emergencyphone`,
             `p`.`emergencyaddress` as `emergencyaddress`,
             `p`.`ecity` as `ecity`,
             `p`.`estate` as `estate`,
             `p`.`ecountry` as `ecountry`,
             `p`.`epincode` as `epincode`
             
           FROM 
             `driver_student_assignment` as `dsa` 
             JOIN `child` as `c` ON `c`.`id` = `dsa`.`studentid` 
             LEFT JOIN `class` as `class` ON `class`.`id` = `c`.`childclass` 
             LEFT JOIN `parent` as `p` ON `p`.`id` = `c`.`parent_id`
           WHERE `dsa`.`driverid` = '".$driverID."' And `dsa`.`schoolid` = '".$schoolID."'";

           if(isset($_GET['search']) && $_GET['search']!=''){
            $selectData .= " AND (c.childfname LIKE '%".$_GET['search']."%' OR c.childlname LIKE '%".$_GET['search']."%')";
           }
          
        $query = $this->db->query($selectData);
        //echo $this->db->last_query(); exit;
        if ($query->num_rows() > 0) {
          $liststudent  =  $query->result_array();
          $newArrayList =array();
            $newArrayList = $this->getPickedStudent($schoolID,$driverID,$liststudent);
            return $newArrayList;
          }
       
        else 
        {
            return false;
        }
    }
     
     public function getPickedStudent($schoolID,$driverID,$liststudent) {
         
       $pickedArray = array();  
       $studentID = array(); 
       
        for($i=0;$i<count($liststudent);$i++) {
           $studentID[] = $liststudent[$i]['id'];
          }
        $studentIDs = implode(",", $studentID);  
       
       $selectData = "SELECT * FROM `daily_student_journey` as `dsj` 
              WHERE  dsj.pick_status = '1' And dsj.studentid IN(".$studentIDs.") And dsj.driverid = '".$driverID."' And dsj.schoolid = '".$schoolID."' And date(dsj.created_date) = '".date('Y-m-d')."'";
          
             $query = $this->db->query($selectData);
             //echo $this->db->last_query(); exit;
                if ($query->num_rows() > 0) {   
                  $pickedData =  $query->result_array();
                }
                for($j=0;$j<count($liststudent);$j++) {
               
                    if((!empty($pickedData))){
                    $compData = $this->comparePickData($pickedData,$liststudent[$j]['id']);
                    $newArray[] = array_merge($liststudent[$j],$compData);
                     }
                    else {
                    $compData['pick_status'] = 0;
                    $compData['pick_time'] = NULL;
                    $compData['journey_id'] = NULL;
                    $compData['journey_created_date'] =NULL; 
                    $newArray[] = array_merge($liststudent[$j],$compData);
                  
                }
            } 
            
             return $newArray;  
               
      }
      
   public function comparePickData($pickedData,$studentId) 
   {
     $liststudent = array();
     if((!empty($pickedData)))    
     for($k=0;$k<count($pickedData);$k++) {
     if($pickedData[$k]['studentid']==$studentId) {
     $liststudent['pick_status'] = $pickedData[$k]['pick_status'];
     $liststudent['pick_time'] = $pickedData[$k]['pick_time']; 
     $liststudent['journey_id'] = $pickedData[$k]['id']; 
     $liststudent['journey_created_date'] = $pickedData[$k]['created_date'];
     break;
     }
     }
      if(empty($liststudent)) {
      $liststudent['pick_status'] =  0;
      $liststudent['pick_time'] =  NULL;
      $liststudent['journey_id'] =  NULL;
      $liststudent['journey_created_date'] =NULL; 
      }
      return $liststudent;
      
    }   
      
    
    public function dropStudentList($schoolID,$driverID) {
           $selectData = '';
           $selectData .= "SELECT 
             `c`.`id` as `id`, 
             `c`.`child_login_id` as `child_login_id`, 
              CONCAT(c.childfname, ' ', `c`.`childmname`, ' ', c.childlname) AS childname, 
              CONCAT(class.class, '-', class.section) as class, 
             `c`.`childRegisterId` as `childRegisterId`, 
             `c`.`childgender` as `childgender`, 
             `c`.`childphoto` as `childphoto`, 
             `c`.`childdob` as `childdob`, 
             `c`.`childemail` as `childemail`, 
             `c`.`healthdetail` as `healthdetail`, 
             `c`.`allergy` as `allergy`, 
             `c`.`childaddress` as `childaddress`, 
             `c`.`specialneed` as `specialneed`, 
             `c`.`specialneed` as `specialneed`, 
             `c`.`specialneed` as `specialneed`, 
             `c`.`specialneed` as `specialneed`, 
             `c`.`schoolId` as `schoolId`, 
             `c`.`status` as `status`,
             `p`.`fatherfname` as `fatherfname`,
             `p`.`fatherlname` as `fatherlname`,
             `p`.`fatheroccupation` as `fatheroccupation`,
             `p`.`fatheremail` as `fatheremail`,
             `p`.`fatherphone` as `fatherphone`,
             `p`.`fatheraddress` as `fatheraddress`,
             `p`.`fcity` as `fcity`,
             `p`.`fstate` as `fstate`,
             `p`.`fcountry` as `fcountry`,
             `p`.`fpincode` as `fpincode`,
             `p`.`motherfname` as `motherfname`,
             `p`.`motherlname` as `motherlname`,
             `p`.`motheremail` as `motheremail`,
             `p`.`motherphone` as `motherphone`,
             `p`.`motheraddress` as `motheraddress`,
             `p`.`emergencyfname` as `emergencyfname`,
             `p`.`emergencylname` as `emergencylname`,
             `p`.`emergencyemail` as `emergencyemail`,
             `p`.`emergencyphone` as `emergencyphone`,
             `p`.`emergencyaddress` as `emergencyaddress`,
             `p`.`ecity` as `ecity`,
             `p`.`estate` as `estate`,
             `p`.`ecountry` as `ecountry`,
             `p`.`epincode` as `epincode`
             
           FROM 
             `driver_student_assignment` as `dsa` 
             JOIN `child` as `c` ON `c`.`id` = `dsa`.`studentid` 
             LEFT JOIN `class` as `class` ON `class`.`id` = `c`.`childclass` 
             LEFT JOIN `parent` as `p` ON `p`.`id` = `c`.`parent_id`
           WHERE `dsa`.`driverid` = '".$driverID."' And `dsa`.`schoolid` = '".$schoolID."'";
          if(isset($_GET['search']) && $_GET['search']!=''){
            $selectData .= " AND (c.childfname LIKE '%".$_GET['search']."%' OR c.childlname LIKE '%".$_GET['search']."%')";
           }
        $query = $this->db->query($selectData);
        //echo $this->db->last_query(); exit;
         if ($query->num_rows() > 0) {
          $liststudent  =  $query->result_array();
          $newArrayList =array();
          $newArrayList = $this->getDropStudent($schoolID,$driverID,$liststudent);
          return $newArrayList;
          }
        else {
            return false;
        }
    }
    
    public function getDropStudent($schoolID,$driverID,$liststudent) {
        
       
       $newArray = array(); 
       $studentID = array(); 
       
        for($i=0;$i<count($liststudent);$i++) {
           $studentID[] = $liststudent[$i]['id'];
          }
        $studentIDs = implode(",", $studentID);  
       
       $selectData = "SELECT * FROM `daily_student_journey` as `dsj` 
              WHERE  dsj.drop_status = '1' And dsj.studentid IN(".$studentIDs.") And dsj.driverid = '".$driverID."' And dsj.schoolid = '".$schoolID."' And date(dsj.created_date) = '".date('Y-m-d')."'";
          
             $query = $this->db->query($selectData);
             //echo $this->db->last_query(); exit;
                if ($query->num_rows() > 0) {   
                  $dropData =  $query->result_array();
                }
                for($j=0;$j<count($liststudent);$j++) {
               
                    if((!empty($dropData))){
                    $compData = $this->compareDropData($dropData,$liststudent[$j]['id']);
                    $newArray[] = array_merge($liststudent[$j],$compData);
                     }
                    else {
                    $compData['drop_status'] = 0;
                    $compData['drop_time'] = NULL;
                    $compData['journey_id'] = NULL;
                    $compData['journey_created_date'] =NULL; 
                    $newArray[] = array_merge($liststudent[$j],$compData);
                  
                }
            } 
            
             return $newArray;  
      }
      
      
    public function compareDropData($pickedData,$studentId) {
     $liststudent = array();
     if((!empty($pickedData)))    
     for($k=0;$k<count($pickedData);$k++) {
     if($pickedData[$k]['studentid']==$studentId) {
     $liststudent['drop_status'] = $pickedData[$k]['drop_status'];
     $liststudent['drop_time'] = $pickedData[$k]['drop_time']; 
     $liststudent['journey_id'] = $pickedData[$k]['id']; 
     $liststudent['journey_created_date'] = $pickedData[$k]['created_date'];
     break;
     }
     }
      if(empty($liststudent)) {
      $liststudent['drop_status'] =  0;
      $liststudent['drop_time'] =  NULL;
      $liststudent['journey_id'] =  NULL;
      $liststudent['journey_created_date'] =NULL; 
      }
      return $liststudent;
      
    }  
    
     public function checkDriverEntry($schoolID,$driverID,$currentDate) {
        $this->db->select('*');
        $this->db->from('daily_driver_journey as ddj');
        $this->db->where('ddj.driverId', $driverID);
        $this->db->where('ddj.schoolid', $schoolID);
        $this->db->where('date(ddj.created_date)', $currentDate);
        $query = $this->db->get();
        
        if ($query->num_rows() > 0) {
            return $query->row();
        } else {
            return false;
        }
     }
     
     public function makeDriverEntry($data) {
        $this->db->insert('daily_driver_journey', $data);
        $id = $this->db->insert_id();
        return $id; 
     }
     
      public function startJourney($data,$journeyID) {
        
       if ($journeyID != '' && (!empty($data))) {
        $this->db->where('id', $journeyID);
        $this->db->update('daily_driver_journey', $data);
        return true;
        }
        else {
           return false; 
        }
     }
     
     public function endJourney($data,$journeyID) {
        
       if ($journeyID != '' && (!empty($data))) {
        $this->db->where('id', $journeyID);
        $this->db->update('daily_driver_journey', $data);
        return true;
        }
        else {
           return false; 
        }
     }
     
     
     
     
    
     public function checkStartJourneySession($driverID,$schoolID,$journey_start_type) {
       
       $this->db->select('*');
        $this->db->from('daily_driver_journey as ddj');
        $this->db->where('ddj.driverId', $driverID);
         $this->db->where('ddj.schoolid', $schoolID);
        
        if($journey_start_type =="morning") {
        $this->db->where('ddj.morning_start_status', '1');  
        }
        if($journey_start_type =="afternoon") {
        $this->db->where('ddj.afternoon_start_status', '1');
        } 
        $this->db->where('date(ddj.created_date)', date('Y-m-d'));
        $query = $this->db->get();
        //echo $this->db->last_query();exit;
        if ($query->num_rows() > 0) {
            return $query->result();
        } else {
            return false;
        }
     }
     
     public function checkEndJourneySession($driverID,$schoolID,$journey_start_type) {
       
       $this->db->select('*');
        $this->db->from('daily_driver_journey as ddj');
        $this->db->where('ddj.driverId', $driverID);
         $this->db->where('ddj.schoolid', $schoolID);
        
        if($journey_start_type =="morning") {
        $this->db->where('ddj.morning_end_status', '1');  
        }
        if($journey_start_type =="afternoon") {
        $this->db->where('ddj.afternoon_end_status', '1');
        } 
        $this->db->where('date(ddj.created_date)', date('Y-m-d'));
        $query = $this->db->get();
        //echo $this->db->last_query();exit;
        if ($query->num_rows() > 0) {
            return $query->result();
        } else {
            return false;
        }
     }
     
     
     public function startJourneyStatus($journeyID,$journeyType) {
       
       $this->db->select('*');
        $this->db->from('daily_driver_journey as ddj');
        $this->db->where('ddj.id', $journeyID);
        
        if($journeyType =="morning") {
        $this->db->where('ddj.morning_start_status', '1');  
        }
        if($journeyType =="afternoon") {
        $this->db->where('ddj.afternoon_start_status', '1');
        } 
        $this->db->where('date(ddj.created_date)', date('Y-m-d'));
        $query = $this->db->get();
        //echo $this->db->last_query();exit;
        if ($query->num_rows() > 0) {
            return $query->result();
        } else {
            return false;
        }
     }
     
      public function endJourneyStatus($journeyID,$journeyType) {
        
       $this->db->select('*');
        $this->db->from('daily_driver_journey as ddj');
        $this->db->where('ddj.id', $journeyID);
        $this->db->where('date(ddj.created_date)', date('Y-m-d'));
        if($journeyType =="morning") {
        $this->db->where('ddj.morning_end_status', '1');  
        }
        if($journeyType =="afternoon") {
        $this->db->where('ddj.afternoon_end_status', '1');
        } 
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result();
        } else {
            return false;
        }
     }
     
     
     public function checkStudentjourney($schoolID,$driverID,$studentID) {
        
        $this->db->select('*');
        $this->db->from('daily_student_journey as dsj');
        $this->db->where('dsj.driverId', $driverID);
        $this->db->where('dsj.schoolid', $schoolID);
        $this->db->where('dsj.studentid', $studentID);
        $this->db->where('date(dsj.created_date)', date('Y-m-d'));
        
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->row();
        } else {
            return false;
        }
     }
     
     public function checkPickDropEntry($schoolID,$driverID,$studentID,$session) {
        
        $this->db->select('*');
        $this->db->from('daily_student_journey as dsj');
        $this->db->where('dsj.driverId', $driverID);
        $this->db->where('dsj.schoolid', $schoolID);
        $this->db->where('dsj.studentid', $studentID);
        if($session == 'pick')
        $this->db->where('dsj.pick_status', '1');
        
        if($session == 'drop')
        $this->db->where('dsj.drop_status', '1');
        
        $this->db->where('date(dsj.created_date)', date('Y-m-d'));
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->row();
        } else {
            return false;
        }
     }
     
     public function addPick($data,$id) {
         $this->db->where('id', $id );
         $this->db->update('daily_student_journey', $data);
         return true;
     }
     public function addDrop($data,$id) {
         $this->db->where('id', $id );
         $this->db->update('daily_student_journey', $data);
         return true;
     }
     
     public function makeStudentJourney($data) {
        $this->db->insert('daily_student_journey', $data);
        $id = $this->db->insert_id();
        return $id; 
     }
     
      public function makeDriverLog($schoolID,$journeyID,$driverID,$session) {
       
        $this->db->select('*');
        $this->db->from('daily_vehicle_log as dvl');
        $this->db->where('dvl.journeyid', $journeyID);
        $this->db->where('dvl.schoolid', $schoolID);
        $this->db->where('dvl.batch_timing', $session);
        $this->db->where('date(dvl.created_date)', date('Y-m-d'));
        $query = $this->db->get();
        if ($query->num_rows() == 0) 
        { 
            $driverDetail = "";   
            $getDriverData = $this->allDriverData($driverID,$session); 
            if($getDriverData) 
            $driverDetail = serialize($getDriverData);
         
         
            $logData = array(
            'schoolid' =>$schoolID,
            'journeyid' => $journeyID,
            'driverid' => $driverID,    
            'driver_details' =>$driverDetail,
            'batch_timing' =>$session,
            'created_date' => date('Y-m-d H:i:s')
            );   
            $driverLog = $this->addDriverLog($logData);  
            return true;
        }
        else {
          return true;  
        }
      }
     
       public function addDriverLog($data) {
        $this->db->insert('daily_vehicle_log', $data);
        $id = $this->db->insert_id();
        return $id; 
     }
     
    
      public function allDriverData($driverid,$session) {
       $this->db->select(
      'd.id as driverid,        
       d.drivercode as drivercode,
       d.driverfname as driverfname,
       d.driverlname as driverlname,
       d.driveremail as driveremail,
       d.driverphone as driverphone,
       d.driveraddress as driveraddress,
       d.dcity as dcity,
       d.dstate as dstate,
       d.dcountry as dcountry,
       d.dpincode as dpincode,
       d.driverphoto as driverphoto,
       d.driverlicense as driverlicense,
       d.driverLicenseExpire as driverLicenseExpire,
       d.schoolId as schoolId,
       v.vcode as vcode,
       v.vehicle_number as vehicle_number,
       v.plate_number as vehicle_plate_number,
       v.vehicle_brand as vehicle_brand,
       v.photo as vehicle_photo,
       v.vehicle_type as vehicle_type,
       v.model as vehicle_model,
       v.colour as vehicle_colour,
       r.route_title as route_title,
       r.route_code as route_code,
       CONCAT(r.route_start," To ",r.route_end) AS routepath,
       r.stops as enc_stops,
       r.lat_long as enc_latlong
       ');
       $this->db->from('driver as d');
       $this->db->join('vehicle as v', ' v.id = d.drivervehicle','left');
       $this->db->join('route as r', ' r.id = v.route','left');
       $this->db->join('school as school ', ' school.id = d.schoolId');
       $this->db->where("(d.id = '$driverid')");
       $query = $this->db->get(); 
        if ($query->num_rows() > 0){ 
            $data_user = $query->row();
             $data_user->stopDetails = $this->getStopsStatusBySession($data_user->schoolId,$driverid,$session);
            unset($data_user->enc_stops); 
            unset($data_user->enc_latlong);
            return $data_user;
      }
      }
      
      
      public function getStopsStatusBySession($schoolid,$driverid,$session) 
      {
        $stopsData = array();
        $this->db->from('journey_status');
        $this->db->where("((schoolid = '".$schoolid."' And  driverid = '".$driverid."' And date(created_date) = '".date('Y-m-d')."'))");
        $this->db->where('schoolid', $schoolid);
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            $data_user =  $query->result_array(); 
            
                if($session =="pick")
                $checkSession = "morning";
                if($session =="drop")
                $checkSession = "afternoon";
                
                 $k=0;
                 for($i=0;$i<count($data_user);$i++){
                    if($data_user[$i]['session']==$checkSession){ 
                     $stopsData[$k]['id'] = $data_user[$i]['id'];
                     $stopsData[$k]['stop_title'] = $data_user[$i]['stop_title'];
                     $stopsData[$k]['stop_latitude'] = $data_user[$i]['stop_latitude'];
                     $stopsData[$k]['stop_longitude'] = $data_user[$i]['stop_longitude'];
                     $stopsData[$k]['status'] = $data_user[$i]['status'];
                     $stopsData[$k]['status_time'] = $data_user[$i]['status_time'];
                     $stopsData[$k]['session'] = $data_user[$i]['session'];
                     $k++;
                    }
                 }
             
             return $stopsData;
        }
        else {
            return (object) $stopsData;
        }
    }
      
      
      public function checkDriverJourneyStartStatus($driverID,$schoolID,$journeyType) {
       
       $this->db->select('*');
        $this->db->from('daily_driver_journey as ddj');
        $this->db->where('ddj.driverId', $driverID);
        $this->db->where('ddj.schoolid', $schoolID);
        
        if($journeyType =="morning") {
        $this->db->where('ddj.morning_start_status', '1');  
        }
        if($journeyType =="afternoon") {
        $this->db->where('ddj.afternoon_start_status', '1');
        } 
        $this->db->where('date(ddj.created_date)', date('Y-m-d'));
        $query = $this->db->get();
        //echo $this->db->last_query();exit;
        if ($query->num_rows() > 0) {
            return $query->result();
        } else {
            return false;
        }
     }
     
     
     
     
     public function pickdropStudentList($schoolID,$driverID, $date = NULL ) {
       
          if($date!="" || $date!=NULL)
           $dbdate = date('Y-m-d');
          else 
           $dbdate = date('Y-m-d');   
              
           $selectData = "SELECT 
             `c`.`id` as `id`, 
             `c`.`child_login_id` as `child_login_id`, 
              CONCAT(c.childfname, ' ', `c`.`childmname`, ' ', c.childlname) AS childname, 
              CONCAT(class.class, '-', class.section) as class, 
             `c`.`childRegisterId` as `childRegisterId`, 
             `c`.`childdob` as `childdob`, 
             `c`.`childgender` as `childgender`, 
             `c`.`childphoto` as `childphoto`, 
             `c`.`parent_id` as `parent_id`, 
             `c`.`schoolId` as `schoolId`, 
             `c`.`status` as `status`, 
             `dsj`.`pick_status` as `pick_status`, 
             `dsj`.`pick_time` as `pick_time`, 
             `dsj`.`drop_status` as `drop_status`, 
             `dsj`.`drop_time` as `drop_time`, 
             `dsj`.`id` as `journey_id`,
             `dsj`.`created_date` as `journey_created_date` 
           FROM 
             `driver_student_assignment` as `dsa` 
             JOIN `child` as `c` ON `c`.`id` = `dsa`.`studentid` 
             LEFT JOIN `class` as `class` ON `class`.`id` = `c`.`childclass` 
             LEFT JOIN `daily_student_journey` as `dsj` ON (dsj.studentid = c.id And dsj.driverid = '".$driverID."' And dsj.schoolid = '".$schoolID."' And date(dsj.created_date) = '".$dbdate."')
           WHERE `dsa`.`driverid` = '".$driverID."'";
          
        $query = $this->db->query($selectData);
        //echo $this->db->last_query(); exit;
        if ($query->num_rows() > 0) {
            return $query->result();
        } else {
            return false;
        }
    }
     
     
     public function get_pick_journey($paramdata) 
     {
         
        $schoolID = isset($paramdata['schoolID']) ? $paramdata['schoolID'] : "";
        $driverID = isset($paramdata['driverID']) ? $paramdata['driverID'] : "";
        $date = isset($paramdata['date']) ? date('Y-m-d', strtotime($paramdata['date'])) : "";
        if($schoolID!="" && $driverID!="" && $date!="")
        {
          
        $this->db->select('
         `c`.`child_login_id` as `child_login_id`, 
         CONCAT(c.childfname, " ", `c`.`childmname`, " ", c.childlname) AS childname, 
         CONCAT(class.class, "-", class.section) as class,
         CONCAT(d.driverfname, " ",d.driverlname, " (",d.drivercode,")") as driver,
         dsj.id  as journey_id,
         dsj.pick_status as pick_status,
         dsj.pick_time as pick_time,     
         ');
        $this->db->from('daily_student_journey as dsj');
        $this->db->join('child as c', 'c.id = dsj.studentid','LEFT'); 
        $this->db->join('class as class', 'class.id = c.childclass','LEFT');
        $this->db->join('daily_vehicle_log as dvl', 'd.id = dsj.driverid','LEFT');
         $this->db->join('driver as d', 'd.id = dsj.driverid','LEFT');
        $this->db->where('dsj.pick_status', '1');
        $this->db->where('dsj.driverId', $driverID);
        $this->db->where('dsj.schoolid', $schoolID);
        $this->db->where('date(dsj.created_date)', $date);
        $query = $this->db->get();
        //echo $this->db->last_query();exit;
        if ($query->num_rows() > 0) {
            return $query->result();
        } else {
            return false;
        }
        }
        else {
           return false; 
        }
         
     } 
     
     
     public function get_drop_journey($paramdata) 
     {
         
        $schoolID = isset($paramdata['schoolID']) ? $paramdata['schoolID'] : "";
        $driverID = isset($paramdata['driverID']) ? $paramdata['driverID'] : "";
        $date = isset($paramdata['date']) ? date('Y-m-d', strtotime($paramdata['date'])) : "";
        if($schoolID!="" && $driverID!="" && $date!="")
        {
          
        $this->db->select('
         `c`.`child_login_id` as `child_login_id`, 
         CONCAT(c.childfname, " ", `c`.`childmname`, " ", c.childlname) AS childname, 
         CONCAT(class.class, "-", class.section) as class,
         CONCAT(d.driverfname, " ",d.driverlname, " (",d.drivercode,")") as driver,
         dsj.id  as journey_id,
         dsj.drop_status as drop_status,
         dsj.drop_time as drop_time,     
         ');
        $this->db->from('daily_student_journey as dsj');
        $this->db->join('child as c', 'c.id = dsj.studentid','LEFT'); 
        $this->db->join('class as class', 'class.id = c.childclass','LEFT');
        $this->db->join('driver as d', 'd.id = dsj.driverid','LEFT');
        $this->db->where('dsj.drop_status', '1');
        $this->db->where('dsj.driverId', $driverID);
        $this->db->where('dsj.schoolid', $schoolID);
        $this->db->where('date(dsj.created_date)', $date);
        $query = $this->db->get();
        //echo $this->db->last_query();exit;
        if ($query->num_rows() > 0) {
            return $query->result();
        } else {
            return false;
        }
        }
        else {
           return false; 
        }
         
     } 
     
     
     public function get_all_journey($paramdata) 
     {
         
        $schoolID = isset($paramdata['schoolID']) ? $paramdata['schoolID'] : "";
        $driverID = isset($paramdata['driverID']) ? $paramdata['driverID'] : "";
        $date = isset($paramdata['date']) ? date('Y-m-d', strtotime($paramdata['date'])) : "";
        if($schoolID!="" && $driverID!="" && $date!="")
        {
          
        $this->db->select('
         `c`.`child_login_id` as `child_login_id`, 
         CONCAT(c.childfname, " ", `c`.`childmname`, " ", c.childlname) AS childname, 
         CONCAT(class.class, "-", class.section) as class,
         CONCAT(d.driverfname, " ",d.driverlname, " (",d.drivercode,")") as driver,
         dsj.id  as journey_id,
         dsj.pick_status as pick_status,
         dsj.pick_time as pick_time, 
         dsj.drop_status as drop_status,
         dsj.drop_time as drop_time,     
         ');
        $this->db->from('daily_student_journey as dsj');
        $this->db->join('child as c', 'c.id = dsj.studentid','LEFT'); 
        $this->db->join('class as class', 'class.id = c.childclass','LEFT');
        $this->db->join('driver as d', 'd.id = dsj.driverid','LEFT');
        $this->db->where('dsj.driverId', $driverID);
        $this->db->where('dsj.schoolid', $schoolID);
        $this->db->where('date(dsj.created_date)', $date);
        $query = $this->db->get();
        //echo $this->db->last_query();exit;
        if ($query->num_rows() > 0) {
            return $query->result();
        } else {
            return false;
        }
        }
        else {
           return false; 
        }
         
     }
     
     
     
     public function get_driver_log($journeyID,$journeyType) 
     {
        if($journeyID!="")
        {
        $this->db->select('*');
        $this->db->from('daily_vehicle_log as vhl');
        $this->db->where('vhl.journeyid', $journeyID);
        $this->db->where('vhl.batch_timing', $journeyType);
        $query = $this->db->get();
        //echo $this->db->last_query();exit;
        if ($query->num_rows() > 0) {
         $rowData  = $query->row();
         $driver_details = unserialize($rowData->driver_details);
         unset($rowData->driver_details);
         $rowData->driver_details = $driver_details;
         return $rowData;
        } 
        else {
         return false;
        }
        }
        else {
           return false; 
        }
         
     }
     
     
     
    public function saveCurrentLog($data) {
        $this->db->insert('latlong_log', $data);
        $id = $this->db->insert_id();
        return $id;
    }
    
    public function removeStopsDetail($schoolID,$driverID) {
       $deleteArray = array('driverid' => $driverID,'schoolid'=>$schoolID,'date(created_date)'=>date('Y-m-d'));
       $this->db->delete('journey_status',$deleteArray);
    }
    
    
    
    public function isPrevAssigned($studetntData)
    {
     $string = array();
     $dataArray = array(); 
       
         $query = "SELECT 
                  d.id as id,
                  CONCAT(d.driverfname, ' ',d.driverlname, ' (',d.drivercode,')') as driver, 
                  CONCAT(c.childfname, ' ',c.childmname, ' ', c.childlname,' (',c.childRegisterId,')') as student 
                  FROM driver_student_assignment as dsa 
                  LEFT join driver as d on d.id = dsa.driverid
                  LEFT join child as c on c.id = dsa.studentid 
                  WHERE  dsa.schoolid ='".$studetntData['schoolid']."' And  dsa.studentid IN(".implode(',',$studetntData['students']).")";
       
        
        $query = $this->db->query($query);
        ///echo $this->db->last_query();exit;
        $dbData = array();
        if ($query->num_rows() > 0) {
          $dbData  = $query->result_array();
          $dataArray['count'] = 1; 
        } else {
           $dataArray['count'] = 0; 
           $dataArray['assignList'] = "";
        }
       
        if(count($dbData)>0){
         for($i=0;$i<count($dbData);$i++) {
             $string[$i]['assigned'] = 'Warning : '.$dbData[$i]['student']. " All ready assigned To " . $dbData[$i]['driver'];
            }
            $dataArray['assignList'] = $string;
          }
        
       return $dataArray;
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
