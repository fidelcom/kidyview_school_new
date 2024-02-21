<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Transferstudent_model extends CI_Model {
    public function getAllAcademicSession($school_id='',$is_new=''){
        $this->db->where('status',1);
        $this->db->where('schoolId',$school_id);
        if($is_new==0){
        $this->db->where('current_sesion',1);
        }else{
        $this->db->where('sessionstart >= DATE(now())');
        $this->db->where('current_sesion!=',1);
        }
        $query = $this->db->get('sessions');
        //echo $this->db->last_query();die;
        if($query->num_rows() > 0)
        {
            return $query->result();
        }
        else
        {
            return array();
        }
    }
    public function getAllClass($school_id=''){
        $this->db->select('id,CONCAT(class," ",section) as class');
        $this->db->where('status',1);
        $this->db->where('schoolId',$school_id);
        $this->db->order_by('class asc,section asc');
        $query = $this->db->get('class');
        if($query->num_rows() > 0)
        {
            return $query->result();
        }
        else
        {
            return array();
        }
    }
    public function getAllClassChild($school_id='',$session_id='',$class_id=''){
        $this->db->select('id,CONCAT(childfname," ",childmname," ",childlname) as childname');
        $this->db->where('status',1);
        $this->db->where('schoolId',$school_id);
        $this->db->where('class_session_id',$session_id);
        //$this->db->where('class_session_id',29);
        $this->db->where('childclass',$class_id);
        //$this->db->where('childclass',13);
        $this->db->order_by('childfname asc,childmname asc,childlname asc');
        $query = $this->db->get('child');
        if($query->num_rows() > 0)
        {
            return $query->result();
        }
        else
        {
            return array();
        }
    }
    public function add($data,$tbl_name)
	{
		$this->db->insert($tbl_name,$data);
		return $this->db->insert_id();
    }
    public function update($data,$tbl_name,$where=array())
    {
        $this->db->where($where);
        $this->db->update($tbl_name,$data);
        return true;
    }
}