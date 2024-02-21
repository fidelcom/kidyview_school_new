<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class LearningAndDevelopment_model extends CI_Model {        
    public function data()
    {
        $schoolDetail 	= $this->session->all_userdata();
        if($this->session->userdata('user_role')=='admin' || $this->session->userdata('user_role')=='schoolsubadmin'){
            $schoolID 	= $schoolDetail['user_data']['school_id']; 
        }elseif($this->session->userdata('user_role')=='school'){
            $schoolID 	= $schoolDetail['user_data']['id'];
        }
        $this->db->select("ld.*,c.class as class_name,c.section");
        $this->db->from("learning_development_category ld");
        $this->db->join("class c","ld.class_id = c.id","LEFT");
        $this->db->where("ld.school_id",$schoolID);
        $query = $this->db->get();
        
        if($query->num_rows() > 0)
        {
            $data = $query->result();
            
            for($i =0; $i < count($data); $i++)
            {
                $data[$i]->detail = $this->learningQuestion($data[$i]->id);
                $data[$i]->info = $this->learningInfo($data[$i]->id);
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
        $schoolDetail 	= $this->session->all_userdata();
        if($this->session->userdata('user_role')=='admin' || $this->session->userdata('user_role')=='schoolsubadmin'){
            $schoolID 	= $schoolDetail['user_data']['school_id']; 
        }elseif($this->session->userdata('user_role')=='school'){
            $schoolID 	= $schoolDetail['user_data']['id'];
        }
        $this->db->select("ld.*,c.class as class_name,c.section");
        $this->db->from("learning_development_category ld");
        $this->db->join("class c","ld.class_id = c.id","LEFT");
        $this->db->where("ld.school_id",$schoolID);
        $this->db->where("ld.id",$_GET['id']);
        $query = $this->db->get();
        
        if($query->num_rows() > 0)
        {
            $data = $query->row();            
            $data->detail = $this->learningQuestion($data->id);
            $data->detail->options = json_decode($data->detail->options);
            $data->info = $this->learningInfo($data->id);                        
            return $data;
        }
        else
        {
            return array();
        }
    }    
    private function learningQuestion($id)
    {
        $this->db->where('category_id',$id);
        $query = $this->db->get('learning_development_question');
        
        if($query->num_rows() > 0)
        {
            return $query->row();
        }
        else
        {
            return array();
        }
    }
    private function learningInfo($id)
    {
        $this->db->where('category_id',$id);
        $query = $this->db->get('learning_development_info');
        
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
