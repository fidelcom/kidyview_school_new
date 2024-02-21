<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Lesssonnotestd extends  REST_Controller {

    public $stdclass = "";
    public $student_id = "";
    public $error = array();
    
    public function __construct() {
        
        parent::__construct();
        $this->load->library('form_validation');
        $this->load->library("security");
        $this->load->library('settings');
        $this->load->helper('common_helper');
        $this->load->model('students/Studentnotes_model','lesson');
        $data = $this->session->userdata('student_data');
        $this->student_id = $data['id'];
        $stddata = $this->lesson->studentdata($this->student_id);
        if($stddata){
         $this->stdclass = $stddata->childclass;  
        }
      
    }
    
  public function studentlessonlist_post() 
    {
       $postData = json_decode(file_get_contents('php://input'), true);
        if ($postData == '') {
            $postData = $_POST;
        }
        
        $class_id= $this->stdclass;
        $schoolID= $postData['schoolID'];
        $result = $this->lesson->studentlessonlist($schoolID,$class_id);

        if ($result) {
            $return['success'] = "true";
            $return['message'] = "Lesson Note List Found";
            $return['data'] = $result;
            $return['error'] = $this->error;
            $this->response($return, REST_Controller::HTTP_OK);
        } else {
            $return['success'] = "false";
            $return['message'] = "No Lesson Note Found.";
            $return['error'] = $this->error;
            $return['data'] = '';
            $this->response($return, REST_Controller::HTTP_BAD_REQUEST);
        } 
        
    } 
    
    
    public function viewdetailsharednote_post() 
    {
    
       $postData = json_decode(file_get_contents('php://input'), true);
        if ($postData == '') {
            $postData = $_POST;
        }
        
        
        $schoolID = $postData['schoolID'];
        $noteid = $postData['noteid'];
        $result = $this->lesson->viewdetailsharednote($schoolID,$noteid);

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
    
    
    public function addcomment_post() 
    {
       $postData = json_decode(file_get_contents('php://input'), true);
        if ($postData == '') {
            $postData = $_POST;
        }
        
        $student_id = $this->student_id;
        $studentId = "ST-".$this->student_id;
        $schoolID = $postData['schoolID'];
        $noteid = $postData['noteid'];
        $comment = $postData['comment'];
        
        $datarray = array(
          'noteid' => $noteid, 
          'schoolid' => $schoolID,
          'user_id' => $studentId,
          'commentId' => $student_id,
          'commentFrom' => 'student',  
          'comment' => $comment,
          'status'=>'0', 
          'created_date' => date('Y-m-d H:i:s') 
        );
        
        $result = $this->lesson->addcomment($datarray);
        if ($result) {
            $return['success'] = "true";
            $return['message'] = "Comment Added Successfully";
            $return['data'] = $result;
            $return['error'] = $this->error;
            $this->response($return, REST_Controller::HTTP_OK);
        } else {
            $return['success'] = "false";
            $return['message'] = "Error occured while adding Comment";
            $return['error'] = $this->error;
            $return['data'] = '';
            $this->response($return, REST_Controller::HTTP_BAD_REQUEST);
        }
        
    }
    
    
    public function commentlist_post() 
    {
    
       $postData = json_decode(file_get_contents('php://input'), true);
        if ($postData == '') {
            $postData = $_POST;
        }
        
        
        $schoolID = $postData['schoolID'];
        $noteid = $postData['noteid'];
        $student_id = $this->student_id;
        $result = $this->lesson->commentlist($schoolID,$noteid,$student_id);

        if ($result) {
            $return['success'] = "true";
            $return['message'] = "Comment List Found";
            $return['data'] = $result;
            $return['error'] = $this->error;

            $this->response($return, REST_Controller::HTTP_OK);
        } else {
            $return['success'] = "false";
            $return['message'] = "No Comment Found";
            $return['error'] = $this->error;
            $return['data'] = '';
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
		//$data = $this->session->userdata('teacher_data');
		$id = $this->student_id;
		$cdata['user_id'] = "ST-".$id;
		$cdata['schoolID'] = $postData['schoolID'];
		$cdata['noteid'] = $postData['noteid'];
        $cdata['comment'] = $postData['comment'];
        $cdata['commentFrom'] = 'Teacher';
		$cdata['created_date'] = date('Y-m-d H:i:s');
		$tbl_name="lesson_note_comment";
		$add = $this->lesson->add($cdata,$tbl_name);
			if ($add) {
					$commentData=$this->lesson->getLessionCommentDataByCommentId($add);
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
        //$data = $this->session->userdata('teacher_data');
        $studentid = "T-".$this->student_id;
        $where=array(
        'id'=>$id,
        'user_id'=>$studentid
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