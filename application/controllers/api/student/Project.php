<?php
	
	defined('BASEPATH') OR exit('No direct script access allowed');
	
	require APPPATH . '/libraries/REST_Controller.php';
	require APPPATH . '/libraries/crypto/autoload.php';
	use Blocktrail\CryptoJSAES\CryptoJSAES;
	class Project extends REST_Controller {
		
		public $error = array();
		public $data = array();
		
		public function __construct() {
			parent::__construct();
			
			//$this->token->validate();
			$this->load->library('form_validation');
			$this->load->library("security");
			$this->load->model('students/Project_model','model');
			$this->load->library('settings');
		}
		public function getStudentProjectList_post() {
			$postData = json_decode(file_get_contents('php://input'), true);
			if ($postData == '') {
				$postData = $_POST;
			}
			$data = $this->session->userdata('student_data');
			$id = $data['id'];
			$classID=$postData['classID'];
			$filterbydate=$postData['filterbydate'];
			$result = $this->model->getStudentProjectList($classID,$id,$filterbydate);
	
				if ($result) {
						$return['success'] = "true";
						$return['message'] = "Project found.";
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
		public function getProjectDetails_post() {
			$postData = json_decode(file_get_contents('php://input'), true);
			if ($postData == '') {
				$postData = $_POST;
			}
			$id=$postData['id'];
			$result = $this->model->getProjectDetails($id);
				if ($result) {
						$return['success'] = "true";
						$return['message'] = "Project details found.";
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
		public function submitProject_post() {
			$postData = json_decode(file_get_contents('php://input'), true);
			if ($postData == '') {
				$postData = $_POST;
			}
			$datas = $this->session->userdata('student_data');
			$id = $datas['id'];
			$checkAttempt=$this->model->getProjectDetails($postData['assignment_id']);
			//print_r($checkAttempt);die;
			if($checkAttempt['no_of_attempt']!='' && $checkAttempt['no_of_attempt']<=$checkAttempt['userAttemptCount']){
				$return['success'] = "false";
				$return['message'] = "You have exceed submission limit.";
				$return['error'] = $this->error;
				$return['data'] = $this->data;
				$this->response($return, REST_Controller::HTTP_BAD_REQUEST);
			}
			$chkSubAssignMent=$this->model->checkExistProject($postData['assignment_id'],$id);
			if($chkSubAssignMent){
				$return['success'] = "false";
				$return['message'] = "Already Submitted.";
				$return['error'] = $this->error;
				$return['data'] = $this->data;
				$this->response($return, REST_Controller::HTTP_BAD_REQUEST);
			}
			$pic='';
			if (!empty($_FILES['files'])){
				$uploadPath = 'img/submitproject/';
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
			$data['project_id']=$postData['assignment_id'];
			$data['submission_date']=date('Y-m-d');
			$data['status']=1;
			$data['created']=date('Y-m-d H:i:s');
			$data['created']=date('Y-m-d H:i:s');
			$tbl_name="project_submission";
			$tbl_name2="project_submission_attachment";
			$this->load->model('students/Student_model');
			$studentData = $this->Student_model->getStudentDetails($id);
			$sudentname='';
			if($studentData){
				$sudentname=$studentData->childfname.' '.$studentData->childlname;
			}
			$add = $this->model->add($data,$tbl_name);
			if ($add) {
			$pass = "KidyView";
			$text = $add;
			$encryptedUrl=$this->encryptData($text,$pass);
			//$contAttempt=$this->Student_model->getAssignmentAttempt($data['assignment_id']);
			//if($contAttempt){
				$tbl_name="project_submission_attempt";
				$attemptData['project_id'] = $data['project_id'];
				$attemptData['user_id'] = $id;
				$this->model->add($attemptData,$tbl_name);
			//}	
				if (!empty($arrPhoto)) {
					foreach ($arrPhoto as $photoData)
					{
						$photoData['project_id'] = $add;
						$photoId = $this->model->add($photoData,$tbl_name2);
					}
				}
				$this->load->model('teachers/Teacher_model');
				$getParentData=$this->Teacher_model->getParentData($id);
				$pnotificationData['sender_id'] = "ST-".$id;
				$pnotificationData['to_do_id'] = $data['project_id'];
				$pnotificationData['message'] = $sudentname." has submitted his/her project successfully";
				$pnotificationData['type'] = "project";
				$pnotificationData['url'] = "submited-project-detail/".$encryptedUrl;
				if($getParentData){
					$pnotificationData['receiver_id'] = "P-".$getParentData->id;
					$isParentNotify=notificationSettingHelper($postData['schoolID'],$pnotificationData['receiver_id'],'Project');
					if(!empty($isParentNotify) && $isParentNotify->is_push==1){
					$this->Teacher_model->add($pnotificationData,'notifications');
					}
				}
				$getAssignedTeacher=$this->Student_model->getAssignedTeacher($checkAttempt['subject_id']);
				//print_r($getAssignedTeacher);die;
				if($getAssignedTeacher){
					$pnotificationData['school_id'] = $postData['schoolID'];
					$pnotificationData['receiver_id'] = "T-".$getAssignedTeacher->id;
					$isTeacherNotify=notificationSettingHelper($postData['schoolID'],$pnotificationData['receiver_id'],'Project');
					if(!empty($isTeacherNotify) && $isTeacherNotify->is_push==1){
					$this->Teacher_model->add($pnotificationData,'notifications');	
					}
					$sendData['tname']=$getAssignedTeacher->teachername;
					$sendData['sname']=$sudentname;
					$sendData['atype']='project';
					$message = $this->load->view('emailtemplate/childSubmittedAssismentTemplate',$sendData, true);
                    sendKidyviewEmail($getAssignedTeacher->teacheremail,'','','', 'Child submitted project', $message);
				}
			$user_id="S-".$postData['schoolID'];
			$isNotify=notificationSettingHelper($postData['schoolID'],$user_id,'Project');
			$schoolNotificationData['receiver_id'] = $user_id;
			$schoolNotificationData['sender_id'] = "ST-".$id;
			$schoolNotificationData['school_id'] = $postData['schoolID'];
			$schoolNotificationData['to_do_id'] = $data['project_id'];
			$schoolNotificationData['message'] = $sudentname." has submitted his/her project successfully";
			$schoolNotificationData['type'] = "project";
			$schoolNotificationData['url'] = "submited-project-detail/".$encryptedUrl;
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
			//$this->sendMail($schoolEmail, "New Submitted Project", $message);
			sendKidyviewEmail($schoolEmail,'','','','Child submitted project', $message);
			}
				$return['success'] = "true";
				$return['message'] = "Project submit successfully.";
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
	public function getStudentSubmitProjectList_post() {
		$postData = json_decode(file_get_contents('php://input'), true);
		if ($postData == '') {
			$postData = $_POST;
		}
		$data = $this->session->userdata('student_data');
		$id = $data['id'];
		$classID=$postData['classID'];
		$result = $this->model->getStudentSubmitProjectList($classID,$id);

			if ($result) {
					$return['success'] = "true";
					$return['message'] = "Project found.";
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
	public function deleteSubmitProject_post() {
		$postData = json_decode(file_get_contents('php://input'), true);
		if ($postData == '') {
			$postData = $_POST;
		}
		$id = $postData['id'];
		$where=array(
		'id'=>$id
		);
		$tbl_name='project_submission';
		$result = $this->model->delete($where,$tbl_name);
		if ($result) {
			$where=array(
				'project_id'=>$id
				);
			$tbl_name='project_submission_attachment';
			$this->model->delete($where,$tbl_name);
			$return['success'] = "true";
			$return['message'] = "Project deleted successfully.";
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
	public function getSubmitProjectDetails_post() {
		$postData = json_decode(file_get_contents('php://input'), true);
		if ($postData == '') {
			$postData = $_POST;
		}
		$id=$postData['id'];
		$result = $this->model->getSubmitProjectDetails($id);

			if ($result) {
					$return['success'] = "true";
					$return['message'] = "Project details found.";
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
		$result = $this->model->editSubmitAtachmentDetails($id);

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

	public function editSubmitProject_post() {
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
		
		$checkAttempt=$this->model->getProjectDetails($postData['assignment_id']);
		if($checkAttempt['no_of_attempt']!='' && $checkAttempt['no_of_attempt']<=$checkAttempt['userAttemptCount']){
			$return['success'] = "false";
			$return['message'] = "You have exceed submission limit.";
			$return['error'] = $this->error;
			$return['data'] = $this->data;
			$this->response($return, REST_Controller::HTTP_BAD_REQUEST);
		}
		$chkSubmission=$this->model->checkProjectSubmission($postData['assignment_id']);
		if($chkSubmission){
			$return['success'] = "false";
			$return['message'] = "Submission date expired.";
			$return['error'] = $this->error;
			$return['data'] = $this->data;
			$this->response($return, REST_Controller::HTTP_BAD_REQUEST);
		}
		if (!empty($_FILES['files'])){
			$uploadPath = 'img/submitproject/';
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
		
		$tbl_name="project_submission";
		$update = $this->model->update($data,$tbl_name,$where);
		//echo $update;die;
		if ($update==0 OR $update==1) {
			$datedata['updated']=date('Y-m-d H:i:s');
			$this->model->update($datedata,$tbl_name,$where);
			if ($update>0) {
			//$contAttempt=$this->Student_model->getAssignmentAttempt($postData['assignment_id']);
			//($contAttempt){
				$tbl_name="project_submission_attempt";
				$attemptData['project_id'] =$postData['assignment_id'];
				$attemptData['user_id'] = $sid;
				$this->model->add($attemptData,$tbl_name);
			//}
			}
			if (!empty($arrPhoto)) {
				$tbl_name2="project_submission_attachment";
				foreach ($arrPhoto as $photoData)
				{
					$photoData['project_id'] = $id;
					$photoId = $this->model->add($photoData,$tbl_name2);
				}
			}
			$return['success'] = "true";
			$return['message'] = "Project updated successfully.";
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
		$tbl_name='project_submission_attachment';
		$result = $this->model->delete($where,$tbl_name);
		if ($result) {
			$filePath='img/submitproject/'.$postData['filename'];
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
