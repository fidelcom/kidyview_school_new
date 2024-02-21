<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Student_model extends CI_Model {

     public function getLoginStudentDetails($student_id=''){
        $this->db->select("c.*,s.school_name,CONCAT(cl.class ,' ', cl.section) AS class,si.academicsession");
        $this->db->from("child c");
        $this->db->join("school s","c.schoolId = s.id");
        $this->db->join("class cl","c.childclass = cl.id");
        $this->db->join('sessions si','c.class_session_id = si.id','left');
        $this->db->where("c.id",$student_id);
        $query = $this->db->get();
        if($query->num_rows() == 1)
        {
            return $query->row();
        }
        else
        {
            return false;
        }
     }
}

