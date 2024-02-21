<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Discussion_model extends CI_Model {
    
    function addPost($data) {
        $this->db->insert('discussion', $data);
        return $this->db->insert_id();
    }
    function addAttachment($data) {
        $this->db->insert('discussion_attachment', $data);
        return $this->db->insert_id();
    }
    
    function allData() {
        $schoolId = $this->token->school_id; 
        $parent_id = $this->token->parent_id;
        
        $order = "id";
        if(isset($_GET['order'])) 
        {
            if($_GET['order'] != '')
            {
                $order = $_GET['order'];
            }
        }
        
        $orderBY = "DESC";
        if(isset($_GET['order_by'])) 
        {
            if($_GET['order_by'] != '')
            {
                $orderBY = $_GET['order_by'];
            }
        }
        $this->db->select("d.*, dt.name as discussion_type_text,IFNULL(dl.total_like,0) as total_like");
        $this->db->from("discussion d");
        $this->db->join("(SELECT discussion_id,count(discussion_id) as total_like FROM discussion_like GROUP BY discussion_id) dl","d.id = dl.discussion_id","LEFT");
        $this->db->join("discussion_category dt","d.discussion_type = dt.id","LEFT");
        $this->db->where("d.school_id",$schoolId);
        $this->db->where("d.status",1);
        $this->db->order_by($order,$orderBY);
        
        
        if(isset($_GET['detail'])) 
        {
            if($_GET['detail'] != '')
            {
                $this->db->where("d.detail",$_GET['detail']);
            }
        }
        
        if(isset($_GET['discussion_type'])) 
        {
            if($_GET['discussion_type'] != '')
            {
                $this->db->where("d.discussion_type",$_GET['discussion_type']);
            }
        }
        
        if(isset($_GET['page'])) 
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
        
        $row = $this->db->get();
        
        $data = $row->result();
        if (!empty($data)) {
            for ($i = 0; $i < count($data); $i++) {
                $this->load->helper('common');
                $data[$i]->created = time_elapsed_string($data[$i]->created);
                $data[$i]->attachment = $this->getAttachment($data[$i]->id);
                $data[$i]->comments = $this->countComment($data[$i]->id);
                $data[$i]->like = $this->countLike($data[$i]->id);
                $isUserLike = $this->userLike($data[$i]->id, '', 'parent', $parent_id);
                if ($isUserLike > 0) {
                    $data[$i]->is_like = 1;
                } else {
                    $data[$i]->is_like = 0;
                }
                $userDetail = $this->userDetail($data[$i]->user_id);
                if($userDetail != false)
                {
                    $data[$i]->create_by = $userDetail->fname." ".$userDetail->lname;                    
                    $data[$i]->create_by_photo = base_url()."img/".$data[$i]->user_type."/".$userDetail->photo;
                }
                
            }
            return $data;
        } else {
            return array();
        }
    }
    
    function allDataCount(){
        $schoolId = $this->token->school_id; 
        $this->db->select("count(d.id) as total");
        $this->db->from("discussion d");
        $this->db->where("d.school_id",$schoolId);
        $this->db->where("d.status",1);    
        
        if(isset($_GET['detail'])) 
        {
            if($_GET['detail'] != '')
            {
                $this->db->where("d.detail",$_GET['detail']);
            }
        }
        
        if(isset($_GET['discussion_type'])) 
        {
            if($_GET['discussion_type'] != '')
            {
                $this->db->where("d.discussion_type",$_GET['discussion_type']);
            }
        }
        
        $query = $this->db->get();
        return $query->row()->total;
    }
    
    function getDetail($id) {
        $this->db->select("d.*,dt.name as discussion_type_text");
        $this->db->from("discussion d");
        $this->db->join("discussion_category dt","d.discussion_type = dt.id","LEFT");
        $this->db->where("d.id",$id);        
        $query = $this->db->get();
        
        if($query->num_rows() == 1)
        {
            $data = $query->row();
            $userDetail = $this->userDetail($data->user_id);
            if($userDetail != false)
            {
                $data->create_by = $userDetail->fname." ".$userDetail->lname;                    
                $data->create_by_photo = base_url()."img/".$data->user_type."/".$userDetail->photo;
            }
            $data->created = time_elapsed_string($data->created);
            $data->attachment = $this->getAttachment($data->id);
            $data->comments = $this->getComments($data->id);
            $data->like = $this->countLike($data->id);
            $isUserLike = $this->userLike($data->id, '', 'parent', $this->token->parent_id);
            if ($isUserLike > 0) 
            {
                $data->is_like = 1;
            } else {
                $data->is_like = 0;
            }
            return $data;
        }
        else
        {
            return false;
        }
    }
    
    public function userDetail($id)
    {
        $this->db->where("id",$id);
        $query = $this->db->get("alluser");
        if($query->num_rows() > 0)
        {
            return $query->row();
        }
        else
        {
            return false;
        }
    }

    public function getAttachment($id) {
        $this->db->select('id,attachment as file');
        $this->db->from('discussion_attachment');
        $this->db->where('discussion_id', $id);
        $this->db->where('status', 1);
        $this->db->order_by('id', 'ASC');
        
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result();
        } else {
            return array();
        }
    }

    public function countComment($id) {
        $this->db->select('*');
        $this->db->from('discussion_comment');
        $this->db->where('discussion_id', $id);
        $this->db->where('deleted', 0);
        $this->db->where('status', '1');
        $query = $this->db->get();
        return $query->num_rows();
    }

    public function countLike($id ) {
        $this->db->select('*');
        $this->db->from('discussion_like');
        $this->db->where('discussion_id', $id);
        $this->db->where('status', '1');
        $query = $this->db->get();
        return $query->num_rows();
    }

    public function userLike($id , $attachId = '') {
        $userType = 'parent';
        $userId = $this->token->parent_id;        
        $userId = "P-" . $userId;        
        $this->db->select('*');
        $this->db->from('discussion_like');
        $this->db->where('discussion_id', $id);        
        $this->db->where('user_id', $userId);
        $isLike = $this->db->get();        
        return $isLike->num_rows();
    }
    
    function getCategory() {
        $this->db->where('school_id',$this->token->school_id);
        $this->db->where('status',1);
        $query = $this->db->get('discussion_category');
        if($query->num_rows() > 0)
        {
            return $query->result();
        }
        else
        {
            return array();
        }
    }
    
    public function insertComment($commentData = array()) {
        $this->db->insert('discussion_comment', $commentData);
        return true;
    }
    public function updateComment($id,$user_id,$commentData = array()) {
        $this->db->where("user_id",$user_id);
        $this->db->where("id",$id);
        $this->db->update('discussion_comment', $commentData);
        return $this->db->affected_rows(); 
    }
    public function deleteComment($id,$user_id) {
        $this->db->where("user_id",$user_id);
        $this->db->where("id",$id);
        $this->db->update('discussion_comment', array('deleted'=>1));
        
        $this->db->select("discussion_id");
        $this->db->from('discussion_comment');
        //$this->db->where("user_id",$user_id);
        $this->db->where("id",$id);
        $query = $this->db->get();
        return $query->row()->discussion_id; 
    }

    public function insertLike($commentData = array()) {
        $this->db->insert('discussion_like', $commentData);
        return true;
    }
    
    public function isUserLike($likeData = array()) {
        $this->db->select('*');
        $this->db->from('discussion_like');
        $this->db->where('discussion_id', $likeData['discussion_id']);
        $this->db->where('user_id', $likeData['user_id']);
        $this->db->where('user_type', $likeData['user_type']);
        $query = $this->db->get();
        return $query->num_rows();
    }

    public function deleteUserLike($likeData = array()) {
        $this->db->where('discussion_id', $likeData['discussion_id']);
        $this->db->where('user_id', $likeData['user_id']);
        $this->db->where('user_type', $likeData['user_type']);
        $this->db->delete('discussion_like');
        return true;
    }
    
    public function getComments($id) {
        $this->db->select('al.*,au.fname,au.lname,au.photo');
        $this->db->from('discussion_comment al');
        $this->db->join('alluser au', 'al.user_id=au.id', 'LEFT');
        $this->db->where('discussion_id', $id);
        $this->db->where('deleted', 0);
        $comment = $this->db->get();
        $comment_row = $comment->result_array();
        for($i=0; $i <count($comment_row);$i++)
        {
            $tmp = explode('-',$comment_row[$i]['user_id']);
            $comment_row[$i]['user_id'] = $tmp[1];
        }
        return $comment_row;
    }
}
