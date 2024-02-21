<?php
defined('BASEPATH') OR exit('No direct script access allowed');
require APPPATH . '/libraries/REST_Controller.php';

class Discussion extends REST_Controller {

    public $error = array();
    public $data = array();

    function __construct() {
        parent::__construct();
        $this->token->parent_validate();
        $this->load->library("security");
        $this->load->library('form_validation');
        $this->load->model('parent/discussion_model');
        $this->load->helper('common_helper');
    }
    
    public function index_get(){
        $data = $this->discussion_model->allData();
        $total = $this->discussion_model->allDataCount();
        
        $return['success'] = "true";
        $return['title'] = "success";
        $return['message'] = "Record found successfully.";
        $return['classData'] = $data;
        $return['total'] = $total;
        $return['error'] = $this->error;
        $this->response($return, REST_Controller::HTTP_OK);
        
    }
    
    public function index_post() {
        $postData = $_POST;
        $dataid = '';
                                       
        $postData = $this->security->xss_clean($postData);
        $this->form_validation->set_error_delimiters('', '');
        $this->form_validation->set_data($postData);
        $this->form_validation->set_rules('detail', 'Detail', 'trim|required');
        $this->form_validation->set_rules('discussion_type', 'Discussion Type', 'trim|required');

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
        
        
        $formData = array();
        $formData['detail'] = $postData['detail'];
        $formData['discussion_type'] = $postData['discussion_type'];
        $formData['optional_detail'] = $postData['optional_detail'];
        $formData['school_id'] = $this->token->school_id;
        $formData['user_id'] = "P-".$this->token->user_id;
        $formData['user_type'] = "parent";
        $formData['created'] = date("Y-m-d H:i:s");
        
        $arrFiles = array();        
        if (!empty($_FILES['files'])){
            $uploadPath = 'img/discussion/';
            $config['upload_path'] = $uploadPath;
            $config['allowed_types'] = 'jpg|jpeg|gif|png|doc|docx|pdf';
            $config['max_size'] = 500000;
            $config['encrypt_name'] = TRUE;
            $this->load->library('upload', $config);
            $this->upload->initialize($config);
            for ($i = 0; $i < count($_FILES['files']['name']); $i++) {
                if ($_FILES['files']['name'][$i] != '') {
                    $_FILES['file']['name'] = $_FILES['files']['name'][$i];
                    $_FILES['file']['type'] = $_FILES['files']['type'][$i];
                    $_FILES['file']['tmp_name'] = $_FILES['files']['tmp_name'][$i];
                    $_FILES['file']['error'] = $_FILES['files']['error'][$i];
                    $_FILES['file']['size'] = $_FILES['files']['size'][$i];

                    if ($this->upload->do_upload('file')) {
                        $uplodimg = $this->upload->data();
                        $fileData = array();
                        $fileData['discussion_id'] = '';
                        $fileData['attachment'] = $uplodimg['file_name'];                        
                        $fileData['status'] = 1;
                        array_push($arrFiles,$fileData);
                    } else {

                        $uploaderror = $this->upload->display_errors();
                        $return['success'] = "false";
                        $return['message'] = $uploaderror;
                        $return['error'] = $this->error;
                        $return['data'] = $this->data;
                        $this->response($return, REST_Controller::HTTP_BAD_REQUEST);
                    }
                }
            }
        }
        

        $dataid = $this->discussion_model->addPost($formData);
        $this->data = $dataid;
        if ($dataid) {
            if (!empty($arrFiles)) {
                foreach ($arrFiles as $photoData)
                {
                    $photoData['discussion_id'] = $dataid;
                    $photoId = $this->discussion_model->addAttachment($photoData);
                }
            }
            
            $return['success'] = "true";
            $return['title'] = "success";
            $return['message'] = "Discussion created successfully.";
            $return['error'] = (object) $this->error;
            $return['data'] = $this->data;
            $this->response($return, REST_Controller::HTTP_OK);
        }
        $return['success'] = "false";
        $return['title'] = "error";
        $return['message'] = "Discussion not created.";
        $return['error'] = (object) $this->error;
        $return['data'] = (object) $this->data;

        $this->response($return, REST_Controller::HTTP_BAD_REQUEST);
    }

    public function detail_get($id = '') {
        $detailData = $this->discussion_model->getDetail($id);
        $return['success'] = "true";
        $return['title'] = "success";
        $return['message'] = $detailData ? "Discussion Detail" : "No data found";
        $return['dataList'] = $detailData;
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
        $this->form_validation->set_rules('discussion_id', 'Discussion Id', 'trim|required');
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
        $commentData['discussion_id'] = $postData['discussion_id'];
        $commentData['user_id'] = "P-" . $this->token->user_id;                        
        $commentData['school_id'] = $this->token->school_id;                        
        $commentData['user_type'] = 'parent';
        $commentData['comment'] = $postData['comment'];
        $commentData['created_time'] = date("Y-m-d H:i:s");
        $commentData['status'] = '1';
        $totalComment = 0;        
        $result = $this->discussion_model->insertComment($commentData);        
        if ($result) {
            $this->data = $result;
            $totalComment = $this->discussion_model->countComment($postData['discussion_id']);
            $comments = $this->discussion_model->getComments($postData['discussion_id']);
            
            $return['success'] = "true";
            $return['title'] = "success";
            $return['message'] = "Comment successfully submitted.";
            $return['error'] = (object) $this->error;
            $return['data'] = array('total'=>$totalComment,'comments'=>$comments);

            $this->response($return, REST_Controller::HTTP_OK);
        }

        $return['success'] = "false";
        $return['title'] = "error";
        $return['message'] = "Comment not submitted.";
        $return['error'] = (object) $this->error;
        $return['data'] = (object) $this->data;

        $this->response($return, REST_Controller::HTTP_BAD_REQUEST);
    }
    
