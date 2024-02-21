<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Exam_model extends CI_Model {
    
    function getExamList($schoolID='',$classID='',$studentID='',$subjectId='',$status='',$session='') {
        $curDateTime=date('Y-m-d H:i:s');
        $curDate=date('Y-m-d');
        $this->db->select("CONCAT(FLOOR(e.exam_duration/60),' hours ',MOD(e.exam_duration,60),' minutes') as examduration,e.*,CONCAT(c.class,' ' ,c.section) as classname,s.subject,exa.id as answerid,exa.no_of_attempt,emo.id as obtain_id,emo.marks_obtained,emo.percentage,emo.grade");
        $this->db->from("exam e");
        $this->db->join("class c","e.class_id=c.id",'LEFT');
        $this->db->join("subjects s","e.subject_id=s.id",'LEFT');
        $this->db->join("(select * from exam_answer where school_id='".$schoolID."' AND class_id='".$classID."' AND user_id='".$studentID."') exa","e.id=exa.exam_id",'LEFT');
        $this->db->join("(select * from  exam_marks_obtain where school_id='".$schoolID."' AND class_id='".$classID."' AND user_id='".$studentID."') emo","e.id=emo.exam_id",'LEFT');
        $this->db->where("e.school_id",$schoolID);
        $this->db->where("e.class_id",$classID);
        if($subjectId!=''){
            $this->db->where("e.subject_id", $subjectId); 
        }
        if($session!=''){
            $this->db->where("e.session", $session); 
        }
        if($status=='Locked'){
            $this->db->where("e.last_submission_date <", $curDate); 
            $this->db->where('e.id NOT IN (SELECT exam_id FROM exam_unlock where school_id='.$schoolID.' AND class_id='.$classID.' AND user_id='.$studentID.')', NULL, FALSE);
        }
        if($status=='Unlock'){
            $this->db->where("e.last_submission_date <", $curDate); 
            $this->db->where('e.id IN (SELECT exam_id FROM exam_unlock where school_id='.$schoolID.' AND class_id='.$classID.' AND user_id='.$studentID.')', NULL, FALSE);
        }
        if($status=='Not started'){
            $this->db->where("e.exam_date_time >", $curDateTime);
        }
        if($status=='Ongoing'){
            $this->db->where("e.exam_date_time <=", $curDateTime);
            $this->db->where("e.last_submission_date >=", $curDate);
            $this->db->where("exa.id=",null);
        }
        if($status=='Completed'){
            $this->db->where("exa.id!=",null);
            $this->db->where("e.exam_category","non-graded");
        }
        if($status=='Graded'){
            $this->db->where("emo.id!=",null);
            $this->db->where("e.exam_category","graded");
        }
        $this->db->where("e.status",'1');
        $this->db->order_by("e.exam_date_time");               
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            $data = $query->result();
            for($i=0; $i < count($data); $i++)
            { 
                $examDate=$data[$i]->exam_date.' '.$data[$i]->exam_time;
                $is_exam_unlock=$this->check_unlock_exam($data[$i]->id,$schoolID,$classID,$studentID);
                if($data[$i]->obtain_id!=null && $data[$i]->exam_category=='graded'){
                    $data[$i]->exam_status="Graded";
                }elseif($is_exam_unlock==1 && $data[$i]->answerid==null){
                    $data[$i]->exam_status="Unlock";
                }elseif($examDate>$curDateTime){
                    $data[$i]->exam_status="Not started";
                }elseif($examDate<=$curDateTime && ($curDate<=$data[$i]->last_submission_date)&& $data[$i]->answerid==null){
                    $data[$i]->exam_status="Ongoing";
                }elseif($data[$i]->answerid!=null){
                    $data[$i]->exam_status="Completed";
                }elseif($curDate>$data[$i]->last_submission_date && $data[$i]->answerid==null){
                    $data[$i]->exam_status="Locked";
                }
            }
            return $data;
        } else {
            return array();
        }
    }
    function check_unlock_exam($examID,$schoolID,$classID,$studentID){
        $this->db->select("id");
        $this->db->from("exam_unlock");
        $this->db->where("exam_id",$examID); 
        $this->db->where("school_id",$schoolID);
        $this->db->where("class_id",$classID);
        $this->db->where("user_id",$studentID);              
        $query = $this->db->get();
       // echo $this->db->last_query();
        return $query->num_rows();
    }

    function getExamDetails($examID='',$schoolID='',$classID='',$studentID='') {
        $curDateTime=date('Y-m-d H:i:s');
        $curDate=date('Y-m-d');
        $this->db->select("CONCAT(FLOOR(e.exam_duration/60),' hours ',MOD(e.exam_duration,60),' minutes') as examduration,e.*,CONCAT(c.class,' ' ,c.section) as classname,s.subject,exa.id as answerid,exa.no_of_attempt,exa.answer_duration,exa.start_time,exa.end_time,emo.id as obtain_id,emo.marks_obtained,emo.percentage,emo.grade");
        $this->db->from("exam e");
        $this->db->join("class c","e.class_id=c.id",'LEFT');
        $this->db->join("subjects s","e.subject_id=s.id",'LEFT');
        $this->db->join("(select * from exam_answer where exam_id='".$examID."' AND user_id='".$studentID."') exa","e.id=exa.exam_id",'LEFT');
        $this->db->join("(select * from  exam_marks_obtain where school_id='".$schoolID."' AND class_id='".$classID."' AND user_id='".$studentID."') emo","e.id=emo.exam_id",'LEFT');
        $this->db->where("e.school_id",$schoolID);
        $this->db->where("e.class_id",$classID);
        $this->db->where("e.id",$examID);
        $this->db->order_by("e.exam_date","DESC");               
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            $data = $query->row();
            $examDate=$data->exam_date.' '.$data->exam_time;
            $is_exam_unlock=$this->check_unlock_exam($examID,$schoolID,$classID,$studentID);
            if($data->obtain_id!=null && $data->exam_category=='graded'){
                $data->exam_status="Graded";
            }elseif($is_exam_unlock==1 && $data->answerid==null){
                $data->exam_status="Unlock";
            }elseif($examDate>$curDateTime){
                $data->exam_status="Not started";
            }elseif($examDate<=$curDateTime && ($curDate<=$data->last_submission_date)&& $data->answerid==null){
                $data->exam_status="Ongoing";
            }elseif($data->answerid!=null){
                $data->exam_status="Completed";
            }elseif($curDate>$data->last_submission_date && $data->answerid==null){
                $data->exam_status="Locked";
            }
            if($data->answerid!=''){
            $getUserExamAnswerData=$this->getUserExamAnswerData($data->answerid,$data->id);
            $data->getUserExamAnswerData=$getUserExamAnswerData;
            }else{
            $examQuestionData=$this->getExamQuestion($data->id);
            $data->getUserExamAnswerData=$examQuestionData;
            }
            return $data;
        } else {
            return array();
        }
    }
    function getExamQuestion($examID='') {
        $this->db->select("*");
        $this->db->from("exam_question");
        $this->db->where("exam_id",$examID);              
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            $data = $query->result();
            for($i=0; $i < count($data); $i++)
            { 
    
                if($data[$i]->option_value){
                //$data[$i]->option_value= json_decode($data[$i]->option_value); 
                $option_value= json_decode($data[$i]->option_value); 
                for($j=0; $j<count($option_value);$j++){
                    if($data[$i]->question_type=='textual'){
                        $option_value[$j]->isUserAnswer= "";
                    }else{
                        $option_value[$j]->isUserAnswer= "false";   
                    }
                }
                $data[$i]->option_value=$option_value;
                }
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
                   // print_r($answer_value);die;
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
    public function add($data,$tbl_name)
    {
        $this->db->insert_batch($tbl_name,$data);
        return $this->db->insert_id();
    }

    public function update($data,$tbl_name,$where=array())
    {
       // $this->db->where($where);
        $this->db->update_batch($tbl_name,$data,'id');
        return true;
    }
    function checkExamStatus($examID='',$schoolID='',$classID='',$studentID='') {
        $curDate=date('Y-m-d');
        $curDateTime=date('Y-m-d H:i:s');
        $this->db->select("e.exam_time,e.last_submission_date,e.exam_duration,e.exam_time,e.exam_attempt_no,exa.id as answerid,exa.no_of_attempt,exa.answer_duration,exa.end_time");
        $this->db->from("exam e");
        $this->db->join("(select * from exam_answer where exam_id='".$examID."'AND school_id='".$schoolID."' AND user_id='".$studentID."') exa","e.id=exa.exam_id",'LEFT');
        $this->db->where("e.school_id",$schoolID);
        $this->db->where("e.class_id",$classID);
        $this->db->where("e.id",$examID);               
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            $data = $query->row();
    
            $is_exam_unlock=$this->check_unlock_exam($examID,$schoolID,$classID,$studentID);
            if($is_exam_unlock==1){
                $return=1;
            }elseif($curDate>$data->last_submission_date){
            $return="Your exam submission date has been over!!.";
            }elseif($data->no_of_attempt>=$data->exam_attempt_no && $data->exam_attempt_no>0){
                $return="You have exceeded the maximum exam attempt limit!!";
            }elseif($data->answerid!='' && $curDateTime>$data->end_time){
                $return="Your exam time has been over!!";
            }else{
                $return=1;
            }
            return $return;
        } else {
            return 0;
        }
    }
    
}
