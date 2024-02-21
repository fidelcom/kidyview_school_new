<?php

defined('BASEPATH') OR exit('No direct script access allowed');
require APPPATH . '/libraries/REST_Controller.php';

class Lessonnote extends REST_Controller {

    public $error = array();
    public $data = array();

    public function __construct() {
        parent::__construct();
        //$this->token->validate();
        $this->load->library('form_validation');
        $this->load->library("security");
        $this->load->model('teachers/Lesson_model','lesson');
        $this->load->library('settings');
    }

    public function getAllSubjectForSchool_post() {
        $postData = json_decode(file_get_contents('php://input'), true);
        if ($postData == '') {
            $postData = $_POST;
        }
        $id = $postData['id'];
        $result = $this->lesson->getAllSubjectForSchool($id);

        if ($result) {
            $return['success'] = "true";
            $return['message'] = "All Subjects details found.";
            $return['data'] = $result;
            $return['error'] = $this->error;

            $this->response($return, REST_Controller::HTTP_OK);
        } else {
            $return['success'] = "false";
            $return['message'] = "Not found.";
            $return['error'] = $this->error;
            $return['data'] = '';

            $this->response($return, REST_Controller::HTTP_BAD_REQUEST);
        }
    }
    
    
    
    public function getAllTermForSchool_post() 
    {
        $postData = json_decode(file_get_contents('php://input'), true);
        if ($postData == '') {
            $postData = $_POST;
        }
        $id = $postData['id'];
        $result = $this->lesson->getAllTermForSchool($id);

        if ($result) {
            $return['success'] = "true";
            $return['message'] = "All Terms details found.";
            $return['data'] = $result;
            $return['error'] = $this->error;

            $this->response($return, REST_Controller::HTTP_OK);
        } else {
            $return['success'] = "false";
            $return['message'] = "Not found.";
            $return['error'] = $this->error;
            $return['data'] = '';

            $this->response($return, REST_Controller::HTTP_BAD_REQUEST);
        }
    }
    
    
    public function gettermdates_post() {
    
       $postData = json_decode(file_get_contents('php://input'), true);
        if ($postData == '') {
            $postData = $_POST;
        }
        $schoolID = $postData['schoolID'];
        $term = $postData['term'];
        
        $result = $this->lesson->gettermdates($schoolID,$term);

        if ($result) {
            $return['success'] = "true";
            $return['message'] = "All Terms details found.";
            $return['data'] = $result;
            $return['error'] = $this->error;

            $this->response($return, REST_Controller::HTTP_OK);
        } else {
            $return['success'] = "false";
            $return['message'] = "Not found.";
            $return['error'] = $this->error;
            $return['data'] = '';

            $this->response($return, REST_Controller::HTTP_BAD_REQUEST);
        } 
        
    }
    
    public function getclass_post() 
    {
    
       $postData = json_decode(file_get_contents('php://input'), true);
        if ($postData == '') {
            $postData = $_POST;
        }
        $data = $this->session->userdata('teacher_data');
        $teacherid = $data['id'];
        $schoolID = $postData['schoolID'];
        $isShared = isset($postData['isShared']) && $postData['isShared']?$postData['isShared']:'';
        $result = $this->lesson->getAllClassForSchool($schoolID,$teacherid,$isShared);

        if ($result) {
            $return['success'] = "true";
            $return['message'] = "class list found";
            $return['data'] = $result;
            $return['error'] = $this->error;

            $this->response($return, REST_Controller::HTTP_OK);
        } else {
            $return['success'] = "false";
            $return['message'] = "Not found.";
            $return['error'] = $this->error;
            $return['data'] = '';

            $this->response($return, REST_Controller::HTTP_BAD_REQUEST);
        } 
        
    }
    
    
    public function getsubject_post() 
    {
    
       $postData = json_decode(file_get_contents('php://input'), true);
        if ($postData == '') {
            $postData = $_POST;
        }
        $schoolID = $postData['schoolID'];
        $classID = $postData['classID'];
        $isShared = isset($postData['isShared']) && $postData['isShared']?$postData['isShared']:'';
        $data = $this->session->userdata('teacher_data');
        $teacherid = $data['id'];
        //$subclass = $postData['subclass'];
        $result = $this->lesson->getsubject($classID,$teacherid,$isShared);

        if ($result) {
            $return['success'] = "true";
            $return['message'] = "subject list found";
            $return['data'] = $result;
            $return['error'] = $this->error;

            $this->response($return, REST_Controller::HTTP_OK);
        } else {
            $return['success'] = "false";
            $return['message'] = "Not found.";
            $return['error'] = $this->error;
            $return['data'] = '';

            $this->response($return, REST_Controller::HTTP_BAD_REQUEST);
        } 
        
    }
    
