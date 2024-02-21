<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Teacher_model extends CI_Model {


     public function getLoginTeacherDetails($teacher_id=''){
        $this->db->select("t.*,s.school_name");
        $this->db->from("teacher t");
        $this->db->join("school s","t.schoolId = s.id");
        $this->db->where("t.id",$teacher_id);
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