    public function comment_put() {
        $postData = json_decode(file_get_contents('php://input'), true);
        if ($postData == '') {
            $postData = $_POST;
        }

        $postData = $this->security->xss_clean($postData);
        $this->form_validation->set_error_delimiters('', '');
        $this->form_validation->set_data($postData);
        $this->form_validation->set_rules('discussion_id', 'Discussion Id', 'trim|required');
        $this->form_validation->set_rules('id', 'Id', 'trim|required');
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
        $discussion_id = $postData['discussion_id'];
        $id = $postData['id'];
        $user_id = "P-" . $this->token->user_id;                        
        $commentData['comment'] = $postData['comment'];
        $commentData['is_edited'] = 1;
        $totalComment = 0;        
        $result = $this->discussion_model->updateComment($id,$user_id,$commentData);        
        if ($result) {
            $this->data = $result;
            $totalComment = $this->discussion_model->countComment($discussion_id);
            $comments = $this->discussion_model->getComments($discussion_id);
            
            $return['success'] = "true";
            $return['title'] = "success";
            $return['message'] = "Comment successfully updated.";
            $return['error'] = (object) $this->error;
            $return['data'] = array('total'=>$totalComment,'comments'=>$comments);

            $this->response($return, REST_Controller::HTTP_OK);
        }

        $return['success'] = "false";
        $return['title'] = "error";
        $return['message'] = "Comment not updated.";
        $return['error'] = (object) $this->error;
        $return['data'] = (object) $this->data;

        $this->response($return, REST_Controller::HTTP_BAD_REQUEST);
    }
    public function comment_delete($id='') {
        if($id != '')
        {
            $user_id = "P-" . $this->token->user_id;    
            $discussion_id = $this->discussion_model->deleteComment($id,$user_id);        
            if ($discussion_id) {
                $this->data = $discussion_id;
                $totalComment = $this->discussion_model->countComment($discussion_id);
                $comments = $this->discussion_model->getComments($discussion_id);

                $return['success'] = "true";
                $return['title'] = "success";
                $return['message'] = "Comment successfully deleted.";
                $return['error'] = (object) $this->error;
                $return['data'] = array('total'=>$totalComment,'comments'=>$comments);
            }
            $this->response($return, REST_Controller::HTTP_OK);
        }

        $return['success'] = "false";
        $return['title'] = "error";
        $return['message'] = "Comment not deleted.";
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
        $this->form_validation->set_rules('discussion_id', 'Timeline Id', 'trim|required');

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
        $commentData['discussion_id'] = $postData['discussion_id'];
        $commentData['school_id'] = $this->token->school_id;
        $commentData['user_id'] = "P-" . $this->token->user_id;
        
        $commentData['user_type'] = 'parent';
        $commentData['status'] = '1';
        
        $totalLike =0;
        $is_like = 0;
       
        $checkArticleLike = $this->discussion_model->isUserLike($commentData);
        if ($checkArticleLike > 0) {
            $this->discussion_model->deleteUserLike($commentData);
            $totalLike = $this->discussion_model->countLike($postData['discussion_id']);
            $isUserLike = $this->discussion_model->userLike($postData['discussion_id']);
            if ($isUserLike > 0) {
                $is_like = 1;
            } else {
                $is_like = 0;
            }
          
            $return['success'] = "true";
            $return['title'] = "success";
            $return['message'] = "Already like.";
            $return['error'] = (object) $this->error;
            $return['data'] = array('like'=>$totalLike,'is_like'=>$is_like);
            $this->response($return, REST_Controller::HTTP_OK);
        }
        $result = $this->discussion_model->insertLike($commentData);
        if ($result) {
            $this->data = $result;
            if($postData['discussion_id'] != '')
            {
                $totalLike = $this->discussion_model->countLike($postData['discussion_id']);
                $isUserLike = $this->discussion_model->userLike($postData['discussion_id']);
                if ($isUserLike > 0) {
                    $is_like = 1;
                } else {
                    $is_like = 0;
                }
            }
            $return['success'] = "true";
            $return['title'] = "success";
            $return['message'] = "Successfull";
            $return['error'] = (object) $this->error;
            $return['data'] = array('like'=>$totalLike,'is_like'=>$is_like);;

            $this->response($return, REST_Controller::HTTP_OK);
        }        
                
        $return['success'] = "false";
        $return['title'] = "error";
        $return['message'] = "Not successfull";
        $return['error'] = (object) $this->error;
        $return['data'] = (object) $this->data;

        $this->response($return, REST_Controller::HTTP_BAD_REQUEST);
    }
    
    public function comment_get($discussion_id) {
        $getComments = $this->discussion_model->getComments($discussion_id);

        if ($getComments) {
            $return['success'] = "true";
            $return['title'] = "success";
            $return['message'] = "Success";
            $return['data'] = $getComments;
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
    
    public function category_get(){
        $data = $this->discussion_model->getCategory();
        
        $return['success'] = "true";
        $return['title'] = "success";
        $return['message'] = "Record found successfully.";
        $return['data'] = $data;
        $return['error'] = $this->error;
        $this->response($return, REST_Controller::HTTP_OK);
    }
}
