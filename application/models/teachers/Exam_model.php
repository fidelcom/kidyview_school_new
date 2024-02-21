<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Exam_model extends CI_Model {
    
    function getExamList($schoolID='',$teacherID='',$classID,$subjectID='',$status='') {
        $currentSession = get_current_session($schoolID);
        $session_id = isset($currentSession) && $currentSession->id?$currentSession->id:'';
        $curDateTime=date('Y-m-d H:i:s');
        $curDate=date('Y-m-d');
        $subject=$this->getSubject($teacherID);
        $this->db->select("CONCAT(FLOOR(e.exam_duration/60),' hours ',MOD(e.exam_duration,60),' minutes') as examduration,e.*,CONCAT(c.class,' ' ,c.section) as classname,s.subject");
        $this->db->from("exam e");
        $this->db->join("class c","e.class_id=c.id",'LEFT');
        $this->db->join("subjects s","e.subject_id=s.id",'LEFT');
        //$this->db->join("(select * from exam_answer where school_id='".$schoolID."' AND subject_id IN (".implode(',',$subject).")) exa","e.id=exa.exam_id",'LEFT');
        $this->db->where("e.school_id",$schoolID);
        if($classID!=''){
            $this->db->where("e.class_id",$classID);
        }
        if($subjectID!=''){
            $this->db->where("e.subject_id",$subjectID);
        }else{
            $this->db->where_in("e.subject_id",$subject);
        }
        if($status=='Locked'){
            $this->db->where("e.last_submission_date <", $curDate); 
        }
        if($status=='Not started'){
            $this->db->where("e.exam_date_time >", $curDateTime);
        }
        if($status=='Ongoing'){
            $this->db->where("e.exam_date_time <=", $curDateTime);
            $this->db->where("e.last_submission_date >=", $curDate);
        }
        $this->db->where("e.session_id",$session_id);
        $this->db->where("e.status",'1');
        $this->db->order_by("e.exam_date_time");               
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
        $this->db->select("CONCAT(FLOOR(e.exam_duration/60),' hours ',MOD(e.exam_duration,60),' minutes') as examduration,e.*,CONCAT(c.class,' ' ,c.section) as classname,s.subject,CONCAT(ch.childfname,' ' ,ch.childmname,' ' ,ch.childlname) as studentname,exa.id as answerid,exa.start_time as submitted_date,emo.id as obtain_id,emo.marks_obtained,emo.percentage,emo.grade");
        $this->db->from("exam e");
        $this->db->join("exam_answer exa","e.id=exa.exam_id",'INNER');
        $this->db->join("child ch","ch.id=exa.user_id",'LEFT');
        $this->db->join("class c","e.class_id=c.id",'LEFT');
        $this->db->join("subjects s","e.subject_id=s.id",'LEFT');
        $this->db->join("exam_marks_obtain emo","exa.id=emo.answer_id",'LEFT');
        $this->db->where("e.school_id",$schoolID);
        $this->db->where_in("e.subject_id",$subject);
        $this->db->where("e.status",'1');
        $this->db->order_by("exa.start_time");               
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            $data = $query->result();
            for($i=0; $i < count($data); $i++)
            {
            $data[$i]->submitted_date =date('d D Y H:i:s',strtotime($data[$i]->submitted_date));
            if($data[$i]->obtain_id!=null){
                if($data[$i]->exam_category=='graded'){
                    $data[$i]->exam_status="Graded";
                }else{
                    $data[$i]->exam_status="Mark Received"; 
                }
            }else{
                $data[$i]->exam_status="Submitted";  
            }   
        }
            return $data;
        } else {
            return array();
        }
    }
    function getSubmittedExamDetails($submitExamID='',$schoolID='') {
        $this->db->select("CONCAT(FLOOR(e.exam_duration/60),' hours ',MOD(e.exam_duration,60),' minutes') as examduration,e.*,CONCAT(c.class,' ' ,c.section) as classname,s.subject,s.subject_code,CONCAT(ch.childfname,' ' ,ch.childmname,' ' ,ch.childlname) as studentname,ch.childphoto,exa.id as answerid,exa.start_time as submitted_date,emo.id as obtain_id,emo.marks_obtained,emo.percentage,emo.grade");
        $this->db->from("exam_answer exa");
        $this->db->join("exam e","exa.exam_id=e.id",'INNER');
        $this->db->join("child ch","ch.id=exa.user_id",'LEFT');
        $this->db->join("class c","e.class_id=c.id",'LEFT');
        $this->db->join("subjects s","e.subject_id=s.id",'LEFT');
        $this->db->join("exam_marks_obtain emo","exa.id=emo.answer_id",'LEFT');
        $this->db->where("e.school_id",$schoolID);
        $this->db->where("exa.id",$submitExamID);              
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            $data = $query->row();
            $getUserExamAnswerData=$this->getUserExamAnswerData($data->answerid,$data->id);
            $data->getUserExamAnswerData=$getUserExamAnswerData;
            $data->submitted_date =date('d D Y H:i:s',strtotime($data->submitted_date));
            if($data->obtain_id!=null){
                if($data->exam_category=='graded'){
                    $data->exam_status="Graded";
                }else{
                    $data->exam_status="Mark Received"; 
                }
            }else{
                $data->exam_status="Submitted";  
            }
            return $data;
        } else {
            return array();
        }
    }
    function getUserExamAnswerData($answerID='',$examID='') {
        $this->db->select("*");
        $this->db->from("exam_question");
        $this->db->where("exam_id",$examID);              
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            $data = $query->result();
            for($i=0; $i < count($data); $i++)
            { 
                $answer_value= $this->getUserAnswer($answerID,$data[$i]->id); 
                $data[$i]->option_value=json_decode($answer_value->answer_value);
                $data[$i]->user_answer_id=$answer_value->id;
            }
            return $data;
        } else {
            return array();
        }
    
}
function getUserAnswer($answerID='',$questionID='') {
    $this->db->select("id,answer_value");
    $this->db->from("exam_user_question_answer");
    $this->db->where("question_id",$questionID); 
    $this->db->where("answer_id",$answerID);             
    $query = $this->db->get();
    if ($query->num_rows() > 0) {
        $data = $query->row();
        return $data;
    } else {
        return '';
    }
}
    
    
}
