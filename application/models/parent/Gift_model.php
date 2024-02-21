<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Gift_model extends CI_Model {
    public function data(){
        $this->db->where('status',1);
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
        $query = $this->db->get('gifts');
        if($query->num_rows() > 0)
        {
            $data = $query->result();
            for($i=0; $i < count($data); $i++)
            {
                $data[$i]->image = base_url()."img/gift/".$data[$i]->image;
            }
            return $data;
        }
        else
        {
            return array();
        }
    }
    function dataCount(){
        $this->db->select("count(g.id) as total");
        $this->db->from("gifts g");
        $this->db->where("g.status",1);                
        $query = $this->db->get();
        return $query->row()->total;
    }
    function pointsDatabkup()
    {
        $parent_id  = $this->token->parent_id;
        $student_id = $this->token->student_id;
        $school_id  = $this->token->school_id;

        $where = array('student_id'=> $student_id, 'school_id'=> $school_id); 
        $query = $this->db->where($where)->order_by('id' ,'desc')->get('student_left_points');
        if($query->num_rows() > 0)
        {
            $remainsPoints  = $query->row_array();

            $where = array('student_id'=> $student_id, 'school_id'=> $school_id, 'transection_type'=>'Goal Achived'); 
            $this->db->select("student_id, sum(points) as totalPoints");
            $this->db->from("student_point");
            $this->db->where($where);    
            $query = $this->db->get();
            $data = $query->row_array();

            $data['totalPoints'] = !empty($remainsPoints['remain_points']) ? $remainsPoints['remain_points'] : '';
            return $data;   

        }else{
            $where = array('student_id'=> $student_id, 'school_id'=> $school_id, 'transection_type'=>'Goal Achived'); 
            $this->db->select("student_id, sum(points) as totalPoints");
            $this->db->from("student_point");
            $this->db->where($where);    
            $query = $this->db->get();
            $data = $query->row_array();
            return $data;            
        }          

    }
    function pointsData()
    {
        $parent_id  = $this->token->parent_id;
        $student_id = $this->token->student_id;
        $school_id  = $this->token->school_id;

            $where = array('student_id'=> $student_id, 'school_id'=> $school_id); 
            $this->db->select("sum(gift_points) as giftPoints");
            $this->db->from("student_left_points");
            $this->db->where($where);    
            $query = $this->db->get();
            $remainsPoints = $query->row_array();

            $where = array('student_id'=> $student_id, 'school_id'=> $school_id, 'transection_type'=>'Goal Achived'); 
            $this->db->select("student_id, sum(points) as totalPoints");
            $this->db->from("student_point");
            $this->db->where($where);    
            $query = $this->db->get();
            $data = $query->row_array();
            if(!empty($remainsPoints)){
            $data['totalPoints'] = $data['totalPoints']-$remainsPoints['giftPoints'];
            }
            return $data;        

    }
    function allPointsData()
    {
        $parent_id  = $this->token->parent_id;
        $student_id = $this->token->student_id;
        $school_id  = $this->token->school_id;

        $where = array('sp.student_id'=> $student_id, 'sp.school_id'=> $school_id, 'sp.transection_type'=>'Goal Achived'); 
        $this->db->select("sp.student_id,sp.points,g.title, g.description, sp.created_date");
        $this->db->from("student_point as sp");
        $this->db->join("goals as g", 'g.id = sp.goal_id', 'left');
        $this->db->where($where);    
        $query = $this->db->order_by('sp.created_date' ,'desc')->get();
        return $query->result_array();   
    }
    function redeemPointsGifts()
    {
        $this->db->select("*");
        $this->db->from("gifts");
        $this->db->where("status",1);     
        $query = $this->db->order_by('id' ,'desc')->get();
        return $query->result_array();
    }
    public function redeemPointsReward($postData)
    {
        $points = $this->pointsData();
        $totalPoints = $points['totalPoints'];
        
        $parent_id  = $this->token->parent_id;
        $student_id = $this->token->student_id;
        $school_id  = $this->token->school_id;
        $redeem_points = $postData['redeem_points'];

        $dataSet = array(
            'student_id'    => $student_id,
            'school_id'     => $school_id,
            'total_points'  => $totalPoints,
            'remain_points' => (int)( $totalPoints - $redeem_points ),
            'gift_id'       => $postData['gift_id'],
            'gift_points'   => $redeem_points,
            'created_at'    => date('Y:m:d H:i:s')
        );
        if( $totalPoints >= $redeem_points )
        {
                $giftsQuantity = $this->db->where('id',$postData['gift_id'])->get('gifts')->row_array();  
                $giftsQuantity = (int)$giftsQuantity['quantity'];
                // echo $giftsQuantity; die;
                if($giftsQuantity > 0 )
                {

                        $this->db->insert('student_left_points', $dataSet);
                        if($this->db->affected_rows() > 0)
                        {
                            $where = array('id'=> $postData['gift_id'] );
                            $updateData = array(
                                'quantity'      => ($giftsQuantity - 1)
                            );
                            // prd($updateData);
                          $this->db->where($where);
                          $this->db->update('gifts',$updateData);
                          return $this->db->affected_rows() ? $this->db->affected_rows() : false;
                        }else{
                            return false;
                        }

                }else{
                    return 'insuficient_qty';
                }
        }else{
            return 'exceed_points_limit';
        }
    }
}
