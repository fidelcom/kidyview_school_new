<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Calendar_model extends CI_Model {
    public function allData(){
        $data = array();        
        $dataHoliday = $this->holiday_data();
        if(!empty($dataHoliday))
        {
            foreach ($dataHoliday as $tmp)
            {
                array_push($data,$tmp);
            }
        }      
        $dataEvent = $this->event_data();
        if(!empty($dataEvent))
        {
            foreach ($dataEvent as $tmp)
            {
                array_push($data,$tmp);
            }
        }      
        $dataStudent = $this->studentBirthday_data();
        // lq();
        if(!empty($dataStudent))
        {
            foreach ($dataStudent as $tmp)
            {
                array_push($data,$tmp);
            }
        }      
//        $dataTeacher = $this->teacherBirthday_data();
//        if(!empty($dataTeacher))
//        {
//            foreach ($dataTeacher as $tmp)
//            {
//                array_push($data,$tmp);
//            }
//        }      
        // prd($data);
        return $data;
    }
    
    public function holiday_data(){
        $this->db->select("title,for_date,'holiday' as data_type");
        $this->db->where('school_id',$this->token->school_id);
        if($this->input->get('date') != '')
        {
              // $tmpDate = $this->input->get('date');
            // $this->db->where('for_date',$this->input->get('date'));
             $month = $this->input->get('date');
               $this->db->where("for_date like '$month%'");
        }
        // elseif ($this->input->get('month') != '') {
        //        $month = $this->input->get('month');
        //        $this->db->where("for_date like '$month%'");
        // }
        else
        {
            $currentMonth = date('Y-m');
            $this->db->where("for_date like '$currentMonth%'");
            // $this->db->where('for_date',date("Y-m-d"));
        }
        $query = $this->db->get('holiday');
        if($query->num_rows() > 0)
        {
            return $query->result();
        }
        else
        {
            return array();
        }
    }
    public function event_data(){
        $this->db->select("title,date as for_date,'event' as data_type");
        $this->db->where('school_id',$this->token->school_id);
        $this->db->where("(FIND_IN_SET(0,visibility)IS TRUE OR visibility = '')"); 
        $teacherID = $this->token->user_id;
        $this->db->where("(teacher_id = $teacherID OR teacher_id = 0)");

        if($this->input->get('date') != '')
        {
            // $this->db->where('date',$this->input->get('date'));
              // $tmpDate = $this->input->get('date');
               // $this->db->where("date like '$tmpDate%'");
               $month = $this->input->get('date');
               $this->db->where("date like '$month%'");
            // $this->db->where('date',$this->input->get('date'));
        }
        // elseif ($this->input->get('month') !='') {
        //        $month = $this->input->get('month');
        //        $this->db->where("date like '$month%'");
        // }
        else
        {
            // $this->db->where('date',date("Y-m-d"));
            $currentMonth = date('Y-m');
            $this->db->where("date like '$currentMonth%'");
        }
        $query = $this->db->get('events');
        if($query->num_rows() > 0)
        {
            return $query->result();
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
                // $selectesDate = explode('-',$this->input->get('date'));
                // $tmpDate = '-'.$selectesDate[1].'-'.$selectesDate[2];
                // $this->db->where("childdob like '%$tmpDate'");
                 // $tmpDate = $selectesDate[0].'-'.$selectesDate[1];
                // $this->db->where("childdob like '$tmpDate%'");
                 // $this->db->where('childdob',$this->input->get('date'));
                $calendardate = explode('-',$this->input->get('date'));
                if(count($calendardate)>2){
                    $month = '-'.$calendardate[1].'-'.$calendardate[2];
                    $this->db->where("childdob like '%$month'");
                }else{
                    //$month = $calendardate[0].'-'.$calendardate[1];
                    $month = '-'.$calendardate[1].'-';
                    $this->db->where("childdob like '%$month%'");

                }
            }
            else
            {
                //$tmpDate = date("-m-d");
                //$this->db->where("childdob like '%$tmpDate'");
                $tmpDate = date("Y-m");
                $this->db->where("childdob like '$tmpDate%'");
            }
            $query = $this->db->get('child');    
            //echo $this->db->last_query();die;        
            // lq();
            if($query->num_rows() > 0)
            {
                if(count($calendardate)>2){
                    return $query->result();
                }else{
                    $dataUser= $query->result();
                    for($i = 0 ; $i < count($dataUser); $i++)
                    {
                        $date=explode('-',$dataUser[$i]->for_date);
                        $dataUser[$i]->for_date = date('Y').'-'.$date[1].'-'.$date[2];
                    }
                    return $dataUser;
                }
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
    public function teacherBirthday_data(){
        $this->db->select("concat(teacherfname,teachermname,teacherlname) as title,date_of_birth as for_date,'teacher_birthday' as data_type");
        $this->db->where('schoolId',$this->token->school_id);
        if($this->input->get('date') != '')
        {
            $selectesDate = explode('-',$this->input->get('date'));
            $tmpDate = '-'.$selectesDate[1].'-'.$selectesDate[2];
            $this->db->where("date_of_birth like '%$tmpDate'");
        }
        else
        {
            $tmpDate = date("-m-d");
            $this->db->where("date_of_birth like '%$tmpDate'");
        }
        $query = $this->db->get('teacher');
        if($query->num_rows() > 0)
        {
            return $query->result();
        }
        else
        {
            return array();
        }
    }
    public function getAssignedClass(){
    // echo $this->token->user_id; die;    
        $this->db->select('t.assignclassteacher');
        $this->db->from('teacher t');
        $this->db->where('t.id', $this->token->user_id);
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
