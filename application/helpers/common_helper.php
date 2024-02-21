<?php
require APPPATH . '/libraries/crypto/autoload.php';
use Blocktrail\CryptoJSAES\CryptoJSAES;
if(!function_exists('encryptData'))
{
function encryptData($text,$pass){
    $ci = &get_instance();
    $encryptedUrl = CryptoJSAES::encrypt($text, $pass);
    if(strpos($encryptedUrl, '/') !== false){
        $encryptedUrl = encryptData($text,$pass);
    }
    return $encryptedUrl;
}
}
if(!function_exists('sendMail'))
{
function sendMail($to, $subject, $message,$from='') {
    if($from!=''){
        $from=$from;
    }else{
        $from="admin@kidyview.com";
    }
    $headers = 'MIME-Version: 1.0' . "\r\n";
    $headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
    $headers .= 'From: '.$from . "\r\n";
    return mail($to, $subject, $message, $headers);
}
}

if(!function_exists('send_email'))
{
	function send_email($mail_data)
	{
			$ci = &get_instance();
			$ci->load->library('email');
			$ci->email->set_newline("\r\n");
			$ci->email->set_mailtype("html");
			$ci->email->clear();
			$ci->email->from($mail_data['from']);
			$ci->email->to($mail_data['to']);
			//$ci->email->to('jyotappan@gmail.com');
			$ci->email->subject($mail_data['subject']);
			$ci->email->message($mail_data['message']);

			if ($ci->email->send())
			{
				return true;
		    }else {
				
				return false;
			}
	}
}

if(!function_exists('getStudentDetails'))
{
    function getStudentDetails($studentUniqid)
    {
           $where = array('status'=>1);
            $ci = &get_instance();
            $ci->load->database();
            $ci->db->select('*');
            $ci->db->where('id',$studentUniqid);
            $ci->db->or_where('child_login_id',$studentUniqid);
            $ci->db->or_where('childRegisterId',$studentUniqid);
            $ci->db->from('child');
            $query =  $ci->db->get();
            return $query->row();
    }
}
if(!function_exists('betweenDates'))
{
    function betweenDates($startDate,$endDate)
    {
            $datesArr = array();
            $dates = range(strtotime($startDate), strtotime($endDate),86400);
            foreach ($dates as $date) {
                $datesArr[] = date('Y-m-d', $date);
            }
            return $datesArr ? $datesArr : array(); 
    }
}
if(!function_exists('dayOffVerifyLeaveDate'))
{
    function dayOffVerifyLeaveDate($startDate,$endDate)
    {
            $datesArr = array();
            $dates = range(strtotime($startDate), strtotime($endDate),86400);
            foreach ($dates as $date) {
                $datesArr = date('Y-m-d', $date);
            }
            return $datesArr ? ['startDate'=>$datesArr[0] , 'endDate' =>  $datesArr[sizeof($datesArr)-1] ] : array(); 
    }
}
if(!function_exists('getStudentsDayoff'))
{
    function getStudentsDayoff($month,$year,$schoolID)
    {
            $where = array('school_id'=>$schoolID);
            $ci = &get_instance();
            $ci->load->database();
            $ci->db->select('d.student_id,CONCAT(c.childfname," ",c.childmname," ",c.childlname) as student,d.from_date,d.to_date,d.number_of_days,d.reason');
            $ci->db->where($where);
            $ci->db->where("DATE_FORMAT(from_date, '%m-%d') = DATE_FORMAT(CONCAT($month,'-',$year), '%m-%d')");
            $ci->db->from('dayoff as d');
            $ci->db->join('child as c','c.id=d.student_id','left');
            $query =  $ci->db->get();
            // lq();
            return $query->result_array();
    }
}
if(!function_exists('getTeachersDayoff'))
{
    function getTeachersDayoff($month,$year,$schoolID)
    {
            $where = array('school_id'=>$schoolID);
            $ci = &get_instance();
            $ci->load->database();
            $ci->db->select('td.teacher_id,CONCAT(t.teacherfname," ",t.teachermname," ",t.teacherlname) as student,td.from_date,td.to_date,td.number_of_days,td.reason');
            $ci->db->where($where);
            $ci->db->from('teacher_dayoff as td');
            $ci->db->join('teacher as t','t.id = td.teacher_id','left');
            $query =  $ci->db->get();
            return $query->result_array();
    }
}
if(!function_exists('getStudentClassRank'))
{
    function getStudentClassRank($student_id,$session_id='')
    {
            // $where = array('status'=>1);
        //$student = getStudentDetails($student_id);
        $where = array('child_id'=>$student_id,'session_id'=>$session_id);
        $ci = &get_instance();
        $ci->load->database();
        $ci->db->select('*');
        $ci->db->from('child_class');
        $ci->db->where($where);
        $query = $ci->db->get();
        $student=$query->row_array();
        $class_id = $student['class_id'];

            $ci = &get_instance();
            $ci->load->database();
            $sql = "SELECT id,student_id,@rank := @rank + 1 rank FROM `result`, (SELECT @rank := 0) init WHERE class_id = $class_id AND session_id=$session_id ORDER BY `result`.`overall_percent`  DESC";
            //echo $sql;
            $query =  $ci->db->query($sql);
            if($query->num_rows() > 0)
            {
                 $rankArr = $query->result_array();
                 $myRank = 0;
                foreach ($rankArr as $key => $value) {
                    
                $ci->db->select('id');
                $ci->db->from('result_term_data');
                $ci->db->where('result_id',$value['id']);
                $query = $ci->db->get();
                //echo $ci->db->last_query();
                $rows=$query->num_rows();
                /*if($rows==0){
                    return 0;
                }*/
                    $class_id = $student['class_id'];
                    if($value['student_id'] == $student_id)
                        $myRank = $value['rank'];

                    }
                    //echo $myRank;die;
                    if ($myRank == 1)
                        return '1st';
                    if ($myRank == 2)
                        return '2nd';
                    if ($myRank == 3)
                        return '3rd';
                    if ($myRank == 4)
                        return '4th';
                    if ($myRank == 5)
                        return '5th';
                    if ($myRank == 6)
                        return '6th';
                    if ($myRank == 7)
                        return '7th';
                    if ($myRank == 8)
                        return '8th';
                    if ($myRank == 9)
                        return '9th';
                    else
                        return $myRank;
                    
            }else{
                return 0;
            }
    }
}
// if(!function_exists('getCurrentMonthWeekendOff'))
// {
//     function getCurrentMonthWeekendOff()
//     {
//         $startDate =  (string)date('Y-m-01');
//         $endDate =  (string)date('Y-m-t');
       
