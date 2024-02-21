<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Loginimage_model extends CI_Model {
    public function data()
    {
        $query = $this->db->get("login_image");
        
        if($query->num_rows() > 0)
        {
            return $query->result();
        }
        else
        {
            return array();
        }
    }
    public function update($id,$data)
    {
        $this->db->where("id",$id);
        $this->db->update("login_image",$data);
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
