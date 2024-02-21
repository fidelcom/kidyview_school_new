<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Goal_model extends CI_Model {
    
    function allData($schoolID='',$classID='',$studentID='') {
        $this->db->select("a.*,CONCAT(au.fname, ' ', au.lname) AS uname");
        $this->db->from("goals a");
        $this->db->join("alluser au","a.user_id=au.id",'LEFT');
        $this->db->where("a.school_id",$schoolID);
        $this->db->where("a.class_id",$classID);
        $this->db->where("a.student_id",$studentID);
        $this->db->order_by("a.id","DESC");               
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            $data = $query->result();
            for ($i = 0; $i < count($data); $i++) {
                $this->load->helper('common');
                $data[$i]->created = time_elapsed_string($data[$i]->created);
                if($data[$i]->completion_date < date("Y-m-d") && $data[$i]->status == 'Created')                
                {
                    $data[$i]->status = "Inactive";
                }
                if($data[$i]->completion_date >= date("Y-m-d") && $data[$i]->status == 'Created')                
                {
                    $data[$i]->status = "Active";
                }
            }
            return $data;
        } else {
            return array();
        }
    }
    function getGoalDetails($schoolID='',$goalID='') {
        $this->db->select("a.*,gl.name,gl.points as spoint");
        $this->db->from("goals a");
        $this->db->join("goal_list gl","a.list_id=gl.id",'LEFT');
        $this->db->where("a.school_id",$schoolID);
        $this->db->where("a.id",$goalID);              
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            $data = $query->result();
            for ($i = 0; $i < count($data); $i++) {
                $this->load->helper('common');
                $data[$i]->attachment = $this->getAttachment($data[$i]->id);  
                $data[$i]->created = time_elapsed_string($data[$i]->created);
                if($data[$i]->completion_date < date("Y-m-d H:i:s") && $data[$i]->status == 'Created')                
                {
                    $data[$i]->status = "Inactive";
                }
                if($data[$i]->completion_date > date("Y-m-d H:i:s") && $data[$i]->status == 'Created')                
                {
                    $data[$i]->status = "Active";
                }
            }
            return $data[0];
        } else {
            return array();
        }
    }
    public function getAttachment($id) {
        $this->db->select('id,attachment as file');
        $this->db->from('goals_attachment');
        $this->db->where('goal_id', $id);
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
