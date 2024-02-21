<?php
	
	defined('BASEPATH') OR exit('No direct script access allowed');

	require APPPATH . '/libraries/REST_Controller.php';
	require APPPATH . '/libraries/crypto/autoload.php';
	use Blocktrail\CryptoJSAES\CryptoJSAES;
	class Classboard extends REST_Controller {
		
		public $error = array();
		public $data = array();
		
		public function __construct() {
			parent::__construct();
			$this->load->library('form_validation');
			$this->load->library("security");
			$this->load->model('teachers/Teacher_model');
			$this->load->library('settings');
		}
		public function getStudentByClass_post() {
			$postData = json_decode(file_get_contents('php://input'), true);
			if ($postData == '') {
				$postData = $_POST;
			}
			$data = $this->session->userdata('teacher_data');
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
			$schoolID=$postData['schoolID'];
			$result = $this->Teacher_model->getTeacherClass($id,$schoolID);
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
					$this->load->model('teachers/Teacher_model');
					$teacherData = $this->Teacher_model->getTeacherDetails($id);
					$pass = "KidyView";
					$text = $add;
					$encryptedUrl=$this->encryptData($text,$pass);
					if(!empty($postData['student_id'])){
						$tbl_name="classboard_student";
						foreach($postData['student_id'] as $student_id){
							$stData['classboard_id']=$add;
							$stData['student_id']=$student_id['id'];
							$this->Teacher_model->add($stData,$tbl_name);
							$notificationData['receiver_id'] = "ST-".$student_id['id'];
							$notificationData['sender_id'] = "T-".$id;
							$notificationData['to_do_id'] = $add;
							$notificationData['message'] = $teacherData->teacherfname." create classboard for you.";
							$notificationData['type'] = "classboard";
							$notificationData['url'] = "view-post/".$encryptedUrl;
							$isNotify=notificationSettingHelper($postData['school_id'],$notificationData['receiver_id'],'Class Board');
							if(!empty($isNotify) && $isNotify->is_push==1){
							$this->Teacher_model->add($notificationData,'notifications');
							}
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
			$data = $this->session->userdata('teacher_data');
			$id = $data['id'];
			$perpage=$postData['per_page'];
			$offset=$postData['offset']*$perpage;
			$count= $this->Teacher_model->getClassboardList('count',$id,'','');
			$result = $this->Teacher_model->getClassboardList('data',$id,$offset,$perpage);
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

		public function getClassboardDetails_post() {
			$postData = json_decode(file_get_contents('php://input'), true);
			if ($postData == '') {
				$postData = $_POST;
			}
			$classboardid = $postData['id'];
			$result = $this->Teacher_model->getClassboardDetails($classboardid);
				if ($result) {
						$return['success'] = "true";
						$return['message'] = "Classboard found.";
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
		public function editClassboard_post() {
		$postData = json_decode(file_get_contents('php://input'), true);
		if ($postData == '') {
			$postData = $_POST;
		}
		$id=$postData['classboardid'];
		$cdata['class_id'] = $postData['class_id'];
		$cdata['name'] 	   = $postData['classroom'];
		$cdata['description'] = $postData['description'];
		$checkData = $this->Teacher_model->classboardExist($postData['classroom'],$id);
		if ($checkData) {
			$return['success'] = "false";
			$return['message'] = "Classboard Already Exists.";
			$return['error'] = $this->error;
			$return['data'] = $this->data;
			$this->response($return, REST_Controller::HTTP_BAD_REQUEST);
		}
		$tbl_name="classboard";
		$where=array('id'=>$id);
		$update = $this->Teacher_model->update($cdata,$tbl_name,$where);
		//echo $update;die;
			if ($update) {
					if(!empty($postData['student_id'])){
						$tbl_name="classboard_student";
						$this->db->where('classboard_id',$id);
        				$this->db->delete($tbl_name);
						$stData['classboard_id']=$id;
						foreach($postData['student_id'] as $student_id){
							$stData['student_id']=$student_id['id'];
							$this->db->select("id`");
							$this->db->where('classboard_id',$id);
							$this->db->where('student_id',$student_id['id']);
							$query = $this->db->get('classboard_student');
							if($query->num_rows()<=0)
							{
							$this->Teacher_model->add($stData,$tbl_name);
							}
							
						}
					}
					$return['success'] = "true";
					$return['message'] = "Classboard updated succefully.";
					$return['data'] = $update;
					$return['error'] = $this->error;

					$this->response($return, REST_Controller::HTTP_OK);
					} else {
					$return['success'] = "false";
					$return['message'] = "Not Updated.";
					$return['error'] = $this->error;
					$return['data'] = $update;

					$this->response($return, REST_Controller::HTTP_BAD_REQUEST);
			}
		}
		public function deleteClassboard_post() {
			$postData = json_decode(file_get_contents('php://input'), true);
			if ($postData == '') {
				$postData = $_POST;
			}
			$id = $postData['id'];
			$where=array(
			'id'=>$id
			);
			$tbl_name='classboard';
			$result = $this->Teacher_model->delete($where,$tbl_name);
			if ($result) {
				$tbl_name='classboard_student';
				$where=array(
					'classboard_id'=>$id
				);
				$result = $this->Teacher_model->delete($where,$tbl_name);
				$tbl_name='classboard_post';
				$result = $this->Teacher_model->delete($where,$tbl_name);
				$return['success'] = "true";
				$return['message'] = "Classboard deleted successfully.";
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
	public function createPost_post() {
			$postData = json_decode(file_get_contents('php://input'), true);
			if ($postData == '') {
				$postData = $_POST;
			};
			
			$pic='';
			if (!empty($_FILES['files'])){
				$uploadPath = 'img/classboard/post/';
				$config['upload_path'] = $uploadPath;
				$config['allowed_types'] = 'jpg|jpeg|png|pdf|doc|docx';
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
							$photoData['type'] = $attachmenttype;
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
			
			$tbl_name="classboard_post";
			$tbl_name2="classboard_post_attachment";
			
			if($postData['post_id']!=''){
				$where=array('id'=>$postData['post_id']);
				$data['updated']=date('Y-m-d H:i:s');
				$add = $this->Teacher_model->update($data,$tbl_name,$where);
			}else{
				$data['classboard_id']=$postData['classboard_id'];
				$data['status']=1;
				$add = $this->Teacher_model->add($data,$tbl_name);
			}
			if ($add) {
				if (!empty($arrPhoto)) {
					foreach ($arrPhoto as $photoData)
					{
						$photoData['classboard_id'] = $postData['classboard_id'];
						$photoData['post_id'] = $postData['post_id']!=''?$postData['post_id']:$add;
						$photoId = $this->Teacher_model->add($photoData,$tbl_name2);
					}
				}
				if($postData['post_id']!=''){
					$message="Post updated successfully.";
				}else{
					$message="Post added successfully.";
				}
				
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
	public function getClassboardPostList_post() {
		$postData = json_decode(file_get_contents('php://input'), true);
		if ($postData == '') {
			$postData = $_POST;
		}
		$data = $this->session->userdata('teacher_data');
		$id = $data['id'];
		$classboardID = $postData['classboardID'];
		$perpage=$postData['per_page'];
		$offset=$postData['offset']*$perpage;
		$count= $this->Teacher_model->getClassboardPostList('count',$classboardID,$id,'','');
		$result = $this->Teacher_model->getClassboardPostList('data',$classboardID,$id,$offset,$perpage);
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
	public function deletePost_post() {
		$postData = json_decode(file_get_contents('php://input'), true);
		if ($postData == '') {
			$postData = $_POST;
		}
		$id = $postData['id'];
		$where=array(
		'id'=>$id
		);
		$tbl_name='classboard_post';
		$result = $this->Teacher_model->delete($where,$tbl_name);
		if ($result) {
			$tbl_name='classboard_post_attachment';
			$where=array(
				'post_id'=>$id
			);
			$result = $this->Teacher_model->delete($where,$tbl_name);
			$return['success'] = "true";
			$return['message'] = "Post deleted successfully.";
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
	public function deletePostAttachData_post() {
		$postData = json_decode(file_get_contents('php://input'), true);
		if ($postData == '') {
			$postData = $_POST;
		}
		$id = $postData['id'];
		$where=array(
		'id'=>$id
		);
		$tbl_name='classboard_post_attachment';
		$result = $this->Teacher_model->delete($where,$tbl_name);
		if ($result) {
			$filePath='img/classboard/post/'.$postData['filename'];
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
		$data = $this->session->userdata('teacher_data');
		$id = $data['id'];
		$cdata['user_id'] = "T-".$id;
		$cdata['post_id'] = $postData['post_id'];
		$cdata['classboard_id'] 	   = $postData['classboard_id'];
		$cdata['comment'] = $postData['comment'];
		$cdata['created'] = date('Y-m-d H:i:s');
		
		$tbl_name="classboard_post_comment";
		$add = $this->Teacher_model->add($cdata,$tbl_name);
			if ($add) {
					$commentData=$this->Teacher_model->getPostCommentDataByCommentId($add);
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
			$result = $this->Teacher_model->delete($where,$tbl_name);
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
		function encryptData($text,$pass){
			$encryptedUrl = CryptoJSAES::encrypt($text, $pass);
			if(strpos($encryptedUrl, '/') !== false){
				$encryptedUrl = $this->encryptData($text,$pass);
			}
			return $encryptedUrl;
		}
}
