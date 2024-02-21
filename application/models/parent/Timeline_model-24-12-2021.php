<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Timeline_model extends CI_Model {
    function addPost($data) {
        $this->emojidb = $this->load->database('emojidb', TRUE);
        $this->emojidb->insert('timeline', $data);
        return $this->emojidb->insert_id();
    }
    function addAttachment($data) {
        $this->db->insert('timeline_attachment', $data);
        return $this->db->insert_id();
    }

    function allData() {
        $this->emojidb = $this->load->database('emojidb', TRUE);
        $schoolId = $this->token->school_id; 
        $user_id = $this->token->user_id;
        
        $this->emojidb->select("t.*");
        $this->emojidb->from("timeline t");
        $this->emojidb->where("t.school_id",$schoolId);
        $this->emojidb->where("t.status",1);
        $this->emojidb->order_by("t.id","DESC");
        if (isset($_GET['page'])) 
        {
            $page = $_GET['page'];
            $limit = 10;
            if(isset($_GET['limit']))
            {
                $limit = $_GET['limit'];
            }
            $offset = ($page - 1) * $limit;

            $this->emojidb->limit($limit, $offset);
        }
        
        $row = $this->emojidb->get();
        $data = $row->result();
        if (!empty($data)) {
            for ($i = 0; $i < count($data); $i++) {
                $this->load->helper('common');
                $data[$i]->created = time_elapsed_string($data[$i]->created);
                $data[$i]->attachment = $this->getAttachment($data[$i]->id);
                $data[$i]->comments = $this->countComment($data[$i]->id);
                $data[$i]->like = $this->countLike($data[$i]->id);
                $isUserLike = $this->userLike($data[$i]->id, '', 'parent', $user_id);
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
        $this->db->select("count(t.id) as total");
        $this->db->from("timeline t");
        $this->db->where("t.school_id",$schoolId);
        $this->db->where("t.status",1);                
        $query = $this->db->get();
        return $query->row()->total;
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
        $this->db->from('timeline_attachment');
        $this->db->where('timeline_id', $id);
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
        $this->db->from('timeline_comment');
        $this->db->where('timeline_id', $id);
        $this->db->where('status', '1');
        $query = $this->db->get();
        return $query->num_rows();
    }

    public function countLike($id ) {
        $this->db->select('*');
        $this->db->from('timeline_like');
        $this->db->where('timeline_id', $id);
        $this->db->where('status', '1');
        $query = $this->db->get();
        return $query->num_rows();
    }

    public function userLike($id , $attachId = '') {
        $userType = 'parent';
        $userId = "P-" . $this->token->user_id;
        
        $this->db->select('*');
        $this->db->from('timeline_like');
        $this->db->where('timeline_id', $id);
        if($attachId != '')
        {
            $this->db->where('attachment_id', $attachId);
        }
        $this->db->where('user_id', $userId);
        $isLike = $this->db->get();
        
        return $isLike->num_rows();
    }

    function getDetail($id) {
        $this->emojidb = $this->load->database('emojidb', TRUE);
        $query = "select id,description,user_id,user_type from timeline where id='" . $id . "'";
        $row = $this->emojidb->query($query);
        $data = $row->result();
        $userDetail = $this->userDetail($data[0]->user_id);
        if($userDetail != false)
        {
            $data[0]->create_by = $userDetail->fname." ".$userDetail->lname;                    
            $data[0]->create_by_photo = base_url()."img/".$data[0]->user_type."/".$userDetail->photo;
        }
        if (!empty($data)) {
            $query1 = "select * from timeline_attachment where timeline_id='" . $data[0]->id . "'";
            $row1 = $this->db->query($query1);
            $data1 = $row1->result();
                                    
            $data[0]->attachmentData = $data1;
            if (!empty($data)) {
                for ($i = 0; $i < count($data); $i++) {
                    for ($j = 0; $j < count($data[$i]->attachmentData); $j++) {
                        $data[$i]->attachmentData[$j]->comments = $this->countAttachmentComment($id,$data[$i]->attachmentData[$j]->id);
                        $data[$i]->attachmentData[$j]->like = $this->countAttachmentLike($id,$data[$i]->attachmentData[$j]->id);
                        $isUserLike = $this->userLike($id, $data[$i]->attachmentData[$j]->id);
                        if ($isUserLike > 0) {
                            $data[$i]->attachmentData[$j]->is_like = 1;
                        } else {
                            $data[$i]->attachmentData[$j]->is_like = 0;
                        }
                    }
                }
                return $data;
            } else {
                return array();
            }
        } else {
            return array();
        }
    }

    public function countAttachmentComment($timeline_id,$attachment_id = '') {
        $this->db->select('*');
        $this->db->from('timeline_comment');
        $this->db->where('timeline_id', $timeline_id);
        if($attachment_id > 0)
        {
            $this->db->where('attachment_id', $attachment_id);
        }
        $this->db->where('status', '1');
        $query = $this->db->get();
        return $query->num_rows();
    }

    public function countAttachmentLike($timeline_id,$attachment_id = '') {
        $this->db->select('*');
        $this->db->from('timeline_like');
        $this->db->where('timeline_id', $timeline_id);
        if($attachment_id > 0)
        {
            $this->db->where('attachment_id', $attachment_id);
        }
        $this->db->where('status', '1');
        $query = $this->db->get();
        return $query->num_rows();
    }

    public function insertComment($commentData = array()) {
        $this->emojidb = $this->load->database('emojidb', TRUE);
        $this->emojidb->insert('timeline_comment', $commentData);
        return true;
    }

    public function insertLike($commentData = array()) {
        $this->db->insert('timeline_like', $commentData);
        return true;
    }
    
    public function isUserLike($likeData = array()) {
        $this->db->select('*');
        $this->db->from('timeline_like');
        $this->db->where('attachment_id', $likeData['attachment_id']);
        $this->db->where('timeline_id', $likeData['timeline_id']);
        $this->db->where('user_id', $likeData['user_id']);
        $this->db->where('user_type', $likeData['user_type']);
        $query = $this->db->get();
        return $query->num_rows();
    }

    public function deleteUserLike($likeData = array()) {
        $this->db->where('timeline_id', $likeData['timeline_id']);
        $this->db->where('attachment_id', $likeData['attachment_id']);
        $this->db->where('user_id', $likeData['user_id']);
        $this->db->where('user_type', $likeData['user_type']);
        $this->db->delete('timeline_like');
        return true;
    }
    
    public function getAttachmentDetail($timeline_id = '', $attachId = '', $schoolId = '', $userid = '', $userType = '') {
        $userid = "P-" . $userid;
        $this->emojidb = $this->load->database('emojidb', TRUE);
        $this->db->select('*');
        $this->db->from('timeline_like');
        $this->db->where('timeline_id', $timeline_id);
        if($attachId >0)
        {
            $this->db->where('attachment_id', $attachId);
        }
        $this->db->where('user_id', $userid);
        $this->db->where('school_id', $schoolId);
        $this->db->where('user_type', $userType);
        $isLike = $this->db->get();
        
        $isUserLike = $isLike->num_rows();

        $this->emojidb->select('t1.*,t2.description');
        $this->emojidb->from('timeline_attachment t1');
        $this->emojidb->join('timeline t2', 't1.timeline_id=t2.id', 'LEFT');
        if($attachId > 0)
        {
            $this->emojidb->where('t1.id', $attachId);
        }
        
        $attachDetail = $this->emojidb->get();
        
        $attachDetails = $attachDetail->row();
        if ($attachDetails) {
            $attachDetails->comments = $this->countAttachmentComment($timeline_id,$attachId);
            $attachDetails->likes = $this->countAttachmentLike($timeline_id,$attachId);
            if ($isUserLike > 0) {
                $attachDetails->is_like = 1;
            } else {
                $attachDetails->is_like = 0;
            }
            return $attachDetails;
        }
        return array("data"=>"no data");
    }

    public function getAttachmentComments($timeline_id = '', $attachId = '') {
        $this->emojidb = $this->load->database('emojidb', TRUE);
        $this->emojidb->select('al.*,au.fname,au.lname,au.photo');
        $this->emojidb->from('timeline_comment al');
        $this->emojidb->join('alluser au', 'al.user_id=au.id', 'LEFT');
        $this->emojidb->where('timeline_id', $timeline_id);
        if($attachId  >0 )
        {
            $this->emojidb->where('attachment_id', $attachId);
        }
        $this->emojidb->order_by('al.created_time','DESC');
        $comment = $this->emojidb->get();
        $comment_row = $comment->result_array();
        return $comment_row;
    }
}
