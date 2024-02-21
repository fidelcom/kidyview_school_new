<?php
	
	defined('BASEPATH') OR exit('No direct script access allowed');
	
	require APPPATH . '/libraries/REST_Controller.php';
	
	class Profile extends REST_Controller {
		
		public $error = array();
		public $data = array();
		
		public function __construct() {
			parent::__construct();
			
			//$this->token->validate();
			$this->load->library('form_validation');
			$this->load->library("security");
			$this->load->model('teachers/Teacher_model','model');
			$this->load->library('settings');
		}
		
public function changePasswordTeacher_post() {
	$postData = json_decode(file_get_contents('php://input'), true);
	if ($postData == '') {
		$postData = $_POST;
	}
	$oldPassword = $postData['opsw'];
	$userDetail = $this->session->all_userdata();
    $id = $userDetail['teacher_data']['id'];
	$teacherdata = $this->model->getTeacherDetails($id);
	if($this->settings->decryptString($teacherdata->password)!=$oldPassword){
		$return['success'] = "false";
		$return['message'] = "Old password not match.";
		$return['error'] = $this->error;
		$return['data'] = 'old paddword';
		$this->response($return, REST_Controller::HTTP_BAD_REQUEST);
	}
	$newPassword = $this->settings->encryptString($postData['npsw']);
	$result = $this->model->changePasswordTeacher($oldPassword, $newPassword);
	
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
	public function getTeacherDetails_post() {
		$data = $this->session->userdata('teacher_data');
		$id = $data['id'];
		$result = $this->model->getTeacherProfileDetails($id);

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
	public function removeProfilePic_post() {
		$postData = json_decode(file_get_contents('php://input'), true);
		if ($postData == '') {
			$postData = $_POST;
		}
		$sdata = $this->session->userdata('teacher_data');
		$id = $sdata['id'];
		$data['teacherphoto'] = '';
		$where=array(
			'id'=>$id
		);
		$tbl_name="teacher";
		$result = $this->model->update($data,$tbl_name,$where);
		if ($result == 1) {
			$filePath='img/teacher/'.$postData['pic'];
			if (file_exists($filePath)) 
            {
			unlink($filePath);
			 }
			$return['success'] = "true";
			$return['message'] = "Profile Pic removed successfully.";
			$return['data'] = $result;
			$return['error'] = $this->error;
			
			$this->response($return, REST_Controller::HTTP_OK);
			} else {
			$return['success'] = "false";
			$return['message'] = "Not removed.";
			$return['error'] = $this->error;
			$return['data'] = $result;
			
			$this->response($return, REST_Controller::HTTP_BAD_REQUEST);
		}
	}
	public function profileImage_post()
    {
        if(isset($_FILES['image']))
        {
                $config['upload_path']          = './img/teacher/';
                $config['allowed_types']        = 'gif|jpg|png|jpeg|GIF|JPG|PNG|JPEG';
                $config['encrypt_name']        = true;
                $config['max_size']             = 200000;
                $this->load->library('upload', $config);

                if ( ! $this->upload->do_upload('image'))
                {
                        $error = array('error' => $this->upload->display_errors());
                        //return(false);
                        echo json_encode($error);
                }
                else
                {
					$sdata = $this->session->userdata('teacher_data');
					$id = $sdata['id'];
						$data = $this->upload->data();
						$where=array(
							'id'=>$id
						);
						$tbl_name="teacher";
						$imageData['teacherphoto']=$data['file_name'];
						$this->model->update($imageData,$tbl_name,$where);
                        echo json_encode(array("file_name"=>$data['file_name']));
                }
        }
        else
        {
            return false;
        }
    }

}
