<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Parent_model extends CI_Model {

    public function validate($email, $phn) {        
        $this->db->from('parent u');
        //$this->db->where('u.status', 1);
        
        if($phn != '')
        {
            $this->db->where("((u.fatherphone = '$phn' OR u.motherphone = '$phn'))");
        }
        if($email != '')
        {
            $this->db->where("(((u.fatheremail = '$email' OR u.motheremail = '$email')))");
        }        
                
        $query = $this->db->get();  
        //echo $this->db->last_query();die;

        if ($query->num_rows() == 1) {
            return $query->row();
        } else {
            return false;
        }
    }

    public function addToken($data) {
        $this->db->insert('user_token', $data);
    }
    
    public function updateParent($data, $id) {
        $this->db->where('id', $id);
        $this->db->update('parent', $data);
        return ($this->db->affected_rows()) ? 1 : 0;
    }
    
    public function isotpvalid($otp, $user_id) { 
        $this->db->select('u.*,s.school_name,s.pic as school_pic');
        $this->db->from('parent u');
        $this->db->join('school s', 's.id=u.schoolId','left');

        $this->db->where(array('u.otp' => $otp, 'u.id' => $user_id, 'u.status' => 1));
        $this->db->limit(1);

        $this->db->order_by('u.id', 'desc');
        $query = $this->db->get();

        if ($query->num_rows() > 0) {
            $user = $query->row();
            return $user;
        }

        return false;
    }
    
    public function childList($parent_id){
        //echo $this->token->school_id;
        //$currentSession_id   = get_current_session($this->token->school_id);
        //print_r($currentSession_id);die;
        //$this->db->where('class_session_id',$currentSession_id);
        $this->db->select("c.*");
        $this->db->from('child c');
        $this->db->join('sessions si','c.class_session_id = si.id','left');
        $this->db->where(array('si.current_sesion'=>1));
        $this->db->where('c.status',1);
        $this->db->where('c.parent_id',$parent_id);
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
    
    public function childDetail($student_id){
        $this->db->where('id',$student_id);
        $this->db->where('status',1);
        $this->db->from('child');
        $query = $this->db->get();
        if($query->num_rows() > 0)
        {
            $row=$query->row();
            $class=$this->getClassName($row->childclass);
            $row->class=$class->class.' '.$class->section;
            return $row;
        }
        else
        {
            return array();
        }
    }
    public function getClassName($class_id){
        $this->db->select('class,section');
        $this->db->from('class');
        $this->db->where('id',$class_id);
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
    public function parentDetail($parent_id){
        $this->db->where('id',$parent_id);
        $this->db->where('status',1);
        $this->db->from('parent');
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
    public function guardianDetail($parent_id){
        $this->db->where('parent_id',$parent_id);
        $this->db->where('status',1);
        $this->db->from('parent_guardian');
        $query = $this->db->get();
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
    public function parentFCMID($user_id)
    {
        return $this->db->select('fcm_key')->where('user_id',$user_id)->order_by('id','desc')->get('user_token')->row();
    }
    public function getThoughtOfTheDay($school_id = '', $parent_id = '') {
        $this->db->select('td.description,td.author_name');
        $this->db->from('thought_of_day as td');
        //$this->db->join('school as s', 's.id=td.school_id','left');
        $this->db->where('td.status', '1');
        $this->db->where('td.school_id', $this->token->school_id);
        $query = $this->db->get();
        $data=$query->result_array();
        return $data?$data[0]:array();
    }
    public function getSchool($school_id = '') {
        //print_r($this->token);
        //echo $this->token->school_id;die;
        $this->db->select('s.school_name,s.pic as school_pic');
        $this->db->from('school as s');
        $this->db->where('id', $this->token->school_id);
        //$this->db->where('id', $school_id);
        $query = $this->db->get();
       // echo $this->db->last_query();
        $data=$query->result_array();
        return $data?$data[0]:array();
    }
}
