<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Parent_model extends CI_Model {
    public function data($schoolID)
    {
        $this->db->where("schoolId",$schoolID);
        $query = $this->db->get("parent");
        
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
