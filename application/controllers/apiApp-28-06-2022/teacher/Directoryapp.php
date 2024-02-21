<?php

defined('BASEPATH') OR exit('No direct script access allowed');
require APPPATH . '/libraries/REST_Controller.php';

class Directoryapp extends REST_Controller {

    public $error = array();
    public $data = array();

    function __construct() {
        parent::__construct();
        $this->token->validate();
        $this->load->library("security");
        $this->load->library('form_validation');
        $this->load->model('teacherapp_model', 'teacherapp');
        $this->load->helper('common_helper');
    }

    public function attendance_post() {

        $postData = json_decode(file_get_contents('php://input'), true);
        if ($postData == '') {
            $postData = $_POST;
        }

        $postData = $this->security->xss_clean($postData);

        $schoolId = $this->token->school_id;
        $teacherId = $this->token->user_id;
        $classId = $postData['classId'];
        $onDate = $postData['onDate'];

        if (empty($classId) || empty($onDate)) {
            $return['success'] = "false";
            $return['title'] = "error";
            $return['message'] = "Please select Class and Date";
            $this->response($return, REST_Controller::HTTP_BAD_REQUEST);
        } else {
            $onDate = date('Y-m-d', strtotime($onDate));
            $expDate = explode('-', $onDate);
            $month = $expDate[1];
            $year = $expDate[0];
            $allStudents = $this->getAllStudents($schoolId, $classId);
            $monthDetails = getHolidaysWithName($month,$year,$schoolId);
            $attendance = $this->getAttendance($onDate, $schoolId,$classId);
            
            //echo '<pre>';
            //print_r($allStudents);
            //exit;

            $present = 0;
            $absent = 0;
            $holidayArray = array();
            $studentsArray = array();
            $attendanceArray = array();

            for ($i = 0; $i < count($monthDetails); $i++) {
                if ($monthDetails[$i]['for_date'] == $onDate) {
                    $holidayArray['holiday_title'] = $monthDetails[$i]['title'];
                    $holidayArray['holiday_date'] = $monthDetails[$i]['for_date'];
                    break;
                }
            }

            if(!empty($holidayArray)){
             $return['success'] = "success";
             $return['message'] = "Students Attendance List.";
             $return['holiday'] = "holiday";
             $return['holiday_data'] =  $holidayArray;
             $return['student_list'] = [];
             $return['error'] = $this->error;
             $this->response($return, REST_Controller::HTTP_OK);
                
            } 
            
            //echo '<pre>';
            //print_r($attendance);
            //exit;
            
            for ($i = 0; $i < count($allStudents); $i++) {
                $studentsArray[$i]['childId'] = $allStudents[$i]['id'];
                $studentsArray[$i]['childclass'] = $allStudents[$i]['childclass'];
                $studentsArray[$i]['childfname'] = $allStudents[$i]['childfname'];
                $studentsArray[$i]['childmname'] = $allStudents[$i]['childmname'];
                $studentsArray[$i]['childlname'] = $allStudents[$i]['childlname'];
                $studentsArray[$i]['childRegisterId'] = $allStudents[$i]['childRegisterId'];
                $studentsArray[$i]['childgender'] = $allStudents[$i]['childgender'];
                $studentsArray[$i]['childphoto'] = $allStudents[$i]['childphoto'];
                $studentsArray[$i]['parent_id'] = $allStudents[$i]['parent_id'];
                $studentsArray[$i]['schoolId'] = $allStudents[$i]['schoolId'];
                $studentsArray[$i]['status'] = $allStudents[$i]['status'];
                $studentsArray[$i]['attendence_date'] = $onDate;
                if (empty($holidayArray)) {
                     if((!empty($attendance)) &&  $this->getMatchUser($attendance,$allStudents[$i]['id'])){
                    //if ((!empty($attendance)) && (array_search($allStudents[$i]['id'], array_column($attendance, 'student_id')))) {
                        //echo "A";die;
                        $studentsArray[$i]['attendence_status'] = 'P';
                        $present++;
                    } else {
                        //echo "B";die;
                        $studentsArray[$i]['attendence_status'] = 'A';
                        $absent++;
                    }
                    
                    
                } 
            }


            if (!empty($studentsArray)) {
                $return['success'] = "success";
                $return['message'] = "Students Attendance List.";
                $return['holiday'] = "none";
                $return['holiday_data'] = (object) $holidayArray;
                $return['total_student'] = count($studentsArray);
                $return['total_absent'] = $absent;
                $return['total_present'] = $present;
                $return['student_list'] = $studentsArray;
                $return['error'] = $this->error;
                $this->response($return, REST_Controller::HTTP_OK);
            } else {
                $return['success'] = "true";
                $return['title'] = "success";
                $return['message'] = "No data Found on current class and date";
                $this->response($return, REST_Controller::HTTP_BAD_REQUEST);
            }
        }
    }

