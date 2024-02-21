<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Assignment_model extends CI_Model {
    public function getSubjectList()
    {
        $this->db->select('s.*,c.class as class_name,c.section,t.teacherfname,t.teachermname,t.teacherlname');
        $this->db->from('subjects s');
        $this->db->join('class c','s.class = c.id','LEFT');
        $this->db->join('teacher t','s.teacher = t.id','LEFT');
        $this->db->where('s.schoolId', $this->token->school_id);
        $this->db->where('s.teacher', $this->token->user_id);
        $this->db->order_by('s.id', 'DESC');
        $query =  $this->db->get();                    

        if($query->result_id->num_rows!=0)
        {
                $data_user = $query->result_array();
                return $data_user;
        }
        else
        {
            return array();
        }
    }
    function add($data) {
        $this->db->insert('assignment', $data);
        return $this->db->insert_id();
    }
    function update($id,$data) {
        $this->db->where('id',$id);
        $this->db->update('assignment', $data);
    }
    function addAttachment($data) {
        $this->db->insert('assignment_attachment', $data);
        return $this->db->insert_id();
    }
    function allData() {
        $schoolId = $this->token->school_id; 
        $teacher_id = $this->token->user_id;
        $session_id= get_current_session($schoolId)->id;
        $this->db->select("a.*");
        $this->db->from("assignment a");
        $this->db->where("a.school_id",$schoolId);
        $this->db->where("a.session_id",$session_id);
        $this->db->where("a.status",1);
        $this->db->order_by("a.id","DESC");
        
        if(isset($_GET['subject_id']))
        {
            if($_GET['subject_id'] != '')
            {
                $this->db->where('subject_id',$_GET['subject_id']);
            }
        }
        
        if (isset($_GET['page'])) 
        {
            $page = $_GET['page'];
            $limit = 10;
            if(isset($_GET['limit']))
            {
                $limit = $_GET['limit'];
            }
            $offset = ($page - 1) * $limit;

            $this->db->limit($limit, $offset);
        }
        
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            $data = $query->result();
            for ($i = 0; $i < count($data); $i++) {
                $this->load->helper('common');
                $data[$i]->created = time_elapsed_string($data[$i]->created);
                $data[$i]->attachment = $this->getAttachment($data[$i]->id);                                
            }
            return $data;
        } else {
            return array();
        }
    }
    function allDataCount(){
        $schoolId = $this->token->school_id; 
        $teacher_id = $this->token->user_id;
        $session_id= get_current_session($schoolId)->id;
        $this->db->select("count(a.id) as total");
        $this->db->from("assignment a");
        $this->db->where("a.school_id",$schoolId);
        $this->db->where("a.session_id",$session_id);
        $this->db->where("a.status",1);
        if(isset($_GET['subject_id']))
        {
            if($_GET['subject_id'] != '')
            {
                $this->db->where('subject_id',$_GET['subject_id']);
            }
        }
                        
        $query = $this->db->get();
        return $query->row()->total;
    }
    public function getAttachment($id) {
        $this->db->select('id,attachment as file');
        $this->db->from('assignment_attachment');
        $this->db->where('assignment_id', $id);
        $this->db->where('status', 1);
        $this->db->order_by('id', 'ASC');
        
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result();
        } else {
            return array();
        }
    }
}
