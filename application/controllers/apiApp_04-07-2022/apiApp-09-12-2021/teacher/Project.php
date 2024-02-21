<?php
defined('BASEPATH') OR exit('No direct script access allowed');
require APPPATH . '/libraries/REST_Controller.php';

class Project extends REST_Controller {

    public $error = array();
    public $data = array();

    function __construct() {
        parent::__construct();
        $this->token->validate();
        $this->load->library("security");
        $this->load->library('form_validation');
        $this->load->model('project_model');
        $this->load->helper('common_helper');
    }
    
    public function index_get(){
        $data = $this->project_model->allData();
        $total = $this->project_model->allDataCount();

        if($total >0 && count($data)>0 ){
            $return['success'] = "true";
            $return['title'] = "success";
            $return['message'] = "Record found successfully.";
            $return['data'] = $data;
            $return['total'] = $total;
            $return['error'] = $this->error;
            $this->response($return, REST_Controller::HTTP_OK);
        }else{
            $return['success'] = "false";
            $return['title'] = "failed";
            $return['message'] = "No project found.";
            $return['data'] = '';
            $return['total'] = '';
            $return['error'] = $this->error;
            $this->response($return, REST_Controller::HTTP_BAD_REQUEST);   
        }
        
    }
    public function subjects_get(){
        $data = $getAttachmentDetail = $this->project_model->getSubjectList();
        if($data){
            $return['success'] = "true";
            $return['title'] = "success";
            $return['message'] = "Subject Assigned.";
            $return['data'] = $data;
            $return['error'] = $this->error;
            $this->response($return, REST_Controller::HTTP_OK);
        }else{
            $return['success'] = "false";
            $return['title'] = "failed";
            $return['message'] = "No subject project found.";
            $return['data'] = '';
            $return['total'] = '';
            $return['error'] = $this->error;
            $this->response($return, REST_Controller::HTTP_BAD_REQUEST);   
        }
    }
    
