<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Attendance_model extends CI_Model {
    
    public function getClassStudents($class_id)
    {
        $this->db->order_by("c.id",'DESC');
        $this->db->select('c.id as child_id,CONCAT(c.childfname," ",c.childmname," ",c.childlname) as child');
        $this->db->from('child c');
        $this->db->join('sessions si','c.class_session_id = si.id','left');
        $this->db->where(array('si.current_sesion'=>1));
        $this->db->where(['c.childclass'=>$class_id,'c.status'=>1]);
        $query = $this->db->get();
        if($query->num_rows() > 0)
        {
            return $query->result_array();
        }else{
            return array();
        }
    }
   
    public function getAllStudentsAttendance($postData)
    {
        $school_id  = $postData['id'];
        $class_id   = !empty($postData['class_id']) ? $postData['class_id'] : '';
        $month      = !empty($postData['month']) ? $postData['month'] : date('m');
        $year       = !empty($postData['year']) ? $postData['year'] : date('Y');
  // prd($getMonthData['selected_monthDays']);
        // All active students list
        $students = getAllStudents($school_id,$class_id);
         if(!empty($postData['month'])){
                $this->db->where(array("MONTH(sa.date)" =>$postData['month'], "YEAR(sa.date)" =>$year)); 
         }
         else{
                return "filter";
                // $startDate = date('Y-m-01');
                // $endDate = date('Y-m-t');
                // $this->db->where('sa.date >=',$startDate); 
                // $this->db->where('sa.date <=',$endDate); 
         }
        $where = array('sa.school_id'=>$school_id,'sa.check_in'=>"true");
        $this->db->select('sa.student_id,sa.date,sa.check_in,sa.check_out,CONCAT(c.childfname," ",c.childmname," ",c.childlname) as child');
        $this->db->from('child as c');
        $this->db->join('student_attendance as sa','sa.student_id=c.id','left');
        $this->db->join('sessions si','sa.session_id = si.id','left');
        $this->db->where(array('si.current_sesion'=>1));
        $this->db->where($where);
        $this->db->group_by('student_id');
        $this->db->group_by('date');
        $this->db->order_by('student_id','ASC');
        $query = $this->db->get();
        //echo "xzC";die;
        //echo $this->db->last_query();die;
        if($query->num_rows()>0)
        {

            $studentsAttendance = $query->result_array();
            
           
            
            
            
            
// prd($studentsAttendance);
            // Get Data all type holidays and total class days
            $daysCountTillToday =  $this->get_startDate_to_currentDate_days(); 
            $weekendDaysCountOff =  $this->getCurrentMonthWeekendOff();
             $getMonthData  = getCurrentMonthDaysDetails($month,$year,$school_id);
            
             $getMonthData['selected_monthDates'] = getSelectedMonthDates($month,$year);
             // prd($getMonthData['selected_monthDates']);
              $students = array_map(function($v) use($studentsAttendance,$getMonthData,$daysCountTillToday,$weekendDaysCountOff) {

                    $myTotalAttendance=0;
                    $totalHolidays=0;
                    $total_class_days=0;
                    $total_absent_days=0;
                    foreach($studentsAttendance as $student){
                
                        if($student['student_id'] == $v['student_id']){
                          
                           // prd($getMonthData);
                           
                          //$myTotalAttendance          = $myTotalAttendance;
                          // echo $myTotalAttendance.'-------'.$student['student_id'].'<br>';
                          $myTotalAttendance++;   
                          $total_class_days           =    ( $getMonthData['total_days'] - count($getMonthData['totalHolidays']) );     
                          // $total_absent_days          =    ( count($daysCountTillToday) - ( $myTotalAttendance + $weekendDaysCountOff ) );;
                          $total_absent_days          =    ($total_class_days - $myTotalAttendance);
                         //echo $total_class_days.'-------------'.$total_absent_days.'<br>';

                          $v['current_month_dates']   = $getMonthData['selected_monthDates'];
                          $v['total_holidays_dates']  = $getMonthData['totalHolidays'];
                          $v['get_holidays_with_name']= $getMonthData['get_holidays_with_name'];
                          $v['myTotalAttendance']     = $myTotalAttendance;
                          $v['total_class_days']      = $total_class_days;
                          $v['total_absent_days']     = $total_absent_days;
                         
                          $v['studentAttendance'][]   = $student;
                          
                        }else{
                          $total_class_days           =    ( $getMonthData['total_days'] - count($getMonthData['totalHolidays']) );     
                          $total_absent_days          =    ($total_class_days - $myTotalAttendance);
                          $v['total_class_days']      = $total_class_days;
                          $v['current_month_dates']   = $getMonthData['selected_monthDates'];
                          $v['get_holidays_with_name']= $getMonthData['get_holidays_with_name'];
                          $v['total_holidays_dates']  = $getMonthData['totalHolidays'];
                          $v['total_absent_days']     = $total_absent_days;
                        }
                    }
                    return $v;
                },$students);

               $getMonthData['selected_monthDays']  = getSelectedMonthDays($month,$year);
            // prd($getMonthData);

                $studentData = array('students'=>$students, 'monthData' => $getMonthData);
            // prd($studentData);
                return $studentData ? $studentData : array();
        }else{
            return array();
        }
    }
    public function get_startDate_to_currentDate_days()
    {
      $days = date('d');
      $totalDays = array();
      for ($i=1; $i <= $days ; $i++) { 
       $date = ($i < 10) ? '0'.$i : $i;
         array_push($totalDays, date('Y-m-').$date);
      }
      return $totalDays ? $totalDays : 0;
    }

    public function getCurrentMonthWeekendOff()
    {
        $startDate = (string)date('Y-m-01');
        $endDate   =  (string)date('Y-m-d');
        $datetime1 = new DateTime($startDate);
        $datetime2 = new DateTime($endDate);
        $interval = $datetime1->diff($datetime2);
        $woweekends = 0;
        for($i=0; $i<=$interval->d; $i++){
            $datetime1->modify('+1 day');
            $weekday = $datetime1->format('w');

            if($weekday !== "0" && $weekday !== "6"){ // 0 for Sunday and 6 for Saturday
                $woweekends++;  
            }

        }
      return $woweekends ? $woweekends : 0;                                         
    }
    public function getAllTeachersAttendance($postData)
    {
       $school_id  = $postData['id'];
      
        
        // prd($daysCountTillToday);
        // All active Teachers list
        $allTeachers = getAllTeachers($school_id);
         if(!empty($postData['month'])){
          $month      = !empty($postData['month']) ? $postData['month'] : date('m'); 
          $year       = !empty($postData['year']) ? $postData['year'] : date('Y'); 
          $this->db->where(array("MONTH(date)" =>$month, "YEAR(date)" =>$year)); 
         }else{
              return false;
                // $startDate = date('Y-m-01');
                // $endDate = date('Y-m-t');
                // $this->db->where('date >=',$startDate); 
                // $this->db->where('date <=',$endDate); 
         }

        $where = array('school_id'=>$school_id,'checkin_time <>'=>null);
        $this->db->select('user_id,date,checkin_time,checkout_time');
        $this->db->from('teacher as t');
        $this->db->join('staff_attendance as sa','sa.user_id=t.id','left');
        $this->db->join('sessions si','sa.session_id = si.id','left');
        $this->db->where(array('si.current_sesion'=>1));
        $this->db->where($where);
        $this->db->group_by('user_id');
        $this->db->group_by('date');
        $this->db->order_by('user_id','ASC');
        $query = $this->db->get();
        // lq();
        if($query->num_rows()>0)
        {
          $teachersAttendance = $query->result_array();
            // Get current month details
            $daysCountTillToday =  $this->get_startDate_to_currentDate_days(); 
            $weekendDaysCountOff =  $this->getCurrentMonthWeekendOff();
            
            // prd($weekendDaysCountOff);

             $getMonthData  = getCurrentMonthDaysDetails($month,$year,$school_id);
             $getMonthData['selected_monthDates'] = getSelectedMonthDates($month,$year);
             // prd($getMonthData['selected_monthDates']);
              $allTeachers = array_map(function($v) use($teachersAttendance,$getMonthData,$daysCountTillToday,$weekendDaysCountOff) {

                    $myTotalAttendance=1;
                    $totalHolidays=0;
                    $total_class_days=0;
                    $total_absent_days=0;
                    $myAttendanceDates=array();
                    foreach($teachersAttendance as $teacher){

                        if($teacher['user_id'] == $v['teacher_id']){

                          $myTotalAttendance          = $myTotalAttendance;
                          // prd($myTotalAttendance);
                          $total_class_days           = ( $getMonthData['total_days'] - count($getMonthData['totalHolidays']) );     
                          // $total_absent_days          = ( $total_class_days - $myTotalAttendance);
                          $total_absent_days          = ( count($daysCountTillToday) - ( $myTotalAttendance + $weekendDaysCountOff ) );

                          $v['current_month_dates']   = $getMonthData['selected_monthDates'];
                          // $v['total_holidays_dates']  = $getMonthData['totalHolidays'];
                          $v['get_holidays_with_name']= $getMonthData['get_holidays_with_name'];
                          $v['myTotalAttendance']     = $myTotalAttendance;
                          $v['total_class_days']      = $total_class_days;
                          $v['total_absent_days']     = $total_class_days - $myTotalAttendance;
                         
                          $v['teacherAttendance'][]   = $teacher;

                         array_push($myAttendanceDates, $teacher['date']);
                         $excludeHolidaysDates = array_diff($getMonthData['selected_monthDates'], $getMonthData['totalHolidays']);


                         $teacherAbsentDates = array_diff($excludeHolidaysDates, $myAttendanceDates);
                         // pr($teacherAbsentDates);
                         // pr($myAttendanceDates);

                          $v['teacherAbsentDates']     = $teacherAbsentDates;
                         // prd($v);
                          $myTotalAttendance++;
                     
                        }else{
                       
                          $total_class_days           =    ( $getMonthData['total_days'] - count($getMonthData['totalHolidays']) );     
                          $v['total_class_days']      = $total_class_days;
                          $v['current_month_dates']   = $getMonthData['selected_monthDates'];
                          $v['get_holidays_with_name']= $getMonthData['get_holidays_with_name'];

                          array_push($myAttendanceDates, $teacher['date']);
                          $teacherAbsentDates = array_diff($getMonthData['selected_monthDates'], $getMonthData['totalHolidays']);
                          $v['teacherAbsentDates']     = $teacherAbsentDates;
                        }
                    }
                    return $v;
                },$allTeachers);
             
// prd($allTeachers);
               $getMonthData['selected_monthDays']  = getSelectedMonthDays($month,$year);
                $teacherData = array('teachers'=>$allTeachers, 'monthData' => $getMonthData);
            // prd($teacherData);
                return $teacherData ? $teacherData : array();
        }else{
            return array();
        }
    }
}