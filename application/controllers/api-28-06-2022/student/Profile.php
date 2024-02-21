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
			$this->load->model('students/Student_model');
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

	public function removeProfilePic_post() {
		$postData = json_decode(file_get_contents('php://input'), true);
		if ($postData == '') {
			$postData = $_POST;
		}
		$sdata = $this->session->userdata('student_data');
		$id = $sdata['id'];
		$data['childphoto'] = '';
		$where=array(
			'id'=>$id
		);
		$tbl_name="child";
		$result = $this->Student_model->update($data,$tbl_name,$where);
		//echo $this->db->last_query();die;
		if ($result == 1) {
			$filePath='img/child/'.$postData['pic'];
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
                $config['upload_path']          = './img/child/';
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
					$sdata = $this->session->userdata('student_data');
					$id = $sdata['id'];
						$data = $this->upload->data();
						$where=array(
							'id'=>$id
						);
						$tbl_name="child";
						$imageData['childphoto']=$data['file_name'];
						$this->Student_model->update($imageData,$tbl_name,$where);
                        echo json_encode(array("file_name"=>$data['file_name']));
                }
        }
        else
        {
            return false;
        }
    }
	
}
