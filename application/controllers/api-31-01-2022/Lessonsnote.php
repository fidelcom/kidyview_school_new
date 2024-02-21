<?php
	
	defined('BASEPATH') OR exit('No direct script access allowed');
	
	require APPPATH . '/libraries/REST_Controller.php';
	
	class Lessonsnote extends REST_Controller {
		
		public $error = array();
		public $data = array();
		
		public function __construct() {
			parent::__construct();
                       
			if($this->session->userdata('user_role')=='school' OR $this->session->userdata('user_role')=='schoolsubadmin'){
			$this->token->validate();
			}
			$this->load->library('form_validation');
			$this->load->library("security");
			$this->load->model('teachers/Lesson_model','lesson');
			$this->load->model('team_model');
			$this->load->library('settings');
		}
                
                
    public function lessonnotelist_post() 
    {
    
       $postData = json_decode(file_get_contents('php://input'), true);
        if ($postData == '') {
            $postData = $_POST;
        }
        $schoolID = $postData['schoolID'];
        //$subclass = $postData['subclass'];
        $result = $this->lesson->alllessonnotelist($schoolID);

        if ($result) {
            $return['success'] = "true";
            $return['message'] = "Teacher Lesson Note List Found";
            $return['data'] = $result;
            $return['error'] = $this->error;

            $this->response($return, REST_Controller::HTTP_OK);
        } else {
            $return['success'] = "false";
            $return['message'] = "No Teacher Lesson Note List Found.";
            $return['error'] = $this->error;
            $return['data'] = '';
            $this->response($return, REST_Controller::HTTP_BAD_REQUEST);
        } 
        
    }  
             
    
    public function viewnote_post() 
    {
    
       $postData = json_decode(file_get_contents('php://input'), true);
        if ($postData == '') {
            $postData = $_POST;
        }
        
        
        $schoolID = $postData['schoolID'];
        $noteid = $postData['noteid'];
        $user_id="S-".$schoolID;
        $result = $this->lesson->viewdetailsharednote($schoolID,$noteid,$user_id);

        if ($result) {
            $return['success'] = "true";
            $return['message'] = "Notes Detail Found";
            $return['data'] = $result;
            $return['error'] = $this->error;

            $this->response($return, REST_Controller::HTTP_OK);
        } else {
            $return['success'] = "false";
            $return['message'] = "No Detail Found";
            $return['error'] = $this->error;
            $return['data'] = '';
            $this->response($return, REST_Controller::HTTP_BAD_REQUEST);
        } 
        
    }
    
    
    public function notedisabled_post() 
    {
    $postData = json_decode(file_get_contents('php://input'), true);
    if ($postData == '') {
    $postData = $_POST;
    }
    $id = $postData['id'];
    $status = $postData['status'];

    $updateArr = array(
    'status' => $status,
    );

    $update = $this->lesson->notedisabled($updateArr, $id);


    if ($update) {
    $return['success'] = "true";
    $return['message'] = "Note Status Disabled Now.";
    $return['error'] = $this->error;
    $return['data'] = $updateArr;

    $this->response($return, REST_Controller::HTTP_OK);
    } else {
    $return['success'] = "false";
    $return['message'] = "Something went wrong.";
    $return['error'] = $this->error;
    $return['data'] = $this->data;

    $this->response($return, REST_Controller::HTTP_BAD_REQUEST);
    }
    }
    public function addLessonComment_post() {
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
		
		$cdata['user_id'] = "S-".$postData['schoolID'];
		$cdata['schoolID'] = $postData['schoolID'];
		$cdata['noteid'] = $postData['noteid'];
        $cdata['comment'] = $postData['comment'];
        $cdata['commentFrom'] = 'School';
		$cdata['created_date'] = date('Y-m-d H:i:s');
		$tbl_name="lesson_note_comment";
		$add = $this->lesson->add($cdata,$tbl_name);
			if ($add) {
					$commentData=$this->lesson->getLessionCommentDataByCommentId($add,$cdata['user_id']);
					$return['success'] = "true";
					$return['message'] = "Lesson added succefully.";
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
        'id'=>$id,
        'user_id'=>"S-".$postData['schoolID']
        );
        $tbl_name='lesson_note_comment';
        $result = $this->lesson->delete($where,$tbl_name);
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