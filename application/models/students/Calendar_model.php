<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
	
	class Calendar_model extends CI_Model
	{
	
		public function getAllCalendarData($id,$calendardate='',$iscalendardata='',$classID='',$studentID='')
		{
			$data = array();        
			$dataHoliday = $this->holiday_calendar_data($id,$calendardate,$iscalendardata);
			if(!empty($dataHoliday))
			{
				foreach ($dataHoliday as $tmp)
				{
					array_push($data,$tmp);
				}
			}      
			$dataEvent = $this->event_calendar_data($id,$calendardate,$iscalendardata,$classID,$studentID);
			if(!empty($dataEvent))
			{
				foreach ($dataEvent as $tmp)
				{
					array_push($data,$tmp);
				}
				
			}  
			$dataBirthday = $this->studentBirthday_calendar_data($id,$calendardate,$iscalendardata,$classID);
			if(!empty($dataBirthday))
			{
				foreach ($dataBirthday as $tmp)
				{
					array_push($data,$tmp);
				}
				
			}     
			return $data;
		}
		public function holiday_calendar_data($school_id='',$calendardate='',$iscalendardata=''){
			if($calendardate!=''){
				$calendardate=$calendardate;
				}else{
				$calendardate=date('Y-m-d');
			}
			$this->db->select("title,for_date as start");
			$this->db->where('school_id',$school_id);
			if($iscalendardata==0){
				$this->db->where('for_date',$calendardate);
			}
			$query = $this->db->get('holiday');
			if($query->num_rows() > 0)
			{
				$data_user = $query->result_array();
				for($i=0; $i<count($data_user); $i++)
				{
					$data_user[$i]['allday'] = true;
					$data_user[$i]['type'] = "Holiday";
				}
				return $data_user;
			}
			else
			{
				return array();
			}
		}
		
		public function event_calendar_data($school_id='',$calendardate='',$iscalendardata='',$classID='',$studentID=''){
			if($calendardate!=''){
				$calendardate=$calendardate;
				}else{
				$calendardate=date('Y-m-d');
			}
			$this->db->select("title,date as start,time");
			$this->db->where("(FIND_IN_SET(1,visibility) IS TRUE OR (class_id=$classID AND FIND_IN_SET($studentID,child_id)))"); 
			if($iscalendardata==0){
				$this->db->where('date',$calendardate);
			}
			$this->db->where('school_id',$school_id);
			$query = $this->db->get('events');
			if($query->num_rows() > 0)
			{
				$data_user = $query->result_array();
				for($i=0; $i<count($data_user); $i++)
				{
					$data_user[$i]['allday'] = true;
					$data_user[$i]['type'] = "Event";
				}
				return $data_user;
			}
			else
			{
				return array();
			}
		}
		
		
		public function studentBirthday_calendar_data($school_id='',$calendardate,$iscalendardata,$classID){  
			if($calendardate!=''){
				//$calendardate= $str1 = substr($calendardate, 4);
				$calendardate = explode('-',$calendardate);
                $calendardate = '-'.$calendardate[1].'-'.$calendardate[2];
				}else{
				$calendardate=date('-m-d');
			}      
			$this->db->select("concat(childfname,childmname,childlname) as title,childdob as start");
			$this->db->where('schoolId',$school_id);
			$this->db->where('childclass',$classID);
			if($iscalendardata==0){
				
				$this->db->where("childdob like '%$calendardate'");
				
			}
			//$this->db->where('id',28);
			$query = $this->db->get('child');         
			if($query->num_rows() > 0)
			{
				$data_user = $query->result_array();
				for($i=0; $i<count($data_user); $i++)
				{
					$data_user[$i]['allday'] = true;
					$data_user[$i]['type'] = "Birthday";
				}
				return $data_user;
			}
			else
			{
				return array();
			}
			
		}
		
	}		