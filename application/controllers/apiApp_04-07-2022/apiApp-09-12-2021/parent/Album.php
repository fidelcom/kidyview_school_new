<?php
defined('BASEPATH') OR exit('No direct script access allowed');
require APPPATH . '/libraries/REST_Controller.php';

class Album extends REST_Controller {

    public $error = array();
    public $data = array();

    function __construct() {
        parent::__construct();
        $this->token->parent_validate();
        $this->load->library("security");
        $this->load->library('form_validation');
        $this->load->model('parent/album_model','model');
        $this->load->helper('common_helper');
    }
            
    public function index_get(){
        $school_id =  $this->token->school_id; 
        $parent_id = $this->token->parent_id;
        $albumData = $this->model->getAlbumDataList($school_id, $parent_id);

        $return['success'] = "true";
        $return['title'] = "success";
        $return['message'] = $albumData ? "Album List" : "No album list yet";
        $return['albumList'] = $albumData;
        $return['error'] = $this->error;
        $this->response($return, REST_Controller::HTTP_OK);
    }
    public function attachment_get($album_id){
        $userId = $this->token->user_id;
        
        $albumDetailData = $this->model->getAttachmentByAlbumId($album_id, 'Parent', $userId);
        $return['success'] = "true";
        $return['title'] = "success";
        $return['message'] = $albumDetailData ? "Album Detail" : "No album list yet";
        $return['albumList'] = $albumDetailData;
        $return['error'] = $this->error;
        $this->response($return, REST_Controller::HTTP_OK);
    }    
    public function comment_get($album_id,$attachId){
        $userid = $this->token->parent_id;
        $schoolId = $this->token->school_id;
        $getAttachmentDetail = $this->model->getAttachmentDetail($album_id, $attachId, $schoolId, $userid);
        $getComments = $this->model->getAttachmentComments($album_id, $attachId);

        if ($getAttachmentDetail) {
            $return['success'] = "true";
            $return['title'] = "success";
            $return['message'] = "Success";
            $return['attachmentData'] = $getAttachmentDetail;
            $return['albumComment'] = $getComments;
            $return['error'] = $this->error;
            $this->response($return, REST_Controller::HTTP_OK);
        }
        $return['success'] = "false";
        $return['title'] = "error";
        $return['message'] = "Failure";
        $return['error'] = (object) $this->error;
        $return['data'] = (object) $this->data;
        $this->response($return, REST_Controller::HTTP_BAD_REQUEST);
    }    
    public function comment_post(){
        $postData = json_decode(file_get_contents('php://input'), true);
        if ($postData == '') {
            $postData = $_POST;
        }

        $postData = $this->security->xss_clean($postData);
        $this->form_validation->set_error_delimiters('', '');
        $this->form_validation->set_data($postData);
        $this->form_validation->set_rules('album_id', 'Album Id', 'trim|required');
        $this->form_validation->set_rules('attachment_id', 'Attachment Id', 'trim|required');
        $this->form_validation->set_rules('comment', 'Comment', 'trim|required');

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
        $commentData['album_id'] = $postData['album_id'];
        $commentData['attachment_id'] = $postData['attachment_id'];
        $commentData['schoolId'] = $this->token->school_id;
        $commentData['user_id'] = "P-" . $this->token->parent_id;
        
        $commentData['user_type'] = 'parent';
        $commentData['comment'] = $postData['comment'];
        $commentData['status'] = '1';

        $result = $this->model->insertAlbumComment($commentData);
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
    public function like_post(){
        $postData = json_decode(file_get_contents('php://input'), true);
        if ($postData == '') {
            $postData = $_POST;
        }
        $postData = $this->security->xss_clean($postData);
        $this->form_validation->set_error_delimiters('', '');
        $this->form_validation->set_data($postData);
        $this->form_validation->set_rules('album_id', 'Album Id', 'trim|required');
        $this->form_validation->set_rules('attachment_id', 'Attachment Id', 'trim|required');

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
        $commentData['album_id'] = $postData['album_id'];
        $commentData['attachment_id'] = $postData['attachment_id'];
        $commentData['schoolId'] = $this->token->school_id;
        $commentData['user_id'] = "P-" . $this->token->parent_id;        
        $commentData['user_type'] = 'parent';
        $commentData['status'] = '1';

        
        $checkAlbumLike = $this->model->isAlbumUserLike($commentData);
        if ($checkAlbumLike > 0) {
            $this->model->deleteAlbumUserLike($commentData);
            $return['success'] = "true";
            $return['title'] = "success";
            $return['message'] = "Already like.";
            $return['error'] = (object) $this->error;
            $return['data'] = 0;
            $this->response($return, REST_Controller::HTTP_OK);
        }
        $result = $this->model->insertAlbumLike($commentData);
        if ($result) {
            $this->data = $result;
            $return['success'] = "true";
            $return['title'] = "success";
            $return['message'] = "Like saved.";
            $return['error'] = (object) $this->error;
            $return['data'] = $this->data;

            $this->response($return, REST_Controller::HTTP_OK);
        }

        $return['success'] = "false";
        $return['title'] = "error";
        $return['message'] = "Not saved.";
        $return['error'] = (object) $this->error;
        $return['data'] = (object) $this->data;

        $this->response($return, REST_Controller::HTTP_BAD_REQUEST);
    }
}
