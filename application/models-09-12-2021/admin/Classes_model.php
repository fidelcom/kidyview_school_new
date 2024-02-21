<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Classes_model extends CI_Model {
    public function data()
    {
        $schoolDetail 	= $this->session->all_userdata();
        if($this->session->userdata('user_role')=='schoolsubadmin'){
            $schoolID 	= $schoolDetail['user_data']['school_id']; 
        }elseif($this->session->userdata('user_role')=='school'){
            $schoolID 	= $schoolDetail['user_data']['id'];
        }
        $this->db->where("schoolId",$schoolID);
        $this->db->where("status",1);
        $query = $this->db->get("class");
        
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