    public function getMatchUser($childArray,$value) {
        
        for($i=0;$i<count($childArray);$i++){
            if(isset($childArray[$i]['student_id'])  && ($childArray[$i]['student_id']==$value)){
                return true;
                break;
            }
            
        }
    }
    
    
    public function getAttendance($date, $schoolId,$classId) {
       $this->db->select(
      'sat.student_id as student_id,
       sat.class_id as class_id,
       sat.teacher_id as teacher_id, 
       sat.school_id as school_id, 
       sat.date as att_date, 
       sat.class_id as class_id, 
       sat.check_in as check_in,
       sat.check_out as check_out,
       sat.check_in as check_in');
        $this->db->from('student_attendance as sat');
        $this->db->where('sat.school_id', $schoolId);
        $this->db->where('sat.date', $date);
        $this->db->where('sat.class_id', $classId);
        $this->db->where("((sat.check_in = 'true'  OR sat.check_in = '1')) ");
        $query = $this->db->get();
        //echo $this->db->last_query() ;
        //exit;

        if ($query->num_rows() > 0) {
            return $query->result_array();
        } else {
            return false;
        }
    }

    public function getAllStudents($school_id, $class_id) {
        $session_id= get_current_session($school_id)->id;
        $this->db->from('child as child');
        $this->db->where("(child.schoolId = '$school_id')");
        $this->db->where("(child.childclass = '$class_id')");
        $this->db->where("(child.class_session_id = '$session_id')");
        $this->db->where("(child.status = '1')");
        $query = $this->db->get();


        if ($query->num_rows() > 0) {
            return $query->result_array();
        } else {
            return false;
        }
    }

    public function getStudentDetail_get($studentid='') {
        
      if (empty($studentid)) {
      $return['success'] = "false";
      $return['title'] = "error";
      $return['message'] = "student id not found";
      $this->response($return, REST_Controller::HTTP_BAD_REQUEST);
      exit;
      }
          
        
      $this->db->select(
      'child.*,
       parent.id as parent_id,
       parent.fatherfname as fatherfname,
       parent.fatherlname as fatherlname, 
       parent.fatheroccupation as fatheroccupation, 
       parent.fatheremail as fatheremail, 
       parent.fatherphone as fatherphone,
       parent.fatheraddress as fatheraddress, 
       parent.fcity as fcity,
       parent.fstate as fstate,
       parent.fcountry as fcountry,
       parent.fpincode as fpincode,
       parent.motherfname as motherfname,
       parent.motherlname as motherlname,
       parent.motheroccupation as motheroccupation,
       parent.motheremail as motheremail,
       parent.motherphone as motherphone,
       parent.emergencyfname as emergencyfname,
       parent.emergencylname as emergencylname,
       parent.emergencyemail as emergencyemail,
       parent.emergencyphone as emergencyphone,
       parent.emergencyaddress as emergencyaddress');  
       $this->db->from('child as child');
       $this->db->join('parent','parent.id = child.parent_id');
       $this->db->where("(child.id = '$studentid')");
       $this->db->where("(child.status = '1')");
       $query = $this->db->get();
       if ($query->num_rows() ==1 ) 
       {
        $return['success'] = "success";
        $return['message'] = "Students Found.";
        $return['data'] = $query->row();
        $return['error'] = $this->error;
        $this->response($return, REST_Controller::HTTP_OK);   
        } 
        else 
        {
            $return['success'] = "false";
            $return['title'] = "error";
            $return['message'] = "No Data Found";
            $this->response($return, REST_Controller::HTTP_BAD_REQUEST);
        }
    }

}

?>