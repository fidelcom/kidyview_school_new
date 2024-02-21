<?php
defined('BASEPATH') OR exit('No direct script access allowed');
require APPPATH . '/libraries/REST_Controller.php';

class Assignment extends REST_Controller {

    public $error = array();
    public $data = array();

    function __construct() {
        parent::__construct();
        $this->load->library("security");
        $this->load->library('form_validation');
        $this->load->model('parent/assignment_model');
        $this->load->helper('common_helper');
    }

    public function index_post() {
        $postData = $_POST;
        $postData = $this->security->xss_clean($postData);
        $this->form_validation->set_error_delimiters('', '');
        $this->form_validation->set_data($postData);
        $this->form_validation->set_rules('Name', 'Name', 'trim|required');
        $this->form_validation->set_rules('email', 'Email Address', 'trim|valid_email|required');
        $this->form_validation->set_rules('phone_number', 'Phone Number', 'trim|required|numeric');
        $this->form_validation->set_rules('subject', 'Subject', 'trim|required');
        $this->form_validation->set_rules('message', 'Message', 'trim|required');

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
        $formData['fname'] = $postData['name'];
        $formData['lname'] = $postData['name'];
        $formData['email'] = $postData['email'];
        $formData['phone'] = $postData['phone_number'];
        $formData['subject'] = $postData['subject'];
        $formData['message'] = $postData['message'];
        $this->db->insert('assignment', $data);
        $message = $this->load->view('emailtemplate/commonTemplate',$notificationData, true);
        sendMail($formData['email'], $formData['subject'], $formData);
        if ($dataid) {
            $return['success'] = "true";
            $return['title'] = "success";
            $return['message'] = "Thank you. We will get back to you shortly.";
            $return['error'] = (object) $this->error;
            $return['data'] = $this->data;
            $this->response($return, REST_Controller::HTTP_OK);
        }
        $return['success'] = "false";
        $return['title'] = "error";
        $return['message'] = "Error.Please try again.";
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
        $formData['updated'] = date("Y-m-d H:i:s");
        $formData['status'] = 1;
        
        $arrPhoto = array();
        
        if (!empty($_FILES['files'])){
            $uploadPath = 'img/assignment/';
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
                        $photoData['assignment_id'] = '';
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
        $this->assignment_model->update($id,$formData);
        
        if ($id) {
            if (!empty($arrPhoto)) {
                $this->db->where("assignment_id",$id);
                $this->db->delete('assignment_attachment');
                foreach ($arrPhoto as $photoData)
                {
                    $photoData['assignment_id'] = $id;
                    $photoId = $this->assignment_model->addAttachment($photoData);
                }
            }
            
            $return['success'] = "true";
            $return['title'] = "success";
            $return['message'] = "Assignment updated successfully.";
            $return['error'] = (object) $this->error;
            $return['data'] = $this->data;
            $this->response($return, REST_Controller::HTTP_OK);
        }
        $return['success'] = "false";
        $return['title'] = "error";
        $return['message'] = "Assignment not added.";
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
            $uploadPath = 'img/assignment/';
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
                        $photoData['assignment_id'] = '';
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
                $photoData['assignment_id'] = $id;
                $photoId = $this->assignment_model->addAttachment($photoData);
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
            $this->db->delete('assignment_attachment');      
            
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
