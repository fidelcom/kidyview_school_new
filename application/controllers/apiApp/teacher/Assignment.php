<?php
defined('BASEPATH') OR exit('No direct script access allowed');
require APPPATH . '/libraries/REST_Controller.php';

class Assignment extends REST_Controller {

    public $error = array();
    public $data = array();

    function __construct() {
        parent::__construct();
        $this->token->validate();
        $this->load->library("security");
        $this->load->library('form_validation');
        $this->load->model('assignment_model');
        $this->load->helper('common_helper');
        $this->load->library('firebases');
        $this->load->library('fcm');
        $this->load->model('parent/Parent_model');
    }
    
    public function index_get(){
        $data = $this->assignment_model->allData();
        $total = $this->assignment_model->allDataCount();

         if($total >0){
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
        $data = $getAttachmentDetail = $this->assignment_model->getSubjectList();
        
        if($data >0){
            $return['success'] = "true";
            $return['title'] = "success";
            $return['message'] = "Subject Assigned.";
            $return['data'] = $data;
            $return['error'] = $this->error;
            $this->response($return, REST_Controller::HTTP_OK);
        }else{
            $return['success'] = "false";
            $return['title'] = "failed";
            $return['message'] = "No assigned found.";
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
        $this->form_validation->set_rules('total_marks', 'Total Marks', 'trim|required');
        $this->form_validation->set_rules('no_of_attempt', 'Total attempt', 'trim|required');
        $this->form_validation->set_rules('open_submission_date', 'Assignment Open Date', 'trim|required');
        $this->form_validation->set_rules('category', 'category', 'trim|required');

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
        $formData['total_marks']            = $postData['total_marks'];
        $formData['no_of_attempt']          = $postData['no_of_attempt'];
        $formData['category']               = $postData['category'];
        $formData['school_id']              = $this->token->school_id;
        $formData['session_id']              = get_current_session($this->token->school_id)->id;
        $formData['user_id']                = "T-".$this->token->user_id;
        $formData['user_type']              = "teacher";
        $formData['created']                = date("Y-m-d H:i:s");
        $formData['status']                 = 1;
        
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
        

        $dataid = $this->assignment_model->add($formData);
        $this->data = $dataid;
        if ($dataid) {
            if (!empty($arrPhoto)) {
                foreach ($arrPhoto as $photoData)
                {
                    $photoData['assignment_id'] = $dataid;
                    $photoId = $this->assignment_model->addAttachment($photoData);
                }
            }
            $this->load->model('teachers/Teacher_model');
            $teacherData = $this->Teacher_model->getTeacherDetails($this->token->user_id);
            $pass = "KidyView";
			$text = $dataid;
			$encryptedUrl=encryptData($text,$pass);
			$getClassStudentData=$this->Teacher_model->getStudentByClassId($postData['class_id']);
			$studentEmailArray=array();
			if (!empty($getClassStudentData)) {
				foreach ($getClassStudentData as $studentData)
				{
					$student_id="ST-".$studentData['id'];
					$isNotify=notificationSettingHelper($this->token->school_id,$student_id,'Assignment');
					$notificationData['receiver_id'] = "ST-".$studentData['id'];
					$notificationData['sender_id'] = "T-".$this->token->user_id;
					$notificationData['to_do_id'] = $dataid;
					$notificationData['school_id'] = $this->token->school_id;
					$notificationData['message'] = $teacherData->teacherfname." created ".$postData['title']." assignment for you.";
					$notificationData['type'] = "assignment";
					$notificationData['url'] = "assignment-detail/".$encryptedUrl;
					if(!empty($isNotify) && $isNotify->is_push==1){
					$this->Teacher_model->add($notificationData,'notifications');
					}
					/* Email to child */
					$studentEmail=$studentData['childemail'];
					if($studentEmail!='' && (!empty($isNotify) && $isNotify->is_web==1) ){
					$message = $this->load->view('emailtemplate/commonTemplate',$notificationData, true);
                    //sendMail($studentEmail, "Your New assignment", $message);
                    sendKidyviewEmail($studentEmail,'','','','Your New assignment', $message);
					}
					$getParentData=$this->Teacher_model->getParentData($studentData['id']);
					if($getParentData){
					$pnotificationData['receiver_id'] = "P-".$getParentData->id;
					$pnotificationData['sender_id'] = "T-".$this->token->user_id;
					$pnotificationData['to_do_id'] = $dataid;
					$pnotificationData['message'] = $teacherData->teacherfname." create ".$postData['title']." assignment for your child.";
					$pnotificationData['type'] = "assignment";
					$pnotificationData['url'] = "assignment-detail/".$encryptedUrl;
					//$isParentNotify=notificationSettingHelper($this->token->school_id,$pnotificationData['receiver_id'],'Assignment');
					//if(!empty($isParentNotify) && $isParentNotify->is_push==1){
					$this->Teacher_model->add($pnotificationData,'notifications');
                        $result = $this->Parent_model->parentFCMID($getParentData->id);
                        $tokenData = $this->db->get_where('user_token', ['user_id' => $getParentData->id])->row();
                        $token = !empty($result->fcm_key) ? $result->fcm_key : '';
                        $message = $postData['message'];
                        $title = "Your New assignment";
                        $this->firebases->sendNotification($token, $title, $message);
					//}
					
					/* Email to parent */
					if($getParentData->fatheremail!=''){
						$parentEmail=$getParentData->fatheremail;
					}else{
						$parentEmail=$getParentData->motheremail;
					}
					//if($parentEmail!='' && (!empty($isParentNotify) && $isParentNotify->is_web==1)){
					$message = $this->load->view('emailtemplate/commonTemplate',$pnotificationData, true);
                    //sendMail($parentEmail, "Your Child New Assignment", $message);
                    sendKidyviewEmail($parentEmail,'','','','Your Child New Assignment', $message);
					//}
				}
				}
			}
			$user_id="S-".$this->token->school_id;
			$isNotify=notificationSettingHelper($this->token->school_id,$user_id,'Assignment');
			$notificationData['receiver_id'] = $user_id;
			$notificationData['sender_id'] = "T-".$this->token->user_id;
			$notificationData['to_do_id'] = $dataid;
			$notificationData['school_id'] = $this->token->school_id;
			$notificationData['message'] = $teacherData->teacherfname." created ".$postData['title']." assignment.";
			$notificationData['type'] = "assignment";
			$notificationData['url'] = "assignment-detail/".$encryptedUrl;
			if(!empty($isNotify) && $isNotify->is_push==1){
			$this->Teacher_model->add($notificationData,'notifications');
			}
			$schoolEmail='';
			$schoolData=getSchoolDetails($this->token->school_id);
			if(!empty($schoolData)){
				$schoolEmail=$schoolData->email;
			}
			if($schoolEmail!='' && (!empty($isNotify) && $isNotify->is_web==1)){
			$notificationData['user'] = "school";
			$message = $this->load->view('emailtemplate/commonTemplate',$notificationData, true);
            //sendMail($schoolEmail, "New Assignment", $message);
            sendKidyviewEmail($schoolEmail,'','','','New Assignment', $message);
			}
			
            $return['success'] = "true";
            $return['title'] = "success";
            $return['message'] = "Assignment added successfully.";
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
        $this->form_validation->set_rules('class_id', 'Class', 'trim|required');
        $this->form_validation->set_rules('total_marks', 'Total Marks', 'trim|required');
        $this->form_validation->set_rules('no_of_attempt', 'Total attempt', 'trim|required');
        $this->form_validation->set_rules('open_submission_date', 'Assignment Open Date', 'trim|required');
        $this->form_validation->set_rules('category', 'category', 'trim|required');

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
        $id                                 = $postData['id'];
        $formData['title']                  = $postData['title'];
        $formData['description']            = $postData['description'];
        $formData['class_id']               = $postData['class_id'];
        $formData['subject_id']             = $postData['subject_id'];
        $formData['submission_date']        = $postData['submission_date'];
        $formData['open_submission_date']   = $postData['open_submission_date'];
        $formData['total_marks']            = $postData['total_marks'];
        $formData['no_of_attempt']          = $postData['no_of_attempt'];
        $formData['category']               = $postData['category'];
        $formData['updated']                = date("Y-m-d H:i:s");
        $formData['status']                 = 1;
        
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
