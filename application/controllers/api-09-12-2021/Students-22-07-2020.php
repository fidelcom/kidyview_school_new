<?php
	
	defined('BASEPATH') OR exit('No direct script access allowed');
	
	require APPPATH . '/libraries/REST_Controller.php';
	
	class Students extends REST_Controller {
		
		public $error = array();
		public $data = array();
		
		public function __construct() {
			parent::__construct();
			
			//$this->token->validate();
			$this->load->library('form_validation');
			$this->load->library("security");
			$this->load->model('Student_model');
			$this->load->library('settings');
		}
		public function getStudentDetails_post() {
		$data = $this->session->userdata('student_data');
		$id = $data['id'];

		$result = $this->Student_model->getStudentDetails($id);

			if ($result) {
					$return['success'] = "true";
					$return['message'] = "Studentn details found.";
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
		
public function changePasswordStudent_post() {
	$postData = json_decode(file_get_contents('php://input'), true);
	if ($postData == '') {
		$postData = $_POST;
	}
	$oldPassword = $postData['opsw'];
	$userDetail = $this->session->all_userdata();
    $id = $userDetail['student_data']['id'];
	$studentdata = $this->Student_model->getStudentDetails($id);
	//echo $studentdata->password;die;
	if($this->settings->decryptString($studentdata->password)!=$oldPassword){
		$return['success'] = "false";
		$return['message'] = "Old password not match.";
		$return['error'] = $this->error;
		$return['data'] = 'old paddword';
		$this->response($return, REST_Controller::HTTP_BAD_REQUEST);
	}
	$newPassword = $this->settings->encryptString($postData['npsw']);
	$result = $this->Student_model->changePasswordStudent($oldPassword, $newPassword);
	
	if ($result == 1) {
		$return['success'] = "true";
		$return['message'] = "Password updated successfully.";
		$return['data'] = $result;
		$return['error'] = $this->error;
		
		$this->response($return, REST_Controller::HTTP_OK);
		} else {
		$return['success'] = "false";
		$return['message'] = "Password not updated.";
		$return['error'] = $this->error;
		$return['data'] = $result;
		
		$this->response($return, REST_Controller::HTTP_BAD_REQUEST);
	}
	}
public function addStudentHobie_post() {
	$postData = json_decode(file_get_contents('php://input'), true);
	if ($postData == '') {
		$postData = $_POST;
	}
	$hdata['hobie_name'] = $postData['hobie'];
	$data = $this->session->userdata('student_data');
	$id = $data['id'];
	$hdata['student_id'] = $id;
	$checkHobie = $this->Student_model->hobieExist($postData['hobie']);
	if ($checkHobie) {
		$return['success'] = "false";
		$return['message'] = "Hobie Already Exists.";
		$return['error'] = $this->error;
		$return['data'] = $this->data;
		$this->response($return, REST_Controller::HTTP_BAD_REQUEST);
	}
	$add = $this->Student_model->addStudentHobie($id,$hdata);
		if ($add) {
				$return['success'] = "true";
				$return['message'] = "Hobie added succefully.";
				$return['data'] = $add;
				$return['error'] = $this->error;

				$this->response($return, REST_Controller::HTTP_OK);
				} else {
				$return['success'] = "false";
				$return['message'] = "Not found.";
				$return['error'] = $this->error;
				$return['data'] = $add;

				$this->response($return, REST_Controller::HTTP_BAD_REQUEST);
		}
	}
	public function getStudentHobieList_post() {
		$data = $this->session->userdata('student_data');
		$id = $data['id'];

		$result = $this->Student_model->getStudentHobieList($id);

			if ($result) {
					$return['success'] = "true";
					$return['message'] = "Student hobies found.";
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
	public function hobieDelete_post() {
		$postData = json_decode(file_get_contents('php://input'), true);
		if ($postData == '') {
			$postData = $_POST;
		}
		$id = $postData['id'];
		$where=array(
		'id'=>$id
		);
		$tbl_name='student_hobie';
		$result = $this->Student_model->delete($where,$tbl_name);
		if ($result) {
			$return['success'] = "true";
			$return['message'] = "Hobie deleted successfully.";
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
	public function addStudentQuote_post() {
		$postData = json_decode(file_get_contents('php://input'), true);
		if ($postData == '') {
			$postData = $_POST;
		}
		$hdata['quote_name'] = $postData['quote'];
		$data = $this->session->userdata('student_data');
		$id = $data['id'];
		$hdata['student_id'] = $id;
		$checkQuote = $this->Student_model->quoteExist($postData['quote']);
		if ($checkQuote) {
			$return['success'] = "false";
			$return['message'] = "Quote Already Exists.";
			$return['error'] = $this->error;
			$return['data'] = $this->data;
			$this->response($return, REST_Controller::HTTP_BAD_REQUEST);
		}
		$add = $this->Student_model->addStudentQuote($id,$hdata);
			if ($add) {
					$return['success'] = "true";
					$return['message'] = "Quote added succefully.";
					$return['data'] = $add;
					$return['error'] = $this->error;
	
					$this->response($return, REST_Controller::HTTP_OK);
					} else {
					$return['success'] = "false";
					$return['message'] = "Not found.";
					$return['error'] = $this->error;
					$return['data'] = $add;
	
					$this->response($return, REST_Controller::HTTP_BAD_REQUEST);
			}
		}
		public function getStudentQuoteList_post() {
			$data = $this->session->userdata('student_data');
			$id = $data['id'];
	
			$result = $this->Student_model->getStudentQuoteList($id);
	
				if ($result) {
						$return['success'] = "true";
						$return['message'] = "Studentn quote found.";
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
	public function quoteDelete_post() {
		$postData = json_decode(file_get_contents('php://input'), true);
		if ($postData == '') {
			$postData = $_POST;
		}
		$id = $postData['id'];
		$where=array(
		'id'=>$id
		);
		$tbl_name='student_quote';
		$result = $this->Student_model->delete($where,$tbl_name);
		if ($result) {
			$return['success'] = "true";
			$return['message'] = "Quote deleted successfully.";
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
	public function updateStudentHobie_post() {
		$postData = json_decode(file_get_contents('php://input'), true);
		if ($postData == '') {
			$postData = $_POST;
		}
		$hdata['hobie_name'] = $postData['hobie_name'];
		$id = $postData['id'];
		$checkHobie = $this->Student_model->hobieExist($postData['hobie_name']);
		if ($checkHobie) {
			$return['success'] = "false";
			$return['message'] = "Hobie Already Exists.";
			$return['error'] = $this->error;
			$return['data'] = $checkHobie;
			$this->response($return, REST_Controller::HTTP_BAD_REQUEST);
		}
		$add = $this->Student_model->updateStudentHobie($id,$hdata);
			if ($add) {
					$return['success'] = "true";
					$return['message'] = "Hobie updated succefully.";
					$return['data'] = $add;
					$return['error'] = $this->error;
	
					$this->response($return, REST_Controller::HTTP_OK);
					} else {
					$return['success'] = "false";
					$return['message'] = "Not found.";
					$return['error'] = $this->error;
					$return['data'] = $add;
	
					$this->response($return, REST_Controller::HTTP_BAD_REQUEST);
			}
		}
		public function updateStudentQuote_post() {
			$postData = json_decode(file_get_contents('php://input'), true);
			if ($postData == '') {
				$postData = $_POST;
			}
			$hdata['quote_name'] = $postData['quote_name'];
			$id = $postData['id'];
			$checkQuote = $this->Student_model->quoteExist($postData['quote_name']);
			if ($checkQuote) {
				$return['success'] = "false";
				$return['message'] = "Quote Already Exists.";
				$return['error'] = $this->error;
				$return['data'] = $checkQuote;
				$this->response($return, REST_Controller::HTTP_BAD_REQUEST);
			}
			$add = $this->Student_model->updateStudentQuote($id,$hdata);
				if ($add) {
						$return['success'] = "true";
						$return['message'] = "Quote updated succefully.";
						$return['data'] = $add;
						$return['error'] = $this->error;
		
						$this->response($return, REST_Controller::HTTP_OK);
						} else {
						$return['success'] = "false";
						$return['message'] = "Not found.";
						$return['error'] = $this->error;
						$return['data'] = $add;
		
						$this->response($return, REST_Controller::HTTP_BAD_REQUEST);
				}
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
			print_r($_FILES['files']);die;
			$datas = $this->session->userdata('student_data');
			$id = $datas['id'];
			$chkSubAssignMent=$this->Student_model->checkExistAssignment($postData['assignment_id'],$id);
			if($chkSubAssignMent){
				$return['success'] = "false";
				$return['message'] = "Already Submitted.";
				$return['error'] = $this->error;
				$return['data'] = $this->data;
				$this->response($return, REST_Controller::HTTP_BAD_REQUEST);
			}
			$pic='';
			$ext = pathinfo($_FILES['pic']['name'], PATHINFO_EXTENSION);
			if($_FILES['pic']['name']!=''){
				$ext = pathinfo($_FILES['pic']['name'], PATHINFO_EXTENSION);
				$typeArr=array('jpg','jpeg','png','pdf');
				if(!in_array($ext,$typeArr)){
				$return['success'] = "false";
				$return['message'] = "Invalid upload file format.";
				$return['error'] = $this->error;
				$return['data'] = $this->data;
				$this->response($return, REST_Controller::HTTP_BAD_REQUEST);
				}
				$uploadPath = 'img/submitassignment/';
				$config['upload_path'] = $uploadPath;
				$config['allowed_types'] = '*';
				$config['max_size'] = 50000;
				$config['encrypt_name'] = TRUE;
				
				$this->load->library('upload', $config);
				$this->upload->initialize($config);
				if (!$this->upload->do_upload('pic')) {
					$uploaderror = $this->upload->display_errors();
					$return['success'] = "false";
					$return['message'] = $uploaderror;
					$return['error'] = $this->error;
					$return['data'] = $this->data;
					
					$this->response($return, REST_Controller::HTTP_BAD_REQUEST);
				} else {
					$uplodimg = $this->upload->data();
					$pic = $uplodimg['file_name'];
				}

				}
			$typeEx=explode('/',$_FILES['pic']['type']);
			if($typeEx[1]=='jpeg' || $typeEx[1]=='jpg' || $typeEx[1]=='png'){
				$data['attachment_type']='image';
			}elseif($typeEx[1]=='pdf'){
				$data['attachment_type']='pdf';
			}
			$data['description']=$postData['description'];
			$data['attachment']=$pic;
			$data['user_id']=$id;
			$data['user_type']='student';
			$data['assignment_id']=$postData['assignment_id'];
			$data['submission_date']=date('Y-m-d');
			$data['status']=1;
			$data['created']=date('Y-m-d H:i:s');
			$data['created']=date('Y-m-d H:i:s');
			$tbl_name="assignment_submission";
			$add = $this->Student_model->add($data,$tbl_name);
			if ($add) {
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
		$result = $this->Student_model->getSubmitAtachmentDetails($id);

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
		if ($postData == '') {
			$postData = $_POST;
		}
		$id = $postData['id'];
		$where=array(
		'id'=>$id
		);
		$pic='';
		$chkSubmission=$this->Student_model->checkAssignmentSubmission($postData['assignment_id']);
		if($chkSubmission){
			$return['success'] = "false";
			$return['message'] = "Submission Date Expired.";
			$return['error'] = $this->error;
			$return['data'] = $this->data;
			$this->response($return, REST_Controller::HTTP_BAD_REQUEST);
		}
		if(!empty($_FILES) && $_FILES['pic']['name']!=''){
			$ext = pathinfo($_FILES['pic']['name'], PATHINFO_EXTENSION);
			$typeArr=array('jpg','jpeg','png','pdf');
			if(!in_array($ext,$typeArr)){
				$return['success'] = "false";
				$return['message'] = "Invalid upload file format.";
				$return['error'] = $this->error;
				$return['data'] = $this->data;
				$this->response($return, REST_Controller::HTTP_BAD_REQUEST);
			}
			$uploadPath = 'img/submitassignment/';
			$config['upload_path'] = $uploadPath;
			$config['allowed_types'] = '*';
			$config['max_size'] = 50000;
			$config['encrypt_name'] = TRUE;
			
			$this->load->library('upload', $config);
			$this->upload->initialize($config);
			if (!$this->upload->do_upload('pic')) {
				$uploaderror = $this->upload->display_errors();
				$return['success'] = "false";
				$return['message'] = $uploaderror;
				$return['error'] = $this->error;
				$return['data'] = $this->data;
				
				$this->response($return, REST_Controller::HTTP_BAD_REQUEST);
			} else {
				$uplodimg = $this->upload->data();
				$pic = $uplodimg['file_name'];
			}
			$typeEx=explode('/',$_FILES['pic']['type']);
			if($typeEx[1]=='jpeg' || $typeEx[1]=='jpg' || $typeEx[1]=='png'){
			$data['attachment_type']='image';
			}elseif($typeEx[1]=='pdf'){
			$data['attachment_type']='pdf';
			}

			}
		
		$data['description']=$postData['description'];
		if($pic!=''){
		$data['attachment']=$pic;
		}
		$data['updated']=date('Y-m-d H:i:s');
		$tbl_name="assignment_submission";
		$update = $this->Student_model->update($data,$tbl_name,$where);
		if ($update) {
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
	public function getTeacherList_post() {
		$postData = json_decode(file_get_contents('php://input'), true);
		if ($postData == '') {
			$postData = $_POST;
		}
		$classID=$postData['classID'];
		$result = $this->Student_model->getTeacherList($classID);
			if ($result) {
					$return['success'] = "true";
					$return['message'] = "Teacher found.";
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
	public function getStudentList_post() {
		$postData = json_decode(file_get_contents('php://input'), true);
		if ($postData == '') {
			$postData = $_POST;
		}
		$data = $this->session->userdata('student_data');
		$id = $data['id'];
		$classID=$postData['classID'];
		$result = $this->Student_model->getStudentList($classID,$id);
			if ($result) {
					$return['success'] = "true";
					$return['message'] = "Teacher found.";
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
	public function getTeacherDetails_post() {
		$postData = json_decode(file_get_contents('php://input'), true);
		if ($postData == '') {
			$postData = $_POST;
		}
		$id=$postData['id'];
		$classID=$postData['classID'];
		$result = $this->Student_model->getTeacherDetails($id,$classID);;
			if ($result) {
					$return['success'] = "true";
					$return['message'] = "Teacher details found.";
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
	public function getStudentDetailsById_post() {
		$postData = json_decode(file_get_contents('php://input'), true);
		if ($postData == '') {
			$postData = $_POST;
		}
		$id=$postData['id'];
		$classID=$postData['classID'];
		$result = $this->Student_model->getStudentDetailsById($id,$classID);;
			if ($result) {
					$return['success'] = "true";
					$return['message'] = "Student details found.";
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
}
