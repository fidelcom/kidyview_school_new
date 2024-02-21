<?php
	
	defined('BASEPATH') OR exit('No direct script access allowed');
	
	require APPPATH . '/libraries/REST_Controller.php';
	
	class Classboard extends REST_Controller {
		
		public $error = array();
		public $data = array();
		
		public function __construct() {
			parent::__construct();
			$this->load->library('form_validation');
			$this->load->library("security");
			$this->load->model('students/Student_model');
			$this->load->library('settings');
			$this->load->helper('common_helper');
		}
		public function getStudentByClass_post() {
			$postData = json_decode(file_get_contents('php://input'), true);
			if ($postData == '') {
				$postData = $_POST;
			}
			$data = $this->session->userdata('student_data');
			$id = $data['id'];
			$class_id = $postData['class'];
			$result = $this->Teacher_model->getStudentByClass($id,$class_id);
				if ($result) {
						$return['success'] = "true";
						$return['message'] = "Student found.";
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
		public function getTeacherClass_post() {
			$postData = json_decode(file_get_contents('php://input'), true);
			if ($postData == '') {
				$postData = $_POST;
			}
			$data = $this->session->userdata('teacher_data');
			$id = $data['id'];
			$result = $this->Teacher_model->getTeacherClass($id);
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
		public function createClassboard_post() {
			$postData = json_decode(file_get_contents('php://input'), true);
			if ($postData == '') {
				$postData = $_POST;
			}
			$data = $this->session->userdata('teacher_data');
			$id = $data['id'];
			$cdata['schoolId'] = $postData['school_id'];
			$cdata['class_id'] = $postData['class_id'];
			$cdata['name'] 	   = $postData['classroom'];
			$cdata['description'] = $postData['description'];
			$cdata['teacher_id'] = $id;
			$cdata['status'] = 1;
			$checkData = $this->Teacher_model->classboardExist($postData['classroom']);
			if ($checkData) {
				$return['success'] = "false";
				$return['message'] = "Classboard Already Exists.";
				$return['error'] = $this->error;
				$return['data'] = $this->data;
				$this->response($return, REST_Controller::HTTP_BAD_REQUEST);
			}
			$tbl_name="classboard";
			$add = $this->Teacher_model->add($cdata,$tbl_name);
				if ($add) {
					if(!empty($postData['student_id'])){
						$tbl_name="classboard_student";
						foreach($postData['student_id'] as $student_id){
							$stData['classboard_id']=$add;
							$stData['student_id']=$student_id;
							$this->Teacher_model->add($stData,$tbl_name);
						}
					}
						$return['success'] = "true";
						$return['message'] = "Classboard added succefully.";
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
		public function getClassboardList_post() {
			$postData = json_decode(file_get_contents('php://input'), true);
			if ($postData == '') {
				$postData = $_POST;
			}
			$data = $this->session->userdata('student_data');
			$id = $data['id'];
			$perpage=$postData['per_page'];
			$offset=$postData['offset']*$perpage;
			$count= $this->Student_model->getClassboardList('count',$id,'','',$postData['classID']);
			$result = $this->Student_model->getClassboardList('data',$id,$offset,$perpage,$postData['classID']);
				if ($result) {
						$return['success'] = "true";
						$return['message'] = "Classboard found.";
						$return['data'] = $result;
						$return['count'] = $count;
						$return['error'] = $this->error;
	
						$this->response($return, REST_Controller::HTTP_OK);
						} else {
						$return['success'] = "false";
						$return['message'] = "Not found.";
						$return['error'] = $this->error;
						$return['data'] = $result;
						$return['count'] = 0;
						$this->response($return, REST_Controller::HTTP_BAD_REQUEST);
				}
		}

	public function getClassboardPostList_post() {
		$postData = json_decode(file_get_contents('php://input'), true);
		if ($postData == '') {
			$postData = $_POST;
		}
		$data = $this->session->userdata('student_data');
		$id = $data['id'];
		$classboardID = $postData['classboardID'];
		$perpage=$postData['per_page'];
		$offset=$postData['offset']*$perpage;
		$count= $this->Student_model->getClassboardPostList('count',$classboardID,$id,'','');
		$result = $this->Student_model->getClassboardPostList('data',$classboardID,$id,$offset,$perpage);
			if ($result) {
					$return['success'] = "true";
					$return['message'] = "Classboard Post  found.";
					$return['data'] = $result;
					$return['count'] = $count;
					$return['error'] = $this->error;

					$this->response($return, REST_Controller::HTTP_OK);
					} else {
					$return['success'] = "false";
					$return['message'] = "Not found.";
					$return['error'] = $this->error;
					$return['data'] = $result;
					$return['count'] = 0;
					$this->response($return, REST_Controller::HTTP_BAD_REQUEST);
			}
	}
	
	public function addClaasboarPostComment_post() {
		$postData = json_decode(file_get_contents('php://input'), true);
		if ($postData == '') {
			$postData = $_POST;
		}
		$postData = $this->security->xss_clean($postData);
		$this->form_validation->set_data($postData);
		$this->form_validation->set_rules('comment', 'comment', 'trim|required');
		$error = array();
		if ($this->form_validation->run() === False) {
			$error = $this->form_validation->error_array();
			$this->response(["error" => $error], REST_Controller::HTTP_BAD_REQUEST);
		}
		$data = $this->session->userdata('student_data');
		$id = $data['id'];
		$cdata['user_id'] = "ST-".$id;
		$cdata['post_id'] = $postData['post_id'];
		$cdata['classboard_id'] 	   = $postData['classboard_id'];
		$cdata['comment'] = $postData['comment'];
		$cdata['created'] = date('Y-m-d H:i:s');
		
		$tbl_name="classboard_post_comment";
		$add = $this->Student_model->add($cdata,$tbl_name);
			if ($add) {
					$commentData=$this->Student_model->getPostCommentDataByCommentId($add,$id);
					$return['success'] = "true";
					$return['message'] = "Post added succefully.";
					$return['data'] = $commentData;
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
		public function deleteComment_post() {
			$postData = json_decode(file_get_contents('php://input'), true);
			if ($postData == '') {
				$postData = $_POST;
			}
			$id = $postData['id'];
			$where=array(
			'id'=>$id
			);
			$tbl_name='classboard_post_comment';
			$result = $this->Student_model->delete($where,$tbl_name);
			if ($result) {
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
}