//         $begin  = new DateTime($startDate);
//         $end    = new DateTime($endDate);
                                       
//         $totalweekendOff = [];
//         while ( $begin <= $end) // Loop will work begin to the end date 
//         {
//             if(($begin->format("D") == "Sun") || $begin->format("D") == "Sat") //Check that the day is Sunday here
//             {
//                 $totalweekendOff[] = $begin->format("Y-m-d");
//             }
//             $begin->modify('+1 day');
//         }
//         // prd($totalweekendOff);
//            return $totalweekendOff ? $totalweekendOff : false;                                         
//     }
// }
if(!function_exists('getCurrentMonthDaysDetails'))
{
    function getCurrentMonthDaysDetails($month,$year,$schoolId=null)
    {
         $total_days=cal_days_in_month(CAL_GREGORIAN, $month, $year);
     
       
            $sundays=0;
            for($i=1;$i<=$total_days;$i++)
            if(date('N',strtotime($year.'-'.$month.'-'.$i))==7)
            $sundays++;

            $holidays              = array_unique(school_monthly_holiday($month,$year));
            $sundayDates           = getCurrentMonthWeekendOff($month,$year);
            $totalHolidays         = array_unique(array_merge($sundayDates,$holidays));
            $getDates              = getSelectedMonthDates($month,$year);
            $getHolidaysWithName   = getHolidaysWithName($month,$year,$schoolId);
            // prd($getHolidaysWithName);
            
            return $dataArr = array(
                            'totalHolidays'        => $totalHolidays,
                            'total_days'           => $total_days,
                            'total_working_days'   => ($total_days - count($getHolidaysWithName)),
                            'current_month_dates'  => $getDates,
                            'get_holidays_with_name'  => $getHolidaysWithName  
                            );
    }
}
if(!function_exists('getCurrentMonthDates'))
{
    function getCurrentMonthDates()
    {
        $getAllDates = [];
        for($i=1;$i<=date('t');$i++) 
        { 
            if($i<=9)
                $day ='0'.$i;
            else
                $day = $i;
            
            $date = date('Y-m').'-'.$day;
            array_push($getAllDates, $date);
        }
        return $getAllDates ? $getAllDates : array();
    }
}

