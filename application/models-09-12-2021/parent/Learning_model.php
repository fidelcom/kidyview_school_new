<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Learning_model extends CI_Model {
    public function studentClass()
    {
        $this->db->select("c.childclass");
        $this->db->from("child c");
        $this->db->where("c.id",$this->token->student_id);        
        $query = $this->db->get();
        return $query->row()->childclass;
    }
    public function learningDevelopmentCategory($class_id)
    {
        $this->db->select("id,name");
        $this->db->where('class_id',$class_id);
        $this->db->where('school_id',$this->token->school_id);
        $query = $this->db->get('learning_development_category');
        
        if($query->num_rows() > 0)
        {
            return $query->result();
        }
        else
        {
            return array();
        }
    }
    public function learningDevelopmentQuestion($category_id)
    {
        $this->db->select("id,question,options,option_type");
        $this->db->where('category_id',$category_id);
        $query = $this->db->get('learning_development_question');
        
        if($query->num_rows() > 0)
        {
            $data = $query->result();
            
            for($i=0; $i < count($data); $i++)
            {
                $data[$i]->options = json_decode($data[$i]->options);
                array_push($data[$i]->options,"Other");
            }
            return $data;
        }
        else
        {
            return array();
        }
    }
    public function learningDevelopmentInfo($category_id)
    {
        $this->db->select("title,detail");
        $this->db->where('category_id',$category_id);
        $query = $this->db->get('learning_development_info');
        
        if($query->num_rows() > 0)
        {
            return $query->result();
        }
        else
        {
            return array();
        }
    }
    
    public function saveLearningDevelopment($data)
    {
        $formData = array(
                "question_id"=>$data['question_id'],
                "student_id"=>$data['student_id'],
                "teacher_id"=>$this->token->user_id,
                "answer"=>$data['answer'],
                "other_answer"=>$data['other_answer'],
                "created_date"=>date("Y-m-d")
            );

            $this->db->insert("learning_development_report",$formData);
            if($this->db->affected_rows() > 0)
            {
                return true;
            }
            else
            {
                return false;
            }
    }
    
    public function learningDevelopmentAnswer($data)
    {
        $this->db->select("ldr.answer,ldr.other_answer");
        $this->db->from("learning_development_report ldr");        
        $this->db->where("question_id",$data['question_id']);
        $this->db->where("student_id",$data['student_id']);
        $this->db->order_by('id',"DESC");
        $query = $this->db->get();
        
        if($query->num_rows() > 0)
        {
            return $query->row();
        }
        else
        {
            return false;
        }
    }
    public function learningDevelopmentList()
    {
        $this->db->select("ldr.*,ldq.question, ldq.options,ldq.option_type,ldq.category_id, ldc.name as category_name, c.childfname, c.childmname, c.childlname");
        $this->db->from("learning_development_report ldr");
        $this->db->join("learning_development_question ldq","ldr.question_id = ldq.id","LEFT");
        $this->db->join("child c","ldr.student_id = c.id","LEFT");
        $this->db->join("learning_development_category ldc","ldq.category_id = ldc.id","LEFT");
        $this->db->where("c.id",$this->token->student_id);
        $query = $this->db->get();
        
        if($query->num_rows() > 0)
        {
            return $query->result();
        }
        else
        {
            return array();
        }
    }    
}


