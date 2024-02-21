<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Timetable_model extends CI_Model {
    public function getClassScheduleList($teacher_id='',$school_id='',$class_id='')
    {
        $days = ['Monday','Tuesday','Wednesday','Thursday','Friday','Saturday']; 
        $this->db->select("DISTINCT(tt.day_name)");
        $this->db->from("time_table tt");
       // $this->db->join("teacher tc","tc.id = tt.teacher_id","LEFT");
        //$this->db->join("subjects sb","sb.id = tt.subject_id","LEFT");
        $this->db->where(['tt.school_id'=>$school_id ,'tt.teacher_id'=>$teacher_id]);
        if($class_id!=''){
            $this->db->where('tt.class_id',$class_id);
        }
        $query = $this->db->get();
        //echo $this->db->last_query();
        if($query->num_rows() > 0)
        {
            $data = $query->result_array();
            $daysAux = array();
            foreach($data as $k=>$v) {
                $key = array_search($v['day_name'], $days);
                if($key !== FALSE) {
                    $daysAux[$key] = $v['day_name'];
                }
            }
            ksort($daysAux);
            $responseData = array();
            $i=0;
            foreach ($daysAux as  $value) {
            $responseData[$i]['day_name']=$value;
            $luctureData = $this->getLectureDetails($value,$teacher_id,$school_id,$class_id);
            $responseData[$i]['luctureData'] = $luctureData;
           $i++; }
            return $responseData;
        }
        else
        {
           return array();
        }
    }
    public function getLectureDetails($day_name,$teacher_id,$school_id,$class_id)
    {
        $sql="SET sql_mode = ''";
        $this->db->query($sql);
        $this->db->select("sp.name as ltname,sp.start_time,sp.end_time,CONCAT(c.class,' ',c.section) as classname,su.subject");
        $this->db->from("time_table tt");
        $this->db->join("schedule_periods sp","tt.period_id = sp.id","LEFT");
        $this->db->join("class c","tt.class_id = c.id","LEFT");
        $this->db->join("subjects su","su.id = tt.subject_id","LEFT");
        $this->db->where([ 'tt.day_name'=> $day_name ,'tt.teacher_id'=> $teacher_id ,'tt.school_id'=> $school_id]);
        if($class_id!=''){
            $this->db->where('tt.class_id',$class_id);
        }
        $this->db->order_by("STR_TO_DATE(sp.start_time, '%l:%i %p')");
        $query = $this->db->get();
        //echo $this->db->last_query();
        if($query->num_rows()>0)
        {
             $result = $query->result_array();
             return $result;
        }else{
            return array();
        }
    }
    public function getTeacherClass($teacher_id='',$school_id='')
    {
        $this->db->select("c.id,CONCAT(c.class,' ',c.section) as classname");
        $this->db->from("class c");
        $this->db->join("subjects su","c.id = su.class","INNER");
        $this->db->where([ 'su.teacher'=> $teacher_id ,'su.schoolId'=> $school_id]);
        $this->db->group_by('c.id');
        $query = $this->db->get();
        if($query->num_rows()>0)
        {
             $result = $query->result_array();
             return $result;
        }else{
            return array();
        }
    }
}