if(!function_exists('getAllStudents'))
{
    function getAllStudents($school_id,$class_id)
    {
        $ci = &get_instance();
    	if(!empty($class_id))
        {
            $ci->db->where('childclass',$class_id);
        }

            $where = array('status'=>1,'schoolId'=>$school_id);
            $ci->load->database();
            $ci->db->select('id as student_id,CONCAT(childfname," ",childmname," ",childlname) as student');
            $ci->db->where($where);
            $ci->db->from('child');
            $query =  $ci->db->get();
            return $query->result_array();
    }
}
if(!function_exists('getAllTeachers'))
{
    function getAllTeachers($school_id)
    {
        $ci = &get_instance();
        
            $where = array('status'=>1,'schoolId'=>$school_id);
            $ci->load->database();
            $ci->db->select('id as teacher_id,CONCAT(teacherfname," ",teachermname," ",teacherlname) as teacher');
            $ci->db->where($where);
            $ci->db->from('teacher');
            $query =  $ci->db->get();
            return $query->result_array();
    }
}
if(!function_exists('getOTPDetails'))
{
    function getOTPDetails($otp,$student_id)
    {
            $where = array('otp'=>$otp,'student_id'=>$student_id);
            $ci = &get_instance();
            $ci->load->database();
            $ci->db->select('*');
            $ci->db->from('otp_checkout');
            $ci->db->where($where);
            // $ci->db->order_by('created_on','desc');
            $query =  $ci->db->get();
            return $query->row();
    }
}
if(!function_exists('check_grades'))
{
    function check_grades($schoolID,$persentage)
    {
        //echo is_int(int($persentage));
           //echo $persentage;
           //echo filter_var($persentage, FILTER_VALIDATE_INT);
            if(is_numeric($persentage)){
                $persentage=$persentage;
            }else{
                $persentage=0;
            }
           // echo $persentage;
            //echo $persentage;die;
            //$where = array('school_id'=>$schoolID,'grade_name!='=>'','min_percent<='=>$persentage,'max_percent>='=>$persentage);
            $where = array('grade_name!='=>'','min_percent<='=>$persentage,'max_percent>='=>$persentage);
            $ci = &get_instance();
            $ci->load->database();
            $ci->db->select('grade_name');
            $ci->db->where($where);
            $ci->db->from('exam_grade_system');
            $query =  $ci->db->get();
            return $query->row('grade_name');
    }
}
if(!function_exists('getSessionByClass'))
{
    function getSessionByClass($classID)
    {
       $where = array('id'=>$classID,'status'=>1);
        $ci = &get_instance();
        $ci->load->database();
        $ci->db->select('academicsession');
        $ci->db->from('class');
        $ci->db->where($where);
        $query = $ci->db->get();
       return $data =  $query->row();
    }
}
if(!function_exists('isCheckinExist'))
{
    function isCheckinExist($studentID)
    {
    $currentDate = date('Y-m-d');
       $where = array('student_id'=>$studentID,'status'=>'1','date'=>$currentDate);
        $ci = &get_instance();
        $ci->load->database();
        $ci->db->select('id');
        $ci->db->from('student_attendance');
        $ci->db->where($where);
        $query = $ci->db->get();
        // lq();
       return $data =  $query->num_rows();
    }
}
if(!function_exists('isCheckinExistDatewise'))
{
    function isCheckinExistDatewise($studentID,$date)
    {
       $where = array('student_id'=>$studentID,'status'=>'1','date'=>$date);
        $ci = &get_instance();
        $ci->load->database();
        $ci->db->select('id');
        $ci->db->from('student_attendance');
        $ci->db->where($where);
        $query = $ci->db->get();
        // lq();
       return $data =  $query->num_rows();
    }
}
if(!function_exists('get_current_session'))
{
    function get_current_session($schoolID)
    {
       $where = array('schoolId'=>$schoolID,'status'=>1,'current_sesion'=>1);
        $ci = &get_instance();
        $ci->load->database();
        $ci->db->select('id,academicsession');
        $ci->db->from('sessions');
        $ci->db->where($where);
        $query = $ci->db->get();
        return $query->row();
    }
}
if(!function_exists('get_feeType'))
{
    function get_feeType($id,$school_id)
    {
       $where = array('id'=>$id,'status'=>'1');
        $ci = &get_instance();
        $ci->load->database();
        $ci->db->select('*');
        $ci->db->from('fee_types');
        $ci->db->where($where);
        $query = $ci->db->get();
        return $query->row_array();
    }
}

