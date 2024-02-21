<?php
defined('BASEPATH') OR exit('No direct script access allowed');
require APPPATH . '/libraries/REST_Controller.php';

class Article extends REST_Controller {

    public $error = array();
    public $data = array();

    function __construct() {
        parent::__construct();
        $this->token->parent_validate();
        $this->load->library("security");
        $this->load->library('form_validation');
        $this->load->model('parent/article_model','model');
        $this->load->helper('common_helper');
    }
            
    public function index_get() {
        $schoolId  = $this->token->school_id;
        $user_id  = $this->token->user_id;
        $usertype  = 'parent';
        $articleResult = $this->model->articleList($schoolId, $user_id, $usertype);
        $return['success'] = "true";
        $return['title'] = "success";
        $return['message'] = $articleResult ? 'Record found successfully.' : "No record found.";
        $return['data'] = $articleResult ? $articleResult : array();
        $return['error'] = $this->error;
        $this->response($return, REST_Controller::HTTP_OK);
    }

    public function detail_get() {
        $articleId = $this->input->get('articleId');
        $user_id = $this->token->user_id;
        $user_type = 'parent';
        $articleResult = $this->model->viewArticleDetails($articleId, $user_id, $user_type);
        $return['success'] = "true";
        $return['title'] = "success";
        $return['message'] = $articleResult ? 'Record found successfully.' : "No record found.";
        $return['data'] = $articleResult ? $articleResult : array();
        $return['error'] = $this->error;
        $this->response($return, REST_Controller::HTTP_OK);
    }
    
    public function comment_post() {
        $postData = json_decode(file_get_contents('php://input'), true);
        if ($postData == '') {
            $postData = $_POST;
        }
        $postData = $this->security->xss_clean($postData);
        $this->form_validation->set_error_delimiters('', '');
        $this->form_validation->set_data($postData);
        $this->form_validation->set_rules('comment', 'Comment', 'trim|required');
        $this->form_validation->set_rules('article_id', 'Article Id', 'trim|required');

        if ($this->form_validation->run() === false) {
            $this->error = $this->form_validation->error_array();
            $message = validation_errors();
            $return['success'] = "false";
            $return['title'] = "error";
            $return['message'] = "$message";
            $return['error'] = $this->error;
            $return['data'] = (object) $this->data;
            $this->response($return, REST_Controller::HTTP_BAD_REQUEST);
        }
        $commentData = array();
        $commentData['schoolId'] = $this->token->school_id;
        $commentData['article_id'] = $postData['article_id'];
        $commentData['user_id'] = "P-" . $this->token->user_id;
        
        $commentData['user_type'] = 'parent';
        $commentData['comment'] = $postData['comment'];
        $commentData['status'] = '1';
        $commentData['created_time'] = date("Y-m-d H:i:s");
        $result = $this->model->inserArticleComment($commentData);
        if ($result) {
            $this->data = $result;
            $return['success'] = "true";
            $return['title'] = "success";
            $return['message'] = "Comment successfully submitted.";
            $return['error'] = (object) $this->error;
            $return['data'] = $this->data;

            $this->response($return, REST_Controller::HTTP_OK);
        }

        $return['success'] = "false";
        $return['title'] = "error";
        $return['message'] = "Comment not submitted.";
        $return['error'] = (object) $this->error;
        $return['data'] = (object) $this->data;

        $this->response($return, REST_Controller::HTTP_BAD_REQUEST);
    }

    public function like_post() {
        $postData = json_decode(file_get_contents('php://input'), true);
        if ($postData == '') {
            $postData = $_POST;
        }
        $postData = $this->security->xss_clean($postData);
        $this->form_validation->set_error_delimiters('', '');
        $this->form_validation->set_data($postData);
        $this->form_validation->set_rules('article_id', 'Article Id', 'trim|required');

        if ($this->form_validation->run() === false) {
            $this->error = $this->form_validation->error_array();
            $message = validation_errors();
            $return['success'] = "false";
            $return['title'] = "error";
            $return['message'] = "$message";
            $return['error'] = $this->error;
            $return['data'] = (object) $this->data;
            $this->response($return, REST_Controller::HTTP_BAD_REQUEST);
        }
        $likeData = array();
        $likeData['schoolId'] = $this->token->school_id;
        $likeData['article_id'] = $postData['article_id'];
        $likeData['user_id'] = "P-".$this->token->user_id;
        
        $likeData['user_type'] = 'parent';
        $likeData['status'] = '1';

        $checkArticleLike = $this->model->isUserLike($likeData);
        if ($checkArticleLike > 0) {
            $this->model->deleteUserLike($likeData);
            $return['success'] = "true";
            $return['title'] = "success";
            $return['message'] = "Already like.";
            $return['error'] = (object) $this->error;
            $return['data'] = 0;
            $this->response($return, REST_Controller::HTTP_OK);
        }
        $result = $this->model->inserArticleLike($likeData);
        if ($result) {
            $this->data = $result;
            $return['success'] = "true";
            $return['title'] = "success";
            $return['message'] = "Like successfully submitted.";
            $return['error'] = (object) $this->error;
            $return['data'] = 1;
            $this->response($return, REST_Controller::HTTP_OK);
        }

        $return['success'] = "false";
        $return['title'] = "error";
        $return['message'] = "Like not submitted.";
        $return['error'] = (object) $this->error;
        $return['data'] = (object) $this->data;

        $this->response($return, REST_Controller::HTTP_BAD_REQUEST);
    }

    public function view_get($articleId = '') {
        $viewArr = array();
        $viewArr['article_id'] = $articleId;
        $viewArr['schoolId'] = $this->token->school_id;
        $viewArr['user_id'] = $this->token->user_id;
        $viewArr['user_type'] = 'parent';
        $checkUserView = $this->model->isUserView($viewArr);
        if ($checkUserView == 0) {
            $view_insert = $this->model->insertArticleViewUser($viewArr);
            if ($view_insert) {
                $return['success'] = "true";
                $return['title'] = "success";
                $return['message'] = "View Added";
                $return['view'] = $view_insert;
                $return['error'] = $this->error;
                $this->response($return, REST_Controller::HTTP_OK);
            }
        } else {
            $return['success'] = "true";
            $return['title'] = "success";
            $return['message'] = "View already Added";
            $return['view'] = 0;
            $return['error'] = $this->error;
            $this->response($return, REST_Controller::HTTP_OK);
        }
        $return['data'] = $this->data;
        $return['success'] = "false";
        $return['title'] = "error";
        $return['message'] = "Something went wrong.";
        $return['error'] = $this->error;
        $this->response($return, REST_Controller::HTTP_BAD_REQUEST);
    }

}
