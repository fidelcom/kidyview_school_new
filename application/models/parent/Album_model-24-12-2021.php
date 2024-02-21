<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Album_model extends CI_Model {    
    public function getAlbumDataList($schoolId = '', $parent_id = '') {
        $this->emojidb = $this->load->database('emojidb', TRUE);
        $query = "select * from album where album.schoolId='" . $schoolId . "' AND status=1 ORDER BY id DESC";
        $row = $this->emojidb->query($query);
        $albumdata = $row->result();
        if (!empty($albumdata)) {
            for ($i = 0; $i < count($albumdata); $i++) {
                $albumdata[$i]->attachment_type = $this->album_attachment_type($albumdata[$i]->id);
                $albumdata[$i]->attachment = $this->album_attachment($albumdata[$i]->id);
                $albumdata[$i]->comments = $this->countAlbumComment($albumdata[$i]->id);
                $albumdata[$i]->like = $this->countAlbumLike($albumdata[$i]->id);
                $isUserLike = $this->userAlbumLike($albumdata[$i]->id, '', 'parent', $parent_id);
                if ($isUserLike > 0) {
                    $albumdata[$i]->is_like = 1;
                } else {
                    $albumdata[$i]->is_like = 0;
                }
            }
            return $albumdata;
        } else {
            return array();
        }
    }
    public function album_attachment($album_id = '') {
        $this->db->select('attachment');
        $this->db->from('album_attachment');
        $this->db->where('albumId', $album_id);
        $this->db->where('status', 1);
        $this->db->order_by('id', 'ASC');
        $this->db->limit(1);
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->row('attachment');
        } else {
            return '';
        }
    }
    public function album_attachment_type($album_id = '') {
        $this->db->select('attachment_type');
        $this->db->from('album_attachment');
        $this->db->where('albumId', $album_id);
        $this->db->where('status', 1);
        $this->db->order_by('id', 'ASC');
        $this->db->limit(1);
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->row('attachment_type');
        } else {
            return '';
        }
    }

    public function countAlbumComment($album_id = '') {
        $this->db->select('*');
        $this->db->from('album_comment');
        $this->db->where('album_id', $album_id);
        $this->db->where('status', '1');
        $query = $this->db->get();
        return $query->num_rows();
    }

    public function countAlbumLike($album_id = '') {
        $this->db->select('*');
        $this->db->from('album_like');
        $this->db->where('album_id', $album_id);
        $this->db->where('status', '1');
        $query = $this->db->get();
        return $query->num_rows();
    }

    public function userAlbumLike($albumId = '', $attachId = '', $userType = '', $userId = '') {
        $userId = "P-" . $userId;
        
        $this->db->select('*');
        $this->db->from('album_like');
        $this->db->where('album_id', $albumId);
        if($attachId != '')
        {
            $this->db->where('attachment_id', $attachId);
        }
        $this->db->where('user_id', $userId);
        $isLike = $this->db->get();
        
        return $isLike->num_rows();
    }

    function getAttachmentByAlbumId($albumId = '', $userType = '', $userId = '') {
        $this->emojidb = $this->load->database('emojidb', TRUE);
        $query = "select id,title,description from album where id='" . $albumId . "'";
        $row = $this->emojidb->query($query);
        $albumDetaildata = $row->result();
        if (!empty($albumDetaildata)) {
            $query1 = "select * from album_attachment where albumId='" . $albumDetaildata[0]->id . "'";
            $row1 = $this->db->query($query1);
            $albumDetaildata1 = $row1->result();
            $albumDetaildata[0]->albumAttachmentData = $albumDetaildata1;
            if (!empty($albumDetaildata)) {
                for ($i = 0; $i < count($albumDetaildata); $i++) {
                    for ($j = 0; $j < count($albumDetaildata[$i]->albumAttachmentData); $j++) {
                        $albumDetaildata[$i]->albumAttachmentData[$j]->comments = $this->countAlbumAttachmentComment($albumDetaildata[$i]->albumAttachmentData[$j]->id);
                        $albumDetaildata[$i]->albumAttachmentData[$j]->like = $this->countAlbumAttachmentLike($albumDetaildata[$i]->albumAttachmentData[$j]->id);
                        $isUserLike = $this->userAlbumLike($albumId, $albumDetaildata[$i]->albumAttachmentData[$j]->id, $userType, $userId);
                        if ($isUserLike > 0) {
                            $albumDetaildata[$i]->albumAttachmentData[$j]->is_like = 1;
                        } else {
                            $albumDetaildata[$i]->albumAttachmentData[$j]->is_like = 0;
                        }
                    }
                }
                return $albumDetaildata;
            } else {
                return array();
            }
        } else {
            return array();
        }
    }

    public function countAlbumAttachmentComment($attachment_id = '') {
        $this->db->select('*');
        $this->db->from('album_comment');
        $this->db->where('attachment_id', $attachment_id);
        $this->db->where('status', '1');
        $query = $this->db->get();
        return $query->num_rows();
    }

    public function countAlbumAttachmentLike($attachment_id = '') {
        $this->db->select('*');
        $this->db->from('album_like');
        $this->db->where('attachment_id', $attachment_id);
        $this->db->where('status', '1');
        $query = $this->db->get();
        return $query->num_rows();
    }

    public function updateAlbumData($albumData = array(), $album_id = '') {
         $this->emojidb = $this->load->database('emojidb', TRUE);
        $this->emojidb->where('id', $album_id);
        $this->emojidb->update('album', $albumData);
        return true;
    }
    
    public function insertAlbumComment($commentData = array()) {
        $this->emojidb = $this->load->database('emojidb', TRUE);
        $this->emojidb->insert('album_comment', $commentData);
        return true;
    }

    public function insertAlbumLike($commentData = array()) {
        $this->db->insert('album_like', $commentData);
        return true;
    }
    
    public function isAlbumUserLike($likeData = array()) {
        $this->db->select('*');
        $this->db->from('album_like');
        $this->db->where('attachment_id', $likeData['attachment_id']);
        $this->db->where('album_id', $likeData['album_id']);
        $this->db->where('user_id', $likeData['user_id']);
        $this->db->where('user_type', $likeData['user_type']);
        $query = $this->db->get();
        return $query->num_rows();
    }
    
    public function deleteAlbumUserLike($likeData = array()) {
        $this->db->where('album_id', $likeData['album_id']);
        $this->db->where('attachment_id', $likeData['attachment_id']);
        $this->db->where('user_id', $likeData['user_id']);
        $this->db->where('user_type', $likeData['user_type']);
        $this->db->delete('album_like');
        return true;
    }
    
    public function getAttachmentDetail($albumId = '', $attachId = '', $schoolId = '', $userid = '') {       
        $this->db->select('*');
        $this->db->from('album_like');
        $this->db->where('album_id', $albumId);
        $this->db->where('attachment_id', $attachId);
        
        $this->db->where('user_id', $userid);
        $this->db->where('schoolId', $schoolId);
        $this->db->where('user_type', 'parent');
        $isLike = $this->db->get();
        $isUserLike = $isLike->num_rows();

        $this->db->select('t1.*,t2.title,t2.description');
        $this->db->from('album_attachment t1');
        $this->db->join('album t2', 't1.albumId=t2.id', 'LEFT');
        $this->db->where('t1.id', $attachId);
        $attachDetail = $this->db->get();
        $attachDetails = $attachDetail->row();
        if ($attachDetails) {
            $attachDetails->comments = $this->countAlbumAttachmentComment($attachId);
            $attachDetails->likes = $this->countAlbumAttachmentLike($attachId);
            if ($isUserLike > 0) {
                $attachDetails->is_like = 1;
            } else {
                $attachDetails->is_like = 0;
            }
        }
        return $attachDetails;
    }

    public function getAttachmentComments($albumId = '', $attachId = '') {
        $this->emojidb = $this->load->database('emojidb', TRUE);
        $this->emojidb->select('al.*,au.fname,au.lname,au.photo');
        $this->emojidb->from('album_comment al');
        $this->emojidb->join('alluser au', 'al.user_id=au.id', 'LEFT');
        $this->emojidb->where('album_id', $albumId);
        $this->emojidb->where('attachment_id', $attachId);
        $comment = $this->emojidb->get();
        $comment_row = $comment->result_array();
        return $comment_row;
    }
}
