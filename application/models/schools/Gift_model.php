<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Gift_model extends CI_Model {
    public function data(){
        $this->db->where('status',1);
       /* if (isset($_GET['page'])) 
        {
            $page = $_GET['page'];
            $limit = 10;
            if(isset($_GET['limit']))
            {
                $limit = $_GET['limit'];
            }
            $offset = ($page - 1) * $limit;

            $this->db->limit($limit, $offset);
        }*/
        $query = $this->db->get('gifts');
        if($query->num_rows() > 0)
        {
            $data = $query->result();
            for($i=0; $i < count($data); $i++)
            {
                if($data[$i]->image!=''){
                    $data[$i]->image = base_url()."img/gift/".$data[$i]->image;
                }else{
                    $data[$i]->image = base_url()."asset/img/catimg.png";
                }
            }
            return $data;
        }
        else
        {
            return array();
        }
    }
    public function details($giftID=''){
        $this->db->where('id',$giftID);
        $query = $this->db->get('gifts');
        if($query->num_rows() > 0)
        {
            $data = $query->row();
            if($data->image!=''){
            $data->image = base_url()."img/gift/".$data->image;
            }else{
            $data->image = base_url()."asset/img/catimg.png";
            }
            return $data;
        }
        else
        {
            return array();
        }
    }
    public function studentPointsList($school_id,$class)
    {
         $where = array('c.status' => 1,'c.childclass'=>$class);

         $this->db->select('sp.id, CONCAT(c.childfname, " ", c.childmname, " ", c.childlname) as studentName,c.id as student_id, CONCAT(p.fatherfname, " ", p.fatherlname) as fatherName, childphoto, CONCAT(cs.class," ", cs.section) as class, sum(points) as totalPoints,curr.currency_name,curr.currency_symbol,curr.currency_code');
         $this->db->from('student_point as sp');
         $this->db->join('child as c', 'c.id = sp.student_id', 'inner');
         $this->db->join('class as cs', 'c.childclass = cs.id', 'inner');
         $this->db->join('parent as p', 'p.id = c.parent_id', 'inner');
         $this->db->join('school as school','school.id='.$school_id.'','inner');
         $this->db->join('admin_currency as curr','curr.id=school.currency_id','inner');
         $this->db->where($where);
         $this->db->group_by('sp.student_id');
        $query = $this->db->get();
        if($query->num_rows() > 0)
        {
           return $data = $query->result_array();
        }
        else
        {
            return array();
        }
    }
    public function studentPointsDetails($postData)
    {
        // prd($postData);
        $where = array('c.status' => 1,'sp.student_id' => $postData['student_id'], 'sp.school_id' => $postData['school_id']);

         $this->db->select('sp.id, CONCAT(c.childfname, " ", c.childmname, " ", c.childlname) as studentName,c.id as student_id, sum(points) as totalPoints,sp.created_date');
         $this->db->from('student_point as sp');
         $this->db->join('child as c', 'c.id = sp.student_id', 'inner');
         // $this->db->join('class as cs', 'c.childclass = cs.id', 'inner');
         $this->db->where($where);
         $this->db->group_by('sp.student_id');
        $query = $this->db->get();
        if($query->num_rows() > 0)
        {
           return $data = $query->row_array();
           // prd($data);
        }else{
            return array();
        }
    }
    public function studentAllPointsDetails($postData)
    {
        // prd($postData);
        $where = array('c.status' => 1,'sp.student_id' => $postData['student_id'], 'sp.school_id' => $postData['school_id']);

         $this->db->select('sp.id, CONCAT(c.childfname, " ", c.childmname, " ", c.childlname) as studentName,c.id as student_id, sp.points,sp.created_date,g.title, g.description');
         $this->db->from('student_point as sp');
         $this->db->join('child as c', 'c.id = sp.student_id', 'inner');
         $this->db->join('goals as g', 'g.id = sp.goal_id', 'inner');
         // $this->db->join('class as cs', 'c.childclass = cs.id', 'inner');
         $this->db->where($where);
         // $this->db->group_by('sp.student_id');
        $query = $this->db->get();
        if($query->num_rows() > 0)
        {
           return $data = $query->result_array();
           // prd($data);
        }else{
            return array();
        }
    }
    
}