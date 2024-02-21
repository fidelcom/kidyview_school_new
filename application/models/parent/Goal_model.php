<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Goal_model extends CI_Model {
    
    function add($data) {
        $this->db->insert('goals', $data);
        return $this->db->insert_id();
    }
    function update($id,$data) {
        $goalPoints = $this->goalType($id);
        
        if(isset($goalPoints->points)){
         $data['points'] = $goalPoints->points;
        }

        $this->db->where('id',$id);
        $this->db->update('goals', $data);
    }
    function detail($id)
    {
        $this->db->where('id',$id);
        $query = $this->db->get('goals');
        if($query->num_rows() == 1)
        {
            $data = $query->row();
            return $data;
        }
    }
    function goalType($id)
    {
        $this->db->where('id',$id);
        $query = $this->db->get('goal_list');
        if($query->num_rows() == 1)
        {
            return $query->row();
        }
    }
    
    function addPoints($user_id,$detail){
        $goalType = $this->goalType($detail->list_id);
        $data = array(
            "school_id"=>$detail->school_id,
            "student_id"=>$detail->student_id,
            "points"=>$goalType->points,
            "goal_id"=>$detail->id,
            "transection_type"=>"Goal Achived",
            "created_by"=>$user_id,
            "created_date"=>date("Y-m-d H:i:s")
        );
        $this->db->insert('student_point',$data);
        return $this->db->affected_rows();
    }
    function reomvePoints(){
        
    }
    function addAttachment($data) {
        $this->db->insert('goals_attachment', $data);
        return $this->db->insert_id();
    }
    function listData(){
        $schoolId = $this->token->school_id; 
        
        $this->db->select("a.*");
        $this->db->from("goal_list a");
        $this->db->where("a.school_id",$schoolId);                
        
        $query = $this->db->get();
        
        if ($query->num_rows() > 0) {
            $data = $query->result();            
            return $data;
        } else {
            return array();
        }
    }
    function allData() {
        $schoolId = $this->token->school_id; 
        $student_id = $this->token->student_id;
        
        $this->db->select("g.*,ch.childfname,ch.childmname,ch.childlname,cl.class,cl.section");
        $this->db->from("goals g");
        $this->db->join("child ch","g.student_id = ch.id","LEFT");
        $this->db->join("class cl","g.class_id = cl.id","LEFT");
        $this->db->where("g.school_id",$schoolId);
        $this->db->where("ch.id",$student_id);        
        $this->db->order_by("g.id","DESC");   
        
                
        if (isset($_GET['page'])) 
        {
            $page = $_GET['page'];
            $limit = 10;
            if(isset($_GET['limit']))
            {
                $limit = $_GET['limit'];
            }
            $offset = ($page - 1) * $limit;

            $this->db->limit($limit, $offset);
        }
        
        $query = $this->db->get();
        
        if ($query->num_rows() > 0) {
            $data = $query->result();
            for ($i = 0; $i < count($data); $i++) {
                $this->load->helper('common');
                $data[$i]->created = time_elapsed_string($data[$i]->created);
                $data[$i]->attachment = $this->getAttachment($data[$i]->id);  
                $data[$i]->expired = false;
                if($data[$i]->completion_date < date("Y-m-d H:i:s") && $data[$i]->status == 'Not Achived')                
                {
                    $data[$i]->expired = true;
                }
            }
            return $data;
        } else {
            return array();
        }
    }
    function allDataCount(){
        $schoolId = $this->token->school_id; 
        $student_id = $this->token->student_id;
        
        $this->db->select("count(g.id) as total");
        $this->db->from("goals g");
        $this->db->join("child ch","g.student_id = ch.id","LEFT");
        $this->db->join("class cl","g.class_id = cl.id","LEFT");
        $this->db->where("g.school_id",$schoolId);
        $this->db->where("ch.id",$student_id); 
        
                                        
        $query = $this->db->get();
        return $query->row()->total;
    }
    public function getAttachment($id) {
        $this->db->select('id,attachment as file');
        $this->db->from('goals_attachment');
        $this->db->where('goal_id', $id);
        $this->db->where('status', 1);
        $this->db->order_by('id', 'ASC');
        
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result();
        } else {
            return array();
        }
    }
}
