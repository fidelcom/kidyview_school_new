<?php
defined('BASEPATH') OR exit('No direct script access allowed');
require APPPATH . '/libraries/REST_Controller.php';
require APPPATH . '/libraries/crypto/autoload.php';
use Blocktrail\CryptoJSAES\CryptoJSAES;
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
        $data = $this->session->userdata('student_data');
		$sid = $data['id'];
        $schoolID=$postData['schoolID'];
        $classID=$postData['classID'];
        $subjectID=$postData['subject_id'];
        $status=$postData['status'];
        $session=$postData['session'];
        $result = $this->model->getExamList($schoolID,$classID,$sid,$subjectID,$status,$session);
        $return['success'] = "true";
        $return['title'] = "success";
        $return['message'] = "Exam List.";
        $return['data'] = $result;
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
    public function startExam_post(){
        $postData = json_decode(file_get_contents('php://input'), true);
		if ($postData == '') {
			$postData = $_POST;
        }
       //echo $grade;die;
        $data = $this->session->userdata('student_data');
		$sid = $data['id'];
        $schoolID=$postData['schoolID'];
        $classID=$postData['classID'];
        $examID=$postData['examID'];
        $tbl_name='exam_answer';
        $tbl_name2='exam_user_question_answer';
        $examUserData = $this->model->getExamDetails($examID,$schoolID,$classID,$sid);
        if(!empty($examUserData)){
            $j=0;
                $examArray[$j]['school_id']=$examUserData->school_id;
                $examArray[$j]['class_id']=$examUserData->class_id;
                $examArray[$j]['subject_id']=$examUserData->subject_id;
                $examArray[$j]['exam_id']=$examUserData->id;
                $examArray[$j]['user_id']=$sid;
                $examArray[$j]['no_of_attempt']=1;
                $examArray[$j]['start_time'] = date('Y-m-d H:i:s');
                $examArray[$j]['end_time'] = date('Y-m-d H:i:s',strtotime('+'.$examUserData->exam_duration.'minutes',strtotime($examArray[$j]['start_time'])));
                if($examUserData->answerid!=''){
                $userExamArray[$j]['id']=$examUserData->answerid;
                $userExamArray[$j]['no_of_attempt'] =$examUserData->no_of_attempt+1;;
                if(!empty($userExamArray)){
                $this->model->update($userExamArray,$tbl_name);
                }
                $return['success'] = "true";
                $return['title'] = "success";
                $return['message'] = "Exam Submit successfully.";
                $return['data'] = $this->model->getExamDetails($examID,$schoolID,$classID,$sid);
                $return['error'] = $this->error;
                $this->response($return, REST_Controller::HTTP_OK);
                }
                $add=$this->model->add($examArray,$tbl_name);
                if($add){
                $pass = "KidyView";
                $text = $add;
                $encryptedUrl=$this->encryptData($text,$pass);
                $this->load->model('students/Student_model');
                $studentData = $this->Student_model->getStudentDetails($sid);
                $sudentname='';
                if($studentData){
                $sudentname=$studentData->childfname.' '.$studentData->childlname;
                }
                $getAssignedTeacher=$this->Student_model->getAssignedTeacher($examUserData->subject_id);
                if($getAssignedTeacher){
                $notificationData[0]['receiver_id'] = "T-".$getAssignedTeacher->id;
                $notificationData[0]['sender_id'] = "ST-".$sid;
                $notificationData[0]['to_do_id'] = $examUserData->id;
                $notificationData[0]['school_id'] = $schoolID;
                if($examUserData->exam_mode=='exam'){
                    $notificationData[0]['message'] = $sudentname." submitted an exam.";
                }elseif($examUserData->exam_mode=='test'){
                    $notificationData[0]['message'] = $sudentname." submitted an test.";
                }
                $notificationData[0]['type'] = "exam";
                $notificationData[0]['url'] = "submitted-exam-details/".$encryptedUrl;
                $isTeacherNotify=notificationSettingHelper($schoolID,$notificationData[0]['receiver_id'],'Exam');
                if(!empty($isTeacherNotify) && $isTeacherNotify->is_push==1){
                $this->Teacher_model->add($notificationData,'notifications');	
                }	
                }
                $userExamArray=array();
                $i=0;
                foreach($examUserData->getUserExamAnswerData as $userexamData){
                        $userExamArray[$i]['school_id']=$examUserData->school_id;
                        $userExamArray[$i]['class_id']=$examUserData->class_id;
                        $userExamArray[$i]['exam_id']=$userexamData->exam_id;
                        $userExamArray[$i]['answer_id']=$add;
                        $userExamArray[$i]['question_id']=$userexamData->id;
                        $userExamArray[$i]['answer_value']=json_encode($userexamData->option_value);
                        $i++; }
               if(!empty($userExamArray)){
               $addAnswer=$this->model->add($userExamArray,$tbl_name2);
                    if($examUserData->exam_type=='multiple'){
                    $marksArray[$j]['school_id']=$examUserData->school_id;
                    $marksArray[$j]['class_id']=$examUserData->class_id;
                    $marksArray[$j]['subject_id']=$examUserData->subject_id;
                    $marksArray[$j]['exam_id']=$examUserData->id;
                    $marksArray[$j]['answer_id']=$add;
                    $marksArray[$j]['user_id']=$sid;
                    $marksArray[$j]['total_marks']=$examUserData->total_marks;
                    $marksArray[$j]['marks_obtained']=0;
                    $marksArray[$j]['percentage']=0;
                    $marksArray[$j]['grade']=check_grades($examUserData->school_id,0);;
                    $marksArray[$j]['created_at']=date('Y-m-d H:i:s'); 
                    $this->model->add($marksArray,'exam_marks_obtain');
                    }
            }
               if(isset($addAnswer)){
                $return['success'] = "true";
                $return['title'] = "success";
                $return['message'] = "Exam Submit successfully.";
                $return['data'] = $this->model->getExamDetails($examID,$schoolID,$classID,$sid);
                $return['error'] = $this->error;
                $this->response($return, REST_Controller::HTTP_OK);
               }else{
                $return['success'] = "false";
                $return['message'] = "Something went wrong.Please try again.";
                $return['error'] = $this->error;
                $return['data'] = $this->model->getExamDetails($examID,$schoolID,$classID,$sid);
                $this->response($return, REST_Controller::HTTP_BAD_REQUEST);
               }
            }else{
                $return['success'] = "false";
                $return['message'] = "Something went wrong.Please try again.";
                $return['error'] = $this->error;
                $return['data'] = $this->model->getExamDetails($examID,$schoolID,$classID,$sid);
                $this->response($return, REST_Controller::HTTP_BAD_REQUEST);
            }
        }
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
                $time=$postData['hours'].':'.$postData['minutes'].':'.$postData['seconds'];
                $remaingTime=$this->minutes($time);
                $examArray[$j]['school_id']=$examData['school_id'];
                $examArray[$j]['class_id']=$examData['class_id'];
                $examArray[$j]['subject_id']=$examData['subject_id'];
                $examArray[$j]['exam_id']=$examData['id'];
                $examArray[$j]['user_id']=$sid;
                $examArray[$j]['no_of_attempt']=1;
                $examArray[$j]['created_at'] = date('Y-m-d H:i:s');
                $examArray[$j]['answer_duration']=$examData['exam_duration']-$remaingTime;
                $add=$this->model->add($examArray,$tbl_name);
                if($add){
                $userExamArray=array();
                $i=0;
                foreach($examData['examQuestionData'] as $userexamData){
                        $userExamArray[$i]['school_id']=$examData['school_id'];
                        $userExamArray[$i]['class_id']=$examData['class_id'];
                        $userExamArray[$i]['exam_id']=$userexamData['exam_id'];
                        $userExamArray[$i]['answer_id']=$add;
                        $userExamArray[$i]['question_id']=$userexamData['id'];
                        $userExamArray[$i]['answer_value']=json_encode($userexamData['option_value']);
               $i++; }
               if(!empty($userExamArray)){
               $addAnswer=$this->model->add($userExamArray,$tbl_name2);
               }
               if($add){
                
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
    public function updateExam_post(){
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
                
                $examArray[$j]['id']=$examData['answerid'];
                $to_time = strtotime(date('Y-m-d H:i'));
                $examArray[$j]['answer_duration']='';
                $updateExam=$this->model->update($examArray,$tbl_name);
                if($updateExam){
                $userExamArray=array();
                $i=0;
                $total_obtain_marks=0;
                $totalpersentage=0;
                foreach($examData['getUserExamAnswerData'] as $userexamData){
                    
                    $userExamArray[$i]['id']=$userexamData['user_answer_id'];
                    $userExamArray[$i]['answer_value']=json_encode($userexamData['option_value']);
                    $getOptionAnswer=array();
                    if($examData['exam_type']=='multiple'){
                        $answernVal=array();
                        if($userexamData['answer']!=''){
                        $answernVal=explode(',',$userexamData['answer']);
                        $answernVal=array_map('strtolower', $answernVal);
                        }
                        if(!empty($userexamData['option_value'])){
                            foreach($userexamData['option_value'] as $option){
                                    if($option['isUserAnswer']=='true'){
                                        array_push($getOptionAnswer,$option['option']);
                                    }
                            }
                        $getOptionAnswer=array_map('strtolower', $getOptionAnswer);
                        $answerDiff=array_diff($answernVal,$getOptionAnswer);
                        if(count($answerDiff)==0){
                            $total_obtain_marks=$total_obtain_marks+$userexamData['question_marks'];
                        }
                    }
                    }
                    
                $i++; }
                if($total_obtain_marks>0){
                    $totalpersentage=($total_obtain_marks*100)/$examData['total_marks'];
                    $totalpersentage=round($totalpersentage);
                }
                $grade=check_grades($examData['school_id'],$totalpersentage);
               if(!empty($userExamArray)){
               $updateAnswer=$this->model->update($userExamArray,$tbl_name2);
               if($examData['exam_type']=='multiple'){
               $school_id=$examData['school_id'];
               $exam_id=$examData['id'];
               $user_id=$sid;
               $where=array('school_id'=>$school_id,'exam_id'=>$exam_id,'user_id'=>$user_id);
               $marksArray['total_marks']=$examData['total_marks'];
               $marksArray['marks_obtained']=$total_obtain_marks;
               $marksArray['percentage']=$totalpersentage;
               if($examData['exam_category']=='graded'){
               $marksArray['grade']=$grade;
               }
               $marksArray['updated_at']=date('Y-m-d H:i:s'); 
               $this->db->update('exam_marks_obtain',$marksArray,$where); 
               }
            }
               if($updateAnswer){
                $return['success'] = "true";
                $return['title'] = "success";
                $return['message'] = "Exam Submit successfully.";
                $return['data'] = $updateAnswer;
                $return['error'] = $this->error;
                $this->response($return, REST_Controller::HTTP_OK);
               }else{
                $return['success'] = "false";
                $return['message'] = "Something went wrong.Please try again.";
                $return['error'] = $this->error;
                $return['data'] = '';
                $this->response($return, REST_Controller::HTTP_BAD_REQUEST);
               }
            }else{
                $return['success'] = "false";
                $return['message'] = "Something went wrong.Please try again.";
                $return['error'] = $this->error;
                $return['data'] = '';
                $this->response($return, REST_Controller::HTTP_BAD_REQUEST);
            }
            $j++;}
        }

    }
    public function checkExamStatus_post(){
        $postData = json_decode(file_get_contents('php://input'), true);
		if ($postData == '') {
			$postData = $_POST;
        }
        $data = $this->session->userdata('student_data');
		$sid = $data['id'];
        $schoolID=$postData['schoolID'];
        $classID=$postData['classID'];
        $examID=$postData['examID'];
        $checkData = $this->model->checkExamStatus($examID,$schoolID,$classID,$sid);
        $return['success'] = "true";
        $return['title'] = "success";
        $return['message'] = "Exam status.";
        $return['data'] = $checkData;
        $return['error'] = $this->error;
        $this->response($return, REST_Controller::HTTP_OK);
    }
    public function minutes($time){
        $time = explode(':', $time);
        return ($time[0]*60) + ($time[1]) + ($time[2]/60);
    }
    function encryptData($text,$pass){
        $encryptedUrl = CryptoJSAES::encrypt($text, $pass);
        if(strpos($encryptedUrl, '/') !== false){
            $encryptedUrl = $this->encryptData($text,$pass);
        }
        return $encryptedUrl;
    }
    
}
