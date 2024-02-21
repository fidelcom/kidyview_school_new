<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Setting_model extends CI_Model {
    public function getNotificationSetting($userID='',$schoolID='') {
        $this->db->select("*");
        $this->db->from('notification_settings');
        $this->db->where('user_id', $userID);
        $this->db->where('school_id', $schoolID);
        $this->db->where('user_type', 'student');
        $query = $this->db->get();
        if ($query->num_rows() ==0) {
            $moduleData=array('Event','Chat','Assignment','Project','Exam','Class Board','Class Schedule');
            $settingArray=array();
            $i=0;
            foreach($moduleData as $module){
                $settingArray[$i]['module_name']=$module;
                $settingArray[$i]['school_id']=$schoolID;
                $settingArray[$i]['user_id']=$userID;
                $settingArray[$i]['user_type']='teacher';
           $i++;
         }
         $this->db->insert_batch('notification_settings',$settingArray);
        }
        $this->db->select("*");
        $this->db->from('notification_settings');
        $this->db->where('user_id', $userID);
        $this->db->where('school_id', $schoolID);
        $this->db->where('user_type', 'teacher');
        $query = $this->db->get();
        if($query->num_rows() > 0)
        {
            return $query->result_array();
        }
        else
        {
            return array();
        }
    }
    public function update($data,$tbl_name)
    {
        $this->db->update_batch($tbl_name,$data,'id');
        return true;
    }
}
