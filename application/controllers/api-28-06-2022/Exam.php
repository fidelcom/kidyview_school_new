<?php
defined('BASEPATH') OR exit('No direct script access allowed');
require APPPATH . '/libraries/REST_Controller.php';
require APPPATH . '/libraries/crypto/autoload.php';
use Blocktrail\CryptoJSAES\CryptoJSAES;
class Exam extends REST_Controller {

    public $error = array();
    public $data = array();

    public function __construct() {
        parent::__construct();
        if($this->session->userdata('user_role')=='school' OR $this->session->userdata('user_role')=='schoolsubadmin'){
            $this->token->validate();
        }
        $this->load->model("admin/exam_model");
        $this->load->model('User_model');
    }
    
    public function index_post()
    {
        date_default_timezone_set('Asia/Kolkata');
        $postData = json_decode(file_get_contents('php://input'), true);
        if ($postData == '') {
                $postData = $_POST;
        }
        $userdata     = $this->session->userdata();
        $user_role    = $userdata['user_role'];
        $user_id      = $userdata['user_data']['id'];
        $user_name      = $userdata['user_data']['fname'];
        // Term Data
        $termData = examDateCheckedTerm($postData['school_id'],$postData['exam_date']);
        $term_id = $termData->term_id;
        $postData = array(
            'session_id'  		   => get_current_session($postData['school_id'])->id,
            'name'                 => $postData['name'], 
            'user_id'              => 'S-'.$user_id, 
            'user_type'            => 'school', 
            'assessment_mode'      => 'online', 
            'school_id'            => $postData['school_id'], 
            'class_id'             => $postData['class_id'], 
            'subject_id'           => $postData['subject_id'], 
            'exam_duration'        => $postData['exam_duration'], 
            'exam_date'            => $postData['exam_date'], 
            'exam_time'            => date('H:i',strtotime($postData['exam_time'])), 
            'exam_date_time'       => $postData['exam_date']." ".date('H:i',strtotime($postData['exam_time'])), 
            'exam_instruction'     => $postData['instruction'], 
            'total_question'       => $postData['total_question'], 
            'total_marks'          => $postData['total_marks'], 
            'term_id'              => $term_id ? $term_id : null, 
            'session'              => $postData['session'], 
            'exam_mode'            => $postData['exam_mode'], 
            'exam_category'        => $postData['exam_category'], 
            'exam_attempt_no'      => $postData['exam_attempt_no'], 
            'last_submission_date' => $postData['last_submission_date'], 
            'exam_type'            => $postData['exam_type'], 
            'created_at'           => date('Y-m-d H:i:s') 
        );
            $isExamExist = $this->exam_model->isExamExist($postData);

            if($isExamExist){
                        $return['success'] = "false";
                        $return['message'] = "This exam is already created for same class and subject.";
                        $return['error'] = $this->error;
                        $return['data'] = "exist";
                        
                        $this->response($return, REST_Controller::HTTP_OK);
           }else{

                $result = $this->exam_model->addexam($postData);
                if($result){
                     $pass = "KidyView";
                    $text = $result;
                    $encryptedUrl=$this->encryptData($text,$pass);
                    if($this->session->userdata('user_role')=='school'){
                        $sender_id='SA-'.$user_id;
                    }elseif($this->session->userdata('user_role')=='schoolsubadmin'){
                        $sender_id='SSA-'.$user_id;
                    }
                    $this->load->model('teachers/Teacher_model');
                    $getClassStudentData=$this->Teacher_model->getStudentByClassId($postData['class_id']);
                    if (!empty($getClassStudentData)) {
                        foreach ($getClassStudentData as $studentData)
                        {
                            $notificationData['receiver_id'] = "ST-".$studentData['id'];
                            $notificationData['sender_id'] = $sender_id;
                            $notificationData['to_do_id'] = $result;
                            $notificationData['message'] = $user_name." create an exam for you.";
                            $notificationData['type'] = "exam";
                            $notificationData['url'] = "exam-details/".$encryptedUrl;
                            $this->Teacher_model->add($notificationData,'notifications');
                        }
                    }
                    $return['success'] = "true";
                    $return['message'] = "New assessment added successfully.";
                    $return['data'] = $result;
                    $return['error'] = $this->error;
                    
                    $this->response($return, REST_Controller::HTTP_OK);
                }else{
                    $return['success'] = "false";
                    $return['message'] = "Not found.";
                    $return['error'] = $this->error;
                    $return['data'] = "";
                    
                    $this->response($return, REST_Controller::HTTP_BAD_REQUEST);
                }    
        } 
    }
    public function addOfflineExam_post()
    {
        date_default_timezone_set('Asia/Kolkata');
        $postData = json_decode(file_get_contents('php://input'), true);
        if ($postData == '') {
                $postData = $_POST;
        }
        $userdata     = $this->session->userdata();
        $user_role    = $userdata['user_role'];
        $user_id      = $userdata['user_data']['id'];
        $user_name      = $userdata['user_data']['fname'];
        // Term Data
        $termData = examDateCheckedTerm($postData['school_id'],$postData['exam_date']);
        $term_id = $termData->term_id;

        $postData = array(
            'session_id'  		   => get_current_session($postData['school_id'])->id,
            'name'                 => $postData['name'], 
            'user_id'              => 'S-'.$user_id, 
            'user_type'            => 'school', 
            'assessment_mode'      => 'offline',
            'school_id'            => $postData['school_id'], 
            'class_id'             => $postData['class_id'], 
            'subject_id'           => $postData['subject_id'], 
            'exam_duration'        => $postData['exam_duration'], 
            'exam_date'            => $postData['exam_date'], 
            'exam_time'            => date('H:i',strtotime($postData['exam_time'])), 
            'exam_date_time'       => $postData['exam_date']." ".date('H:i',strtotime($postData['exam_time'])), 

            // Add  30 Days validity from exam submission date
            'marks_validity_extends'=> date('Y-m-d', strtotime($postData['last_submission_date']. ' +30 days'))." ".date('H:i',strtotime($postData['exam_time'])), 
            'marks_validity_days'     =>30, 
            
            'exam_instruction'     => $postData['instruction'], 
            'total_question'       => 0, 
            'total_marks'          => $postData['total_marks'], 
            'session'              => $postData['session'], 
            'term_id'              => $term_id ? $term_id : null, 
            'exam_mode'            => $postData['exam_mode'], 
            'exam_category'        => $postData['exam_category'], 
            'exam_attempt_no'      => 0, 
            'last_submission_date' => $postData['last_submission_date'], 
            'exam_type'            => 'non-multiple', 
            'created_at'           => date('Y-m-d H:i:s') 
        );
       // prd($postData);

        $isExamExist = $this->exam_model->isExamExist($postData);
        if($isExamExist){
                    $return['success'] = "false";
                    $return['message'] = "This assessment is already created for same class and subject.";
                    $return['error'] = $this->error;
                    $return['data'] = "exist";
                    
                    $this->response($return, REST_Controller::HTTP_OK);
       }else{
                 $result = $this->exam_model->addexam($postData);
                 if($result){
                     $pass = "KidyView";
                    $text = $result;
                    $encryptedUrl=$this->encryptData($text,$pass);
                    if($this->session->userdata('user_role')=='school'){
                        $sender_id='SA-'.$user_id;
                    }elseif($this->session->userdata('user_role')=='schoolsubadmin'){
                        $sender_id='SSA-'.$user_id;
                    }
                    $this->load->model('teachers/Teacher_model');
                    $getClassStudentData=$this->Teacher_model->getStudentByClassId($postData['class_id']);

                    if (!empty($getClassStudentData)) {
                        foreach ($getClassStudentData as $studentData)
                        {
                            $notificationData['receiver_id'] = "ST-".$studentData['id'];
                            $notificationData['sender_id'] = $sender_id;
                            $notificationData['to_do_id'] = $result;
                            $notificationData['message'] = $user_name." create an exam for you.";
                            $notificationData['type'] = "exam";
                            $notificationData['url'] = "exam-details/".$encryptedUrl;
                            $this->Teacher_model->add($notificationData,'notifications');
                        }
                    }
                    $return['success'] = "true";
                    $return['message'] = "Offline assessment has been added successfully.";
                    $return['data'] = $result;
                    $return['error'] = $this->error;
                    
                    $this->response($return, REST_Controller::HTTP_OK);
                }else{
                    $return['success'] = "false";
                    $return['message'] = "Not found.";
                    $return['error'] = $this->error;
                    $return['data'] = $result;
                    
                    $this->response($return, REST_Controller::HTTP_BAD_REQUEST);
                }
        } 
    }
    public function classwiseStudentsData_post()
    {
         $postData = json_decode(file_get_contents('php://input'), true);
         if ($postData == '') {
            $postData = $_POST;
         }
         // prd($postData);
          $result        = $this->exam_model->offlineExamDetails($postData['id']);        
          
          $classStudents = $this->exam_model->getClassStudents($result->class_id,$result->subject_id,$result->studentID);        
         //  $studentsMarksObtain = $this->exam_model->getStudentsMarksObtain($result->class_id,$result->subject_id,$result->studentID);        
         // prd($classStudents);
          // $result = $this->exam_model->examList($postData);        
         // prd($classStudents);
       $totalData = array(
            'examDetails' => !empty($result) ? $result : false,
            'classStudents' => $classStudents ? $classStudents :array() 
       );
         // prd($totalData);
         if ($result) {
            $return['success'] = "true";
            $return['message'] = "Exam Details class and subject wise.";
            $return['data'] = $totalData;
            $return['error'] = $this->error;
            
            $this->response($return, REST_Controller::HTTP_OK);
            } else {
            $return['success'] = "false";
            $return['message'] = "No record found.";
            $return['error'] = $this->error;
            $return['data'] = '';
            
            $this->response($return, REST_Controller::HTTP_BAD_REQUEST);
        }
    }

