<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Teacherdayoff_model extends CI_Model {
    
    function add($data) {
        $this->db->insert('teacher_dayoff', $data);
        return $this->db->insert_id();
    }
        
    function allData() {
        $this->db->select("*");
        $this->db->from("teacher_dayoff");
        $this->db->where("teacher_id", $this->token->user_id);
        $this->db->order_by("id", 'DESC');
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
    
    function allDataCount(){
        
    }
    
    function getDetail($id) {
        $this->db->select("*");
        $this->db->from("teacher_dayoff");
        $this->db->where("id", $id);
        $query = $this->db->get();
        if($query->num_rows() > 0)
        {
            return $query->row();
        }
        else
        {
            return array();
        }
    }
    
}
