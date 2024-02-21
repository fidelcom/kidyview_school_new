<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Faq_model extends CI_Model {
    public function getFaqList($school_id='',$user_type='')
    {
        $this->db->select("*");
        $this->db->from("school_faq");
        $this->db->where([ 'user_type'=> $user_type]);
        $this->db->order_by('id','DESC');
        $query = $this->db->get();
        if($query->num_rows() > 0)
        {
            $data = $query->result_array();
            return $data;
        }
        else
        {
           return array();
        }
    }

}
