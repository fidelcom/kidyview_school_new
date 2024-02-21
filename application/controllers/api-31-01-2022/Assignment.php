<?php
	
	defined('BASEPATH') OR exit('No direct script access allowed');
	require APPPATH . '/libraries/REST_Controller.php';
	require APPPATH . '/libraries/crypto/autoload.php';
	use Blocktrail\CryptoJSAES\CryptoJSAES;
	class Assignment extends REST_Controller {
		
		public $error = array();
		public $data = array();
		
		public function __construct() {
			parent::__construct();
			if($this->session->userdata('user_role')=='school' OR $this->session->userdata('user_role')=='schoolsubadmin'){
				$this->token->validate();
			}
			$this->load->library('form_validation');
			$this->load->library("security");
			$this->load->model('admin/Assignment_model');
			$this->load->library('settings');
		}
		
	public function getAssignmentList_post() {
		$postData = json_decode(file_get_contents('php://input'), true);
		if ($postData == '') {
			$postData = $_POST;
		}
		$userdata = $this->session->userdata('user_data');
		$school_id = $userdata['school_id'];
	
		// prd($school_id);
		$class_id=$postData['class_id'];
		$subject_id=$postData['subject_id'];
		$category=$postData['category'];
		
		$result = $this->Assignment_model->getAssignmentList($school_id,$filterbydate='',$class_id,$subject_id,$category);
// prd($result);
			if ($result) {
					$return['success'] = "true";
					$return['message'] = "Assignment found.";
					$return['data'] = $result;
					$return['error'] = $this->error;

					$this->response($return, REST_Controller::HTTP_OK);
					} else {
					$return['success'] = "false";
					$return['message'] = "Not found.";
					$return['error'] = $this->error;
					$return['data'] = $result;
					$this->response($return, REST_Controller::HTTP_BAD_REQUEST);
			}
	}
	
	public function getAssignmentDetails_post() {
		$postData = json_decode(file_get_contents('php://input'), true);
		if ($postData == '') {
			$postData = $_POST;
		}
		$id=$postData['id'];
		$result = $this->Assignment_model->getAssignmentDetails($id);

			if ($result) {
					$return['success'] = "true";
					$return['message'] = "Assignment details found.";
					$return['data'] = $result;
					$return['error'] = $this->error;

					$this->response($return, REST_Controller::HTTP_OK);
					} else {
					$return['success'] = "false";
					$return['message'] = "Not found.";
					$return['error'] = $this->error;
					$return['data'] = $result;
					$this->response($return, REST_Controller::HTTP_BAD_REQUEST);
			}
	}
	public function getSchoolSubjectClass_post() {
		$postData = json_decode(file_get_contents('php://input'), true);
		if ($postData == '') {
			$postData = $_POST;
		}
		// $data = $this->session->userdata('teacher_data');
		$id = $postData['school_id'];
		$result = $this->Assignment_model->getSchoolSubjectClass($id);
			if ($result) {
					$return['success'] = "true";
					$return['message'] = "Class found.";
					$return['data'] = $result;
					$return['error'] = $this->error;

					$this->response($return, REST_Controller::HTTP_OK);
					} else {
					$return['success'] = "false";
					$return['message'] = "Not found.";
					$return['error'] = $this->error;
					$return['data'] = $result;
					$this->response($return, REST_Controller::HTTP_BAD_REQUEST);
			}
	}
	public function getSchoolSubject_post() {
		$postData = json_decode(file_get_contents('php://input'), true);
		if ($postData == '') {
			$postData = $_POST;
		}
		// $data = $this->session->userdata('teacher_data');
		// $id = $data['id'];
		$class_id=$postData['classID'];
		$id=$postData['school_id'];
		$result = $this->Assignment_model->getSchoolSubject($class_id,$id);
			if ($result) {
					$return['success'] = "true";
					$return['message'] = "Class found.";
					$return['data'] = $result;
					$return['error'] = $this->error;

					$this->response($return, REST_Controller::HTTP_OK);
					} else {
					$return['success'] = "false";
					$return['message'] = "Not found.";
					$return['error'] = $this->error;
					$return['data'] = $result;
					$this->response($return, REST_Controller::HTTP_BAD_REQUEST);
			}
	}
	function encryptData($text,$pass){
        $encryptedUrl = CryptoJSAES::encrypt($text, $pass);
        if(strpos($encryptedUrl, '/') !== false){
            $encryptedUrl = $this->encryptData($text,$pass);
        }
        return $encryptedUrl;
    }
	public function createAssignment_post() {
		$postData = json_decode(file_get_contents('php://input'), true);
		if ($postData == '') {
			$postData = $_POST;
		};
		$postData = $this->security->xss_clean($postData);
		
		$this->form_validation->set_data($postData);
		$this->form_validation->set_rules('category', 'Category', 'trim|required');
		$this->form_validation->set_rules('total_marks', 'Total Marks', 'trim|required|numeric');
		$this->form_validation->set_rules('class_id', 'Class', 'trim|required');
        $this->form_validation->set_rules('subject_id', 'Subject', 'trim|required');
        $this->form_validation->set_rules('title', 'Assignment Name', 'trim|required');
		$this->form_validation->set_rules('no_of_attampt', 'Submission attampt', 'trim|numeric');
		$this->form_validation->set_rules('date', 'Submission Date', 'trim|required');
        $this->form_validation->set_rules('description', 'Description', 'trim|required');
		$error = array();
        if ($this->form_validation->run() === False) {
            $error = $this->form_validation->error_array();
            $message = validation_errors();
            $this->response(["success" => "false", 'message'=>$message,'data'=>'',"error" => $error], REST_Controller::HTTP_BAD_REQUEST);
        } 
		$pic='';
		if (!empty($_FILES['files'])){
			$uploadPath = 'img/assignment/';
			$config['upload_path'] = $uploadPath;
			$config['allowed_types'] = 'jpg|jpeg|png|pdf|doc|docx|mp4|mp3|3gp||avi|flv|wmv|mov|mkv';
			$config['max_size'] = 500000;
			$config['encrypt_name'] = TRUE;
			$this->load->library('upload', $config);
			$this->upload->initialize($config);
			$arrPhoto=array();
			for ($i = 0; $i < count($_FILES['files']['name']); $i++) {
				if ($_FILES['files']['name'][$i] != '') {
					$_FILES['file']['name'] = $_FILES['files']['name'][$i];
					$_FILES['file']['type'] = $_FILES['files']['type'][$i];
					$_FILES['file']['tmp_name'] = $_FILES['files']['tmp_name'][$i];
					$_FILES['file']['error'] = $_FILES['files']['error'][$i];
					$_FILES['file']['size'] = $_FILES['files']['size'][$i];
					$typeEx=explode('/',$_FILES['file']['type']);
					$attachmenttype='';
					if($typeEx[1]=='jpeg' || $typeEx[1]=='jpg' || $typeEx[1]=='png'){
						$attachmenttype='image';
					}elseif($typeEx[1]=='pdf'){
						$attachmenttype='pdf';
					}elseif($typeEx[1]=='doc' OR $typeEx[1]=='docx'){
						$attachmenttype='doc';
					}
					if ($this->upload->do_upload('file')) {
						$uplodimg = $this->upload->data();
						$photoData = array();
						$photoData['attachment'] = $uplodimg['file_name'];
						$photoData['attachment_type'] = $attachmenttype;
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
		$sdata = $this->session->userdata('userdata');
		$sid = $sdata['id'];
		$schoolData = $this->Assignment_model->getSchoolDetails($sid);
		$data['category']=$postData['category'];
		$data['total_marks']=$postData['total_marks'];
		$data['title']=$postData['title'];
		$data['no_of_attempt']=$postData['no_of_attampt'];
		$data['description']=$postData['description'];
		$data['submission_date']=$postData['date'];
		$data['open_submission_date']=$postData['opendate']&&$postData['opendate']!=''?$postData['opendate']:NULL;
		$data['class_id']=$postData['class_id'];
		$data['subject_id']=$postData['subject_id'];
		$data['school_id']=$postData['school_id'];
		$data['created']=date('Y-m-d H:i:s');
		$data['user_id']="S-".$postData['school_id'];
		$tbl_name="assignment";
		$tbl_name2="assignment_attachment";
		$data['status']=1;
		// prd($data);
		$add = $this->Assignment_model->add($data,$tbl_name);
		if ($add) {
			$pass = "KidyView";
			$text = $add;
			$encryptedUrl=$this->encryptData($text,$pass);
			if (!empty($arrPhoto)) {
				foreach ($arrPhoto as $photoData)
				{
					$photoData['assignment_id'] = $add;
					$photoId = $this->Assignment_model->add($photoData,$tbl_name2);
				}
			}
			$getClassStudentData=$this->Assignment_model->getStudentByClassId($postData['class_id']);
			//print_r($getClassStudentData);die;
			$studentEmailArray=array();
			if (!empty($getClassStudentData)) {
				foreach ($getClassStudentData as $studentData)
				{
					$student_id="ST-".$studentData['id'];
					$isNotify=notificationSettingHelper($postData['school_id'],$student_id,'Assignment');
					$notificationData['receiver_id'] = "ST-".$studentData['id'];
					$notificationData['sender_id'] = "S-".$sid;
					$notificationData['to_do_id'] = $add;
					$notificationData['message'] = $schoolData->fname." created ".$postData['title']." assignment for you.";
					$notificationData['type'] = "assignment";
					$notificationData['url'] = "assignment-detail/".$encryptedUrl;
					if(!empty($isNotify) && $isNotify->is_push==1){
					$this->Assignment_model->add($notificationData,'notifications');
					}
					$getParentData=$this->Assignment_model->getParentData($studentData['id']);
					if($getParentData){
					$pnotificationData['receiver_id'] = "P-".$getParentData->id;
					$pnotificationData['sender_id'] = "T-".$tid;
					$pnotificationData['to_do_id'] = $add;
					$pnotificationData['message'] = $teacherData->teacherfname." create ".$postData['title']." assignment for your child.";
					$pnotificationData['type'] = "assignment";
					$pnotificationData['url'] = "assignment-detail/".$encryptedUrl;
					$isParentNotify=notificationSettingHelper($postData['school_id'],$pnotificationData['receiver_id'],'Assignment');
					if(!empty($isParentNotify) && $isParentNotify->is_push==1){
					$this->Teacher_model->add($pnotificationData,'notifications');
					}
					/* Email to child */
					$studentEmail=$studentData['childemail'];
					if($studentEmail!='' && (!empty($isNotify) && $isNotify->is_web==1) ){
					$message = $this->load->view('emailtemplate/commonTemplate',$notificationData, true);
					$this->sendMail($studentEmail, "Your New assignment", $message);
					}
					/* Email to parent */
					if($getParentData->fatheremail!=''){
						$parentEmail=$getParentData->fatheremail;
					}else{
						$parentEmail=$getParentData->motheremail;
					}
					if($parentEmail!='' && (!empty($isParentNotify) && $isParentNotify->is_web==1)){
					$message = $this->load->view('emailtemplate/commonTemplate',$pnotificationData, true);
					$this->sendMail($parentEmail, "Your Child New Assignment", $message);
					}
				}
				}
			}
			$message="Assignment added successfully.";
			$return['success'] = "true";
			$return['message'] = $message;
			$return['error'] = $this->error;
			$return['data'] = $add;
			
			$this->response($return, REST_Controller::HTTP_OK);
			} else {
			$return['success'] = "false";
			$return['message'] = "Something went wrong.";
			$return['error'] = $this->error;
			$return['data'] = $this->data;
			
			$this->response($return, REST_Controller::HTTP_BAD_REQUEST);
		}
	}
	public function deleteAssignment_post() {
	$postData = json_decode(file_get_contents('php://input'), true);
	if ($postData == '') {
		$postData = $_POST;
	}
	$id = $postData['id'];
	$where=array(
	'id'=>$id
	);
	$tbl_name='assignment';
	$result = $this->Assignment_model->delete($where,$tbl_name);
	if ($result) {
		$tbl_name='assignment_attachment';
		$where=array(
			'assignment_id'=>$id
		);
		$result = $this->Assignment_model->delete($where,$tbl_name);
		$return['success'] = "true";
		$return['message'] = "Assignment deleted successfully.";
		$return['data'] = $result;
		$return['error'] = $this->error;
		
		$this->response($return, REST_Controller::HTTP_OK);
		} else {
		$return['success'] = "false";
		$return['message'] = "Something went wrong.";
		$return['error'] = $this->error;
		$return['data'] = $result;
		$this->response($return, REST_Controller::HTTP_BAD_REQUEST);
	}
}
	
	public function getStudentSubmitedAssignmentList_post() {
		$postData = json_decode(file_get_contents('php://input'), true);
		if ($postData == '') {
			$postData = $_POST;
		}
		// $data = $this->session->userdata('teacher_data');
		// $id = $data['id'];
		$schoolID=$postData['schoolID'];
		$class_id=$postData['class_id'];
		$subject_id=$postData['subject_id'];
		$category=$postData['category'];
		$result = $this->Assignment_model->getStudentSubmitedAssignmentList($schoolID,$class_id,$subject_id,$category);

			if ($result) {
					$return['success'] = "true";
					$return['message'] = "Assignment found.";
					$return['data'] = $result;
					$return['error'] = $this->error;

					$this->response($return, REST_Controller::HTTP_OK);
					} else {
					$return['success'] = "false";
					$return['message'] = "Not found.";
					$return['error'] = $this->error;
					$return['data'] = $result;
					$this->response($return, REST_Controller::HTTP_BAD_REQUEST);
			}
	}
	
	public function getSubmitedAssignmentDetails_post() {
		$postData = json_decode(file_get_contents('php://input'), true);
		if ($postData == '') {
			$postData = $_POST;
		}
		$id=$postData['id'];
		$result = $this->Assignment_model->getSubmitedAssignmentDetails($id);

			if ($result) {
					$return['success'] = "true";
					$return['message'] = "Assignment details found.";
					$return['data'] = $result;
					$return['error'] = $this->error;

					$this->response($return, REST_Controller::HTTP_OK);
					} else {
					$return['success'] = "false";
					$return['message'] = "Not found.";
					$return['error'] = $this->error;
					$return['data'] = $result;
					$this->response($return, REST_Controller::HTTP_BAD_REQUEST);
			}
	}
	public function deleteAttachmentAttachData_post() {
		$postData = json_decode(file_get_contents('php://input'), true);
		if ($postData == '') {
			$postData = $_POST;
		}
		$id = $postData['id'];
		$where=array(
		'id'=>$id
		);
		$tbl_name='assignment_attachment';
		$result = $this->Assignment_model->delete($where,$tbl_name);
		if ($result) {
			$filePath='img/assignment/'.$postData['filename'];
			if (file_exists($filePath)) 
            {
			unlink($filePath);
			 }
			$return['success'] = "true";
			$return['message'] = "Deleted successfully.";
			$return['data'] = $result;
			$return['error'] = $this->error;
			
			$this->response($return, REST_Controller::HTTP_OK);
			} else {
			$return['success'] = "false";
			$return['message'] = "Something went wrong.";
			$return['error'] = $this->error;
			$return['data'] = $result;
			$this->response($return, REST_Controller::HTTP_BAD_REQUEST);
		}
	}
	public function editAssignment_post() {
		$postData = json_decode(file_get_contents('php://input'), true);
		if ($postData == '') {
			$postData = $_POST;
		};
		$postData = $this->security->xss_clean($postData);
		$this->form_validation->set_data($postData);
		$this->form_validation->set_rules('category', 'Category', 'trim|required');
		$this->form_validation->set_rules('total_marks', 'Total Marks', 'trim|required|numeric');
		$this->form_validation->set_rules('class_id', 'Class', 'trim|required');
        $this->form_validation->set_rules('subject_id', 'Subject', 'trim|required');
        $this->form_validation->set_rules('title', 'Assignment Name', 'trim|required');
		$this->form_validation->set_rules('no_of_attampt', 'Submission attampt', 'trim|numeric');
		$this->form_validation->set_rules('date', 'Submission Date', 'trim|required');
        $this->form_validation->set_rules('description', 'Description', 'trim|required');
		$error = array();
        if ($this->form_validation->run() === False) {
            $error = $this->form_validation->error_array();
            $message = validation_errors();
            $this->response(["success" => "false", 'message'=>$message,'data'=>'',"error" => $error], REST_Controller::HTTP_BAD_REQUEST);
        } 
		$pic='';
		if (!empty($_FILES['files'])){
			$uploadPath = 'img/assignment/';
			$config['upload_path'] = $uploadPath;
			$config['allowed_types'] = 'jpg|jpeg|png|pdf|doc|docx|mp4|mp3|3gp||avi|flv|wmv|mov|mkv';
			$config['max_size'] = 500000;
			$config['encrypt_name'] = TRUE;
			$this->load->library('upload', $config);
			$this->upload->initialize($config);
			$arrPhoto=array();
			for ($i = 0; $i < count($_FILES['files']['name']); $i++) {
				if ($_FILES['files']['name'][$i] != '') {
					$_FILES['file']['name'] = $_FILES['files']['name'][$i];
					$_FILES['file']['type'] = $_FILES['files']['type'][$i];
					$_FILES['file']['tmp_name'] = $_FILES['files']['tmp_name'][$i];
					$_FILES['file']['error'] = $_FILES['files']['error'][$i];
					$_FILES['file']['size'] = $_FILES['files']['size'][$i];
					$typeEx=explode('/',$_FILES['file']['type']);
					$attachmenttype='';
					if($typeEx[1]=='jpeg' || $typeEx[1]=='jpg' || $typeEx[1]=='png'){
						$attachmenttype='image';
					}elseif($typeEx[1]=='pdf'){
						$attachmenttype='pdf';
					}elseif($typeEx[1]=='doc' OR $typeEx[1]=='docx'){
						$attachmenttype='doc';
					}
					if ($this->upload->do_upload('file')) {
						$uplodimg = $this->upload->data();
						$photoData = array();
						$photoData['attachment'] = $uplodimg['file_name'];
						$photoData['attachment_type'] = $attachmenttype;
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
		$data['category']=$postData['category'];
		$data['total_marks']=$postData['total_marks'];
		$data['title']=$postData['title'];
		$data['no_of_attempt']=$postData['no_of_attampt'];
		$data['description']=$postData['description'];
		$data['submission_date']=$postData['date'];
		$data['open_submission_date']=$postData['opendate']&&$postData['opendate']!=''?$postData['opendate']:NULL;
		$data['subject_id']=$postData['subject_id'];
		$data['class_id']=$postData['class_id'];
		$data['updated']=date('Y-m-d H:i:s');
		$tbl_name="assignment";
		$tbl_name2="assignment_attachment";
		$where=array(
			'id'=>$postData['assignmentID']
		);
		$sdata = $this->session->userdata('userdata');
		$sid = $sdata['id'];
		$schoolData = $this->Assignment_model->getSchoolDetails($sid);
		$update = $this->Assignment_model->update($data,$tbl_name,$where);
		if ($update) {
			$pass = "KidyView";
			$text = $postData['assignmentID'];
			$encryptedUrl=$this->encryptData($text,$pass);
			if (!empty($arrPhoto)) {
				foreach ($arrPhoto as $photoData)
				{
					$photoData['assignment_id'] = $postData['assignmentID'];
					$photoId = $this->Assignment_model->add($photoData,$tbl_name2);
				}
			}
			if($postData['date']!=$postData['old_due_date']){
			$getClassStudentData=$this->Assignment_model->getStudentByClassId($postData['class_id']);
			if (!empty($getClassStudentData)) {
				foreach ($getClassStudentData as $studentData)
				{
					$student_id="ST-".$studentData['id'];
					$isNotify=notificationSettingHelper($postData['school_id'],$student_id,'Assignment');
					$notificationData['receiver_id'] = "ST-".$studentData['id'];
					$notificationData['sender_id'] = "S-".$sid;
					$notificationData['to_do_id'] = $postData['assignmentID'];
					$notificationData['message'] = $schoolData->fname." have changed due date for ".$postData['title']." assignment.";
					$notificationData['type'] = "assignment";
					$notificationData['url'] = "assignment-detail/".$encryptedUrl;
					if(!empty($isNotify) && $isNotify->is_push==1){
					$this->Teacher_model->add($notificationData,'notifications');
					}
					$studentEmail=$studentData['childemail'];
					if($studentEmail!='' && (!empty($isNotify) && $isNotify->is_web==1) ){
					$message = $this->load->view('emailtemplate/commonTemplate',$notificationData, true);
					$this->sendMail($studentEmail, "Your New assignment", $message);
					}
				}
			}
		}
			$message="Assignment updated successfully.";
			$return['success'] = "true";
			$return['message'] = $message;
			$return['error'] = $this->error;
			$return['data'] = $update;
			
			$this->response($return, REST_Controller::HTTP_OK);
			} else {
			$return['success'] = "false";
			$return['message'] = "Something went wrong.";
			$return['error'] = $this->error;
			$return['data'] = $this->data;
			
			$this->response($return, REST_Controller::HTTP_BAD_REQUEST);
		}
	}
	public function updateAssignmentFeedback_post() {
		$postData = json_decode(file_get_contents('php://input'), true);
		if ($postData == '') {
			$postData = $_POST;
		};
		$data['feedback']=$postData['feedback'];
		$tbl_name="assignment_submission";
		$where=array(
			'id'=>$postData['id']
		);
		$update = $this->Teacher_model->update($data,$tbl_name,$where);
		if ($update) {
			$message="Feedback updated successfully.";
			$return['success'] = "true";
			$return['message'] = $message;
			$return['error'] = $this->error;
			$return['data'] = $update;
			
			$this->response($return, REST_Controller::HTTP_OK);
			} else {
			$return['success'] = "false";
			$return['message'] = "Something went wrong.";
			$return['error'] = $this->error;
			$return['data'] = $this->data;
			$this->response($return, REST_Controller::HTTP_BAD_REQUEST);
		}
	}
	public function assignMarks_post() {
		$postData = json_decode(file_get_contents('php://input'), true);
		if ($postData == '') {
		$postData = $_POST;
		}
		$postData = $this->security->xss_clean($postData);
		//print_r($postData);die;
		$this->form_validation->set_data($postData);
		$this->form_validation->set_rules('marks_obtained', 'Marks obtained', 'trim|required|numeric|callback_checkNumber['.$postData['total_marks'].']');
		$error = array();
        if ($this->form_validation->run() === False) {
            $error = $this->form_validation->error_array();
            $message = validation_errors();
            $this->response(["success" => "false", 'message'=>$message,'data'=>'',"error" => $error], REST_Controller::HTTP_BAD_REQUEST);
        }
		$totalpersentage=0;
		if($postData['total_marks']>0){
		$persentage=($postData['marks_obtained']*100)/$postData['total_marks'];
		$totalpersentage=round($persentage);
		}
		
		$postData['percentage']=$totalpersentage;
		if($postData['category']=='graded'){
		$grade=check_grades($postData['school_id'],$totalpersentage);
		$postData['grade']=$grade;
		}
		$tdata = $this->session->userdata('teacher_data');
		$tid = $tdata['id'];
		$postData['created_by']="T-".$tid;
		$postData['updated_by']="T-".$tid;
		$postData['created_at']=date('Y-m-d H:i:s');
		$postData['updated_at']=date('Y-m-d H:i:s');
		$tbl_name="assignment_marks_obtain";
		$update = $this->Teacher_model->assignAssignmentMarks($postData,$tbl_name);
		if ($update) {
			$return['success'] = "true";
			$return['message'] = "Marks updated.";
			$return['data'] = $update;
			$return['error'] = $this->error;
			$this->response($return, REST_Controller::HTTP_OK);
			} else {
			$return['success'] = "false";
			$return['message'] = "Already Updated.";
			$return['error'] = $this->error;
			$this->response($return, REST_Controller::HTTP_BAD_REQUEST);
		}
	}
	public function checkNumber($num1,$num2){
			if($num1>$num2){
				$this->form_validation->set_message('checkNumber','Marks obtained should not be greater than total marks.');
				return FALSE;
			}else{
				return true;
			}
	}
	private function sendMail($to, $subject, $message) {
        $headers = 'MIME-Version: 1.0' . "\r\n";
        $headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
        $headers .= 'From: admin@kidyview.com' . "\r\n";
        return mail($to, $subject, $message, $headers);
    }
}