if(!function_exists('get_session_n_terms'))
{
    function get_session_n_terms($schoolID,$exam_date)
    {
        // $exam_date = '2021-04-02';
           $where = array('s.schoolId'=>$schoolID,'s.status'=>1,'s.current_sesion'=>1,'t.status'=>1);
            $ci = &get_instance();
            $ci->load->database();
            $ci->db->select('s.id as session_id,s.academicsession,t.id as term_id,t.termname,t.termstart,t.termend');
            $ci->db->from('sessions as s');
            $ci->db->join('terms as t','t.academicsession=s.id','left');
            $ci->db->where($where);
            $ci->db->group_start();
            $ci->db->where('t.termstart <=', $exam_date);
            $ci->db->where('t.termend   >=', $exam_date);
            $ci->db->group_end();
            $query =  $ci->db->get();
            // lq();
            return ( $query->row() ? $query->row() : 0 );
    }
}
if(!function_exists('examDateCheckedTerm'))
{
    function examDateCheckedTerm($schoolID,$exam_date)
    {
            // To Make date format valid
           $exam_date =  date('Y-m-d',strtotime($exam_date));
          
           $where = array('t.schoolId'=>$schoolID,'t.status'=>1);
            $ci = &get_instance();
            $ci->load->database();
            $ci->db->select('t.id as term_id,t.termname,t.termend');
            $ci->db->from('terms as t');
            $ci->db->where($where);
            $ci->db->group_start();
            $ci->db->where('t.termstart <=', $exam_date);
            $ci->db->where('t.termend   >=', $exam_date);
            $ci->db->group_end();
            $query =  $ci->db->get();
            // lq();
            return ( $query->row() ? $query->row() : 0 );
    }
}
if(!function_exists('resultExist'))
{
    function resultExist($student_id,$session_id)
    {
            $where = array('student_id'=>$student_id,'session_id'=>$session_id);
            $ci = &get_instance();
            $ci->load->database();
            $ci->db->select('*');
            $ci->db->from('result');
            $ci->db->where($where);
            $query =  $ci->db->get();
            return ( $query->num_rows() ? $query->num_rows() : 0 );
    }
}
if(!function_exists('subjectResultExist'))
{
    function subjectResultExist($student_id,$session_id,$term_id,$subject_id)
    {
            $where = array('student_id'=>$student_id,'session_id'=>$session_id,'subject_id'=>$subject_id,'term_id'=>$term_id);
            $ci = &get_instance();
            $ci->load->database();
            $ci->db->select('*');
            $ci->db->from('result_term_subject_data');
            $ci->db->where($where);
            $query =  $ci->db->get();
            //echo $ci->last_query();die;
            return ( $query->row() ? $query->row() : 0 );
    }
}
if(!function_exists('orderByTermsList'))
{
    function orderByTermsList($school_id,$session_id='')
    {       
        if($session_id==''){
            $session_id= get_current_session($school_id)->id;
        }
            $where = array('academicsession'=>$session_id,'schoolID'=>$school_id,'status'=>1);
            $ci = &get_instance();
            $ci->load->database();
            $ci->db->select('id as term_id,termname');
            $ci->db->from('terms');
            $ci->db->where($where);
            $ci->db->order_by('termstart');
            $query =  $ci->db->get();
            return ( $query->result() ? $query->result() : 0 );
    }
}
if(!function_exists('termnameByTermid'))
{
    function termnameByTermid($term_id)
    {
            $where = array('id'=>$term_id,'status'=>1);
            $ci = &get_instance();
            $ci->load->database();
            $ci->db->select('id as term_id,termname');
            $ci->db->from('terms');
            $ci->db->where($where);
            $query =  $ci->db->get();
            return ( $query->row() ? $query->row() : 0 );
    }
}
if(!function_exists('studentOverAllMarksDetails'))
{
    function studentOverAllMarksDetails($student_id,$session_id)
    {
            $where = array('student_id'=>$student_id,'session_id'=>$session_id);
            $ci = &get_instance();
            $ci->load->database();
            $ci->db->select('(SUM(total_exam_marks)+SUM(total_test_marks)+SUM(total_assignment_marks)+SUM(total_project_marks) ) as totalMarks, (SUM(obtain_exam_marks)+SUM(obtain_test_marks )+SUM(obtain_assignment_marks)+SUM(obtain_project_marks) ) as totalObtain');
            $ci->db->from('result_term_data');
            $ci->db->where($where);
            $ci->db->group_by('student_id');
            $query =  $ci->db->get();
            return ( $query->row() ? $query->row() : 0 );
    }
}
if(!function_exists('termwise_overall_marks'))
{
    function termwise_overall_marks($student_id,$session_id)
    {
            $where = array('student_id'=>$student_id,'session_id'=>$session_id);
            $ci = &get_instance();
            $ci->load->database();
            $ci->db->select('id,term_id,student_id,(SUM(total_exam_marks)+SUM(total_test_marks)+SUM(total_assignment_marks)+SUM(total_project_marks) ) as totalMarks, (SUM(obtain_exam_marks)+SUM(obtain_test_marks )+SUM(obtain_assignment_marks)+SUM(obtain_project_marks) ) as totalObtain');
            $ci->db->from('result_term_data');
            $ci->db->where($where);
            $ci->db->group_by('student_id');
            $ci->db->group_by('term_id');
            $query =  $ci->db->get();
            // $totalData = $query->row();
            return ( $query->result_array() ? $query->result_array() : 0 );
    }
}


if (!function_exists('sent_mail')){
        function sent_mail($ids){ 
            $thiss = &get_instance();  
            
            /* relevent user ids */
            if(isset($ids)){
                // $ids = implode(',',array_column($thiss->db->where('status',1)->where_in('role_id',$ids['roles'])->get('users')->result_array(),'email'));
            }elseif(isset($ids)){
                // $ids = implode(',',array_column($thiss->db->where('status',1)->get('users')->result_array(),'email'));
            }
            $data['to']  = $ids;
            return $ids;
        }
} 
if (!function_exists('month_options')){  
        function month_options($month) {
            $months = array('01' => 'January', '02' => 'February', '03' => 'March', '04' => 'April', '05' => 'May', '06' => 'June', '07' => 'July', '08' => 'August', '09' => 'September', 10 => 'October', 11 => 'November', 12 => 'December');
            return $months;
        }
    }

if (!function_exists('month_shortname')){  
    function month_shortname($month) { 
        return date("F", mktime(0, 0, 0,$month, 10));
    }
}

