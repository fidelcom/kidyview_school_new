<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Dayoff_model extends CI_Model {
    
    public function getAllDayoff($school_id)
    {
        $this->db->select('*');
        $this->db->from('alldayoff');
        $this->db->where('school_id',$school_id);
        $query = $this->db->get();
        if($query->num_rows() > 0)
        {
            return $query->result_array();
        }else{
            return false;
        }
    }
    public function getDayoffDetails($concat_id)
    {
        $id = explode("@@", $concat_id);
        $dayoff_id = $id[0];
        $type      = $id[1];
       
        $where = array('id'=>$dayoff_id, 'user_type' => $type);
        $this->db->select('*');
        $this->db->where($where);
        $this->db->from('alldayoff');
        $query = $this->db->get();
        if($query->num_rows() > 0)
        {
            return (array)$query->row();
        }else{
            return false;
        }
    }
    public function dayoffStatus($postData)
    {
        if( !empty($postData['user_type'] == 'student'))
        {
            $where = array('id'=>$postData['id']);
            $updateArr = array('status'=>$postData['status'],'updated_date'=>date('Y-m-d'), 'updated_by' => $postData['school_id']);
            // $updateArr = array('status'=>$postData['status']);
            $this->db->where($where);
            $this->db->update('dayoff',$updateArr);
            return $this->db->affected_rows() ? $this->db->affected_rows() : false;
        }else{
            $where = array('id'=>$postData['id']);
            $updateArr = array('status'=>$postData['status'],'updated_date'=>date('Y-m-d'), 'updated_by' => $postData['school_id']);
            $this->db->where($where);
            $this->db->update('teacher_dayoff',$updateArr);
            return $this->db->affected_rows() ? $this->db->affected_rows() : false;
        }
    }
  
}