    public function index_post() {
        $postData = $_POST;
        $dataid = '';
        
        $totalImageSize = 0;
        $maxphotosize = 2000;
        $imageArray = array('image/jpg', 'image/jpeg', 'image/gif', 'image/png', 'image/JPEG', 'image/JPG');

        if (!empty($_FILES['files'])) {
            for ($i = 0; $i < count($_FILES['files']['name']); $i++) {
                if ($_FILES['files']['name'][$i] != '') {
                    $size = $_FILES['files']['size'][$i];
                    $type = $_FILES['files']['type'][$i];                    
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

        
        $postData = $this->security->xss_clean($postData);
        $this->form_validation->set_error_delimiters('', '');
        $this->form_validation->set_data($postData);
        $this->form_validation->set_rules('title', 'Title', 'trim|required');
        $this->form_validation->set_rules('submission_date', 'Submission Date', 'trim|required');
        $this->form_validation->set_rules('description', 'Description', 'trim|required');
        $this->form_validation->set_rules('subject_id', 'Subject', 'trim|required');
        $this->form_validation->set_rules('class_id', 'Class', 'trim|required');
        $this->form_validation->set_rules('category', 'category', 'trim|required');
        $this->form_validation->set_rules('total_marks', 'Total Marks', 'trim|required');
        $this->form_validation->set_rules('no_of_attempt', 'Total attempt', 'trim|required');
        $this->form_validation->set_rules('open_submission_date', 'Assignment Open Date', 'trim|required');

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
        $formData['title']                  = $postData['title'];
        $formData['description']            = $postData['description'];
        $formData['submission_date']        = $postData['submission_date'];
        $formData['class_id']               = $postData['class_id'];
        $formData['subject_id']             = $postData['subject_id'];
        $formData['open_submission_date']   = $postData['open_submission_date'];
        $formData['category']               = $postData['category'];
        $formData['total_marks']            = $postData['total_marks'];
        $formData['no_of_attempt']          = $postData['no_of_attempt'];
        $formData['school_id']              = $this->token->school_id;
        $formData['user_id']                = "T-".$this->token->user_id;
        $formData['user_type']              = "teacher";
        $formData['created']                = date("Y-m-d H:i:s");
        $formData['status']                 = 1;
        
        $arrPhoto = array();
        
        if (!empty($_FILES['files'])){
            $uploadPath = 'img/project/';
            $config['upload_path'] = $uploadPath;
            $config['allowed_types'] = 'jpg|jpeg|gif|png|pdf|doc|docx';
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
                        $photoData = array();
                        $photoData['project_id'] = '';
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
        

        $dataid = $this->project_model->addProjectAssignment($formData);
        $this->data = $dataid;
        if ($dataid) {
            if (!empty($arrPhoto)) {
                foreach ($arrPhoto as $photoData)
                {
                    $photoData['project_id'] = $dataid;
                    $photoId = $this->project_model->addAttachment($photoData);
                }
            }
            
            $return['success'] = "true";
            $return['title'] = "success";
            $return['message'] = "Project added successfully.";
            $return['error'] = (object) $this->error;
            $return['data'] = $this->data;
            $this->response($return, REST_Controller::HTTP_OK);
        }
        $return['success'] = "false";
        $return['title'] = "error";
        $return['message'] = "Project not added.";
        $return['error'] = (object) $this->error;
        $return['data'] = (object) $this->data;

        $this->response($return, REST_Controller::HTTP_BAD_REQUEST);
    }
    
    public function update_post() {
        $postData = $_POST;
        $dataid = '';
        
        $totalImageSize = 0;
        $maxphotosize = 2000;
        $imageArray = array('image/jpg', 'image/jpeg', 'image/gif', 'image/png', 'image/JPEG', 'image/JPG');

        if (!empty($_FILES['files'])) {
            for ($i = 0; $i < count($_FILES['files']['name']); $i++) {
                if ($_FILES['files']['name'][$i] != '') {
                    $size = $_FILES['files']['size'][$i];
                    $type = $_FILES['files']['type'][$i];                    
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

        
        $postData = $this->security->xss_clean($postData);
        $this->form_validation->set_error_delimiters('', '');
        $this->form_validation->set_data($postData);
        $this->form_validation->set_rules('id', 'ID', 'trim|required');
        $this->form_validation->set_rules('title', 'Title', 'trim|required');
        $this->form_validation->set_rules('submission_date', 'Submission Date', 'trim|required');
        $this->form_validation->set_rules('description', 'Description', 'trim|required');
        $this->form_validation->set_rules('subject_id', 'Subject', 'trim|required');
        $this->form_validation->set_rules('category', 'category', 'trim|required');
        $this->form_validation->set_rules('total_marks', 'Total Marks', 'trim|required');
        $this->form_validation->set_rules('no_of_attempt', 'Total attempt', 'trim|required');
        $this->form_validation->set_rules('open_submission_date', 'Assignment Open Date', 'trim|required');
        //$this->form_validation->set_rules('class_id', 'Class', 'trim|required');

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
        $id = $postData['id'];
        $formData['title'] = $postData['title'];
        $formData['description'] = $postData['description'];
        $formData['submission_date'] = $postData['submission_date'];
        $formData['category'] = $postData['category'];
        $formData['total_marks'] = $postData['total_marks'];
        $formData['no_of_attempt'] = $postData['no_of_attempt'];
        $formData['open_submission_date'] = $postData['open_submission_date'];
        $formData['updated'] = date("Y-m-d H:i:s");
        $formData['status'] = 1;
        
        $arrPhoto = array();
        
        if (!empty($_FILES['files'])){
            $uploadPath = 'img/project/';
            $config['upload_path'] = $uploadPath;
            $config['allowed_types'] = 'jpg|jpeg|gif|png|pdf|doc|docx';
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
                        $photoData = array();
                        $photoData['project_id'] = '';
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
        
        $this->data = $id;
        $this->project_model->updateProjectAssignment($id,$formData);
        // lq();
        
        if ($id) {
            if (!empty($arrPhoto)) {
                $this->db->where("project_id",$id);
                $this->db->delete('project_attachment');
                foreach ($arrPhoto as $photoData)
                {
                    $photoData['project_id'] = $id;
                    $photoId = $this->project_model->addAttachment($photoData);
                }
            }
            
            $return['success'] = "true";
            $return['title'] = "success";
            $return['message'] = "Project updated successfully.";
            $return['error'] = (object) $this->error;
            $return['data'] = $this->data;
            $this->response($return, REST_Controller::HTTP_OK);
        }
        $return['success'] = "false";
        $return['title'] = "error";
        $return['message'] = "Project not added.";
        $return['error'] = (object) $this->error;
        $return['data'] = (object) $this->data;

        $this->response($return, REST_Controller::HTTP_BAD_REQUEST);
    }
    public function attachment_post() {
        $postData = $_POST;
        $dataid = '';
        
        $totalImageSize = 0;
        $maxphotosize = 2000;
        $imageArray = array('image/jpg', 'image/jpeg', 'image/gif', 'image/png', 'image/JPEG', 'image/JPG');

        if (!empty($_FILES['files'])) {
            for ($i = 0; $i < count($_FILES['files']['name']); $i++) {
                if ($_FILES['files']['name'][$i] != '') {
                    $size = $_FILES['files']['size'][$i];
                    $type = $_FILES['files']['type'][$i];                    
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

        
        $postData = $this->security->xss_clean($postData);
        $this->form_validation->set_error_delimiters('', '');
        $this->form_validation->set_data($postData);
        $this->form_validation->set_rules('id', 'ID', 'trim|required');

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
        $id = $postData['id'];
        
        $arrPhoto = array();
        
        if (!empty($_FILES['files'])){
            $uploadPath = 'img/project/';
            $config['upload_path'] = $uploadPath;
            $config['allowed_types'] = 'jpg|jpeg|gif|png|pdf|doc|docx';
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
                        $photoData = array();
                        $photoData['project_id'] = '';
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
        
        $this->data = $id;
        
        if ($id && !empty($arrPhoto)) { 
            $fileDetail = array();
            foreach ($arrPhoto as $photoData)
            {
                $photoData['project_id'] = $id;
                $photoId = $this->project_model->addAttachment($photoData);
                array_push($fileDetail,array('id'=>$photoId,'file'=>$photoData['attachment']));
            }
                        
            $return['success'] = "true";
            $return['title'] = "success";
            $return['message'] = "Attachment added successfully.";
            $return['error'] = (object) $this->error;
            $return['data'] = $fileDetail;
            $this->response($return, REST_Controller::HTTP_OK);
        }
        $return['success'] = "false";
        $return['title'] = "error";
        $return['message'] = "Attachment not added.";
        $return['error'] = (object) $this->error;
        $return['data'] = (object) $this->data;

        $this->response($return, REST_Controller::HTTP_BAD_REQUEST);
    }
    
    public function attachment_delete($id='') {
        if(is_numeric($id))
        {            
            $this->db->where("id",$id);
            $this->db->delete('project_attachment');      
            
            if($this->db->affected_rows() > 0)
            {
                $return['success'] = "true";
                $return['title'] = "success";
                $return['message'] = "Attachment deleted successfully.";
                $return['error'] = (object) $this->error;
                $return['data'] = $this->data;
                $this->response($return, REST_Controller::HTTP_OK);
            }
            else
            {
                $return['success'] = "true";
                $return['title'] = "success";
                $return['message'] = "Attachment does not exist.";
                $return['error'] = (object) $this->error;
                $return['data'] = $this->data;
                $this->response($return, REST_Controller::HTTP_OK);
            }
        }
        $return['success'] = "false";
        $return['title'] = "error";
        $return['message'] = "Please send attchment detail.";
        $return['error'] = (object) $this->error;
        $return['data'] = (object) $this->data;

        $this->response($return, REST_Controller::HTTP_BAD_REQUEST);
    }
    
}