if (!function_exists('gender')){  
    function gender() {
        $gender = array('m' => 'Male', 'f' => 'Female');
        return $gender;
    }
}
if (!function_exists('feeType')){  
    function feeType($val) {
        $feeTypeVal = array('1' => 'Monthly', '4' => 'Quarterly', '12' => 'Yearly');
        return array_search($val, $feeTypeVal );
    }
}


    if (!function_exists('school_monthly_holiday')){ 
        function school_monthly_holiday($month=null, $year=null){ 
            $month = !empty($month)?$month:date('m');
            $year = !empty($year)?$year:date('Y');
            $CI = & get_instance();
            if($month!='all'){
                $CI->db->where(array("MONTH(for_date)" =>$month, "YEAR(for_date)" =>$year)); 
            }
            $result = $CI->db->order_by('for_date')->get('holiday')->result_array(); 
           return $holiday = array_values( array_column($result,'for_date','title') );
        } 
    }

if(!function_exists('get_subject'))
{
    function get_subject($id)
    {
            $ci = &get_instance();
            $ci->load->database();
            $ci->db->select('id as subject_id,subject');
            $ci->db->where('id',$id);
            $ci->db->from('subjects');
            $query =  $ci->db->get();
            $res = $query->result();
            return $res[0];
    }
}
if(!function_exists('getAnswer'))
{
    function getAnswer($ques_id)
    {
           $where = array('status'=>'1','id'=>$ques_id);
            $ci = &get_instance();
            $ci->load->database();
            $ci->db->select('answer');
            $ci->db->from('exam_question');
            $ci->db->where($where);
            $query =  $ci->db->get();
            $res = $query->result_array();
            return $res[0];
    }
}

if(!function_exists('getAdminEmail'))
{
	function getAdminEmail(){
		$ci = &get_instance();
		$ci->load->database();
		$ci->db->select('id,email');
		$ci->db->from('ics_admin');
		$ci->db->where('role','admin');
		$query =  $ci->db->get();
		return $query->row();		
	}
}
if(!function_exists('time_elapsed_string'))
{
    function time_elapsed_string($datetime, $full = false) {
        $now = new DateTime;
        $ago = new DateTime($datetime);
        $diff = $now->diff($ago);

        $diff->w = floor($diff->d / 7);
        $diff->d -= $diff->w * 7;

        $string = array(
            'y' => 'year',
            'm' => 'month',
            'w' => 'week',
            'd' => 'day',
            'h' => 'hour',
            'i' => 'minute',
            's' => 'second',
        );
        foreach ($string as $k => &$v) {
            if ($diff->$k) {
                $v = $diff->$k . ' ' . $v . ($diff->$k > 1 ? 's' : '');
            } else {
                unset($string[$k]);
            }
        }

        if (!$full) $string = array_slice($string, 0, 1);
        return $string ? implode(', ', $string) . ' ago' : 'just now';
    }
}
if(!function_exists('prd'))
{
    function prd($array) {
		if(count($array)>0){
			echo "<pre>"; print_r($array); die;
		}
    }
}
if(!function_exists('pr'))
{
    function pr($array) {
		if(count($array)){
			echo "<pre>"; print_r($array);
		}
    }
}
if(!function_exists('lq'))
{
    function lq() {
        $ci = &get_instance();
        echo $ci->db->last_query(); die;
    }
}
function get_time_ago($date) {
    $timestamp = $date;
    
    $strTime = array("second", "minute", "hour", "day", "month", "year");
    $length = array("60","60","24","30","12","10");

    $currentTime = time();
    if($currentTime >= $timestamp) {
         $diff     = time()- $timestamp;
         for($i = 0; $diff >= $length[$i] && $i < count($length)-1; $i++) {
         $diff = $diff / $length[$i];
         }

         $diff = round($diff);
         return $diff . " " . $strTime[$i] . "(s) ago ";
    }
 }
if(!function_exists('notificationSettingHelper'))
{
	function notificationSettingHelper($school_id='',$user_id='',$module_name=""){
		$ci = &get_instance();
		$ci->load->database();
		$ci->db->select('is_web,is_push,user_type');
		$ci->db->from('notification_settings');
        $ci->db->where('school_id',$school_id);
        $ci->db->where('user_id',$user_id);
        $ci->db->where('module_name',$module_name);
		$query =  $ci->db->get();
		return $query->row();		
	}
}
if(!function_exists('getSelectedMonthDates'))
{
        function getSelectedMonthDates($month,$year)
        {
          $list=array();
          if($month == date('m'))
            $days = date('t');
          else
            $days = 31;
          
          for($d=1; $d<=$days; $d++)
          {
              $time=mktime(12, 0, 0, $month, $d, $year);          
              if (date('m', $time)==$month)       
                  $list[]=date('Y-m-d', $time);
          }
          return $list; 
        }
    }
