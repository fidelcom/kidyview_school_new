<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class HomeMeal_model extends CI_Model {
    public function data()
    {
        $schoolDetail 	= $this->session->all_userdata();
        if($this->session->userdata('user_role')=='schoolsubadmin'){
            $schoolID 	= $schoolDetail['user_data']['school_id']; 
        }elseif($this->session->userdata('user_role')=='school'){
            $schoolID 	= $schoolDetail['user_data']['id'];
        }
        $this->db->where("school_id",$schoolID);
        $query = $this->db->get("home_meal");
        
        if($query->num_rows() > 0)
        {
            return $query->result();
        }
        else
        {
            return array();
        }
    }
    public function add($data)
    {
        $this->db->insert("home_meal",$data);
        if($this->db->affected_rows() == 1)
        {
            return true;
        }
        else
        {
            return false;
        }
    }
}
