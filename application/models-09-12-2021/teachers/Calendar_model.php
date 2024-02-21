<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
	
	class Calendar_model extends CI_Model
	{
	
		public function getAllCalendarData($id,$calendardate='',$iscalendardata='',$classID='',$teacherID='')
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
			$dataEvent = $this->event_calendar_data($id,$calendardate,$iscalendardata,$classID,$teacherID);
			if(!empty($dataEvent))
			{
				foreach ($dataEvent as $tmp)
				{
					array_push($data,$tmp);
				}
				
			}  
			$dataBirthday = $this->studentBirthday_calendar_data($id,$calendardate,$iscalendardata,$teacherID);
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
		
		public function event_calendar_data($school_id='',$calendardate='',$iscalendardata='',$classID='',$teacherID=''){
			if($calendardate!=''){
				$calendardate=$calendardate;
				}else{
				$calendardate=date('Y-m-d');
			}
			$this->db->select("title,date as start,time");
			$this->db->where("(FIND_IN_SET(0,visibility)IS TRUE OR visibility = '')");
			$this->db->where("(teacher_id = $teacherID OR teacher_id = 0)");
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
		
		
		public function studentBirthday_calendar_data($school_id='',$calendardate,$iscalendardata,$teacherID){  
			$assignedClass = $this->getAssignedClass($teacherID);
			//print_r($assignedClass);die;
			if($assignedClass != false)
			{
			if($calendardate!=''){
				//$calendardate= $str1 = substr($calendardate, 4);
				$calendardate = explode('-',$calendardate);
                $calendardate = '-'.$calendardate[1].'-'.$calendardate[2];
				}else{
				$calendardate=date('-m-d');
			}      
			$this->db->select("concat(childfname,childmname,childlname) as title,childdob as start");
			$this->db->where('schoolId',$school_id);
			$this->db->where("FIND_IN_SET(childclass,'$assignedClass') AND 1");
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
        else
        {
            return array();
        }
		}
		public function studentBirthday_data(){        
			$assignedClass = $this->getAssignedClass();
			//print_r($assignedClass);die;
			if($assignedClass != false)
			{
				$this->db->select("concat(childfname,childmname,childlname) as title,childdob as for_date,'student_birthday' as data_type");
				$this->db->where('schoolId',$this->token->school_id);
				$this->db->where("FIND_IN_SET(childclass,'$assignedClass') AND 1");
				if($this->input->get('date') != '')
				{
					$selectesDate = explode('-',$this->input->get('date'));
					$tmpDate = '-'.$selectesDate[1].'-'.$selectesDate[2];
					$this->db->where("childdob like '%$tmpDate'");
				}
				else
				{
					$tmpDate = date("-m-d");
					$this->db->where("childdob like '%$tmpDate'");
				}
				$query = $this->db->get('child');            
				
				if($query->num_rows() > 0)
				{
					return $query->result();
				}
				else
				{
					return array();
				}
			}
			else
			{
				return array();
			}
		}
		
		public function getAssignedClass($teacherID){    
			$this->db->select('t.assignclassteacher');
			$this->db->from('teacher t');
			$this->db->where('t.id', $teacherID);
			$query = $this->db->get();
			if($query->num_rows() > 0)
			{
				$classList = $query->row()->assignclassteacher;
				
				return $classList;
			}
			else
			{
				return false;
			}
		}
		
	}		