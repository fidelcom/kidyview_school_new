<?php
defined('BASEPATH') OR exit('No direct script access allowed');
require APPPATH . '/libraries/REST_Controller.php';
class Attendance extends REST_Controller {

    public $error = array();
    public $data = array();

    public function __construct() {
        parent::__construct();
        if($this->session->userdata('user_role')=='school' OR $this->session->userdata('user_role')=='schoolsubadmin'){
         $this->token->validate();
         }
         $this->load->model("admin/Attendance_model",'model');
         $this->load->model('studentAttendance_model','smodel');
         $this->load->helper('common_helper');
    }
    public function getClassStudents_post() 
    {  	 
         $postData = json_decode(file_get_contents('php://input'), true);
         if ($postData == '') {
            $postData = $_POST;
         }
         // prd($postData);
          $class_id = $postData['class_id'];
          $result = $this->model->getClassStudents($class_id);
      // prd($result);
     if($result) 
      {
            $return['success'] = "success";
            $return['message'] = "Students List.";
            $return['data'] = $result;
            $return['error'] = $this->error;
            
            $this->response($return, REST_Controller::HTTP_OK);
          
     	}else{
            $return['success'] = "false";
            $return['message'] = "No record found.";
            $return['error'] = $this->error;
            $return['data'] = '';
            
            $this->response($return, REST_Controller::HTTP_BAD_REQUEST);
         }
    }
    // public function studentManualAttendanceBySchool_post()
    // {
    //      $postData = json_decode(file_get_contents('php://input'), true);
    //      if ($postData == '') {
    //         $postData = $_POST;
    //      }

    //      $studentAttendance = array();
    //      $alreadyCheckIn = array();
    //      $i=0;
    //      foreach ($postData['multiStudents'] as $value) {

    //            $session = getSessionByClass($postData['class_id'])->academicsession;
               
    //             if(isCheckinExistDatewise($value['child_id'],$postData['attendance_date']))
    //             {
    //                 $alreadyCheckIn[$i]['child_id'] = $value['child_id'];
    //                 $result=array();
    //                 $i++;

    //             }else{
    //                 $studentAttendance[$i]['student_id']        = $value['child_id'];
    //                 $studentAttendance[$i]['class_id']          = $postData['class_id'];
    //                 $studentAttendance[$i]['check_in']          = "true";
    //                 $studentAttendance[$i]['check_out']         = "true";
    //                 $studentAttendance[$i]['checkout_type']     = "school-manual";
    //                 $studentAttendance[$i]['teacher_id']        = $postData['school_id'];
    //                 $studentAttendance[$i]['school_id']         = $postData['school_id'];
    //                 $studentAttendance[$i]['session']           = $session;
    //                 $studentAttendance[$i]['created_by']        = $postData['school_id'];
    //                 $studentAttendance[$i]['updated_by']        = $postData['school_id'];
    //                 $studentAttendance[$i]['date']              = $postData['attendance_date'];
    //                 $studentAttendance[$i]['created_at']        = date('Y-m-d H:i:s');
    //                 $studentAttendance[$i]['updated_at']        = date('Y-m-d H:i:s');
    //                 $i++;
    //             }
    //      }
    //      $result  = $this->smodel->checkinStudentAttendance($studentAttendance);
    //        if ($result || (count($alreadyCheckIn)>0)) {
    //                 $return['success'] = "true";
    //                 $return['message'] = (count($alreadyCheckIn)>0) ? "Attendance already checked-in." :"Attendance has been check-in successfully.";
    //                 $return['data'] = $result ? $result :0;
    //                 $return['already_checkin'] = $alreadyCheckIn;
    //                 $return['error'] = $this->error;

    //                 $this->response($return, REST_Controller::HTTP_OK);
    //                 } else {
    //                 $return['success'] = "false";
    //                 $return['message'] = "Not found.";
    //                 $return['error'] = $this->error;
    //                 $return['data'] = $result;

    //                 $this->response($return, REST_Controller::HTTP_BAD_REQUEST);
    //         }
    // }
    public function studentManualAttendanceBySchool_post()
    {
         $postData = json_decode(file_get_contents('php://input'), true);
         if ($postData == '') {
            $postData = $_POST;
         }
         $result = $this->smodel->studentAttendanceBySchool($postData);
         // prd($result); die;
            if ($result) {
                    $return['success'] = "true";
                    $return['message'] = "Student attendance punched successfully.";
                    $return['data'] = $result;
                    $return['error'] = $this->error;

                    $this->response($return, REST_Controller::HTTP_OK);
                    } else {

                    $attendance_date =  !empty($postData['attendance_date']) ? $postData['attendance_date'] : '';
                    $return['success'] = "false";
                    $return['message'] = "Attendance already available on this date: $attendance_date.";
                    $return['error'] = $this->error;
                    $return['data'] = $result;
                    $this->response($return, REST_Controller::HTTP_BAD_REQUEST);
            }   
    }
    public function getAllStudentsAttendance_post()
    {
         $postData = json_decode(file_get_contents('php://input'), true);
         if ($postData == '') {
            $postData = $_POST;
         }
         $result = $this->model->getAllStudentsAttendance($postData);

// prd($result);
            if($result) 
            {
                $return['success'] = "success";
                $return['message'] = "Students Attendance List.";
                $return['data'] = $result;
                $return['error'] = $this->error;
                
                $this->response($return, REST_Controller::HTTP_OK);
            
            }else{
                $getMonthData = array();
                $month                               = !empty($postData['month']) ? $postData['month'] : date('m');
                $year                                = !empty($postData['year']) ? $postData['year'] : date('Y');

                $getMonthData['selected_monthDates'] = getSelectedMonthDays($month,$year);
         // prd($selected_monthDays);
                $return['success'] = "false";
                $return['message'] = "No record found.";
                $return['error'] = $this->error;
                $return['data'] = $getMonthData;
                
                $this->response($return, REST_Controller::HTTP_BAD_REQUEST);
             }
    }
    public function getAllTeachersAttendance_post()
    {
         $postData = json_decode(file_get_contents('php://input'), true);
         if ($postData == '') {
            $postData = $_POST;
         }
         $result = $this->model->getAllTeachersAttendance($postData);

// prd($result);
            if($result) 
            {
                $return['success'] = "success";
                $return['message'] = "Teachers Attendance List.";
                $return['data'] = $result;
                $return['error'] = $this->error;
                
                $this->response($return, REST_Controller::HTTP_OK);
            
            }else{

                $getMonthData  = array();
                $month                               = !empty($postData['month']) ? $postData['month'] : date('m');
                $year                                = !empty($postData['year']) ? $postData['year'] : date('Y');
                $getMonthData['selected_monthDates'] = getSelectedMonthDays($month,$year);
// prd($getMonthData);
                $return['success'] = "false";
                $return['message'] = "No record found.";
                $return['error'] = $this->error;
                $return['data'] = $getMonthData;
                
                $this->response($return, REST_Controller::HTTP_BAD_REQUEST);
             }
    }
}
