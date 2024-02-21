<?php
defined('BASEPATH') OR exit('No direct script access allowed');
require APPPATH . '/libraries/REST_Controller.php';

class Timeline extends REST_Controller {

    public $error = array();
    public $data = array();

    function __construct() {
        parent::__construct();
        $this->token->parent_validate();
        $this->load->library("security");
        $this->load->library('form_validation');
        $this->load->model('parent/timeline_model');
        $this->load->helper('common_helper');
    }
    
    public function index_get(){
        $data = $this->timeline_model->allData();
        $total = $this->timeline_model->allDataCount();
        
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
        
        $totalImageSize = 0;
        $maxphotosize = 2000;
        $imageArray = array('image/jpg', 'image/jpeg', 'image/gif', 'image/png', 'image/JPEG', 'image/JPG');

        if (!empty($_FILES['photo'])) {
            for ($i = 0; $i < count($_FILES['photo']['name']); $i++) {
                if ($_FILES['photo']['name'][$i] != '') {
                    $size = $_FILES['photo']['size'][$i];
                    $type = $_FILES['photo']['type'][$i];                    
                    $totalImageSize = $totalImageSize + $size;
                }
            }
            $totalphotosize = $totalImageSize / (1024 * 1024);
            if ($totalphotosize > $maxphotosize) {
                $this->error = $this->form_validation->error_array();
                $message = validation_errors();
                $return['success'] = "false";
                $return['title'] = "error";
                $return['message'] = "File size not greater than 20MB.";
                $return['error'] = $this->error;
                $this->response($return, REST_Controller::HTTP_BAD_REQUEST);
            }
        }

        /* check video size */
        $totalVideoSize = 0;
        $maxvideosize = 20;
        $videoArray = array('video/mp4', 'video/MP4,video/3gp', 'video/3GP', 'video/mkv', 'video/MKV');
        if (!empty($_FILES['video'])) {
            for ($i = 0; $i < count($_FILES['video']['name']); $i++) {
                if ($_FILES['video']['name'][$i] != '') {
                    $videosize = $_FILES['video']['size'][$i];
                    $videotype = $_FILES['video']['type'][$i];
                    $totalVideoSize = $totalVideoSize + $videosize;
                }
            }
            $totalvideosize = $totalVideoSize / (1024 * 1024);
            if ($totalvideosize > $maxvideosize) {
                $this->error = $this->form_validation->error_array();
                $message = validation_errors();
                $return['success'] = "false";
                $return['title'] = "error";
                $return['message'] = "File size not greater than 20MB.";
                $return['error'] = $this->error;
                $this->response($return, REST_Controller::HTTP_BAD_REQUEST);
            }
        }
        
        $postData = $this->security->xss_clean($postData);
        $this->form_validation->set_error_delimiters('', '');
        $this->form_validation->set_data($postData);
        $this->form_validation->set_rules('description', 'Description', 'trim|required');

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
        $formData['description'] = $postData['description'];
        $formData['school_id'] = $this->token->school_id;
        $formData['user_id'] = "P-".$this->token->user_id;
        $formData['user_type'] = "parent";
        $formData['created'] = date("Y-m-d H:i:s");
        $formData['status'] = 1;
        
        $arrPhoto = array();
        
        if (!empty($_FILES['photo'])){
            $uploadPath = 'img/timeline/';
            $config['upload_path'] = $uploadPath;
            $config['allowed_types'] = 'jpg|jpeg|gif|png';
            $config['max_size'] = 500000;
            $config['encrypt_name'] = TRUE;
            $this->load->library('upload', $config);
            $this->upload->initialize($config);
            for ($i = 0; $i < count($_FILES['photo']['name']); $i++) {
                if ($_FILES['photo']['name'][$i] != '') {
                    $_FILES['file']['name'] = $_FILES['photo']['name'][$i];
                    $_FILES['file']['type'] = $_FILES['photo']['type'][$i];
                    $_FILES['file']['tmp_name'] = $_FILES['photo']['tmp_name'][$i];
                    $_FILES['file']['error'] = $_FILES['photo']['error'][$i];
                    $_FILES['file']['size'] = $_FILES['photo']['size'][$i];

                    if ($this->upload->do_upload('file')) {
                        $uplodimg = $this->upload->data();
                        $photoData = array();
                        $photoData['timeline_id'] = '';
                        $photoData['attachment'] = $uplodimg['file_name'];
                        $photoData['attachment_type'] = "image";
                        $photoData['status'] = 1;
                        array_push($arrPhoto,$photoData);
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
        $arrVideo = array();
        if (!empty($_FILES['video'])) {
            $uploadPath = 'img/timeline/';
            $config['upload_path'] = $uploadPath;
            $config['allowed_types'] = 'mp4|MP4|3gp|3GP|mkv|MKV';
            $config['max_size'] = 500000;
            $config['encrypt_name'] = TRUE;
            $this->load->library('upload', $config);
            $this->upload->initialize($config);
            for ($i = 0; $i < count($_FILES['video']['name']); $i++) {
                if ($_FILES['video']['name'][$i] != '') {
                    $_FILES['file2']['name'] = $_FILES['video']['name'][$i];
                    $_FILES['file2']['type'] = $_FILES['video']['type'][$i];
                    $_FILES['file2']['tmp_name'] = $_FILES['video']['tmp_name'][$i];
                    $_FILES['file2']['error'] = $_FILES['video']['error'][$i];
                    $_FILES['file2']['size'] = $_FILES['video']['size'][$i];
                    if ($this->upload->do_upload('file2')) {
                        $uplodimg = $this->upload->data();
                        $videoData = array();
                        $videoData['timeline_id'] = '';
                        $videoData['attachment'] = $uplodimg['file_name'];
                        $videoData['attachment_type'] = "video";
                        $videoData['status'] = 1;
                        array_push($arrVideo,$videoData);
                    }
                    else {

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

        $dataid = $this->timeline_model->addPost($formData);
        $this->data = $dataid;
        if ($dataid) {
            if (!empty($arrPhoto)) {
                foreach ($arrPhoto as $photoData)
                {
                    $photoData['timeline_id'] = $dataid;
                    $photoId = $this->timeline_model->addAttachment($photoData);
                }
            }
            if (!empty($arrVideo)) {
                foreach ($arrVideo as $videoData)
                {
                    $videoData['timeline_id'] = $dataid;
                    $videoId = $this->timeline_model->addAttachment($videoData);
                }
            }

            $return['success'] = "true";
            $return['title'] = "success";
            $return['message'] = "Timeline added successfully.";
            $return['error'] = (object) $this->error;
            $return['data'] = $this->data;
            $this->response($return, REST_Controller::HTTP_OK);
        }
        $return['success'] = "false";
        $return['title'] = "error";
        $return['message'] = "Timeline not added.";
        $return['error'] = (object) $this->error;
        $return['data'] = (object) $this->data;

        $this->response($return, REST_Controller::HTTP_BAD_REQUEST);
    }

    public function detail_get($id = '') {
        $detailData = $this->timeline_model->getDetail($id);
        $return['success'] = "true";
        $return['title'] = "success";
        $return['message'] = $detailData ? "Timeline Detail" : "No timeline list yet";
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
        $this->form_validation->set_rules('timeline_id', 'Timeline Id', 'trim|required');
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
        $commentData['timeline_id'] = $postData['timeline_id'];
        $commentData['attachment_id'] = $postData['attachment_id'];
        $commentData['user_id'] = "P-" . $this->token->user_id;                        
        $commentData['school_id'] = $this->token->school_id;                        
        $commentData['user_type'] = 'parent';
        $commentData['comment'] = $postData['comment'];
        $commentData['status'] = '1';
        $commentData['created_time'] = date("Y-m-d H:i:s");
        $totalComment = 0;        
        $result = $this->timeline_model->insertComment($commentData);        
        if ($result) {
            $this->data = $result;
            if($postData['attachment_id'] != '' && $postData['attachment_id'] != null)
            {
                $totalComment = $this->timeline_model->countAttachmentComment($postData['timeline_id'],$postData['attachment_id']);
            }
            $return['success'] = "true";
            $return['title'] = "success";
            $return['message'] = "Comment successfully submitted.";
            $return['error'] = (object) $this->error;
            $return['data'] = array('comments'=>$totalComment);

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
        $this->form_validation->set_rules('timeline_id', 'Timeline Id', 'trim|required');
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
        $commentData['timeline_id'] = $postData['timeline_id'];
        $commentData['attachment_id'] = $postData['attachment_id'];
        $commentData['school_id'] = $this->token->school_id;
        $commentData['user_id'] = "P-" . $this->token->user_id;
        
        $commentData['user_type'] = 'parent';
        $commentData['status'] = '1';
        
        $totalLike =0;
        $is_like = 0;
       
        $checkArticleLike = $this->timeline_model->isUserLike($commentData);
        if ($checkArticleLike > 0) {
            $this->timeline_model->deleteUserLike($commentData);
            if($postData['attachment_id'] != '' && $postData['attachment_id'] != null)
            {
                $totalLike = $this->timeline_model->countAttachmentLike($postData['timeline_id'],$postData['attachment_id']);
                $isUserLike = $this->timeline_model->userLike($postData['timeline_id'], $postData['attachment_id'], 'teacher', $this->token->user_id);
                if ($isUserLike > 0) {
                    $is_like = 1;
                } else {
                    $is_like = 0;
                }
            }
            $return['success'] = "true";
            $return['title'] = "success";
            $return['message'] = "Already like.";
            $return['error'] = (object) $this->error;
            $return['data'] = array('like'=>$totalLike,'is_like'=>$is_like);
            $this->response($return, REST_Controller::HTTP_OK);
        }
        $result = $this->timeline_model->insertLike($commentData);
        if ($result) {
            $this->data = $result;
            if($postData['attachment_id'] != '' && $postData['attachment_id'] != null)
            {
                $totalLike = $this->timeline_model->countAttachmentLike($postData['timeline_id'],$postData['attachment_id']);
                $isUserLike = $this->timeline_model->userLike($postData['timeline_id'], $postData['attachment_id'], 'teacher', $this->token->user_id);
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
    
    public function comment_get($timeline_id = '', $attachment_id = 0) {
        $userid = $this->token->user_id;
        $userType = 'parent';
        $schoolId = $this->token->school_id;
        
        $getAttachmentDetail = $this->timeline_model->getAttachmentDetail($timeline_id, $attachment_id, $schoolId, $userid, $userType);
        $getComments = $this->timeline_model->getAttachmentComments($timeline_id, $attachment_id);

        if ($getComments) {
            $return['success'] = "true";
            $return['title'] = "success";
            $return['message'] = "Success";
            $return['attachmentData'] = $getAttachmentDetail;
            $return['timelineComment'] = $getComments;
            $return['error'] = $this->error;
            $this->response($return, REST_Controller::HTTP_OK);
        }
        $return['success'] = "true";
        $return['title'] = "success";
        $return['message'] = "No Comment found";
        $return['attachmentData'] = $getAttachmentDetail;
        $return['timelineComment'] = $getComments;
        $return['error'] = $this->error;
        $this->response($return, REST_Controller::HTTP_OK);
    }
}