if(!function_exists('getSelectedMonthDays'))
{
    function getSelectedMonthDays($month,$year)
    {
      $list=array();
      if($month == date('m'))
        $days = date('t');
      else
        $days = 31;
      
      for($d=1; $d<=$days; $d++)
      {
          $time=mktime(12, 0, 0, $month, $d, $year);          
          if (date('m', $time)==$month)       
              array_push($list,    date('d', $time) );
      }
      return $list; 
    }
}
if(!function_exists('getCurrentMonthWeekendOff'))
{
     function getCurrentMonthWeekendOff($month,$year)
    {
            $monthDates = getMonthDates($month,$year);
             $first = reset($monthDates);
             $last = end($monthDates); 
            // prd($monthDates);
            $startDate =  (string)$first;
            $endDate =  (string)$last;
           
            $begin  = new DateTime($startDate);
            $end    = new DateTime($endDate);
                                           
            $totalweekendOff = [];
            while ( $begin <= $end) // Loop will work begin to the end date 
            {
                if(($begin->format("D") == "Sun") || $begin->format("D") == "Sat") //Check that the day is Sunday here
                {
                    $totalweekendOff[] = $begin->format("Y-m-d");
                }
                $begin->modify('+1 day');
            }
            // prd($totalweekendOff);
               return $totalweekendOff ? $totalweekendOff : false;                                         
    }
}
if(!function_exists('getMonthDates'))
{
    function getMonthDates($month,$year)
    {
            $list=array();
            
            for($d=1; $d<=31; $d++)
            {
                $time=mktime(12, 0, 0, $month, $d, $year);          
                if (date('m', $time)==$month)       
                    $list[]=date('Y-m-d', $time);
            }
            return $list;
    } 
}
if(!function_exists('getHolidaysWithName'))
{
    function getHolidaysWithName($month,$year,$schoolId="")
    {
        $holidays = array();
            // Get holidays from school list
            $CI = & get_instance();
            
            if($schoolId!="" && $schoolId>0){
             $CI->db->where(array("school_id" =>$schoolId));   
            }
            
            if($month!='all'){
                $CI->db->where(array("MONTH(for_date)" =>$month, "YEAR(for_date)" =>$year)); 
            }
            $result = $CI->db->select('title,for_date')->order_by('for_date')->group_by('for_date')->get('holiday')->result_array(); 

            $schoolHolidays        = array_merge($holidays, $result);
           
         
        // Get holidays from monthly weekend list
            $monthDates = getMonthDates($month,$year);
             $first = reset($monthDates);
             $last = end($monthDates); 
          
            $startDate =  (string)$first;
            $endDate =  (string)$last;
           
            $begin  = new DateTime($startDate);
            $end    = new DateTime($endDate);
                                           
            $totalweekendOff = [];
            $i=0;
            while ( $begin <= $end) // Loop will work begin to the end date 
            {
             if(!array_search($begin->format("Y-m-d"), array_column($schoolHolidays, 'for_date')))
               {
                if(($begin->format("D") == "Sun") || $begin->format("D") == "Sat") //Check that the day is Sunday here
                {
                    $totalweekendOff[$i]['for_date'] = $begin->format("Y-m-d");
                    $totalweekendOff[$i]['title'] = $begin->format("l");
                    $i++;
                }
               }
               $begin->modify('+1 day');
            }
            $finalHolidaysData = array_merge($schoolHolidays, $totalweekendOff);
            //print_r($finalHolidaysData);
            ///exit;
            
            return $finalHolidaysData ? $finalHolidaysData : array();
    }
}
if(!function_exists('getDaysOffDays'))
{
    function getDaysOffDays($startDate,$endDate)
    {
          $date=strtotime($startDate);
          $month=date("m",$date);
          $year=date("Y",$date);


        $startDate1 = (string)$startDate;
        $endDate1   = (string)$endDate;
        $startDate = new DateTime($startDate1);
        $endDate   = new DateTime($endDate1);

        if($startDate == $endDate )
        {
            $interval = 1;
            $days =  $interval.' day';
        }else{
            $interval = $startDate->diff($endDate);
            $days =  $interval->days.' days';
        }

        $holidays = array();
            // Get holidays from school list
            $CI = & get_instance();
            if($month!='all'){
                $CI->db->where(array("MONTH(for_date)" =>$month, "YEAR(for_date)" =>$year)); 
            }
            $result = $CI->db->select('title,for_date')->order_by('for_date')->group_by('for_date')->get('holiday')->result_array(); 

            $schoolHolidays        = array_merge($holidays, $result);
       // prd($schoolHolidays);
        // Get holidays from monthly weekend list
            $totalweekendOff = [];
            $i=0;
            while ( $startDate <= $endDate) // Loop will work begin to the end date 
            {
                if(($startDate->format("D") == "Sun") || $startDate->format("D") == "Sat") //Check that the day is Sunday here
                {
                    $totalweekendOff[$i]['for_date'] = $startDate->format("Y-m-d");
                    $totalweekendOff[$i]['title'] = $startDate->format("l");
                    $i++;
                }
                $startDate->modify('+1 day');
            }
            $finalHolidaysData = array_merge($schoolHolidays, $totalweekendOff);
            $finalHolidaysData = array_column($finalHolidaysData, 'for_date');
            return $finalHolidaysData ? $finalHolidaysData : array();
    }
}

