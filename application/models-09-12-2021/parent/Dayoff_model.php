<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Dayoff_model extends CI_Model {
    
    function add($data) {
        $this->db->insert('dayoff', $data);
        return $this->db->insert_id();
    }
        
    function allData() {
        $this->db->select("d.*,c.childfname,c.childmname,c.childlname,c.childphoto,CONCAT(p.fatherfname,' ',p.fatherlname) as father_name,CONCAT(cs.class,' ',cs.section ) as class");
        $this->db->from("dayoff d");
        $this->db->join("child c","d.student_id = c.id","LEFT");
        $this->db->join("parent p","p.id = c.parent_id","LEFT");
        $this->db->join("class cs","cs.id = c.childclass","LEFT");
        $this->db->where("d.student_id", $this->token->student_id);
        $this->db->order_by("d.id", 'DESC');
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
        $this->db->select("d.*,c.childfname,c.childmname,c.childlname,c.childphoto");
        $this->db->from("dayoff d");
        $this->db->join("child c","d.student_id = c.id","LEFT");
        $this->db->where("d.id", $id);
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
    public function getStudentDayOff($student_id,$startDate,$endDate)
    {
        $where = array('student_id'=>$student_id,'from_date'=>$startDate,'to_date'=>$endDate,'status !=' => 'Rejected');
        return $this->db->select('*')->where($where)->get('dayoff')->row();
        // lq();
    }
    public function getLeave()
    {
        $student_id = $this->token->student_id;
        $school_id  = $this->token->school_id;
        $dated = $this->input->get('date');
      
        $sql = "SELECT * FROM `dayoff` WHERE '$dated' BETWEEN  from_date AND to_date AND student_id = $student_id ";
        $query = $this->db->query($sql);
           
       if($query->num_rows() >0 )
       {
            return  $result = $query->result_array();
       }else{
            return array();
       }
    }
    
}