    public function examList_post() { 
     $postData = json_decode(file_get_contents('php://input'), true);
     if ($postData == '') {
        $postData = $_POST;
     }
      $school_id = $postData['school_id'];      	
     
      $result = $this->exam_model->examList($school_id);        
         // prd($result);
       if ($result) {
            $return['success'] = "true";
            $return['message'] = "Exam Schedule List.";
            $return['data'] = $result;
            $return['error'] = $this->error;
            
            $this->response($return, REST_Controller::HTTP_OK);
            } else {
            $return['success'] = "false";
            $return['message'] = "No record found.";
            $return['error'] = $this->error;
            $return['data'] = '';
            
            $this->response($return, REST_Controller::HTTP_BAD_REQUEST);
        }
    }
    public function offlineAssessmentList_post() { 
     $postData = json_decode(file_get_contents('php://input'), true);
     if ($postData == '') {
        $postData = $_POST;
     }
      $school_id = $postData['school_id'];          
     
      $result = $this->exam_model->offlineAssessmentList($school_id);        
         // prd($result);
       if ($result) {
            $return['success'] = "true";
            $return['message'] = "Offline assessment List Data.";
            $return['data'] = $result;
            $return['error'] = $this->error;
            
            $this->response($return, REST_Controller::HTTP_OK);
            } else {
            $return['success'] = "false";
            $return['message'] = "No record found.";
            $return['error'] = $this->error;
            $return['data'] = '';
            
            $this->response($return, REST_Controller::HTTP_BAD_REQUEST);
        }
    }
    public function offlineExamMarkObtain_post() { 
     $postData = json_decode(file_get_contents('php://input'), true);
     if ($postData == '') {
        $postData = $_POST;
     }
     
      $result = $this->exam_model->offlineExamMarkObtain($postData);        
         // prd($result);
       if ($result) {
            $return['success'] = "true";
            $return['message'] = "Marks obtained successfully.";
            $return['data'] = $result;
            $return['error'] = $this->error;
            
            $this->response($return, REST_Controller::HTTP_OK);
            } else {
            $return['success'] = "false";
            $return['message'] = "Same marks assigned.";
            $return['error'] = $this->error;
            $return['data'] = '';
            
            $this->response($return, REST_Controller::HTTP_BAD_REQUEST);
        }
    }
    public function getAllSubjectForClass_post() { 
     $postData = json_decode(file_get_contents('php://input'), true);
     if ($postData == '') {
        $postData = $_POST;
     }
     
      $result = $this->exam_model->getAllSubjectForClass($postData);        
         // prd($result);
       if ($result) {
            $return['success'] = "true";
            $return['message'] = "Subject List.";
            $return['data'] = $result;
            $return['error'] = $this->error;
            
            $this->response($return, REST_Controller::HTTP_OK);
            } else {
            $return['success'] = "false";
            $return['message'] = "No record found.";
            $return['error'] = $this->error;
            $return['data'] = '';
            
            $this->response($return, REST_Controller::HTTP_BAD_REQUEST);
        }
    }
    public function deleteExam_post()
    {
         $postData = json_decode(file_get_contents('php://input'), true);
         if ($postData == '') {
            $postData = $_POST;
         }
        $id = $postData['id'];       
     
      $result = $this->exam_model->deleteExam($id);        
         // prd($result);
       if ($result) {
            $return['success'] = "true";
            $return['message'] = "Exam Deleted.";
            $return['data'] = $result;
            $return['error'] = $this->error;
            
            $this->response($return, REST_Controller::HTTP_OK);
            } else {
            $return['success'] = "false";
            $return['message'] = "No record found.";
            $return['error'] = $this->error;
            $return['data'] = '';
            
            $this->response($return, REST_Controller::HTTP_BAD_REQUEST);
        }
    }
    public function questionList_post()
    {
        $postData = json_decode(file_get_contents('php://input'), true);
        if ($postData == '') {
                $postData = $_POST;
        }

         $exam_id = $postData['id'];
        $result = $this->exam_model->questionList($exam_id);
        if($result){
            $return['success'] = "true";
            $return['message'] = "Question List Successfully.";
            $return['data'] = $result;
            $return['error'] = $this->error;
            
            $this->response($return, REST_Controller::HTTP_OK);
        }else{
            $return['success'] = "false";
            $return['message'] = "Not found.";
            $return['error'] = $this->error;
            $return['data'] = $result;
            
            $this->response($return, REST_Controller::HTTP_BAD_REQUEST);
        }  

    } 
    public function deleteQuestion_post()
    {
        $postData = json_decode(file_get_contents('php://input'), true);
        if ($postData == '') {
                $postData = $_POST;
        }
         $ques_id = $postData['id'];
        $result = $this->exam_model->deleteQuestion($ques_id);
        if($result){
            $return['success'] = "true";
            $return['message'] = "Delete Question Successfully.";
            $return['data'] = $result;
            $return['error'] = $this->error;
            
            $this->response($return, REST_Controller::HTTP_OK);
        }else{
            $return['success'] = "false";
            $return['message'] = "Not found.";
            $return['error'] = $this->error;
            $return['data'] = $result;
            
            $this->response($return, REST_Controller::HTTP_BAD_REQUEST);
        }  
    }
    public function questionDetails_post()
    {
        $postData = json_decode(file_get_contents('php://input'), true);
        if ($postData == '') {
                $postData = $_POST;
        }
        $ques_id = $postData['id'];
        $result = $this->exam_model->questionDetails($ques_id);
        // prd($result);
        if($result){
            $return['success'] = "true";
            $return['message'] = "Question Details Successfully.";
            $return['data'] = $result;
            $return['error'] = $this->error;
            
            $this->response($return, REST_Controller::HTTP_OK);
        }else{
            $return['success'] = "false";
            $return['message'] = "Not found.";
            $return['error'] = $this->error;
            $return['data'] = $result;
            
            $this->response($return, REST_Controller::HTTP_BAD_REQUEST);
        }     
    }
    public function addQuestion_post()
    {
        $postData = json_decode(file_get_contents('php://input'), true);
        if ($postData == '') {
                $postData = $_POST;
        }
      
     //   $optVal = json_encode($postData['options']);
        $questionData = array(
            'exam_id'           => $postData['exam_id'], 
            'question'          => $postData['question'], 
            // 'answer'            => $postData['answer'], 
            'question_marks'    => $postData['question_marks'], 
            'question_type'     => $postData['question_type'], 
            'option_value'      => null, 
            'created_at'        => date('Y-m-d H:i:s') 
        );
        // prd($questionData);
         $result = $this->exam_model->addQuestion($questionData,$postData['options']);
                 if($result){
                    $return['success'] = "true";
                    $return['message'] = "Question Added Successfully.";
                    $return['data'] = $result;
                    $return['error'] = $this->error;
                    
                    $this->response($return, REST_Controller::HTTP_OK);
                }else{
                    $return['success'] = "false";
                    $return['message'] = "Not found.";
                    $return['error'] = $this->error;
                    $return['data'] = $result;
                    
                    $this->response($return, REST_Controller::HTTP_BAD_REQUEST);
                }   
    } 
    public function addMultipleAnswers_post()
    {
        $postData = json_decode(file_get_contents('php://input'), true);
        if ($postData == '') {
                $postData = $_POST;
        } 
      
        $result = $this->exam_model->addMultipleAnswers($postData);
         if($result){
            $return['success'] = "true";
            $return['message'] = "Multiple answers has been added successfully.";
            $return['data'] = $result;
            $return['error'] = $this->error;
            
            $this->response($return, REST_Controller::HTTP_OK);
        }else{
            $return['success'] = "false";
            $return['message'] = "Not found.";
            $return['error'] = $this->error;
            $return['data'] = $result;
            
            $this->response($return, REST_Controller::HTTP_BAD_REQUEST);
        } 
          
    }
    public function updateQuestion_post()
    {
        $postData = json_decode(file_get_contents('php://input'), true);
        if ($postData == '') {
                $postData = $_POST;
        }
      
         $result = $this->exam_model->updateQuestion($postData);
                 if($result){
                    $return['success'] = "true";
                    $return['message'] = "Question Added Successfully.";
                    $return['data'] = $result;
                    $return['error'] = $this->error;
                    
                    $this->response($return, REST_Controller::HTTP_OK);
                }else{
                    $return['success'] = "false";
                    $return['message'] = "Not found.";
                    $return['error'] = $this->error;
                    $return['data'] = $result;
                    
                    $this->response($return, REST_Controller::HTTP_BAD_REQUEST);
                }   
    }
    public function examDetails_post() { 

            $postData = json_decode(file_get_contents('php://input'), true);
            if ($postData == '') {
                $postData = $_POST;
            }
            $id = $postData['id'];
            $result = $this->exam_model->details($id);  
            $selectedSubject = get_subject($result->subject_id);  
            $result->SubjectList = $selectedSubject;
            if ($result) {
            // prd($result);
                $return['success'] = "true";
                $return['message'] = "Exam detail found.";
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
        $return['success'] = "true";
        $return['message'] = "Class Schedule Detail.";
        $return['error'] = "";
        $return['data'] = $res;
        $this->response($res, REST_Controller::HTTP_OK);
    }
    public function updateExam_post()
    {
          $postData = json_decode(file_get_contents('php://input'), true);
            if ($postData == '') {
                $postData = $_POST;
            }
            // prd($postData);
           	$postData['exam_date_time'] = $postData['exam_date']." ".date('H:i',strtotime($postData['exam_time']));
            $result = $this->exam_model->updateExam($postData);
            if ($result) {
                if($postData['old_submission_date']!=$postData['last_submission_date']){
                    $pass = "KidyView";
                    $text = $postData['id'];
                    $user_id = $postData['school_id'];
                    $encryptedUrl=$this->encryptData($text,$pass);
                    if($this->session->userdata('user_role')=='school'){
                        $sender_id='SA-'.$user_id;
                    }elseif($this->session->userdata('user_role')=='schoolsubadmin'){
                        $sender_id='SSA-'.$user_id;
                    }
                     $userdata     = $this->session->userdata();
                     $user_name      = $userdata['user_data']['fname'];
                    $this->load->model('teachers/Teacher_model');
                    $getClassStudentData=$this->Teacher_model->getStudentByClassId($postData['class_id']);
                    if (!empty($getClassStudentData)) {
                        foreach ($getClassStudentData as $studentData)
                        {
                            $notificationData['receiver_id'] = "ST-".$studentData['id'];
                            $notificationData['sender_id'] = $sender_id;
                            $notificationData['to_do_id'] = $postData['id'];
                            $notificationData['message'] = $user_name." have changed due date of an exam.";
                            $notificationData['type'] = "exam";
                            $notificationData['url'] = "exam-details/".$encryptedUrl;
                            $this->Teacher_model->add($notificationData,'notifications');
                        }
                    }
                }
                $return['success'] = "true";
                $return['message'] = "Exam update successfully.";
                $return['data'] = $result;
                $return['error'] = $this->error;
                
                $this->response($return, REST_Controller::HTTP_OK);
                } else {
                $return['success'] = "false";
                $return['message'] = "Not found.";
                $return['error'] = $this->error;
                $return['data'] = '';
                
                $this->response($return, REST_Controller::HTTP_OK);
            }
    }
    public function examAndQuestionMarksCount_post()
    {
        $postData = json_decode(file_get_contents('php://input'), true);
            if ($postData == '') {
                $postData = $_POST;
            }
             $id = $postData['id'];

            $result = $this->exam_model->examAndQuestionMarksCount($id);  
            if ($result) {
                $return['success'] = "true";
                $return['message'] = "Exam and Question detail successfully.";
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
    public function getStudentsBySchool_post()
    {
        $postData = json_decode(file_get_contents('php://input'), true);
            if ($postData == '') {
                $postData = $_POST;
            }
             $school_id = $postData['school_id'];

            $result = $this->exam_model->getStudentBySchool($school_id); 
            // prd($result); 
            if ($result) {
                $return['success'] = "true";
                $return['message'] = "Student List data successfully.";
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
    public function unlockExamRequest_post()
    {
        $postData = json_decode(file_get_contents('php://input'), true);
            if ($postData == '') {
                $postData = $_POST;
            }
            $result = $this->exam_model->unlockExamRequest($postData); 
            if ($result) {
                $return['success'] = "true";
                $return['message'] = "Student unlock exam request has been approved successfully.";
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
    public function getGrades_post()
    {
         $postData = json_decode(file_get_contents('php://input'), true);
            if ($postData == '') {
                $postData = $_POST;
            }
            $result = $this->exam_model->getGrades($postData); 
            // prd($GradeData);
            if ($result) {
                $return['success'] = "true";
                $return['message'] = "Grades List.";
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
    public function saveGrades_post()
    {
        $postData = json_decode(file_get_contents('php://input'), true);
            if ($postData == '') {
                $postData = $_POST;
            }
            $result = $this->exam_model->saveGrades($postData); 
            // prd($GradeData);
            if ($result) {
                $return['success'] = "true";
                $return['message'] = "Grades has been save successfully.";
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
    public function deleteGrade_post()
    {
         $postData = json_decode(file_get_contents('php://input'), true);
            if ($postData == '') {
                $postData = $_POST;
            }

            // prd($postData);
            $result = $this->exam_model->deleteGrade($postData); 
            if ($result) {
                $return['success'] = "true";
                $return['message'] = "Grades has been deleted successfully.";
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
    public function getExamSubmitted_post()
    {
            $postData = json_decode(file_get_contents('php://input'), true);
                if ($postData == '') {
                    $postData = $_POST;
                }
            $school_id = $postData['school_id'];
            $result = $this->exam_model->getExamSubmitted($school_id); 
            // prd($result);
            if ($result) {
                $return['success'] = "true";
                $return['message'] = "Submitted exams list by students.";
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
    public function myExamDetails_post()
    {
         $postData = json_decode(file_get_contents('php://input'), true);
                if ($postData == '') {
                    $postData = $_POST;
                }
              $id = $postData['id'];
              $result = $this->exam_model->myExamDetails($id);
               // prd($result);
            if ($result) {
                $return['success'] = "true";
                $return['message'] = "Single Student Exam Submitted Details.";
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
    public function getCurrentSession_post()
    {
         $postData = json_decode(file_get_contents('php://input'), true);
                if ($postData == '') {
                    $postData = $_POST;
                }
                $schoolID = $postData['id'];
          $result = $this->exam_model->schoolwiseSession($schoolID);
               // prd($result);
            if ($result) {
                $return['success'] = "true";
                $return['message'] = "Get currernt session Successfully.";
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
    public function calculateMarks_post()
    {
         $postData = json_decode(file_get_contents('php://input'), true);
                if ($postData == '') {
                    $postData = $_POST;
                }
              
              $result = $this->exam_model->calculateMarks($postData);
               // prd($result);
            if ($result) {
                $return['success'] = "true";
                $return['message'] = "Marks has been Submitted Successfully.";
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
    function encryptData($text,$pass){
        $encryptedUrl = CryptoJSAES::encrypt($text, $pass);
        if(strpos($encryptedUrl, '/') !== false){
            $encryptedUrl = $this->encryptData($text,$pass);
        }
        return $encryptedUrl;
    }
}
