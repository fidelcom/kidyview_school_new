<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Notification_model extends CI_Model {
    public function getNotification($action="",$teacherID='',$schoolID='',$limit='',$alldata='') {
        $schoolID="S-".$schoolID;
        // var_dump($schoolID);
        $this->db->select("n.*,CONCAT(u.fname,' ' ,u.lname) as name,u.user_type");
        $this->db->from('notifications n');
        $this->db->join('alluser u','n.sender_id=u.id','INNER');
        $this->db->where('n.receiver_id', $schoolID);
        if($alldata==''){
        $this->db->where('n.is_read','0');
        }
        $this->db->where('n.is_delete',0);
        $this->db->order_by('n.created_on','DESC');
        if($action=='data'){
        $this->db->limit($limit);
        }
        $query = $this->db->get();
        
        if ($query->num_rows() > 0) {
            if($action=='data'){
            $data_data = $query->result_array();
            return $data_data;
            }else{
                return $query->num_rows();
            }
            } else {
            return array();
        }
    }
    public function updateNotification($where,$data)
    {
        $this->db->where($where);
        $this->db->update('notifications',$data);
        if($this->db->affected_rows())
        {
            return true;
        }
        else
        {
            return false;
        }
    }
    public function delete($where=array(),$tbl_name='')
    {
        $this->db->where($where);
        $query = $this->db->delete($tbl_name);
        return $query;
    }
}
