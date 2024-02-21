<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Article_model extends CI_Model {    
   public function articleList($school_id = '', $user_id = '', $usertype = '') {

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
        $this->db->select("*");
        $this->db->from('article');
        $this->db->where('status', 1);
        $this->db->where('schoolId', $school_id);
        $this->db->order_by($order,$orderBY);
        $query = $this->db->get();
        
        if ($query->num_rows() > 0) {
            $dataArticle = $query->result();
            for ($i = 0; $i < count($dataArticle); $i++) {
                $dataArticle[$i]->created_time = date('d M,Y', strtotime($dataArticle[$i]->created_time));
                $dataArticle[$i]->comments = $this->countArticleComment($dataArticle[$i]->id);
                $dataArticle[$i]->like = $this->countArticleLike($dataArticle[$i]->id);
                $dataArticle[$i]->view = $this->countArticleView($dataArticle[$i]->id);
                $islikeArr = array();
                $islikeArr['article_id'] = $dataArticle[$i]->id;
                $islikeArr['user_id'] = "P-".$user_id;
                $islikeArr['user_type'] = $usertype;
                $dataArticle[$i]->is_like = $this->isUserLike($islikeArr);
            }
            return $dataArticle;
        } else {
            return false;
        }
    }

    public function viewArticleDetails($article_id = '', $user_id = '', $usertype = '') {
        $viewData = array(
            'article_id'=>$article_id,
            'schoolId'=>$this->token->school_id,
            'user_id'=>$user_id,
            'user_type'=>$usertype,
            'created_time'=>date("Y-m-d H:i:s")
        );
        
        $this->inserArticleView($viewData);        
        
        $this->db->select("*");
        $this->db->from('article');
        $this->db->where('id', $article_id);
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            $dataArticle = $query->result();
            $commentArray = array();
            for ($i = 0; $i < count($dataArticle); $i++) {
                $dataArticle[$i]->created_time = date('d M,Y', strtotime($dataArticle[$i]->created_time));
                $dataArticle[$i]->comments = $this->countArticleComment($dataArticle[$i]->id);
                $dataArticle[$i]->like = $this->countArticleLike($dataArticle[$i]->id);
                $dataArticle[$i]->view = $this->countArticleView($dataArticle[$i]->id);
                $commentData = $this->getCommentByArticleId($dataArticle[$i]->id);
                $dataArticle[0]->commentList = $commentData;
                $islikeArr = array();
                $islikeArr['article_id'] = $dataArticle[$i]->id;
                $islikeArr['user_id'] = "P-".$user_id;
                $islikeArr['user_type'] = $usertype;
                $dataArticle[$i]->is_like = $this->isUserLike($islikeArr);
            }

            return $dataArticle;
        } else {
            return false;
        }
    }
    
    public function inserArticleComment($commentData = array()) {
        $this->db->insert('article_comment', $commentData);
        return true;
    }

    public function inserArticleLike($likeData = array()) {
        $this->db->insert('article_like', $likeData);
        return true;
    }
    public function inserArticleView($viewData = array()) {
        $this->db->where('article_id',$viewData['article_id']);
        $this->db->where('schoolId',$this->token->school_id);
        $this->db->where('user_id',$viewData['user_id']);
        $this->db->where('user_type',$viewData['user_type']);
        $query = $this->db->get("article_view");
        
        if($query->num_rows() == 0)
        {
            $this->db->insert('article_view', $viewData);
        }
        return true;
    }

    public function countArticleComment($article_id = '') {
        $this->db->select('*');
        $this->db->from('article_comment');
        $this->db->where('article_id', $article_id);
        $this->db->where('status', '1');
        $query = $this->db->get();
        return $query->num_rows();
    }

    public function countArticleLike($article_id = '') {
        $this->db->select('*');
        $this->db->from('article_like');
        $this->db->where('article_id', $article_id);
        $this->db->where('status', '1');
        $query = $this->db->get();
        return $query->num_rows();
    }

    public function countArticleView($article_id = '') {
        $this->db->select('*');
        $this->db->from('article_view');
        $this->db->where('article_id', $article_id);
        $query = $this->db->get();
        return $query->num_rows();
    }
    
    public function getCommentByArticleId($articleId = '') {
        $this->db->select('c.comment,c.id as cid,au.id as uid,au.fname,au.lname,au.photo');
        $this->db->from('article_comment c');
        $this->db->join('alluser au', 'c.user_id=au.id', 'LEFT');
        $this->db->where('article_id', $articleId);
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result();
        } else {
            return array();
        }
    }

    public function isUserLike($likeData = array()) {
        $this->db->select('*');
        $this->db->from('article_like');
        $this->db->where('article_id', $likeData['article_id']);
        $this->db->where('user_id', $likeData['user_id']);
        $this->db->where('user_type', $likeData['user_type']);
        $query = $this->db->get();
        return $query->num_rows();
    }

    public function deleteUserLike($likeData = array()) {
        $this->db->where('article_id', $likeData['article_id']);
        $this->db->where('user_id', $likeData['user_id']);
        $this->db->where('user_type', $likeData['user_type']);
        $this->db->delete('article_like');
        return true;
    }

    function insertArticleViewUser($viewData = array()) {
        $this->db->insert('article_view', $viewData);
        return true;
    }

    public function isUserView($viewData = array()) {
        $this->db->select('*');
        $this->db->from('article_view');
        $this->db->where('article_id', $viewData['article_id']);
        $this->db->where('user_id', $viewData['user_id']);
        $this->db->where('user_type', $viewData['user_type']);
        $query = $this->db->get();
        return $query->num_rows();
    }

}
