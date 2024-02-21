<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Activityperformance_model extends CI_Model {
    public function getActivityPerformance($schoolID='') {
        $this->db->select("*");
        $this->db->from('activities_performance');
        $this->db->where('school_id', $schoolID);
        $query = $this->db->get();
        if ($query->num_rows() ==0) {
            $moduleData=array('Beginner','Intermediate','Advanced','Expert');
            $settingArray=array();
            $i=0;
            foreach($moduleData as $module){
                $settingArray[$i]['name']=$module;
                $settingArray[$i]['school_id']=$schoolID;
           $i++;
         }
         $this->db->insert_batch('activities_performance',$settingArray);
        }
        $this->db->select("*");
        $this->db->from('activities_performance');
        $this->db->where('school_id', $schoolID);
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
    public function update($data,$tbl_name,$where)
    {
        $this->db->where($where);
        $this->db->update($tbl_name,$data);
        return true;
    }
}
