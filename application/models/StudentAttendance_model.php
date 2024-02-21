<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
	
	class StudentAttendance_model extends CI_Model
	{
		public function classList($school_id,$user_id)
		{
			$this->db->select("assignclassteacher");
			$this->db->from('teacher');
			$this->db->where(['id'=>$user_id,'schoolId'=>$school_id]);
			$query = $this->db->get();
			$teacherdata=$query->row();
			$classid='NULL';
			if(!empty($teacherdata) && $teacherdata->assignclassteacher!=''){
				$classid=$teacherdata->assignclassteacher;
			}
            $sql='select c.id,CONCAT(c.class," " ,c.section) as classname,s.school_name from class c inner join school s on c.schoolId=s.id where c.id IN ('.$classid.')';
			$query=$this->db->query($sql);
            if($query->num_rows() > 0)
            {
               $data_user = $query->result_array();
               return $data_user;
            }else{
                return array();
			}
		}
		public function getStudentsByClass($classID,$school_id,$search=false)
		{	
        	$session_id= get_current_session($school_id)->id;
			$currentDate = date('Y-m-d');
				$sql = 'SELECT `c`.`id`,CONCAT(c.childfname," ",`c`.`childmname`," ",c.childlname) AS  studentName,`c`.`childphoto`,`sa`.`check_in`,`sa`.`check_out`
					 FROM `child` AS `c`
					 LEFT JOIN (SELECT * FROM `student_attendance` WHERE student_attendance.date = "'.$currentDate.'") sa
					 ON `sa`.`student_id` = `c`.`id`
					 WHERE `c`.`childclass` = '.$classID.' AND `c`.`class_session_id` = '.$session_id.' AND `c`.`status` = 1 AND `c`.`schoolId` = '.$school_id.' ';
					 if(!empty($search))
					{
						$sql .= "AND ( c.childfname like '%".$search."%'";
						 $sql .= " OR c.childmname like '%".$search."%'";
						 $sql .= " OR c.childlname like '%".$search."%')";
					}
			
				$query=$this->db->query($sql);
			if($query->num_rows() > 0)
            {
 	          $students = $query->result_array();
 	          // prd($students);
 	          $studentsArr = array();
 	          $i=0;
 	          foreach ($students as $value) {
 	          			if(empty($value['check_in']) || ($value['check_in']==null))
 	          			{
 	          					$value['check_in'] = false;	
 	          			}else{
 	          					$value['check_in'] = true;	
 	          			}

  	         			if(empty($value['check_out']) || ($value['check_out']==null) || ($value['check_out']=='false') )
 	          			{
 	          					$value['check_out'] = false;	
 	          			}else{
 	          					$value['check_out'] = true;	
 	          			}
 	          	$studentsArr[$i] = $value;
 	          	$i++;
 	          }
 	          return $studentsArr;
 	        }else{
                return array();
            }	
		}
		public function checkinStudentAttendance($attendanceData)
		{
			// prd($attendanceData);
			if(count($attendanceData) >0)
			{
				$this->db->insert_batch('student_attendance',$attendanceData);
				if($this->db->affected_rows() > 0)
                	return 1;
            	else
                	return array();

			}else{
				return array();
			}
		}
		public function manualCheckout($checkoutArr)
		{
			$student_id = $checkoutArr['student_id'];
			$currentDate = date('Y-m-d');
			$this->db->where(['student_id'=>$student_id, 'date'=>$currentDate]);
			unset($checkoutArr['student_id']);
			$this->db->update("student_attendance",$checkoutArr);
			return ($this->db->affected_rows() ? $this->db->affected_rows() : 0);
		}
		public function updateParentAttendanceOtp($updateArr, $parent_id)
		{
			$this->db->where('id',$parent_id);
			$this->db->update('parent',$updateArr);
			return ($this->db->affected_rows() ? $this->db->affected_rows() : false);
		}
		public function saveOtpCheckout($student_id,$updateQRCodeCheckout)
		{
			$currentDate = date('Y-m-d');
			$this->db->where(['student_id'=>$student_id,'date'=>$currentDate]);
			$this->db->update('student_attendance',$updateQRCodeCheckout);
			return ($this->db->affected_rows() ? $this->db->affected_rows() : false);
		}
		public function saveQRCodeCheckout($student_id,$updateOtpChechout)
		{
			$currentDate = date('Y-m-d');
			$this->db->where(['student_id'=>$student_id,'date'=>$currentDate]);
			$this->db->update('student_attendance',$updateOtpChechout);
			return ($this->db->affected_rows() ? $this->db->affected_rows() : false);
		}
		public function guardiansList($parent_id)
		{
			$this->db->where('parent_id',$parent_id);
	        $this->db->where('status',1);
	        $this->db->from('parent_guardian');
	        $query = $this->db->get();
	        //echo $this->db->last_query();die;
	        if($query->num_rows() > 0)
	        {
	            return $query->result();
	        }
	        else
	        {
	            return array();
	        }
		}
		public function guardianDetails($id)
		{
			$this->db->where('id',$id);
	        $this->db->where('status',1);
	        $this->db->from('parent_guardian');
	        $query = $this->db->get();
	        if($query->num_rows() > 0)
	        {
	            return (array)$query->row();
	        }
	        else
	        {
	            return array();
	        }
		}
		public function saveGuardianOTPDetails($saveArr,$student_id)
		{
			if(!empty($student_id))
			{
				$expireOldOTP = array(
						'is_expired' => 'yes'
					);
				$this->db->where(['student_id'=>$student_id]);
				$this->db->update('otp_checkout',$expireOldOTP);

			}else{
				return 0;
			}
			$this->db->insert('otp_checkout',$saveArr);
			if($this->db->affected_rows()>0)
			{			
				return $this->db->affected_rows() ? $this->db->affected_rows() : 0;
			}else{
				return 0;
			}
		}
		public function saveParentQRCodeDetails($qrcodeDataArr)
		{
			$this->db->insert('qrcode_checkout',$qrcodeDataArr);
			if($this->db->affected_rows() > 0)
               	return $this->db->insert_id();
            else
               	return 0;
		}
		public function getQRCodeDetails($id)
		{
			$this->db->where('id',$id);
			$this->db->from('qrcode_checkout');
			$query = $this->db->get();
			if($query->num_rows() > 0)
               	return $query->row();
            else
               	return 0;
		}
		public function getQRCodeValidate($parent_id,$student_id)
		{
	    	$currentDateTime = date('Y-m-d H:i:s');
			$this->db->where(['parent_id'=>$parent_id,'student_id'=>$student_id,'date(created_on)'=>date('Y-m-d')]);
			$this->db->from('qrcode_checkout');
			$this->db->order_by('id','desc');
			$query = $this->db->get();

			if($query->num_rows() > 0)
			{
				$result = (array)$query->row();
				if( $currentDateTime > $result['expired_on'])
	            {
	            	return ['status'=>"qrcode_expired",'data'=>$result];
	            }else{
	            	return ['status'=>"qrcode_valid",'data'=>$result];
	            }
			}
            else{
               	return ['status'=>"parent_not_found",'data'=>array()];
            }
		}
		public function getQRCodeValidateForCheckout($parent_id,$student_id)
		{
	    	$currentDateTime = date('Y-m-d H:i:s');
			$this->db->where(['parent_id'=>$parent_id,'student_id'=>$student_id,'date(created_on)'=>date('Y-m-d')]);
			$this->db->from('qrcode_checkout');
			$query = $this->db->get();
			if($query->num_rows() > 0)
			{
				$result = (array)$query->row();
				if( $currentDateTime > $result['expired_on'])
	            {
	            	return ['status'=>"qrcode_expired",'data'=>$result];
	            }else{
	            	return ['status'=>"qrcode_valid",'data'=>$result];
	            }
			}
            else{
	            	return ['status'=>"parent_not_found",'data'=>array()];
            }
		}
		public function isOtpExpired($otp,$student_id)
	    {
	    	$currentDateTime = date('Y-m-d H:i:s');
	  		$this->db->where(['otp'=>$otp,'student_id'=>$student_id]);
	        $this->db->from('otp_checkout');
	        $query = $this->db->get();
	        if($query->num_rows() > 0)
	        {
	       		$result = (array)$query->row();
	       		if( $currentDateTime > $result['expired_on'])
	            {
	            	return "otp_expired";
	            }else if($result['is_expired'] == 'yes')
	            {
	            	return "otp_expired";
	            }
	            else{
	            	return "otp_valid";
	            }
	        }
	        else
	        {
	            return "student_mismatched";
	        }
	    }
	    public function isQRCodeExpired($qrcode,$student_id)
	    {
	    	$currentDateTime = date('Y-m-d H:i:s');
	  		$this->db->where(['qr_code'=>$qrcode,'student_id'=>$student_id]);
	        $this->db->from('qrcode_checkout');
	        $query = $this->db->get();
	        if($query->num_rows() > 0)
	        {
	       		$result = (array)$query->row();
	            if( $currentDateTime > $result['expired_on'])
	            {
	            	return "qrcode_expired";
	            }else{
	            	return "qrcode_valid";
	            }
	        }
	        else
	        {
	            return "student_mismatched";
	        }
	    }
		public function getDetailsByQRCode($qrcode,$student_id)
	    {
	    	$currentDateTime = date('Y-m-d H:i:s');
	  		$this->db->where(['qr_code'=>$qrcode,'student_id'=>$student_id]);
	        $this->db->from('qrcode_checkout');
	        $query = $this->db->get();
	        if($query->num_rows() > 0)
	        {
	       		return $result = (array)$query->row();
	        }
	        else
	        {
	            return 0;
	        }
	    }
	    public function getChildDetails($student_id)
	    {
		   $query = $this->db->select("CONCAT(childfname,' ',childmname,' ',childlname) as child,childRegisterId")->where(['id'=>$student_id,'status'=>1])->get('child');
	       return $query->num_rows() ? (array)$query->row() : array();
	    }

	public function studentAttendanceBySchool($postData)
    {
    	$class_id = $postData['class_id'];
    	$school_id = $postData['school_id'];
    	$attendance_date = $postData['attendance_date'];
    	$attendance_date_mod = date('Y-m-d',strtotime($attendance_date));
    	// prd($completeStudentArr);
    	$finalAttendArr = array();
    	$i=0;
    	foreach( $postData['studentAttendance'] as $key => $value) 
    	{
    		// prd($value);
    		if( !empty($value['checkout_status']) &&  !empty($value['checkin_status'])  && array_key_exists('checkout_status', $value) && array_key_exists('checkin_status', $value) )
    		{
    			// echo "check_in";
    			$finalAttendArr[$i]['student_id']  	= $value['child_id'];
    			$finalAttendArr[$i]['check_in'] 	= !empty($value['checkin_status'] == 1) ?  "true" : null;
    			$finalAttendArr[$i]['check_out'] 	= !empty($value['checkout_status'] == 1) ?  "true" : null;
    			$finalAttendArr[$i]['date']  		= $attendance_date_mod;
				$finalAttendArr[$i]['session'] 		= get_current_session($school_id)->academicsession;
				$finalAttendArr[$i]['session_id'] 		= get_current_session($school_id)->id;
    			$finalAttendArr[$i]['school_id'] 	= $school_id;
    			$finalAttendArr[$i]['teacher_id'] 	= $school_id;
    			$finalAttendArr[$i]['class_id'] 	= $class_id;
    			$finalAttendArr[$i]['checkout_type']= 'school-manual';
    			$finalAttendArr[$i]['created_by'] 	= $school_id;
    			$finalAttendArr[$i]['created_at'] 	= date('Y-m-d H:i:s');
    			$i++;
    		
    		}
    		else if( !empty($value['checkout_status']) && array_key_exists( 'checkout_status', $value) )
    		{
    			$finalAttendArr[$i]['student_id']  	= $value['child_id'];
    			// $finalAttendArr[$i]['check_in'] 	=  null;
    			$finalAttendArr[$i]['check_out'] 	= !empty($value['checkout_status'] == 1) ?  "true" : null;;
    			$finalAttendArr[$i]['date']  		= $attendance_date_mod;
    			$finalAttendArr[$i]['session'] 		= get_current_session($school_id)->academicsession;
				$finalAttendArr[$i]['session_id'] 		= get_current_session($school_id)->id;
				$finalAttendArr[$i]['school_id'] 	= $school_id;
    			$finalAttendArr[$i]['teacher_id'] 	= $school_id;
    			$finalAttendArr[$i]['class_id'] 	= $class_id;
    			$finalAttendArr[$i]['checkout_type']= 'school-manual';
    			$finalAttendArr[$i]['created_by'] 	= $school_id;
    			$finalAttendArr[$i]['created_at'] 	= date('Y-m-d H:i:s');
    			$i++;
    		}
    		else if( !empty($value['checkin_status']) && array_key_exists( 'checkin_status', $value) )
    		{
    			$finalAttendArr[$i]['student_id']  	= $value['child_id'];
    			$finalAttendArr[$i]['check_in'] 	= !empty($value['checkin_status'] == 1) ?  "true" : null;
    			// $finalAttendArr[$i]['check_out'] 	=  null;
    			$finalAttendArr[$i]['date']  		= $attendance_date_mod;
    			$finalAttendArr[$i]['session'] 		= get_current_session($school_id)->academicsession;
				$finalAttendArr[$i]['session_id'] 		= get_current_session($school_id)->id;
				$finalAttendArr[$i]['school_id'] 	= $school_id;
    			$finalAttendArr[$i]['teacher_id'] 	= $school_id;
    			$finalAttendArr[$i]['class_id'] 	= $class_id;
    			$finalAttendArr[$i]['checkout_type']= 'school-manual';
    			$finalAttendArr[$i]['created_by'] 	= $school_id;
    			$finalAttendArr[$i]['created_at'] 	= date('Y-m-d H:i:s');
    			$i++;
    		}
		}
// prd($finalAttendArr);
    	$rowsInserted=0;
    	foreach ($finalAttendArr as  $value) {
    			$isExist = $this->checkStudentAttendance($value['student_id'],$value['date']);
    			// lq();
    			if($isExist > 0)
    			{
    				$value['updated_at'] = date('Y-m-d H:s:s');
    				$value['updated_by'] = $value['school_id'];
    				$this->db->where(['student_id'=>$value['student_id'],'date'=>$value['date'] ]);
    				$this->db->update('student_attendance',$value);
    				$rowsInserted = $this->db->affected_rows();
    				$rowsInserted++;
    				// continue;
    			}else{
    				$this->db->insert('student_attendance',$value);
    				$rowsInserted = $this->db->affected_rows();
    				$rowsInserted++;
    			}
    	}
    	return ($rowsInserted > 0) ? $rowsInserted : false; 
    	// echo $rowsInserted;
    	// prd($finalAttendArr);
    }
    protected function checkStudentAttendance($student_id,$attendance_date)
    {
    	// $where = array('student_id'=>$student_id, 'date' => $attendance_date , 'check_in'=>'true', 'check_out'=>'true');
    	$where = array('student_id'=>$student_id, 'date' => $attendance_date );
    	$this->db->where($where);
    	return $num_rows = $this->db->get('student_attendance')->num_rows();
    }
    public function getStudentAttendanceData()
    {
			$student_id = $this->token->student_id;
			//$student_id=59;
    		if($this->input->get('date') != '')
			{
				$date = $this->input->get('date');
				$attendanceResult = $this->monthly_attendance($student_id,$date,'date');
				// $studentLeave = $this->student_dayoff($student_id,$date,'date');
				 return ['studentAttendance' => $attendanceResult , 'total_work_days' => 0,'attended_days' =>0,'absent_days' =>0];
			}
			if( empty($this->input->get('month') ) )
			{
				return false;
			}
			if($this->input->get('month') != '')
			{
					$monthYear 			    =  $this->input->get('month');
		     		$monthYear 			    = explode("-", $monthYear);
		     		$month 				    = ($monthYear[1] ? $monthYear[1] : date('m'));
		     		$year 				    = ($monthYear[0] ? $monthYear[0] : date('Y'));
	         	 	$getMonthData   	  	= getCurrentMonthDaysDetails($month,$year,'');
	         	 	
	         	 	$holidays    			= array_unique(school_monthly_holiday($month,$year));
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
					$weekendHolidays    	= $this->getCurrentMonthWeekendOff($month,$year);
	         	 	$totalHolidays 			= array_merge($weekendHolidays,$holidays);
	         	 	
	         	 	$getSelectedMonthData   = $this->getSelectedMonthDates($month,$year);

				 	$totalHolidays  	    = $totalHolidays; 
				 	$selected_month_dates   = $this->getSelectedMonthDates($month,$year); 

	         	 	$current_month_date     = 			$getMonthData['current_month_dates']; 
				 	// pr($selected_month_dates);
	     //     	 	prd($totalHolidays);
	           		$total_work_days       	= ( count($selected_month_dates) - count($totalHolidays));
				    $attendanceDates 		= array_diff($getSelectedMonthData, $totalHolidays);
				  
				  $studentAttendance = array();
				  $studentAttendance  = $this->monthly_attendance($student_id, $this->input->get('month'), 'month' );
				 // print_r($studentAttendance);die;
	         	 	  $mySttudent = array();
	         	 	  foreach ($studentAttendance as $student) {
	         	 	  		$mySttudent[$student->date]  = $student;
	         	 	  }

	         	 	$finalAttendArr=array();
				  	$i=0;
					  $totalPresent=0;
					  //print_r($mySttudent);die;
				    // $newDataArr = array();
					foreach($attendanceDates as $date){
						if( !in_array($date, array_keys($mySttudent)))
						{
							$finalAttendArr[$i]['status']  = 'Absent';
							$finalAttendArr[$i]['date']  = $date;
						}else{
							$finalAttendArr[$i]['status']  = 'Present';
							$finalAttendArr[$i]['date']  = $date;
							$totalPresent++;
						}
							$finalAttendArr[$i]['user_type']  = 'Parent';
						$i++;
					}
					//print_r($totalPresent);die;
		    return ['studentAttendance' => $finalAttendArr , 'total_work_days' => $total_work_days,'attended_days' => $totalPresent,'absent_days' => $total_work_days - $totalPresent];
			}
    }
    private function monthly_attendance($student_id,$date,$type)
	{
		if($type == 'month')
		{
        	$this->db->where("date like '$date%'");
		}
		if($type == 'date')
		{
        	$this->db->where("date",$date);
		}
		$this->db->select("student_id,check_in,check_out,checkout_type,date");
	    $this->db->where(['student_id' => $student_id,'check_in' => 'true' ]);
		$query = $this->db->get('student_attendance');
		//echo $this->db->last_query();die;
	        if($query->num_rows() > 0)
	        {
	            return $query->result();
	        }
	        else
	        {
	        	return array();
	             //return array('user_type'=>'Parent','checkin_time'=>'','checkout_time'=>'','date'=>$date,'status'=>'Absent');
	        }
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
    
    
    public function getStudentsCheckInCheckOut($school_id, $teacherId,$classID,$studentID,$date) 
    {
        if(empty($school_id) || empty($teacherId) || empty($classID) || empty($studentID))
        return false;
        $dataArray = array();
        $this->db->select("*");
        $this->db->where(['sa.school_id'=>$school_id,'sa.student_id'=>$studentID,'sa.class_id'=>$classID,'sa.teacher_id'=>$teacherId,'date(sa.created_at)'=>$date]);
        $query = $this->db->get('student_attendance as sa');
        //echo $this->db->last_query();die;
        if ($query->num_rows() > 0) {
            $result = (array) $query->row();
           
            if(($result['check_in']=='true' || $result['check_in'] =='1') && ($result['check_out']=='true' || $result['check_out'] =='1') ){
             $dataArray['check_in'] =  $result['check_in'];  
             $dataArray['check_in_time'] =  date('h:i a',strtotime($result['created_at']));
             $dataArray['check_out'] =  $result['check_out'];  
             $dataArray['check_out_time'] =  date('h:i a',strtotime($result['updated_at']));
            }
            else if(($result['check_in']=='true' || $result['check_in'] =='1') && ($result['check_out']=='false' || $result['check_out'] =='')){
             $dataArray['check_in'] =  $result['check_in'];  
             $dataArray['check_in_time'] =  date('h:i a',strtotime($result['created_at']));
             $dataArray['check_out'] =  "";  
             $dataArray['check_out_time'] = "";   
            }
            else if(($result['check_in']=='false' || $result['check_in'] =='') && ($result['check_out']=='true' || $result['check_out'] =='1')){
             $dataArray['check_in'] =  "";  
             $dataArray['check_in_time'] =  "";
             $dataArray['check_out'] =  $result['check_out'];  
             $dataArray['check_out_time'] =  date('h:i a',strtotime($result['updated_at']));
            }
            else if(($result['check_in']=='false' || $result['check_in'] =='') && ($result['check_out']=='false' || $result['check_out'] =='')){
             $dataArray['check_in'] = "";  
             $dataArray['check_in_time'] =  date('h:i a',strtotime($result['created_at']));
             $dataArray['check_out'] =  "";  
             $dataArray['check_out_time'] = "";   
            }
            return $dataArray;
          
        } else {
            return false;
        }
    }

}		