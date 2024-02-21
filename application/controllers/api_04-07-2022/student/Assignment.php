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
			
			//$this->token->validate();
			$this->load->library('form_validation');
			$this->load->library("security");
			$this->load->model('students/Student_model');
			$this->load->library('settings');
		}
		public function getStudentAssignmentList_post() {
			$postData = json_decode(file_get_contents('php://input'), true);
			if ($postData == '') {
				$postData = $_POST;
			}
			$data = $this->session->userdata('student_data');
			$id = $data['id'];
			$classID=$postData['classID'];
			$filterbydate=$postData['filterbydate'];
			$result = $this->Student_model->getStudentAssignmentList($classID,$id,$filterbydate);
	
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
			$result = $this->Student_model->getAssignmentDetails($id);
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
		public function submitAssignment_post() {
			$postData = json_decode(file_get_contents('php://input'), true);
			if ($postData == '') {
				$postData = $_POST;
			}
			$datas = $this->session->userdata('student_data');
			$id = $datas['id'];
			$checkAttempt=$this->Student_model->getAssignmentDetails($postData['assignment_id']);
			//print_r($checkAttempt);die;
			if($checkAttempt['no_of_attempt']!='' && $checkAttempt['no_of_attempt']<=$checkAttempt['userAttemptCount']){
				$return['success'] = "false";
				$return['message'] = "You have exceed submission limit.";
				$return['error'] = $this->error;
				$return['data'] = $this->data;
				$this->response($return, REST_Controller::HTTP_BAD_REQUEST);
			}
			$chkSubAssignMent=$this->Student_model->checkExistAssignment($postData['assignment_id'],$id);
			if($chkSubAssignMent){
				$return['success'] = "false";
				$return['message'] = "Already Submitted.";
				$return['error'] = $this->error;
				$return['data'] = $this->data;
				$this->response($return, REST_Controller::HTTP_BAD_REQUEST);
			}
			$pic='';
			if (!empty($_FILES['files'])){
				$uploadPath = 'img/submitassignment/';
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
			$data['description']=$postData['description'];
			//$data['attachment']=$pic;
			$data['user_id']=$id;
			$data['user_type']='student';
			$data['assignment_id']=$postData['assignment_id'];
			$data['submission_date']=date('Y-m-d');
			$data['status']=1;
			$data['created']=date('Y-m-d H:i:s');
			$data['created']=date('Y-m-d H:i:s');
			$tbl_name="assignment_submission";
			$tbl_name2="submission_attachment";
			$this->load->model('students/Student_model');
			$studentData = $this->Student_model->getStudentDetails($id);
			$sudentname='';
			if($studentData){
				$sudentname=$studentData->childfname.' '.$studentData->childlname;
			}
			$add = $this->Student_model->add($data,$tbl_name);
			if ($add) {
			$pass = "KidyView";
			$text = $add;
			$encryptedUrl=$this->encryptData($text,$pass);
			//$contAttempt=$this->Student_model->getAssignmentAttempt($data['assignment_id']);
			//if($contAttempt){
				$tbl_name="assignment_submission_attempt";
				$attemptData['assignment_id'] = $data['assignment_id'];
				$attemptData['user_id'] = $id;
				$this->Student_model->add($attemptData,$tbl_name);
			//}	
				if (!empty($arrPhoto)) {
					foreach ($arrPhoto as $photoData)
					{
						$photoData['assignment_id'] = $add;
						$photoId = $this->Student_model->add($photoData,$tbl_name2);
					}
				}
				$this->load->model('teachers/Teacher_model');
				$getParentData=$this->Teacher_model->getParentData($id);
				$pnotificationData['sender_id'] = "ST-".$id;
				$pnotificationData['to_do_id'] = $data['assignment_id'];
				$pnotificationData['message'] = $sudentname." submitted his assignment.";
				$pnotificationData['school_id'] = $postData['schoolID'];
				$pnotificationData['type'] = "assignment";
				$pnotificationData['url'] = "submited-assignment-detail/".$encryptedUrl;
				if($getParentData){
					$pnotificationData['receiver_id'] = "P-".$getParentData->id;
					$isParentNotify=notificationSettingHelper($postData['schoolID'],$pnotificationData['receiver_id'],'Assignment');
					if(!empty($isParentNotify) && $isParentNotify->is_push==1){
					$this->Teacher_model->add($pnotificationData,'notifications');
					}	
				}
				$getAssignedTeacher=$this->Student_model->getAssignedTeacher($checkAttempt['subject_id']);
				if($getAssignedTeacher){
					$pnotificationData['receiver_id'] = "T-".$getAssignedTeacher->id;
					$isTeacherNotify=notificationSettingHelper($postData['schoolID'],$pnotificationData['receiver_id'],'Assignment');
					if(!empty($isTeacherNotify) && $isTeacherNotify->is_push==1){
					$this->Teacher_model->add($pnotificationData,'notifications');	
					}
				}
			$user_id="S-".$postData['schoolID'];
			$isNotify=notificationSettingHelper($postData['schoolID'],$user_id,'Assignment');
			$schoolNotificationData['receiver_id'] = $user_id;
			$schoolNotificationData['sender_id'] = "ST-".$id;
			$schoolNotificationData['to_do_id'] = $data['assignment_id'];
			$schoolNotificationData['message'] = $sudentname." submitted his assignment.";
			$schoolNotificationData['school_id'] = $postData['schoolID'];
			$schoolNotificationData['type'] = "assignment";
			$schoolNotificationData['url'] = "submited-assignment-detail/".$encryptedUrl;
			if(!empty($isNotify) && $isNotify->is_push==1){
			$this->Teacher_model->add($schoolNotificationData,'notifications');
			}
			$schoolEmail='';
			$schoolData=getSchoolDetails($postData['schoolID']);
			if(!empty($schoolData)){
				$schoolEmail=$schoolData->email;
				//$schoolEmail='yogendratomar.777@gmail.com';
			}
			if($schoolEmail!='' && (!empty($isNotify) && $isNotify->is_web==1)){
			$schoolNotificationData['user'] = "school";
			$message = $this->load->view('emailtemplate/commonTemplate',$schoolNotificationData, true);
			$this->sendMail($schoolEmail, "New Submitted Assignment", $message);
			}
				$return['success'] = "true";
				$return['message'] = "Assignment submit successfully.";
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
	public function getStudentSubmitAssignmentList_post() {
		$postData = json_decode(file_get_contents('php://input'), true);
		if ($postData == '') {
			$postData = $_POST;
		}
		$data = $this->session->userdata('student_data');
		$id = $data['id'];
		$classID=$postData['classID'];
		$result = $this->Student_model->getStudentSubmitAssignmentList($classID,$id);

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
	public function deleteSubmitAssignment_post() {
		$postData = json_decode(file_get_contents('php://input'), true);
		if ($postData == '') {
			$postData = $_POST;
		}
		$id = $postData['id'];
		$where=array(
		'id'=>$id
		);
		$tbl_name='assignment_submission';
		$result = $this->Student_model->delete($where,$tbl_name);
		if ($result) {
			$where=array(
				'assignment_id'=>$id
				);
			$tbl_name='submission_attachment';
			$this->Student_model->delete($where,$tbl_name);
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
	public function getSubmitAssignmentDetails_post() {
		$postData = json_decode(file_get_contents('php://input'), true);
		if ($postData == '') {
			$postData = $_POST;
		}
		$id=$postData['id'];
		$result = $this->Student_model->getSubmitAssignmentDetails($id);

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
	public function getSubmitAtachmentDetails_post() {
		$postData = json_decode(file_get_contents('php://input'), true);
		if ($postData == '') {
			$postData = $_POST;
		}
		$id=$postData['id'];
		$result = $this->Student_model->editSubmitAtachmentDetails($id);

			if ($result) {
					$return['success'] = "true";
					$return['message'] = "Attachment details found.";
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

	public function editSubmitAssignment_post() {
		$postData = json_decode(file_get_contents('php://input'), true);
		$sdata = $this->session->userdata('student_data');
		$sid = $sdata['id'];
		if ($postData == '') {
			$postData = $_POST;
		}
		$id = $postData['id'];
		$where=array(
		'id'=>$id
		);
		$pic='';
		
		$checkAttempt=$this->Student_model->getAssignmentDetails($postData['assignment_id']);
		if($checkAttempt['no_of_attempt']!='' && $checkAttempt['no_of_attempt']<=$checkAttempt['userAttemptCount']){
			$return['success'] = "false";
			$return['message'] = "You have exceed submission limit.";
			$return['error'] = $this->error;
			$return['data'] = $this->data;
			$this->response($return, REST_Controller::HTTP_BAD_REQUEST);
		}
		$chkSubmission=$this->Student_model->checkAssignmentSubmission($postData['assignment_id']);
		if($chkSubmission){
			$return['success'] = "false";
			$return['message'] = "Submission date expired.";
			$return['error'] = $this->error;
			$return['data'] = $this->data;
			$this->response($return, REST_Controller::HTTP_BAD_REQUEST);
		}
		if (!empty($_FILES['files'])){
			$uploadPath = 'img/submitassignment/';
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
		
		$data['description']=$postData['description'];
		
		$tbl_name="assignment_submission";
		$update = $this->Student_model->update($data,$tbl_name,$where);
		//echo $update;die;
		if ($update==0 OR $update==1) {
			$datedata['updated']=date('Y-m-d H:i:s');
			$this->Student_model->update($datedata,$tbl_name,$where);
			if ($update>0) {
			//$contAttempt=$this->Student_model->getAssignmentAttempt($postData['assignment_id']);
			//($contAttempt){
				$tbl_name="assignment_submission_attempt";
				$attemptData['assignment_id'] =$postData['assignment_id'];
				$attemptData['user_id'] = $sid;
				$this->Student_model->add($attemptData,$tbl_name);
			//}
			}
			if (!empty($arrPhoto)) {
				$tbl_name2="submission_attachment";
				foreach ($arrPhoto as $photoData)
				{
					$photoData['assignment_id'] = $id;
					$photoId = $this->Student_model->add($photoData,$tbl_name2);
				}
			}
			$return['success'] = "true";
			$return['message'] = "Assignment updated successfully.";
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
	public function deleteSubmitAttachData_post() {
		$postData = json_decode(file_get_contents('php://input'), true);
		if ($postData == '') {
			$postData = $_POST;
		}
		$id = $postData['id'];
		$where=array(
		'id'=>$id
		);
		$tbl_name='submission_attachment';
		$result = $this->Student_model->delete($where,$tbl_name);
		if ($result) {
			$filePath='img/submitassignment/'.$postData['filename'];
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
	function encryptData($text,$pass){
        $encryptedUrl = CryptoJSAES::encrypt($text, $pass);
        if(strpos($encryptedUrl, '/') !== false){
            $encryptedUrl = $this->encryptData($text,$pass);
        }
        return $encryptedUrl;
	}
	private function sendMail($to, $subject, $message) {
        $headers = 'MIME-Version: 1.0' . "\r\n";
        $headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
        $headers .= 'From: admin@kidyview.com' . "\r\n";
        return mail($to, $subject, $message, $headers);
    }
}
