<?php
defined('BASEPATH') OR exit('No direct script access allowed');
require APPPATH . '/libraries/REST_Controller.php';

class Student extends REST_Controller {

    public $error = array();
    public $data = array();

    function __construct() {
        parent::__construct();
        $this->token->validate();
        $this->load->library("security");
        $this->load->library('form_validation');
        $this->load->model('student_model');
        $this->load->helper('common_helper');
    }
    
    public function profile_get($id){
        $data = $this->student_model->getProfile($id);
        $return['success'] = "true";
        $return['title'] = "success";
        $return['message'] = "Record found successfully.";
        $return['data'] = $data;
        $return['error'] = $this->error;
        $this->response($return, REST_Controller::HTTP_OK);        
    }
    public function parentProfile_get($parentid){
        $data = $this->student_model->getParentProfile($parentid);
        $return['success'] = "true";
        $return['title'] = "success";
        $return['message'] = "Record found successfully.";
        $return['data'] = $data;
        $return['error'] = $this->error;
        $this->response($return, REST_Controller::HTTP_OK);        
    }
        
    public function addGuardian_post() {
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
        $this->form_validation->set_rules('parent_id', 'Parent', 'trim|required');
        $this->form_validation->set_rules('fname', 'First Name', 'trim|required');
        $this->form_validation->set_rules('lname', 'Last Name', 'trim');
        $this->form_validation->set_rules('email', 'Email', 'trim');
        $this->form_validation->set_rules('phone', 'Phone', 'trim');
        $this->form_validation->set_rules('address', 'Address', 'trim|required');
        $this->form_validation->set_rules('city', 'City', 'trim|required');
        $this->form_validation->set_rules('state', 'State', 'trim|required');
        $this->form_validation->set_rules('country', 'Country', 'trim|required');
        $this->form_validation->set_rules('pincode', 'pincode', 'trim|required');
        $this->form_validation->set_rules('relation', 'Relation', 'trim|required');

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
        $formData['parent_id'] = $postData['parent_id'];
        $formData['fname'] = $postData['fname'];
        $formData['lname'] = $postData['lname'];
        $formData['email'] = $postData['email'];
        $formData['phone'] = $postData['phone'];
        $formData['address'] = $postData['address'];
        $formData['city'] = $postData['city'];
        $formData['state'] = $postData['state'];
        $formData['country'] = $postData['country'];
        $formData['pincode'] = $postData['pincode'];
        $formData['relation'] = $postData['relation'];
        $formData['school_id'] = $this->token->school_id;
        $formData['created_by'] = "T-".$this->token->user_id;
        $formData['created_date'] = date("Y-m-d H:i:s");
                        
        if (!empty($_FILES['photo'])){
            $uploadPath = 'img/parent/';
            $config['upload_path'] = $uploadPath;
            $config['allowed_types'] = 'jpg|jpeg|png';
            $config['max_size'] = 500000;
            $config['encrypt_name'] = TRUE;
            $this->load->library('upload', $config);
            $this->upload->initialize($config);
            
            if ($this->upload->do_upload('photo')) {
                        $uplodimg = $this->upload->data();
                        $formData['photo'] = $uplodimg['file_name'];
                        
                    } else {

                        $uploaderror = $this->upload->display_errors();
                        $return['success'] = "false";
                        $return['message'] = $uploaderror;
                        $return['error'] = $this->error;
                        $return['data'] = $this->data;
                        $this->response($return, REST_Controller::HTTP_BAD_REQUEST);
                    }            
        }
        
        
        $dataid = $this->student_model->addGuardian($formData);
        $this->data = $dataid;
        if ($dataid) {            
            $return['success'] = "true";
            $return['title'] = "success";
            $return['message'] = "Guardian added successfully.";
            $return['error'] = (object) $this->error;
            $return['data'] = $this->data;
            $this->response($return, REST_Controller::HTTP_OK);
        }
        $return['success'] = "false";
        $return['title'] = "error";
        $return['message'] = "Guardian not added.";
        $return['error'] = (object) $this->error;
        $return['data'] = (object) $this->data;

        $this->response($return, REST_Controller::HTTP_BAD_REQUEST);
    }    
    public function updateGuardian_post() {
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
        $this->form_validation->set_rules('parent_id', 'Parent', 'trim|required');
        $this->form_validation->set_rules('fname', 'First Name', 'trim|required');
        $this->form_validation->set_rules('lname', 'Last Name', 'trim');
        $this->form_validation->set_rules('email', 'Email', 'trim');
        $this->form_validation->set_rules('phone', 'Phone', 'trim');
        $this->form_validation->set_rules('address', 'Address', 'trim|required');
        $this->form_validation->set_rules('city', 'City', 'trim|required');
        $this->form_validation->set_rules('state', 'State', 'trim|required');
        $this->form_validation->set_rules('country', 'Country', 'trim|required');
        $this->form_validation->set_rules('pincode', 'pincode', 'trim|required');
        $this->form_validation->set_rules('relation', 'Relation', 'trim|required');

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
        $formData['parent_id'] = $postData['parent_id'];
        $formData['fname'] = $postData['fname'];
        $formData['lname'] = $postData['lname'];
        $formData['email'] = $postData['email'];
        $formData['phone'] = $postData['phone'];
        $formData['address'] = $postData['address'];
        $formData['city'] = $postData['city'];
        $formData['state'] = $postData['state'];
        $formData['country'] = $postData['country'];
        $formData['pincode'] = $postData['pincode'];
        $formData['relation'] = $postData['relation'];
        $formData['school_id'] = $this->token->school_id;
        $formData['updated_by'] = "T-".$this->token->user_id;
        $formData['updated_date'] = date("Y-m-d H:i:s");
                        
        if (!empty($_FILES['photo'])){
            $uploadPath = 'img/parent/';
            $config['upload_path'] = $uploadPath;
            $config['allowed_types'] = 'jpg|jpeg|png';
            $config['max_size'] = 500000;
            $config['encrypt_name'] = TRUE;
            $this->load->library('upload', $config);
            $this->upload->initialize($config);
            
            if ($this->upload->do_upload('photo')) {
                        $uplodimg = $this->upload->data();
                        $formData['photo'] = $uplodimg['file_name'];                        
                    } else {

                        $uploaderror = $this->upload->display_errors();
                        $return['success'] = "false";
                        $return['message'] = $uploaderror;
                        $return['error'] = $this->error;
                        $return['data'] = $this->data;
                        $this->response($return, REST_Controller::HTTP_BAD_REQUEST);
                    }            
        }
        
        
        $res = $this->student_model->updateGuardian($id,$formData);
        $this->data = $id;
        if ($res) {            
            $return['success'] = "true";
            $return['title'] = "success";
            $return['message'] = "Guardian Updated successfully.";
            $return['error'] = (object) $this->error;
            $return['data'] = $this->data;
            $this->response($return, REST_Controller::HTTP_OK);
        }
        $return['success'] = "false";
        $return['title'] = "error";
        $return['message'] = "Guardian not updated.";
        $return['error'] = (object) $this->error;
        $return['data'] = (object) $this->data;

        $this->response($return, REST_Controller::HTTP_BAD_REQUEST);
    }    

    
    public function profile_post() {
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
        $this->form_validation->set_rules('list_id', 'Goal', 'trim|required');
        $this->form_validation->set_rules('title', 'Title', 'trim');
        $this->form_validation->set_rules('completion_date', 'Completion Date', 'trim|required');
        $this->form_validation->set_rules('description', 'Description', 'trim');
        $this->form_validation->set_rules('class_id', 'Class', 'trim|required');
        $this->form_validation->set_rules('student_id', 'Student', 'trim|required');

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
        $formData['list_id'] = $postData['list_id'];
        $formData['title'] = $postData['title'];
        $formData['description'] = $postData['description'];
        $formData['completion_date'] = $postData['completion_date'];
        $formData['class_id'] = $postData['class_id'];
        $formData['student_id'] = $postData['student_id'];
        $formData['school_id'] = $this->token->school_id;
        $formData['user_id'] = "T-".$this->token->user_id;
        $formData['user_type'] = "teacher";
        $formData['created'] = date("Y-m-d H:i:s");
        $formData['status'] = 'Created';
        
        $arrPhoto = array();
        
        if (!empty($_FILES['files'])){
            $uploadPath = 'img/goal/';
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
                        $photoData['goal_id'] = '';
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
        

        $dataid = $this->goal_model->add($formData);
        $this->data = $dataid;
        if ($dataid) {
            if (!empty($arrPhoto)) {
                foreach ($arrPhoto as $photoData)
                {
                    $photoData['goal_id'] = $dataid;
                    $photoId = $this->goal_model->addAttachment($photoData);
                }
            }
            
            $return['success'] = "true";
            $return['title'] = "success";
            $return['message'] = "Goal added successfully.";
            $return['error'] = (object) $this->error;
            $return['data'] = $this->data;
            $this->response($return, REST_Controller::HTTP_OK);
        }
        $return['success'] = "false";
        $return['title'] = "error";
        $return['message'] = "Goal not added.";
        $return['error'] = (object) $this->error;
        $return['data'] = (object) $this->data;

        $this->response($return, REST_Controller::HTTP_BAD_REQUEST);
    }        
}