if(!function_exists('date_range'))
{
   function date_range($begin,$end){

        $begin = new DateTime($begin);

        $end = new DateTime($end.' +1 day');

        $daterange = new DatePeriod($begin, new DateInterval('P1D'), $end);

        foreach($daterange as $date){
            $dates[] = $date->format("Y-m-d");
        }
        return $dates;

    }
}
if(!function_exists('get_school'))
{
    function get_school($schoolID)
    {
		$ci = &get_instance();
		$ci->load->database();
		$ci->db->where('school_id',$schoolID);
		$query =  $ci->db->get('school_admin');
		if($query->result_id->num_rows==1)
		{
			$data_user = $query->row_array();
			$ci->db->where('id',$schoolID);
			$query1 =  $ci->db->get('school');
			$data_user1 = $query1->row();
			$data_user['school_name'] = $data_user1->school_name;
			$data_user['subscription_id'] = $data_user1->subscription_id;
                        $data_user['currency_id'] = $data_user1->currency_id;
			$data_user['phone'] = $data_user1->phone;
			return $data_user;
		}else{
			return array();
		}
    }
}
if(!function_exists('get_subscription'))
{
    function get_subscription($schoolID)
    {
		$ci = &get_instance();
		$ci->load->database();
		$ci->db->select("id");
		$ci->db->where('school_id', $schoolID);
		$ci->db->where('status','Active');
		$ci->db->order_by('id','DESC');
		$ci->db->limit(1);
		$data=$ci->db->get('school_subscription');
		$countData=$data->num_rows();
		return $countData;
    }
}
if(!function_exists('get_school_subscription_data'))
{
    function get_school_subscription_data($schoolID,$subscription_id='')
    {
		$ci = &get_instance();
		$ci->load->database();
		$ci->db->select("*");
		$ci->db->where('school_id', $schoolID);
        if($subscription_id!=''){
        $ci->db->where('subscription_id', $subscription_id);
        }
		$ci->db->where('status','Active');
		$ci->db->order_by('id','DESC');
		$ci->db->limit(1);
		$data=$ci->db->get('school_subscription');
		$data=$data->result_array();
		return $data[0];
    }
}
if(!function_exists('count_school_child'))
{
    function count_school_child($schoolID)
    {
		$ci = &get_instance();
		$ci->load->database();
		$ci->db->select("id");
		$ci->db->where('schoolId', $schoolID);
		$data=$ci->db->get('child');
		$data=$data->num_rows();
		return $data;
    }
}
if(!function_exists('test'))
{
    function test()
    {
	echo die('dsafd');
           $where = array('status'=>1);
            $ci = &get_instance();
            $ci->load->database();
            $ci->db->select('*');
            $ci->db->where('id',$studentUniqid);
            $ci->db->or_where('child_login_id',$studentUniqid);
            $ci->db->or_where('childRegisterId',$studentUniqid);
            $ci->db->from('child');
            $query =  $ci->db->get();
            return $query->row();
    }
}

