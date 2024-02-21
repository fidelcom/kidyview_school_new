<?php
defined('BASEPATH') OR exit('No direct script access allowed');
require APPPATH . '/libraries/REST_Controller.php';
class Exam extends REST_Controller {

    public $error = array();
    public $data = array();

    function __construct() {
        parent::__construct();
        $this->load->library("security");
        $this->load->library('form_validation');
        $this->load->model('students/Exam_model','model');
        $this->load->helper('common_helper');
    }
    
    public function getExamList_post(){
        $postData = json_decode(file_get_contents('php://input'), true);
		if ($postData == '') {
			$postData = $_POST;
        }
        $schoolID=$postData['schoolID'];
        $classID=$postData['classID'];
        $data = $this->model->getExamList($schoolID,$classID);
        $return['success'] = "true";
        $return['title'] = "success";
        $return['message'] = "Exam List.";
        $return['data'] = $data;
        $return['error'] = $this->error;
        $this->response($return, REST_Controller::HTTP_OK);
    }
    public function getExamDetails_post(){
        $postData = json_decode(file_get_contents('php://input'), true);
		if ($postData == '') {
			$postData = $_POST;
        }
        $data = $this->session->userdata('student_data');
		$sid = $data['id'];
        $schoolID=$postData['schoolID'];
        $classID=$postData['classID'];
        $examID=$postData['examID'];
        $data = $this->model->getExamDetails($examID,$schoolID,$classID,$sid);
        $return['success'] = "true";
        $return['title'] = "success";
        $return['message'] = "Exam Details.";
        $return['data'] = $data;
        $return['error'] = $this->error;
        $this->response($return, REST_Controller::HTTP_OK);
    }
    public function submitExam_post(){
        $postData = json_decode(file_get_contents('php://input'), true);
		if ($postData == '') {
			$postData = $_POST;
        }
        $data = $this->session->userdata('student_data');
		$sid = $data['id'];
        $tbl_name='exam_answer';
        $tbl_name2='exam_user_question_answer';
        if(!empty($postData)){
            $j=0;
            foreach($postData as $examData){
                //print_r();
                $examArray[$j]['school_id']=$examData['school_id'];
                $examArray[$j]['class_id']=$examData['class_id'];
                $examArray[$j]['exam_id']=$examData['id'];
                $examArray[$j]['user_id']=$sid;
                $examArray[$j]['no_of_attempt']=1;
                $examArray[$j]['created_at'] = date('Y-m-d H:i:s');
                $to_time = strtotime(date('Y-m-d H:i'));
                $examtime=$examData['exam_date'].' '.$examData['exam_time'];
			    $from_time = strtotime($examtime);
			    $examArray[$j]['answer_duration']=round(($from_time - $to_time) / 60,2);
                $add=$this->model->add($examArray,$tbl_name);
                if($add){
                $userExamArray=array();
                $i=0;
                foreach($examData['examQuestionData'] as $userexamData){
                        $userExamArray[$i]['school_id']=$examData['school_id'];
                        $userExamArray[$i]['class_id']=$examData['class_id'];
                        $userExamArray[$i]['exam_id']=$userexamData['exam_id'];
                        $userExamArray[$i]['answer_id']=$add;
                        $userExamArray[$i]['question_id']=$userexamData['exam_id'];
                        $userExamArray[$i]['answer_value']=json_encode($userexamData['option_value']);
               $i++; }
               if(!empty($userExamArray)){
               $addAnswer=$this->model->add($userExamArray,$tbl_name2);
               }
               if($addAnswer){
                $return['success'] = "true";
                $return['title'] = "success";
                $return['message'] = "Exam Submit successfully.";
                $return['data'] = $data;
                $return['error'] = $this->error;
                $this->response($return, REST_Controller::HTTP_OK);
               }else{
                $return['success'] = "false";
                $return['message'] = "Something went wrong.Please try again.";
                $return['error'] = $this->error;
                $return['data'] = $result;
                $this->response($return, REST_Controller::HTTP_BAD_REQUEST);
               }
            }else{
                $return['success'] = "false";
                $return['message'] = "Something went wrong.Please try again.";
                $return['error'] = $this->error;
                $return['data'] = $result;
                $this->response($return, REST_Controller::HTTP_BAD_REQUEST);
            }
            $j++;}
        }

    }
    
}
