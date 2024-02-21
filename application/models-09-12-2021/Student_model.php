<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Student_model extends CI_Model {
    public function getProfile($id){
        $this->db->select("c.*,s.school_name,CONCAT(cl.class ,' ', cl.section) AS class");
        $this->db->from("child c");
        $this->db->join("school s","c.schoolId = s.id");
        $this->db->join("class cl","c.childclass = cl.id");
        $this->db->where("c.id",$id);
        $this->db->where("c.schoolId",$this->token->school_id);
        $query = $this->db->get();
        if($query->num_rows() == 1)
        {
            return $query->row();
        }
        else
        {
            return false;
        }
    }
    public function getParentProfile($id){
        $this->db->from("parent");
        $this->db->where("id",$id);
        $this->db->where("schoolId",$this->token->school_id);
        $query = $this->db->get();
        if($query->num_rows() == 1)
        {
            $data = $query->row();
            
            $data->guardian_data = $this->getGuardianProfile($id);
            
            return $data;
        }
        else
        {
            return false;
        }
    }
    public function getGuardianProfile($id){
        $this->db->from("parent_guardian");
        $this->db->where("parent_id",$id);
        $this->db->where("school_id",$this->token->school_id);
        $query = $this->db->get();
        if($query->num_rows() >0)
        {
            return $query->result();
        }
        else
        {
            return array();
        }
    }
    public function addGuardian($data)
    {
        $this->db->insert("parent_guardian",$data);
        return $this->db->insert_id();
    }
    public function updateGuardian($id,$data)
    {
        $this->db->where("id",$id);
        $this->db->update("parent_guardian",$data);
        return $this->db->affected_rows();
    }
    public function getStudentsList($school_id,$postData)
    {
        if( !empty($postData['classID']) )
        {
            // $this->db->where(array('cc.id'=>$postData['classID'],'cc.status'=>1));
            $this->db->where(array('cc.id'=>$postData['classID']));
        }
        // $where = array('c.schoolId'=>$school_id,'c.status'=>1);
        $where = array('c.schoolId'=>$school_id);
        $this->db->select('c.id as childID,c.child_login_id,c.childfname,c.childmname,c.childlname,c.childRegisterId,c.childgender,c.childaddress,c.status,c.created_date,p.fatherfname,p.fatherlname,p.id as parent_id,cc.id as class_id,cc.class,cc.section');
        $this->db->from('child c');
        $this->db->join('class cc','cc.id = c.childclass','left');
        $this->db->join('parent p','p.id = c.parent_id','left');
        $this->db->where($where);
        $this->db->group_by(['c.id']);
        $query = $this->db->get(); 
         // lq();
        if($query->num_rows() > 0)
        {
           return $query->result();                }
        else
        {
            return array();
        }
    }
    public function childDisabled($data,$id)
    {
        $this->db->where('id',$id);
        $this->db->update('child',$data);
        if($this->db->affected_rows())
        {
            return true;
        }
        else
        {
            return false;
        }
    }
    public function getStudentDetails($id){
        $this->db->select("c.*,s.school_name");
        $this->db->from("child c");
        $this->db->join("school s","c.schoolId = s.id");
        $this->db->where("c.id",$id);
        $query = $this->db->get();
        if($query->num_rows() == 1)
        {
            return $query->row();
        }
        else
        {
            return false;
        }
    }
    public function changePasswordStudent($oldPassword,$newPassword)
    {  
                $userDetail = $this->session->all_userdata();
                $id = $userDetail['student_data']['id'];                    
                $newPassword = array('password'=> $newPassword);
                $this->db->where('id',$id);
                $this->db->update('child',$newPassword);
                
                return ($this->db->affected_rows()) ? 1: 0;
    }
   
}