if(!function_exists('sendSmtpCustomEmail')){
function sendSmtpCustomEmail($to, $subject,$body, $cc='',$bcc='') {
require_once APPPATH . "phpmailer/class.phpmailer.php";
$from = "admin@kidyview.com";
$mail = new PHPMailer();
$mail->IsSMTP(true); // SMTP
$mail->SMTPAuth = true;  // SMTP authentication
$mail->Mailer = "smtp";
$mail->Host = "smtp.mailgun.org"; // Amazon SES server, note "tls://" protocol
$mail->Port = 587;                    // set the SMTP port
$mail->Username = "postmaster@sandboxbccfa2e4d9cf4ae2883445c68eccf3d3.mailgun.org";  // SMTP  Username
$mail->Password = "e6adbbe4a78db0d5ca584f0278e253d8-30b9cd6d-c7497395";  // SMTP Password
$mail->SetFrom($from, 'KidyView');
$mail->Subject = $subject;
$mail->MsgHTML($body);
$address = $to;
$mail->AddAddress($address, $to);
if (!$mail->Send())
return false;
else
return true;
}
}
if(!function_exists('getSchoolDetails'))
{
    function getSchoolDetails($schoolID)
    {
           //$where = array('status'=>1);
            $ci = &get_instance();
            $ci->load->database();
            $ci->db->select('*');
            $ci->db->where('id',$schoolID);
            $ci->db->from('school_admin');
            $query =  $ci->db->get();
            return $query->row();
    }
}
if(!function_exists('getStudentBySchool'))
{
    function getStudentBySchool($school_id)
    {
           $where = array('status'=>1);
            $ci = &get_instance();
            $ci->load->database();
            $ci->db->select('*');
            $ci->db->where('schoolId',$school_id);
            $ci->db->from('child');
            $query =  $ci->db->get();
            return $query->result_array();
    }
}
if(!function_exists('getCurrencyAmmount'))
{
    function getCurrencyAmmount($currency_id)
    {
           //$where = array('status'=>1);
            $ci = &get_instance();
            $ci->load->database();
            $ci->db->select('*');
            $ci->db->where('id',$currency_id);
            $ci->db->from('admin_currency');
            $query =  $ci->db->get();
            return $query->row_array();
    }
}
if(!function_exists('getSchoolCurrency'))
{
    function getSchoolCurrency($school_id)
    {
           //$where = array('status'=>1);
            $ci = &get_instance();
            $ci->load->database();
            $ci->db->select('currency_id');
            $ci->db->where('id',$school_id);
            $ci->db->from('school');
            $query =  $ci->db->get();
            return $query->row_array();
    }
}
if(!function_exists('get_all_session'))
{
    function get_all_session($schoolID)
    {
       $where = array('schoolId'=>$schoolID,'status'=>1);
        $ci = &get_instance();
        $ci->load->database();
        $ci->db->select('id,academicsession');
        $ci->db->from('sessions');
        $ci->db->where($where);
        $ci->db->order_by('current_sesion','DESC');
        $query = $ci->db->get();
        return $query->result();
    }
}
if(!function_exists('sendKidyviewEmail'))
{
	function sendKidyviewEmail($toemail1='',$toemail2='',$toemail3='',$toname='',$subject="",$message="")
	{
        $sendgrid_apikey = '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';
        $url = 'https://api.sendgrid.com/';
        $pass = $sendgrid_apikey;
        $template_id = 'Your template id';
        $js = array(
          'sub' => array(':name' => array('Elmer')),
          'filters' => array('templates' => array('settings' => array('enable' => 1, 'template_id' => $template_id)))
        );
        if(is_array($toemail1)) {
            $i=0;
            foreach($toemail1 as $t) $params['to['.$i++.']']=$t;
        }else {
            $params['to']=$toemail1;
        }
        $params['from']='hello@kidyview.com';
        $params['fromname']='Kidyview';
        $params['subject']=$subject;
        $params['html']=$message;
       /* $params = array(
            'to'        => 'y1@yopmail.com,y2@yopmail.com',
            //'toname'    => "Yogendra",
            'from'      => "hello@kidyview.com",
            'fromname'  => "Kidyview",
            'subject'   => $subject,
            //'text'      => "click on it",
            'html'      => $message,
          );*/
        $request =  $url.'api/mail.send.json';
        $session = curl_init($request);
        curl_setopt($session, CURLOPT_SSLVERSION, CURL_SSLVERSION_TLSv1_2);
        curl_setopt($session, CURLOPT_HTTPHEADER, array('Authorization: Bearer ' . $sendgrid_apikey));
        curl_setopt ($session, CURLOPT_POST, true);
        curl_setopt ($session, CURLOPT_POSTFIELDS, $params);
        curl_setopt($session, CURLOPT_HEADER, false);
        curl_setopt($session, CURLOPT_RETURNTRANSFER, true);
        $response = curl_exec($session);
        curl_close($session);
        $data=json_decode($response,true);
       //print_r($data);die;
        if(!empty($data)){
            if($data['message']=='success'){
                return true;
            }else{
                return false;
            }
        }else{
            return false;
        }
	}
}

if(!function_exists('sendKidyviewSms'))
{
	function sendKidyviewSms($to='',$msg='')
	{
        $from="(903) 300-1178";
        //$sid = "AC88b2bb2733f6fc92a17f45b40060b5e9"; // Your Account SID from www.twilio.com/console
        //$token = "39c44944860d5aa86687b7d8c35bb773"; // Your Auth Token from www.twilio.com/console
        $sid = "AC88b2bb2733f6fc92a17f45b40060b5e9"; // Your Account SID from www.twilio.com/console
        $token = "39c44944860d5aa86687b7d8c35bb773"; // Your Auth Token from www.twilio.com/console
        
        $client = new Twilio\Rest\Client($sid, $token);
        $client->messages->create(
            // the number you'd like to send the message to
            $to,
            [
                // A Twilio phone number you purchased at twilio.com/console
                'from' => $from,
                // the body of the text message you'd like to send
                'body' => $msg
            ]
        ); 
	}
}
if(!function_exists('getChildParent'))
{
    function getChildParent($child_id)
    {
           //$where = array('status'=>1);
            $ci = &get_instance();
            $ci->load->database();
            $ci->db->select('fatherfname,fatherlname,fatheremail,motherfname,motherlname,motheremail');
            $ci->db->where_in('child_id',$child_id);
            $ci->db->from(' parent');
            $query =  $ci->db->get();
            return $query->row_array();
    }
}
if(!function_exists('getTeacher'))
{
    function getTeacher($teacher_id)
    {
           //$where = array('status'=>1);
            $ci = &get_instance();
            $ci->load->database();
            $ci->db->select('teacherfname,teacherlname,teacheremail');
            $ci->db->where_in('child_id',$child_id);
            $ci->db->from(' teacher');
            $query =  $ci->db->get();
            return $query->row_array();
    }
}
?>