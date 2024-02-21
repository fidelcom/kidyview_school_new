<?php
	
	defined('BASEPATH') OR exit('No direct script access allowed');
	
	require APPPATH . '/libraries/REST_Controller.php';
	require APPPATH . '/libraries/crypto/autoload.php';
	use Blocktrail\CryptoJSAES\CryptoJSAES;
	class Message extends REST_Controller {
		
		public $error = array();
		public $data = array();
		
		public function __construct() {
			parent::__construct();
			$this->load->library('form_validation');
			$this->load->library("security");
			$this->load->model('teachers/Message_model','model');
			$this->load->library('settings');
			$this->load->helper('common_helper');
		}
		
		public function getUser_post() {
			$postData = json_decode(file_get_contents('php://input'), true);
			if ($postData == '') {
				$postData = $_POST;
			}
			$data = $this->session->userdata('teacher_data');
			$userId = $data['id'];
			$userType=$postData['user_type'];
			$classId=$postData['schoolID'];
			$result = $this->model->getUser($userType,$classId,$userId);
				if ($result) {
						$return['success'] = "true";
						$return['message'] = "User found.";
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
		public function sendMessage_post() {
			$postData = json_decode(file_get_contents('php://input'), true);
			if ($postData == '') {
				$postData = $_POST;
			};
			$postData = $this->security->xss_clean($postData);
			$this->form_validation->set_data($postData);
			$this->form_validation->set_rules('receiver_id[]', 'Message', 'trim|required');
			if($postData['usertype']!='' || empty($_FILES['files'])){
			$this->form_validation->set_rules('message', 'Message', 'trim|required');
			}
			$error = array();
			if ($this->form_validation->run() === False) {
				$error = $this->form_validation->error_array();
				$message = validation_errors();
				$this->response(["success" => "false", 'message'=>$message,'data'=>'',"error" => $error], REST_Controller::HTTP_BAD_REQUEST);
			} 
			$pic='';
			if (!empty($_FILES['files'])){
				$uploadPath = 'img/message/';
				$config['upload_path'] = $uploadPath;
				$config['allowed_types'] = 'jpg|jpeg|png|pdf|doc|docx|mp4|mp3|3gp||avi|flv|wmv';
				$config['max_size'] = 500000;
				$config['encrypt_name'] = TRUE;
				$this->load->library('upload', $config);
				$this->upload->initialize($config);
				$arrPhoto=array();
				$totalImageSize = 0;
				//size in MB
				$maxphotosize = 8;
				if (!empty($_FILES['files'])) {
					for ($i = 0; $i < count($_FILES['files']['name']); $i++) {
						if ($_FILES['files']['name'][$i] != '') {
							$size = $_FILES['files']['size'][$i]	;                    
							$totalImageSize = $totalImageSize + $size;
						}
					}
				}
				$totalphotosize = $totalImageSize / (1024 * 1024);
            	if ($totalphotosize > $maxphotosize) {
				$this->response(["status" => "error", "message" => "Attachment should not be greater than $maxphotosize MB"], REST_Controller::HTTP_BAD_REQUEST);
				}
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
							$photoData['file_name'] = $uplodimg['file_name'];
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
			$sdata = $this->session->userdata('teacher_data');
			$sid = $sdata['id'];
			$data['message']=$postData['message'];
			$data['sender']="T-".$sid;
			$data['school_id']=$postData['schoolID'];
			$data['created_date']=date('Y-m-d H:i:s');
			$tbl_name="messages";
			$tbl_name2="message_attachment";
			$add='';
			$this->load->model('teachers/Teacher_model');
			$teacherData = $this->Teacher_model->getTeacherDetails($sid);
			$pass = "KidyView";
			$text = $data['sender'];
			$encryptedUrl=$this->encryptData($text,$pass);			
			//print_r($postData['receiver_id']);die;
				if (!empty($postData['receiver_id'])){
					foreach($postData['receiver_id'] as $user){
					$isNotify=notificationSettingHelper($postData['schoolID'],$user,'Chat');
					$data['reciever']=$user;
					$add = $this->model->add($data,$tbl_name);
					if($add) {
						if (!empty($arrPhoto)) {
							foreach ($arrPhoto as $photoData)
							{
								$photoData['message_id'] = $add;
								$photoId = $this->model->add($photoData,$tbl_name2);
							}
						}
						$notificationData['receiver_id'] = $user;
						$notificationData['sender_id'] = "T-".$sid;
						$notificationData['to_do_id'] = $add;
						$notificationData['message'] = $teacherData->teacherfname." initiate chat meaasge for you.";
						$notificationData['type'] = "chat";
						$notificationData['url'] = "conversation/".$encryptedUrl;
						if(!empty($isNotify) && $isNotify->is_push==1){
						$this->model->add($notificationData,'notifications');
						}
					} 

					}
				}
				if ($add) {
					
					$message="Message send successfully.";
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
		public function getMessageList_post() {
			$postData = json_decode(file_get_contents('php://input'), true);
			if ($postData == '') {
				$postData = $_POST;
			}
			$data = $this->session->userdata('teacher_data');
			$userId = "T-".$data['id'];
			$result = $this->model->allData($userId);
				if ($result) {
						$return['success'] = "true";
						$return['message'] = "Message found.";
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
		public function deleteMessage_post() {
			$postData = json_decode(file_get_contents('php://input'), true);
			if ($postData == '') {
				$postData = $_POST;
			}
			$id = $postData['id'];
			$data = $this->session->userdata('teacher_data');
			$userID = "T-".$data['id'];
			$result = $this->model->deleteMessage($id,$userID);
			if ($result) {
				$return['success'] = "true";
				$return['message'] = "Message deleted successfully.";
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
		public function getConversationList_post() {
			$postData = json_decode(file_get_contents('php://input'), true);
			if ($postData == '') {
				$postData = $_POST;
			}
			$data = $this->session->userdata('teacher_data');
			$user1 = "T-".$data['id'];
			$user2 = $postData['user_id'];
			$messageData = $this->model->getConversation($user1,$user2);
			$userDetail = $this->model->userDetail($user2);
			
			$conversationData = array(
				"user_detail"=>$userDetail,
				"conversation"=>$messageData
			);
			$return['success'] = "true";
			$return['title'] = "success";
			$return['message'] = $conversationData ? "Message Detail" : "No data found";
			$return['data'] = $conversationData;
			$return['error'] = $this->error;
			$this->response($return, REST_Controller::HTTP_OK);
		}

		public function deleteConversationMessage_post() {
			$postData = json_decode(file_get_contents('php://input'), true);
			if ($postData == '') {
				$postData = $_POST;
			}
			$data = $this->session->userdata('teacher_data');
			$user1 = "T-".$data['id'];
			$user2 = $postData['user'];
			$result = $this->model->deleteConversationMessage($user1,$user2);
			if ($result) {
				$return['success'] = "true";
				$return['message'] = "Message deleted successfully.";
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

