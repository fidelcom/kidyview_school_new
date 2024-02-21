<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Mealplanner_model extends CI_Model {
    public function schoolTypeList()
    {
        $schoolDetail 	= $this->session->all_userdata();
       
        if($this->session->userdata('user_role')=='schoolsubadmin'){
            $schoolID 	= $schoolDetail['user_data']['school_id']; 
        }elseif($this->session->userdata('user_role')=='school'){
            $schoolID 	= $schoolDetail['user_data']['id'];
        }
        //print_r($schoolDetail);
        $this->db->select("st.value,st.name");
        $this->db->from("schooltype st, school s");
        $this->db->where("FIND_IN_SET(st.value,s.schoolType) AND 1");
        $this->db->where("st.status",1);             
        $this->db->where("s.id",$schoolID);             
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
    
    public function data()
    {
        $schoolDetail 	= $this->session->all_userdata();
        //print_r($schoolDetail);die;
        if($this->session->userdata('user_role')=='schoolsubadmin'){
            $schoolID 	= $schoolDetail['user_data']['school_id']; 
        }elseif($this->session->userdata('user_role')=='school'){
            $schoolID 	= $schoolDetail['user_data']['id'];
        }
        $this->db->select("mp.*,st.name as school_type_name,c.class as class_name,c.section");
        $this->db->from("meal_planner mp");
        $this->db->join("schooltype st","mp.school_type = st.value","LEFT");
        $this->db->join("class c","mp.class = c.id","LEFT");
        $this->db->where("school_id",$schoolID);
        $query = $this->db->get();
       // echo $this->db->last_query();
        if($query->num_rows() > 0)
        {
            $data = $query->result();
            
            for($i =0; $i < count($data); $i++)
            {
                $data[$i]->detail = $this->mealPlannerDetail($data[$i]->id);
            }
            
            return $data;
        }
        else
        {
            return array();
        }
    }
    public function detail()
    {
        $this->db->select("mp.*,st.name as school_type_name,c.class as class_name,c.section");
        $this->db->from("meal_planner mp");
        $this->db->join("schooltype st","mp.school_type = st.value","LEFT");
        $this->db->join("class c","mp.class = c.id","LEFT");
        $this->db->where("mp.id",$_GET['id']);
        $query = $this->db->get();
        
        if($query->num_rows() > 0)
        {
            $data = $query->row();            
            $data->detailList = $this->mealPlannerDetail($_GET['id']);                        
            return $data;
        }
        else
        {
            return array();
        }
    }
    
    private function mealPlannerDetail($id)
    {
        $this->db->where('meal_planner_id',$id);
        $query = $this->db->get('meal_planner_detail');
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


    public function add($data)
    {
        $this->db->insert("meal_planner",$data);
        if($this->db->affected_rows() == 1)
        {
            return $this->db->insert_id();
        }
        else
        {
            return false;
        }
    }
    public function addDetail($data)
    {
        $this->db->insert_batch("meal_planner_detail",$data);
        
        if($this->db->affected_rows() > 0)
        {
            return $this->db->affected_rows();
        }
        else
        {
            return 0;
        }
    }
    
    public function delete($where=array(),$tbl_name='')
    {
        $this->db->where($where);
        $query = $this->db->delete($tbl_name);
        return $query;
    }
}
