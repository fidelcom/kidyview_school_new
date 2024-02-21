<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Timetable_model extends CI_Model {
    public function getClassScheduleList($school_id='',$class_id='')
    {
        $days = ['Monday','Tuesday','Wednesday','Thursday','Friday','Saturday']; 
        $this->db->select("tt.*,CONCAT(tc.teacherfname,' ',tc.teacherlname) as teacher_name,sb.subject");
        $this->db->from("time_table tt");
        $this->db->join("teacher tc","tc.id = tt.teacher_id","LEFT");
        $this->db->join("subjects sb","sb.id = tt.subject_id","LEFT");
        $this->db->where([ 'tt.class_id'=> $class_id ,'tt.school_id'=>$school_id ]);
        $query = $this->db->get();
        if($query->num_rows() > 0)
        {
            $data = $query->result();
            $responseData = array();
            foreach ($data as  $value) {
            $timeData = $this->getLectureTime($value->period_id,$value->school_id);
            $value->start_time=$timeData->start_time;
            $value->end_time=$timeData->end_time;
                if( isset($responseData[$value->day_name]) ){
                    array_push($responseData[$value->day_name], $value);
                }else{
                    $responseData[$value->day_name] = array();
                    array_push($responseData[$value->day_name], $value);
                }
            }
            return $responseData;
        }
        else
        {
           return array();
        }
    }
    protected function getLectureTime($period_id,$school_id)
    {

        $this->db->select("sp.id as period_id,sp.start_time,sp.end_time");
        $this->db->from("schedule_periods sp");
        // $this->db->join("schedule_periods sp","sp.schedule_id = s.id","LEFT");
        // $this->db->join("schooltype st","st.value = s.school_type","LEFT");
        $this->db->where([ 'sp.id'=> $period_id ,'sp.school_id'=> $school_id]);
        $query = $this->db->get();
        if($query->num_rows()>0)
        {
             $result = $query->result();
             return $result[0];
        }else{
            return false;
        }
    }
}
