<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
	
	class Attendance_model extends CI_Model
	{
		public function teacherCheckin($attendanceArr)
		{
			$current_session = get_current_session($attendanceArr['school_id'])->academicsession;
			$attendanceArr['session'] 			= $current_session;
			$attendanceArr['checkin_time'] 		= date('H:i:s');
			$attendanceArr['date'] 				= date('Y-m-d');
			$attendanceArr['created_at'] 		= date('Y-m-d H:i:s');

			$this->db->insert('staff_attendance',$attendanceArr);
			if($this->db->affected_rows() > 0)
			{	
				$id = $this->db->insert_id();
				$result = $this->db->where('id',$id)->get('staff_attendance')->row();
				return (array)$result;
			}else{
				return 0;
			}
		}
		public function teacherCheckout($checkoutData,$user_id)
		{
			$currentDate = date('Y-m-d');
			$checkoutData['checkout_time']		= date('H:i:s');
			$checkoutData['updated_by'] 		= $user_id;
			$checkoutData['updated_at'] 		= date('Y-m-d H:i:s');
			
			$this->db->where(['user_id'=>$user_id,'date'=>$currentDate]);
			$this->db->update('staff_attendance',$checkoutData);
			if($this->db->affected_rows() > 0)
			{
				$result = $this->db->where(['user_id'=>$user_id,'date'=>$currentDate])->get('staff_attendance')->row();
				return (array)$result ? (array)$result : 0;
			}else{
				return 0;
			}
		}
		public function isAlreadyCheckin($user_id)
		{
			$todayDate = date('Y-m-d');
			return $num_rows = $this->db->where(['user_id'=>$user_id,'date'=>$todayDate])->get('staff_attendance')->num_rows();
		}
		public function getCurrentMonthWeekendOff($month,$year)
	    {
	    	$monthDates = $this->getMonthDates($month,$year);
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

		public function allAttendance()
		{
                        $schoolId                        = $this->token->school_id; 
			$user_type 	  			  =  $this->token->user_type;
			$teacher_id   			  =  $this->token->user_id;

			if(empty($this->input->get('date')) && empty($this->input->get('month')))
			{
				return false;
			}
			if($this->input->get('date') != '')
			{
				$monthYear 			  =  $this->input->get('date');
	     		$monthYear 			  = explode("-", $monthYear);
				$month 				  = ($monthYear[1] ? $monthYear[1] : date('m'));
	     		$year 				  = ($monthYear[0] ? $monthYear[0] : date('Y'));
         	 	$getMonthData   	  = getCurrentMonthDaysDetails($month,$year,$schoolId);
			 	$totalHolidays  	   = $getMonthData['totalHolidays']; 
         	 	$current_month_date        = $getMonthData['current_month_dates']; 
           		$total_work_days           = ( count($current_month_date) - count($totalHolidays));
				
				$date = $this->input->get('date');
				return ['myAttendance' => $this->datewise_attendance($teacher_id,$user_type,$date) , 'total_work_days' => $total_work_days];
			}
	     		$monthYear 			  =  $this->input->get('month');
	     		$monthYear 			  = explode("-", $monthYear);
	     		$month 				  = ($monthYear[1] ? $monthYear[1] : date('m'));
	     		$year 				  = ($monthYear[0] ? $monthYear[0] : date('Y'));
         	 	$getMonthData   	  = getCurrentMonthDaysDetails($month,$year,$schoolId);
         	 	
         	 	$holidays    		= array_unique(school_monthly_holiday($month,$year));
				$holidaysArr	= [];
				  if(!empty($holidays)){
					foreach($holidays as $date){
						$timestamp = strtotime($date);
						$day = date('D', $timestamp);
						if($day!='Sun' && $day!='Sat'){
							array_push($holidaysArr,$day);	
						}
					}
				$holidays=$holidaysArr;
				}
				$weekendHolidays    = $this->getCurrentMonthWeekendOff($month,$year);
				//print_r($weekendHolidays);die;  
				$totalHolidays = array_merge($weekendHolidays,$holidays);
         	 	//echo count($totalHolidays);die;
         	 	$getSelectedMonthData = $this->getSelectedMonthDates($month,$year);

			 	$totalHolidays  	   = $totalHolidays; 
			 	$selected_month_dates  = $this->getSelectedMonthDates($month,$year); 

         	 	// prd($totalHolidays);

			 	$current_month_date        = 			$getMonthData['current_month_dates']; 
			 	// pr($selected_month_dates);
         	 	// prd($totalHolidays);
// lq();
           		$total_work_days           = ( count($selected_month_dates) - count($totalHolidays));
         	 	// prd($getMonthData);
			  $attendanceDates = array_diff($getSelectedMonthData, $totalHolidays);
			  
			  $myAttendance = array();
			  $i=0;
			  foreach ($attendanceDates as  $date) {
			  		$myAttendance[$i]  = $this->datewise_attendance($teacher_id,$user_type,$date);
		      		$i++;
		    }
		    // $totalPresentDays = count(array_filter($myAttendance, function($value) { return !is_null($value['checkout_time']) &&  $value['checkout_time'] !== ''; }));
		    return ['myAttendance' => $myAttendance , 'total_work_days' => $total_work_days];
		        // prd($myAttendance);
		}
	private function datewise_attendance($teacher_id,$user_type,$date)
	{
		$this->db->select("user_type,checkin_time,checkout_time,date");
	    $this->db->where(['user_id' => $teacher_id, 'user_type'=>$user_type]);
        $this->db->where("date like '$date%'");
	        $query = $this->db->get('staff_attendance');
	        if($query->num_rows() > 0)
	        {
	            $result = (array)$query->row();
	            $result['status']    = 'Present';
	           
	            return $result;
	        }
	        else
	        {
	             return array('user_type'=>'Teacher','checkin_time'=>'','checkout_time'=>'','date'=>$date,'status'=>'Absent');
	        }

	}
	public function getSelectedMonthDates($month,$year)
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
	public function dates_till_today()
    {
        $getAllDates = [];
        for($i=1;$i<=date('d');$i++) 
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
    public function teacherFCMID($user_id)
    {
    	return $this->db->select('fcm_key')->where('user_id',$user_id)->order_by('id','desc')->get('user_token')->row();
    }
	public function getTeachersBySchoolType($postData)
    {
    	// prd($postData);
    	return $this->db->select('id as teacher_id,CONCAT(teacherfname," ",teachermname," ",teacherlname) as teacher')->like('schoolType',$postData['schoolType'],'both')->where(['status'=>1, 'schoolId'=>$postData['school_id'] ])->get('teacher')->result();
    }
    public function teacherAttendanceBySchool($postData)
    {
    	$school_id = $postData['school_id'];
    	$attendance_date = $postData['attendance_date'];
    	// prd($postData['teacherAttendance']);
    	$finalAttendArr = array();
    	$i=0;
    	foreach ( $postData['teacherAttendance'] as $key => $value) {
    		if( $value['checkin_time'] != 'NaN:NaN AM' && !empty($value['checkin_status']) && $value['checkout_time'] != 'NaN:NaN AM' && !empty($value['checkout_status']) )
    		{
    			// prd($value);
    			$checkedin   = explode(":", $value['checkin_time']);
    			$checkinHrs  = $checkedin[0];
    			$checkinMins = $checkedin[1];
    			$checkinHrs  = ($checkinHrs <=9) ? '0'.$checkinHrs : $checkinHrs; 
    			$checkinMins = ($checkinMins <=9) ? '0'.$checkinMins : $checkinMins;

				$checkin_time = $checkinHrs.":".$checkinMins;

    			// Check out Time format
    			$checkout   = explode(":", $value['checkout_time']);
    			$checkoutHrs  = $checkout[0];
    			$checkoutMins = $checkout[1];
    			$checkoutHrs  = ($checkoutHrs <=9) ? '0'.$checkoutHrs : $checkoutHrs; 
    			$checkoutMins = ($checkoutMins <=9) ? '0'.$checkoutMins : $checkoutMins;

				$checkout_time = $checkoutHrs.":".$checkoutMins;

    			$finalAttendArr[$i]['user_id']  		= $value['teacher_id'];
    			$finalAttendArr[$i]['session'] 			= get_current_session($school_id)->academicsession;
    			$finalAttendArr[$i]['checkin_time'] 	= $checkin_time;
    			$finalAttendArr[$i]['checkout_time'] 	= $checkout_time;
    			$finalAttendArr[$i]['date']  			= date('Y-m-d',strtotime($attendance_date));
    			$finalAttendArr[$i]['school_id'] 		= $school_id;
    			$finalAttendArr[$i]['user_type'] 		= 'Teacher';
    			$finalAttendArr[$i]['created_by'] 		= $school_id;
    			$finalAttendArr[$i]['created_at'] 		= date('Y-m-d H:i:s');
    			$i++;
    		}elseif ( $value['checkin_time'] != 'NaN:NaN AM' && !empty($value['checkin_status']) && $value['checkout_time'] == 'NaN:NaN AM' && empty($value['checkout_status']) ) 
    		{
    			$checkedin   = explode(":", $value['checkin_time']);
    			$checkinHrs  = $checkedin[0];
    			$checkinMins = $checkedin[1];
    			$checkinHrs  = ($checkinHrs <=9) ? '0'.$checkinHrs : $checkinHrs; 
    			$checkinMins = ($checkinMins <=9) ? '0'.$checkinMins : $checkinMins;

				$checkin_time = $checkinHrs.":".$checkinMins;

    			$finalAttendArr[$i]['user_id']  		= $value['teacher_id'];
    			$finalAttendArr[$i]['session'] 			= get_current_session($school_id)->academicsession;
    			$finalAttendArr[$i]['checkin_time'] 	= $checkin_time;
    			$finalAttendArr[$i]['checkout_time'] 	= null;
    			$finalAttendArr[$i]['date']  			= date('Y-m-d',strtotime($attendance_date));
    			$finalAttendArr[$i]['school_id'] 		= $school_id;
    			$finalAttendArr[$i]['user_type'] 		= 'Teacher';
    			$finalAttendArr[$i]['created_by'] 		= $school_id;
    			$finalAttendArr[$i]['created_at'] 		= date('Y-m-d H:i:s');
    			$i++;
    		
    		}elseif ( $value['checkin_time'] == 'NaN:NaN AM' && empty($value['checkin_status']) && $value['checkout_time'] != 'NaN:NaN AM' && !empty($value['checkout_status']) ) 
    		{
    			// Check out Time format
    			$checkout   = explode(":", $value['checkout_time']);
    			$checkoutHrs  = $checkout[0];
    			$checkoutMins = $checkout[1];
    			$checkoutHrs  = ($checkoutHrs <=9) ? '0'.$checkoutHrs : $checkoutHrs; 
    			$checkoutMins = ($checkoutMins <=9) ? '0'.$checkoutMins : $checkoutMins;

				$checkout_time = $checkoutHrs.":".$checkoutMins;

    			$finalAttendArr[$i]['user_id']  		= $value['teacher_id'];
    			$finalAttendArr[$i]['session'] 			= get_current_session($school_id)->academicsession;
    			// $finalAttendArr[$i]['checkin_time'] 	= ;
    			$finalAttendArr[$i]['checkout_time'] 	= $checkout_time;
    			$finalAttendArr[$i]['date']  			= date('Y-m-d',strtotime($attendance_date));
    			$finalAttendArr[$i]['school_id'] 		= $school_id;
    			$finalAttendArr[$i]['user_type'] 		= 'Teacher';
    			$finalAttendArr[$i]['created_by'] 		= $school_id;
    			$finalAttendArr[$i]['created_at'] 		= date('Y-m-d H:i:s');
    			$i++;
    		}
    	}
// prd($finalAttendArr);
    	$rowsInserted=0;
    	foreach ( $finalAttendArr as  $value) {
    			$isExist = $this->checkTeacherAttendance($value['user_id'],$value['date']);
    			if($isExist > 0)
    			{
    				$this->db->where([ 'user_id' => $value['user_id'], 'date' => $value['date'] ]);
    				$this->db->update('staff_attendance',$value);
    				$rowsInserted = $this->db->affected_rows();
    				$rowsInserted++;
    				// continue;
    			}else{
    				$this->db->insert('staff_attendance',$value);
    				$rowsInserted = $this->db->affected_rows();
    				$rowsInserted++;
    			}
    	}
    	// echo $rowsInserted; die;
    	return ($rowsInserted > 0) ? $rowsInserted : false; 
    	// prd($finalAttendArr);
    }
    protected function checkTeacherAttendance($teacher_id,$attendance_date)
    {
    	$where = array('user_id'=>$teacher_id, 'date' => $attendance_date);
    	// $where = array('user_id'=>$teacher_id, 'date' => $attendance_date , 'checkin_time <>'=>null, 'checkout_time <>'=>null);
    	$this->db->where($where);
    	return $num_rows = $this->db->get('staff_attendance')->num_rows();
    } 
}