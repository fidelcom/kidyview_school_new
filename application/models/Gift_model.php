<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Gift_model extends CI_Model {
    public function data(){
        $this->db->where('status',1);
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
        $query = $this->db->get('gifts');
        if($query->num_rows() > 0)
        {
            $data = $query->result();
            for($i=0; $i < count($data); $i++)
            {
                $data[$i]->image = base_url()."img/gift/".$data[$i]->image;
            }
            return $data;
        }
        else
        {
            return array();
        }
    }
    function dataCount(){
        $this->db->select("count(g.id) as total");
        $this->db->from("gifts g");
        $this->db->where("g.status",1);                
        $query = $this->db->get();
        return $query->row()->total;
    }
    
}
