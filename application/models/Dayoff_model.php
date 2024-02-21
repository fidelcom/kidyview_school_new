<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Dayoff_model extends CI_Model {
    
    function updateData($id,$data) {
        $this->db->where('id', $id);
        $this->db->update('dayoff', $data);
        return $this->db->affected_rows();
    }
        
    function allData() {
        $this->token->user_id;
        $res = $this->assignedClasses($this->token->user_id);
        
        if(!empty($res))
        {
            for($i = 0 ; $i < count($res); $i++)
            {
                $res[$i] = "c.childclass = ".$res[$i];
            }
            
            $str = implode(' OR ',$res);            
            
            $this->db->select("d.*,c.childfname,c.childmname,c.childlname,c.childphoto,cl.class,cl.section");
            $this->db->from("dayoff d");
            $this->db->join("child c",'d.student_id = c.id','LEFT');
            $this->db->join("class cl",'c.childclass = cl.id','LEFT');
            $this->db->where("($str)");
            $this->db->order_by("d.id", 'DESC');
            $query = $this->db->get();
            //echo $this->db->last_query();die;
            if($query->num_rows() > 0)
            {
                $data =  $query->result();
                for($j = 0; $j < count($data); $j++)
                {
                   $data[$j]->parent_detail = $this->parentDetail($data[$j]->created_by);
                }
                return $data;
            }
            else
            {
                return array();
            }
        }
        else
        {
            return array();
        }
    }
    
    function parentDetail($id){
        $this->db->where('id',$id);
        $this->db->from('parent');
        $query = $this->db->get();
        if($query->num_rows() == 1)
        {
            return $query->row();
        }
        else
        {
            return array();
        }
    }
    
    function assignedClasses($id){
        $this->db->where('id',$id);
        $this->db->from('teacher');
        $query = $this->db->get();
        if($query->num_rows() == 1)
        {
            $tmp = $query->row()->assignclassteacher;
            $tmp  = explode(',',$tmp);
            return $tmp;
        }
        else
        {
            return array();
        }
    }
    
    function allDataCount(){
        
    }
    
    function getDetail($id) {
        $this->db->select("d.*,c.childfname,c.childmname,c.childlname,c.childphoto,cl.class,cl.section");
        $this->db->from("dayoff d");
        $this->db->join("child c",'d.student_id = c.id','LEFT');
        $this->db->join("class cl",'c.childclass = cl.id','LEFT');        
        $this->db->where("d.id", $id);
        $query = $this->db->get();
        if($query->num_rows() > 0)
        {
            $data = $query->row();
            $data->parent_detail = $this->parentDetail($id->created_by);
            return $data;
        }
        else
        {
            return array();
        }
    }
    
}