    public function getteacher_post() 
    {
    
       $postData = json_decode(file_get_contents('php://input'), true);
        if ($postData == '') {
            $postData = $_POST;
        }
        $data = $this->session->userdata('teacher_data');
        $teacherid = $data['id'];
        $schoolID = $postData['schoolID'];
        //$subclass = $postData['subclass'];
        $result = $this->lesson->getteacher($schoolID,$teacherid);

        if ($result) {
            $return['success'] = "true";
            $return['message'] = "Teacher list found";
            $return['data'] = $result;
            $return['error'] = $this->error;

            $this->response($return, REST_Controller::HTTP_OK);
        } else {
            $return['success'] = "false";
            $return['message'] = "Not found.";
            $return['error'] = $this->error;
            $return['data'] = '';

            $this->response($return, REST_Controller::HTTP_BAD_REQUEST);
        } 
        
    }
    
    
    
    public function addnote_post() 
    {
    
       $postData = json_decode(file_get_contents('php://input'), true);
        if ($postData == '') {
            $postData = $_POST;
        }
        //print_r($postData);die;
        $data = $this->session->userdata('teacher_data');
        $teacherid = $data['id'];
        $schoolID = $postData['schoolID'];
        $term = $postData['term'];
        $activitytype = $postData['activitytype'];
        $fromdate = $postData['fromdate'];
        $todate = $postData['todate'];
        $lessonsubject = $postData['lessonsubject'];
        $topic = $postData['topic'];
        $class_share = isset($postData['class_share']) && $postData['class_share'] =="true" ? 1 : 0;
        $teacher_share = $postData['teacher_share'];
        $lessonclass = $postData['lessonclass'];
        $teacherlist = $postData['teacherlist'];
        $objectives = $postData['objectives'];
        $material = $postData['material'];
        $introduction = $postData['introduction'];
        $pic = '';
        if (!empty($_FILES['document']['name'])) 
        {
            $uploadPath = 'img/teacher/';
            $config['upload_path'] = $uploadPath;
            $config['allowed_types'] = '*';
            $config['max_size'] = 50000;
            $config['encrypt_name'] = TRUE;
            $this->load->library('upload', $config);
            $this->upload->initialize($config);
            if (!$this->upload->do_upload('document')) 
            {
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
        
        
        $dataArr = array(
          'teacherid' => $teacherid,
          'schoolId' => $schoolID, 
          'term' => $term, 
          'fromdate' => $fromdate, 
          'todate' => $todate, 
          'topic' => $topic, 
          'classlist'=> $lessonclass,
          'subject' => $lessonsubject, 
          'objectives' => $objectives,
          'material' => $material, 
          'concept' => $introduction, 
          'attachment' => $pic, 
          'activity_type' => $activitytype,
          'created_date' => date('Y-m-d H:i:s'),
          'status' => '0',  
        );  
        
        if($lessonclass!=''){
        $dataArr['sharewithclass'] = '1';    
        //$dataArr['classlist'] = $lessonclass;
        }
        else {
        $dataArr['sharewithclass'] = '0';     
        }
        
        if($teacher_share == '1' || $teacher_share=='2'){
        $dataArr['sharewithteacher'] = '1';    
        $dataArr['edit_right'] = $teacher_share;
        $dataArr['teacherlist'] = $teacherlist;
        }
        else {
        $dataArr['sharewithteacher'] = '0';     
        }
         
        $result = $this->lesson->addnote($dataArr);

        if ($result) {
            $return['success'] = "true";
            $return['message'] = "Note Added Successfully";
            $return['data'] = $result;
            $return['error'] = $this->error;
            $this->response($return, REST_Controller::HTTP_OK);
        } else {
            $return['success'] = "false";
            $return['message'] = "Error occured while adding";
            $return['error'] = $this->error;
            $return['data'] = '';
            $this->response($return, REST_Controller::HTTP_BAD_REQUEST);
        } 
        
    }
   

    public function lessonnotelist_post() 
    {
    
       $postData = json_decode(file_get_contents('php://input'), true);
        if ($postData == '') {
            $postData = $_POST;
        }
        $data = $this->session->userdata('teacher_data');
        $teacherid = $data['id'];
        $schoolID = $postData['schoolID'];
        //$subclass = $postData['subclass'];
        $result = $this->lesson->lessonnotelist($schoolID,$teacherid);

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
    
    
    public function getnotesdata_post() 
    {
    
       $postData = json_decode(file_get_contents('php://input'), true);
        if ($postData == '') {
            $postData = $_POST;
        }
       
        $schoolID = $postData['schoolID'];
        $noteid = $postData['noteid'];
        $result = $this->lesson->getnotesdata($schoolID,$noteid);

        if ($result) {
            $return['success'] = "true";
            $return['message'] = "Note Data Found";
            $return['data'] = $result;
            $return['error'] = $this->error;

            $this->response($return, REST_Controller::HTTP_OK);
        } else {
            $return['success'] = "false";
            $return['message'] = "No Data Found.";
            $return['error'] = $this->error;
            $return['data'] = '';
            $this->response($return, REST_Controller::HTTP_BAD_REQUEST);
        } 
        
    }
    
    public function updatenote_post() 
    {
      $postData = json_decode(file_get_contents('php://input'), true);
        if ($postData == '') {
            $postData = $_POST;
        }
        
        $data = $this->session->userdata('teacher_data');
        $teacherid = $data['id'];
        $noteid = $postData['noteid'];
        $schoolID = $postData['schoolID'];
        $term = $postData['term'];
        $activitytype = $postData['activitytype'];
        $fromdate = $postData['fromdate'];
        $todate = $postData['todate'];
        $lessonsubject = $postData['lessonsubject'];
        $topic = $postData['topic'];
        $class_share = isset($postData['class_share']) && $postData['class_share'] =="1" ? 1 : 0;
        $teacher_share = $postData['teacher_share'];
        $lessonclass = $postData['lessonclass'];
        $teacherlist = $postData['teacherlist'];
        $objectives = $postData['objectives'];
        $material = $postData['material'];
        $introduction = $postData['introduction'];
        $pic = '';
        if (!empty($_FILES['document']['name'])) 
        {
            $uploadPath = 'img/teacher/';
            $config['upload_path'] = $uploadPath;
            $config['allowed_types'] = '*';
            $config['max_size'] = 50000;
            $config['encrypt_name'] = TRUE;
            $this->load->library('upload', $config);
            $this->upload->initialize($config);
            if (!$this->upload->do_upload('document')) 
            {
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
        
        
        $dataArr = array(
          'teacherid' => $teacherid,
          'term' => $term, 
          'fromdate' => $fromdate, 
          'todate' => $todate, 
          'topic' => $topic, 
          'subject' => $lessonsubject, 
          'objectives' => $objectives,
          'material' => $material, 
          'concept' => $introduction, 
          'activity_type' => $activitytype,
          'created_date' => date('Y-m-d H:i:s'),
        );  
        
        if($lessonclass!=''){
        $dataArr['sharewithclass'] = '1';    
        $dataArr['classlist'] = $lessonclass;
        }
        else {
        $dataArr['sharewithclass'] = '0';     
        }
        
        if($teacher_share == '1' || $teacher_share=='2'){
        $dataArr['sharewithteacher'] = '1';    
        $dataArr['edit_right'] = $teacher_share;
        $dataArr['teacherlist'] = $teacherlist;
        }
        else {
        $dataArr['sharewithteacher'] = '0';     
        }
        
        if($pic!=""){
        $dataArr['attachment'] = $pic;      
        }
        
        $result = $this->lesson->updatenote($dataArr,$noteid);

        if ($result) {
            $return['success'] = "true";
            $return['message'] = "Note Updated Successfully";
            $return['data'] = $result;
            $return['error'] = $this->error;
            $this->response($return, REST_Controller::HTTP_OK);
        } else {
            $return['success'] = "false";
            $return['message'] = "Error occured while Updating";
            $return['error'] = $this->error;
            $return['data'] = '';
            $this->response($return, REST_Controller::HTTP_BAD_REQUEST);
        }   
    }
    
    
    public function sharedlessonlist_post() 
    {
    
       $postData = json_decode(file_get_contents('php://input'), true);
        if ($postData == '') {
            $postData = $_POST;
        }
        $data = $this->session->userdata('teacher_data');
        $teacherid = $data['id'];
        $schoolID = $postData['schoolID'];
        //$subclass = $postData['subclass'];
        $result = $this->lesson->sharedlessonlist($schoolID,$teacherid);

        if ($result) {
            $return['success'] = "true";
            $return['message'] = "Shared Lesson Note List Found";
            $return['data'] = $result;
            $return['error'] = $this->error;

            $this->response($return, REST_Controller::HTTP_OK);
        } else {
            $return['success'] = "false";
            $return['message'] = "No Shared Lesson Note Found.";
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
        
        $data = $this->session->userdata('teacher_data');
        $user_id = $data['id'];

        $schoolID = $postData['schoolID'];
        $noteid = $postData['noteid'];
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
    
    
    
    public function updatesharednote_post() 
    {
      $postData = json_decode(file_get_contents('php://input'), true);
        if ($postData == '') {
            $postData = $_POST;
        }
        
        $data = $this->session->userdata('teacher_data');
        $teacherid = $data['id'];
        $noteid = $postData['noteid'];
        $schoolID = $postData['schoolID'];
        $term = $postData['term'];
        $activitytype = $postData['activitytype'];
        $fromdate = $postData['fromdate'];
        $todate = $postData['todate'];
        $lessonsubject = $postData['lessonsubject'];
        $topic = $postData['topic'];
        $class_share = isset($postData['class_share']) && $postData['class_share'] =="1" ? 1 : 0;
        $teacher_share = $postData['teacher_share'];
        $lessonclass = $postData['lessonclass'];
        $teacherlist = $postData['teacherlist'];
        $objectives = $postData['objectives'];
        $material = $postData['material'];
        $introduction = $postData['introduction'];
        $pic = '';
        if (!empty($_FILES['document']['name'])) 
        {
            $uploadPath = 'img/teacher/';
            $config['upload_path'] = $uploadPath;
            $config['allowed_types'] = '*';
            $config['max_size'] = 50000;
            $config['encrypt_name'] = TRUE;
            $this->load->library('upload', $config);
            $this->upload->initialize($config);
            if (!$this->upload->do_upload('document')) 
            {
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
        
        
        $dataArr = array(
          'teacherid' => $teacherid,
          'term' => $term, 
          'fromdate' => $fromdate, 
          'todate' => $todate, 
          'topic' => $topic, 
          'subject' => $lessonsubject, 
          'objectives' => $objectives,
          'material' => $material, 
          'concept' => $introduction, 
          'activity_type' => $activitytype,
          'created_date' => date('Y-m-d H:i:s'),
        );  
        
//        if($class_share ==1){
//        $dataArr['sharewithclass'] = '1';    
//        $dataArr['classlist'] = $lessonclass;
//        }
//        else {
//        $dataArr['sharewithclass'] = '0';     
//        }
//        
//        if($teacher_share == '1' || $teacher_share=='2'){
//        $dataArr['sharewithteacher'] = '1';    
//        $dataArr['edit_right'] = $teacher_share;
//        $dataArr['teacherlist'] = $teacherlist;
//        }
//        else {
//        $dataArr['sharewithteacher'] = '0';     
//        }

        if($pic!=""){
        $dataArr['attachment'] = $pic;      
        }
         
        
        $result = $this->lesson->updatenote($dataArr,$noteid);

        if ($result) {
            $return['success'] = "true";
            $return['message'] = "Note Updated Successfully";
            $return['data'] = $result;
            $return['error'] = $this->error;
            $this->response($return, REST_Controller::HTTP_OK);
        } else {
            $return['success'] = "false";
            $return['message'] = "Error occured while Updating";
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
		$data = $this->session->userdata('teacher_data');
		$id = $data['id'];
		$cdata['user_id'] = "T-".$id;
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
        $data = $this->session->userdata('teacher_data');
        $teacherid = "T-".$data['id'];
        $where=array(
        'id'=>$id,
        'user_id'=>$teacherid
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