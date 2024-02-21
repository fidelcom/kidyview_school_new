<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Exam_model extends CI_Model {
    
    function getExamList($schoolID='',$teacherID='') {
        $curDateTime=date('Y-m-d H:i:s');
        $curDate=date('Y-m-d');
        $subject=$this->getSubject($teacherID);
        $this->db->select("CONCAT(FLOOR(e.exam_duration/60),' hours ',MOD(e.exam_duration,60),' minutes') as examduration,e.*,CONCAT(c.class,' ' ,c.section) as classname,s.subject");
        $this->db->from("exam e");
        $this->db->join("class c","e.class_id=c.id",'LEFT');
        $this->db->join("subjects s","e.subject_id=s.id",'LEFT');
        //$this->db->join("(select * from exam_answer where school_id='".$schoolID."' AND subject_id IN (".implode(',',$subject).")) exa","e.id=exa.exam_id",'LEFT');
        $this->db->join("exam_answer exa","e.id=exa.id",'INNER');
        $this->db->where("e.school_id",$schoolID);
        $this->db->where_in("e.subject_id",$subject);
        $this->db->where("e.status",'1');
        $this->db->order_by("e.exam_date");               
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            $data = $query->result();
            for($i=0; $i < count($data); $i++)
            { 
                $examDate=$data[$i]->exam_date.' '.$data[$i]->exam_time;
                if($examDate>$curDateTime){
                    $data[$i]->exam_status="Not started";
                }elseif($examDate<=$curDateTime && ($curDate<=$data[$i]->last_submission_date)){
                    $data[$i]->exam_status="Ongoing";
                }elseif($curDate>$data[$i]->last_submission_date){
                    $data[$i]->exam_status="Locked";
                }
            }
            return $data;
        } else {
            return array();
        }
    }
    public function getSubject($teacher_id=''){
			
        $sql='select id from subjects where teacher="'.$teacher_id.'"';
        $query=$this->db->query($sql);
        if($query->num_rows() > 0)
        {
            $data_user = $query->result_array();
            $subArr=array();
			if(!empty($data_user)){
				foreach($data_user as $subject){
					$subArr[]=$subject['id'];
				}
			}
         return $subArr;
            
        }else{
            return array('');
        }
    }

    function getExamDetails($examID='',$schoolID='') {
        $curDateTime=date('Y-m-d H:i:s');
        $curDate=date('Y-m-d');
        $this->db->select("CONCAT(FLOOR(e.exam_duration/60),' hours ',MOD(e.exam_duration,60),' minutes') as examduration,e.*,CONCAT(c.class,' ' ,c.section) as classname,s.subject");
        $this->db->from("exam e");
        $this->db->join("class c","e.class_id=c.id",'LEFT');
        $this->db->join("subjects s","e.subject_id=s.id",'LEFT');
        $this->db->where("e.school_id",$schoolID);
        $this->db->where("e.id",$examID);
        $this->db->order_by("e.exam_date","DESC");               
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            $data = $query->row();
            $examDate=$data->exam_date.' '.$data->exam_time;
            if($examDate>$curDateTime){
                $data->exam_status="Not started";
            }elseif($examDate<=$curDateTime && ($curDate<=$data->last_submission_date)){
                $data->exam_status="Ongoing";
            }elseif($curDate>$data->last_submission_date){
                $data->exam_status="Locked";
            }
            
            return $data;
        } else {
            return array();
        }
    }
    function getSubmittedExamList($schoolID='',$teacherID='') {
        $curDateTime=date('Y-m-d H:i:s');
        $curDate=date('Y-m-d');
        $subject=$this->getSubject($teacherID);
        $this->db->select("CONCAT(FLOOR(e.exam_duration/60),' hours ',MOD(e.exam_duration,60),' minutes') as examduration,e.*,CONCAT(c.class,' ' ,c.section) as classname,s.subject");
        $this->db->from("exam e");
        $this->db->join("class c","e.class_id=c.id",'LEFT');
        $this->db->join("subjects s","e.subject_id=s.id",'LEFT');
        $this->db->join("(select * from exam_answer where school_id='".$schoolID."' AND subject_id IN (".implode(',',$subject).")) exa","e.id=exa.exam_id",'LEFT');
        $this->db->where("e.school_id",$schoolID);
        $this->db->where_in("e.subject_id",$subject);
        $this->db->where("e.status",'1');
        $this->db->order_by("e.exam_date");               
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            $data = $query->result();
            return $data;
        } else {
            return array();
        }
    }
    
    
    
}
