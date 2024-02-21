<?php

defined('BASEPATH') OR exit('No direct script access allowed');
require APPPATH . '/libraries/crypto/autoload.php';
use Blocktrail\CryptoJSAES\CryptoJSAES;
class Cron extends CI_Controller {

    /*Cron for start asignment*/
    public function getTodayAssignmentNotification() {
        $date=date('Y-m-d');
        $this->db->select('*');
        $this->db->from('assignment');
        $this->db->where('open_submission_date',$date);
        $this->db->where('status',1);
        $query=$this->db->get();
        if($query->num_rows()>0)
        {
            $assignmentData=$query->result_array();
            //print_r($assignmentData);die;
            for($i=0;$i<count($assignmentData);$i++){
                $pass = "KidyView";
                $text = $assignmentData[$i]['id'];
                $encryptedUrl=$this->encryptData($text,$pass);
                $this->load->model('teachers/Teacher_model');
                if($assignmentData[$i]['class_id']>0){
                $getClassStudentData=$this->Teacher_model->getStudentByClassId($assignmentData[$i]['class_id']);
                }
                //print_r($getClassStudentData);die;
                $studentEmailArray=array();
                if (!empty($getClassStudentData)) {
                    foreach ($getClassStudentData as $studentData)
                    {
                        $student_id="ST-".$studentData['id'];
					    $isNotify=notificationSettingHelper($assignmentData[$i]['school_id'],$student_id,'Assignment');
                        $notificationData['receiver_id'] = "ST-".$studentData['id'];
                        $notificationData['sender_id'] = $assignmentData[$i]['user_id'];
                        $notificationData['to_do_id'] = $assignmentData[$i]['id'];
                        $notificationData['message'] = $assignmentData[$i]['title']." has been start.";
                        $notificationData['type'] = "assignment";
                        $notificationData['url'] = "assignment-detail/".$encryptedUrl;
                        if(!empty($isNotify) && $isNotify->is_push==1){
                        $this->Teacher_model->add($notificationData,'notifications');
                        }
                        $getParentData=$this->Teacher_model->getParentData($studentData['id']);
                        if($getParentData){
                        $pnotificationData['receiver_id'] = "P-".$getParentData->id;
                        $pnotificationData['sender_id'] = $assignmentData[$i]['user_id'];
                        $pnotificationData['to_do_id'] = $assignmentData[$i]['id'];
                        $pnotificationData['message'] = $assignmentData[$i]['title']." has been start.";
                        $pnotificationData['type'] = "assignment";
                        $pnotificationData['url'] = "assignment-detail/".$encryptedUrl;
                        $isParentNotify=notificationSettingHelper($assignmentData[$i]['school_id'],$pnotificationData['receiver_id'],'Assignment');
                        if(!empty($isParentNotify) && $isParentNotify->is_push==1){
                        $this->Teacher_model->add($pnotificationData,'notifications');
                        }
                        /* Email to child */
                        //$studentEmail=$studentData['childemail'];
                       /*
                        $studentEmail='yt@yopmail.com';
                        if($studentEmail!='' && (!empty($isNotify) && $isNotify->is_web==1) ){
                        $message = $this->load->view('emailtemplate/commonTemplate',$notificationData, true);
                        //$this->sendMail($studentEmail, "Your assignment", $message);
                        sendKidyviewEmail($studentEmail,'','','', 'Your New Assignment', $message);
                        }
                        */
                        /* Email to parent */
                        if($getParentData->fatheremail!=''){
                            $parentEmail=$getParentData->fatheremail;
                        }else{
                            $parentEmail=$getParentData->motheremail;
                        }
                        $parentEmail='yt@yopmail.com';
                        if($parentEmail!=''){
                            $sendData['message'] = "Your child’s assessment is due today.";
                            $sendData['pname']=isset($getParentData->fname) && $getParentData->fname!=''?$getParentData->fname:$getParentData->mname;
                            $message = $this->load->view('emailtemplate/cronAssismentTemplate',$sendData, true);
                            sendKidyviewEmail($parentEmail,'','','', 'Your Child Due Assignment', $message);
                        }
                    }
                    }
                }  
            }
        }
        else
        {
            return array();;
        }
    }
    /*Cron for start project*/
    public function getTodayProjectNotification() {
        $date=date('Y-m-d');
        $this->db->select('*');
        $this->db->from('project');
        $this->db->where('open_submission_date',$date);
        $this->db->where('status',1);
        $query=$this->db->get();
        if($query->num_rows()>0)
        {
            $assignmentData=$query->result_array();
            //print_r($assignmentData);die;
            for($i=0;$i<count($assignmentData);$i++){
                $pass = "KidyView";
                $text = $assignmentData[$i]['id'];
                $encryptedUrl=$this->encryptData($text,$pass);
                $this->load->model('teachers/Teacher_model');
                if($assignmentData[$i]['class_id']>0){
                $getClassStudentData=$this->Teacher_model->getStudentByClassId($assignmentData[$i]['class_id']);
                }
                //print_r($getClassStudentData);die;
                $studentEmailArray=array();
                if (!empty($getClassStudentData)) {
                    foreach ($getClassStudentData as $studentData)
                    {
                        $student_id="ST-".$studentData['id'];
					    $isNotify=notificationSettingHelper($assignmentData[$i]['school_id'],$student_id,'Project');
                        $notificationData['receiver_id'] = "ST-".$studentData['id'];
                        $notificationData['sender_id'] = $assignmentData[$i]['user_id'];
                        $notificationData['to_do_id'] = $assignmentData[$i]['id'];
                        $notificationData['message'] = $assignmentData[$i]['title']." has been started.";
                        $notificationData['type'] = "project";
                        $notificationData['url'] = "project-detail/".$encryptedUrl;
                        if(!empty($isNotify) && $isNotify->is_push==1){
                        $this->Teacher_model->add($notificationData,'notifications');
                        }
                        $getParentData=$this->Teacher_model->getParentData($studentData['id']);
                        if($getParentData){
                        $pnotificationData['receiver_id'] = "P-".$getParentData->id;
                        $pnotificationData['sender_id'] = $assignmentData[$i]['user_id'];
                        $pnotificationData['to_do_id'] = $assignmentData[$i]['id'];
                        $pnotificationData['message'] = $assignmentData[$i]['title']." has been started.";
                        $pnotificationData['type'] = "project";
                        $pnotificationData['url'] = "project-detail/".$encryptedUrl;
                        $isParentNotify=notificationSettingHelper($assignmentData[$i]['school_id'],$pnotificationData['receiver_id'],'Project');
                        if(!empty($isParentNotify) && $isParentNotify->is_push==1){
                        $this->Teacher_model->add($pnotificationData,'notifications');
                        }
                        /* Email to child */
                        /* $studentEmail=$studentData['childemail'];
                        if($studentEmail!='' && (!empty($isNotify) && $isNotify->is_web==1) ){
                        $message = $this->load->view('emailtemplate/commonTemplate',$notificationData, true);
                        //$this->sendMail($studentEmail, "Your Project", $message);
                        sendKidyviewEmail($studentEmail,'','','', 'Your New Project', $message);
                        }
                        /* Email to parent */
                        if($getParentData->fatheremail!=''){
                            $parentEmail=$getParentData->fatheremail;
                        }else{
                            $parentEmail=$getParentData->motheremail;
                        }
                        $parentEmail="yts@yopmail.com";
                        if($parentEmail!=''){
                            $sendData['message'] = "Your child’s assessment is due todayss.";
                            $sendData['pname']=isset($getParentData->fname) && $getParentData->fname!=''?$getParentData->fname:$getParentData->mname;
                            $message = $this->load->view('emailtemplate/cronAssismentTemplate',$sendData, true);
                            sendKidyviewEmail($parentEmail,'','','', 'Your Child Due Assignment', $message);
                        }
                    }
                    }
                }  
            }
        }
        else
        {
            return array();;
        }
    }
    /*Cron for get Twenty Four Hour sAssignment Notification*/
    public function getTwentyFourHoursAssignmentNotification() {
        $tomorrowDate = date( "Y-m-d", strtotime( "+1 days" ) );
        $this->db->select('*');
        $this->db->from('assignment');
        $this->db->where('submission_date',$tomorrowDate);
        $this->db->where('status',1);
        $query=$this->db->get();
        if($query->num_rows()>0)
        {
            $assignmentData=$query->result_array();
            //print_r($assignmentData);die;
            for($i=0;$i<count($assignmentData);$i++){
                $pass = "KidyView";
                $text = $assignmentData[$i]['id'];
                $encryptedUrl=$this->encryptData($text,$pass);
                $this->load->model('teachers/Teacher_model');
                if($assignmentData[$i]['class_id']>0){
                $getClassStudentData=$this->Teacher_model->getStudentByClassId($assignmentData[$i]['class_id']);
                }
                //print_r($getClassStudentData);die;
                $studentEmailArray=array();
                if (!empty($getClassStudentData)) {
                    foreach ($getClassStudentData as $studentData)
                    {
                        $student_id="ST-".$studentData['id'];
					    $isNotify=notificationSettingHelper($assignmentData[$i]['school_id'],$student_id,'Assignment');
                        $notificationData['receiver_id'] = "ST-".$studentData['id'];
                        $notificationData['sender_id'] = $assignmentData[$i]['user_id'];
                        $notificationData['to_do_id'] = $assignmentData[$i]['id'];
                        $notificationData['message'] = "24 hours left for ".$assignmentData[$i]['title']." to submission.";
                        $notificationData['type'] = "assignment";
                        $notificationData['url'] = "assignment-detail/".$encryptedUrl;
                        if(!empty($isNotify) && $isNotify->is_push==1){
                        $this->Teacher_model->add($notificationData,'notifications');
                        }
                        $getParentData=$this->Teacher_model->getParentData($studentData['id']);
                        if($getParentData){
                        $pnotificationData['receiver_id'] = "P-".$getParentData->id;
                        $pnotificationData['sender_id'] = $assignmentData[$i]['user_id'];
                        $pnotificationData['to_do_id'] = $assignmentData[$i]['id'];
                        $pnotificationData['message'] = "24 hours left for".$assignmentData[$i]['title']." submission.";
                        $pnotificationData['type'] = "assignment";
                        $pnotificationData['url'] = "assignment-detail/".$encryptedUrl;
                        $isParentNotify=notificationSettingHelper($assignmentData[$i]['school_id'],$pnotificationData['receiver_id'],'Assignment');
                        if(!empty($isParentNotify) && $isParentNotify->is_push==1){
                        $this->Teacher_model->add($pnotificationData,'notifications');
                        }
                        /* Email to child */
                       /* $studentEmail=$studentData['childemail'];
                        if($studentEmail!='' && (!empty($isNotify) && $isNotify->is_web==1) ){
                        $message = $this->load->view('emailtemplate/commonTemplate',$notificationData, true);
                        //$this->sendMail($studentEmail, "Your assignment", $message);
                        sendKidyviewEmail($studentEmail,'','','', 'Your New Assignment', $message);
                        }*/
                        /* Email to parent */
                        if($getParentData->fatheremail!=''){
                            $parentEmail=$getParentData->fatheremail;
                        }else{
                            $parentEmail=$getParentData->motheremail;
                        }
                        $parentEmail="ytss@yopmail.com";
                        if($parentEmail!=''){
                            $sendData['message'] = "Your child’s assessment is due in the next 24 hours.";
                            $sendData['pname']=isset($getParentData->fname) && $getParentData->fname!=''?$getParentData->fname:$getParentData->mname;
                            $message = $this->load->view('emailtemplate/cronAssismentTemplate',$sendData, true);
                            sendKidyviewEmail($parentEmail,'','','', 'Your Child Due Assignment', $message);
                        }
                    }
                    }
                }  
            }
        }
        else
        {
            return array();;
        }
    }
     /*Cron for get Twenty Four Hours Project Notification*/
    public function getTwentyFourHoursProjectNotification() {
        $tomorrowDate = date( "Y-m-d", strtotime( "+1 days" ) );
        $this->db->select('*');
        $this->db->from('project');
        $this->db->where('submission_date',$tomorrowDate);
        $this->db->where('status',1);
        $query=$this->db->get();
        if($query->num_rows()>0)
        {
            $assignmentData=$query->result_array();
            //print_r($assignmentData);die;
            for($i=0;$i<count($assignmentData);$i++){
                $pass = "KidyView";
                $text = $assignmentData[$i]['id'];
                $encryptedUrl=$this->encryptData($text,$pass);
                $this->load->model('teachers/Teacher_model');
                if($assignmentData[$i]['class_id']>0){
                $getClassStudentData=$this->Teacher_model->getStudentByClassId($assignmentData[$i]['class_id']);
                }
                //print_r($getClassStudentData);die;
                $studentEmailArray=array();
                if (!empty($getClassStudentData)) {
                    foreach ($getClassStudentData as $studentData)
                    {
                        $student_id="ST-".$studentData['id'];
					    $isNotify=notificationSettingHelper($assignmentData[$i]['school_id'],$student_id,'Project');
                        $notificationData['receiver_id'] = "ST-".$studentData['id'];
                        $notificationData['sender_id'] = $assignmentData[$i]['user_id'];
                        $notificationData['to_do_id'] = $assignmentData[$i]['id'];
                        $notificationData['message'] = "24 hours left for ".$assignmentData[$i]['title']." to submission.";
                        $notificationData['type'] = "project";
                        $notificationData['url'] = "project-detail/".$encryptedUrl;
                        if(!empty($isNotify) && $isNotify->is_push==1){
                        $this->Teacher_model->add($notificationData,'notifications');
                        }
                        $getParentData=$this->Teacher_model->getParentData($studentData['id']);
                        if($getParentData){
                        $pnotificationData['receiver_id'] = "P-".$getParentData->id;
                        $pnotificationData['sender_id'] = $assignmentData[$i]['user_id'];
                        $pnotificationData['to_do_id'] = $assignmentData[$i]['id'];
                        $pnotificationData['message'] = "24 hours left for".$assignmentData[$i]['title']." submission.";
                        $pnotificationData['type'] = "project";
                        $pnotificationData['url'] = "project-detail/".$encryptedUrl;
                        $isParentNotify=notificationSettingHelper($assignmentData[$i]['school_id'],$pnotificationData['receiver_id'],'Project');
                        if(!empty($isParentNotify) && $isParentNotify->is_push==1){
                        $this->Teacher_model->add($pnotificationData,'notifications');
                        }
                        /* Email to child */
                        /*
                        $studentEmail=$studentData['childemail'];
                        if($studentEmail!='' && (!empty($isNotify) && $isNotify->is_web==1) ){
                        $message = $this->load->view('emailtemplate/commonTemplate',$notificationData, true);
                        //$this->sendMail($studentEmail, "Your project", $message);
                        sendKidyviewEmail($studentEmail,'','','', 'Your Project', $message);
                        }
                        */
                        /* Email to parent */
                        if($getParentData->fatheremail!=''){
                            $parentEmail=$getParentData->fatheremail;
                        }else{
                            $parentEmail=$getParentData->motheremail;
                        }
                        $parentEmail='ytsss@yopmail.com';
                        if($parentEmail!=''){
                            $sendData['message'] = "Your child’s assessment is due in the next 24 hours.";
                            $sendData['pname']=isset($getParentData->fname) && $getParentData->fname!=''?$getParentData->fname:$getParentData->mname;
                            $message = $this->load->view('emailtemplate/cronAssismentTemplate',$sendData, true);
                            sendKidyviewEmail($parentEmail,'','','', 'Your Child Due Assignment', $message);
                        }
                    }
                    }
                }  
            }
        }
        else
        {
            return array();;
        }
    }
    /*Cron for get Before Two Hours Submission Assignment Notifications*/
    public function getBeforeTwoHoursAssignmentNotifications() {
        $date=date('Y-m-d');
        $this->db->select('*');
        $this->db->from('assignment');
        $this->db->where('submission_date',$date);
        $this->db->where('status',1);
        $query=$this->db->get();
        if($query->num_rows()>0)
        {
            $assignmentData=$query->result_array();
            for($i=0;$i<count($assignmentData);$i++){
                $pass = "KidyView";
                $text = $assignmentData[$i]['id'];
                $encryptedUrl=$this->encryptData($text,$pass);
                $this->load->model('teachers/Teacher_model');
                if($assignmentData[$i]['class_id']>0){
                $getClassStudentData=$this->Teacher_model->getStudentByClassId($assignmentData[$i]['class_id']);
                }
                //print_r($getClassStudentData);die;
                $studentEmailArray=array();
                if (!empty($getClassStudentData)) {
                    foreach ($getClassStudentData as $studentData)
                    {
                        $student_id="ST-".$studentData['id'];
					    $isNotify=notificationSettingHelper($assignmentData[$i]['school_id'],$student_id,'Assignment');
                        $notificationData['receiver_id'] = "ST-".$studentData['id'];
                        $notificationData['sender_id'] = $assignmentData[$i]['user_id'];
                        $notificationData['to_do_id'] = $assignmentData[$i]['id'];
                        $notificationData['message'] = "2 hours left for ".$assignmentData[$i]['title']." to submission.";
                        $notificationData['type'] = "assignment";
                        $notificationData['url'] = "assignment-detail/".$encryptedUrl;
                        if(!empty($isNotify) && $isNotify->is_push==1){
                        $this->Teacher_model->add($notificationData,'notifications');
                        }
                        $getParentData=$this->Teacher_model->getParentData($studentData['id']);
                        if($getParentData){
                        $pnotificationData['receiver_id'] = "P-".$getParentData->id;
                        $pnotificationData['sender_id'] = $assignmentData[$i]['user_id'];
                        $pnotificationData['to_do_id'] = $assignmentData[$i]['id'];
                        $pnotificationData['message'] = "2 hours left for ".$assignmentData[$i]['title']." to submission.";
                        $pnotificationData['type'] = "assignment";
                        $pnotificationData['url'] = "assignment-detail/".$encryptedUrl;
                        $isParentNotify=notificationSettingHelper($assignmentData[$i]['school_id'],$pnotificationData['receiver_id'],'Assignment');
                        if(!empty($isParentNotify) && $isParentNotify->is_push==1){
                        $this->Teacher_model->add($pnotificationData,'notifications');
                        }
                        /* Email to child */
                        /*
                        $studentEmail=$studentData['childemail'];
                        if($studentEmail!='' && (!empty($isNotify) && $isNotify->is_web==1) ){
                        $message = $this->load->view('emailtemplate/commonTemplate',$notificationData, true);
                        //$this->sendMail($studentEmail, "Your assignment", $message);
                        sendKidyviewEmail($studentEmail,'','','', 'Your Assignment', $message);
                        }
                        */
                        /* Email to parent */
                        if($getParentData->fatheremail!=''){
                            $parentEmail=$getParentData->fatheremail;
                        }else{
                            $parentEmail=$getParentData->motheremail;
                        }
                        $parentEmail='ytsss@yopmail.com';
                        if($parentEmail!=''){
                        $sendData['message'] = "Your child’s assessment is due in the next 2 hours.";
                        $sendData['pname']=isset($getParentData->fname) && $getParentData->fname!=''?$getParentData->fname:$getParentData->mname;
                        $message = $this->load->view('emailtemplate/cronAssismentTemplate',$sendData, true);
                        sendKidyviewEmail($parentEmail,'','','', 'Your Child Due Assignment', $message);
                        }
                    }
                    }
                }  
            }
        }
        else
        {
            return array();;
        }
    }
    /*Cron for get Before Two Hours Project Notifications*/
    public function getBeforeTwoHoursProjectNotifications() {
        $date=date('Y-m-d');
        $this->db->select('*');
        $this->db->from('project');
        $this->db->where('submission_date',$date);
        $this->db->where('status',1);
        $query=$this->db->get();
        if($query->num_rows()>0)
        {
            $assignmentData=$query->result_array();
            for($i=0;$i<count($assignmentData);$i++){
                $pass = "KidyView";
                $text = $assignmentData[$i]['id'];
                $encryptedUrl=$this->encryptData($text,$pass);
                $this->load->model('teachers/Teacher_model');
                if($assignmentData[$i]['class_id']>0){
                $getClassStudentData=$this->Teacher_model->getStudentByClassId($assignmentData[$i]['class_id']);
                }
                $studentEmailArray=array();
                if (!empty($getClassStudentData)) {
                    foreach ($getClassStudentData as $studentData)
                    {
                        $student_id="ST-".$studentData['id'];
					    $isNotify=notificationSettingHelper($assignmentData[$i]['school_id'],$student_id,'Project');
                        $notificationData['receiver_id'] = "ST-".$studentData['id'];
                        $notificationData['sender_id'] = $assignmentData[$i]['user_id'];
                        $notificationData['to_do_id'] = $assignmentData[$i]['id'];
                        $notificationData['message'] = "2 hours left for ".$assignmentData[$i]['title']." to submission.";
                        $notificationData['type'] = "project";
                        $notificationData['url'] = "project-detail/".$encryptedUrl;
                        if(!empty($isNotify) && $isNotify->is_push==1){
                        $this->Teacher_model->add($notificationData,'notifications');
                        }
                        $getParentData=$this->Teacher_model->getParentData($studentData['id']);
                        if($getParentData){
                        $pnotificationData['receiver_id'] = "P-".$getParentData->id;
                        $pnotificationData['sender_id'] = $assignmentData[$i]['user_id'];
                        $pnotificationData['to_do_id'] = $assignmentData[$i]['id'];
                        $pnotificationData['message'] = "2 hours left for ".$assignmentData[$i]['title']." to submission.";
                        $pnotificationData['type'] = "project";
                        $pnotificationData['url'] = "project-detail/".$encryptedUrl;
                        $isParentNotify=notificationSettingHelper($assignmentData[$i]['school_id'],$pnotificationData['receiver_id'],'Project');
                        if(!empty($isParentNotify) && $isParentNotify->is_push==1){
                        $this->Teacher_model->add($pnotificationData,'notifications');
                        }
                        /* Email to child */
                        /*
                        $studentEmail=$studentData['childemail'];
                        if($studentEmail!='' && (!empty($isNotify) && $isNotify->is_web==1) ){
                        $message = $this->load->view('emailtemplate/commonTemplate',$notificationData, true);
                        //$this->sendMail($studentEmail, "Your Project", $message);
                        sendKidyviewEmail($studentEmail,'','','', 'Your Assignment', $message);
                        }
                        */
                        /* Email to parent */
                        if($getParentData->fatheremail!=''){
                            $parentEmail=$getParentData->fatheremail;
                        }else{
                            $parentEmail=$getParentData->motheremail;
                        }
                        $parentEmail='ytssss@yopmail.com';
                        if($parentEmail!=''){
                        $sendData['message'] = "Your child’s assessment is due in the next 2 hours.";
                        $sendData['pname']=isset($getParentData->fname) && $getParentData->fname!=''?$getParentData->fname:$getParentData->mname;
                        $message = $this->load->view('emailtemplate/cronAssismentTemplate',$sendData, true);
                        sendKidyviewEmail($parentEmail,'','','', 'Your Child Due Assignment', $message);
                        }
                    }
                    }
                }  
            }
        }
        else
        {
            return array();;
        }
    }
     /*Cron for get Twenty Four Hours Exam Notification*/
    public function getTwentyFourHoursExamNotification() {
        $tomorrowDate = date( "Y-m-d", strtotime( "+1 days" ) );
        $this->db->select('*');
        $this->db->from('exam');
        $this->db->where('exam_date',$tomorrowDate);
        $this->db->where('status','1');
        $query=$this->db->get();
        if($query->num_rows()>0)
        {
            $examData=$query->result_array();
            //print_r($assignmentData);die;
            for($i=0;$i<count($examData);$i++){
                echo $examData[$i]['name'];
                $pass = "KidyView";
                $text = $examData[$i]['id'];
                $encryptedUrl=$this->encryptData($text,$pass);
                $this->load->model('teachers/Teacher_model');
                if($examData[$i]['class_id']>0){
                $getClassStudentData=$this->Teacher_model->getStudentByClassId($examData[$i]['class_id']);
                }
                $studentEmailArray=array();
                if (!empty($getClassStudentData)) {
                    foreach ($getClassStudentData as $studentData)
                    {
                        $student_id="ST-".$studentData['id'];
					    $isNotify=notificationSettingHelper($examData[$i]['school_id'],$student_id,'Exam');
                        $notificationData['receiver_id'] = "ST-".$studentData['id'];
                        $notificationData['sender_id'] = $examData[$i]['user_id'];
                        $notificationData['to_do_id'] = $examData[$i]['id'];
                        $notificationData['message'] = "24 hours left for ".$examData[$i]['name']." to submission.";
                        $notificationData['type'] = "exam";
                        $notificationData['url'] = "exam-details/".$encryptedUrl;
                        if(!empty($isNotify) && $isNotify->is_push==1){
                        $this->Teacher_model->add($notificationData,'notifications');
                        }
                        $studentEmail=$studentData['childemail'];
                        if($studentEmail!='' && (!empty($isNotify) && $isNotify->is_web==1) ){
                        $message = $this->load->view('emailtemplate/commonTemplate',$notificationData, true);
                       // $this->sendMail($studentEmail, "Your exam", $message);
                        sendKidyviewEmail($studentEmail,'','','', 'Your Exam', $message);
                        }
                        $getParentData=$this->Teacher_model->getParentData($studentData['id']);
                        if($getParentData){
                            $pnotificationData['receiver_id'] = "P-".$getParentData->id;
                            $pnotificationData['sender_id'] = $examData[$i]['user_id'];
                            $pnotificationData['to_do_id'] = $examData[$i]['id'];
                            $pnotificationData['message'] = "24 hours left for ".$examData[$i]['name']." to submission.";
                            $pnotificationData['type'] = "exam";
                            $pnotificationData['url'] = "exam-details/".$encryptedUrl;
                        $isParentNotify=notificationSettingHelper($assignmentData[$i]['school_id'],$pnotificationData['receiver_id'],'Project');
                        if(!empty($isParentNotify) && $isParentNotify->is_push==1){
                        $this->Teacher_model->add($pnotificationData,'notifications');
                        }
                        /* Email to parent */
                        if($getParentData->fatheremail!=''){
                            $parentEmail=$getParentData->fatheremail;
                        }else{
                            $parentEmail=$getParentData->motheremail;
                        }
                        $parentEmail="ytssss@yopmail.com";
                        if($parentEmail!=''){
                        $sendData['message'] = "Your child’s assessment is due in the next 24 hours.";
                        $sendData['pname']=isset($getParentData->fname) && $getParentData->fname!=''?$getParentData->fname:$getParentData->mname;
                        $message = $this->load->view('emailtemplate/cronAssismentTemplate',$sendData, true);
                        sendKidyviewEmail($parentEmail,'','','', 'Your Child Due Assignment', $message);
                        }
                    }
                }
                }  
            }
        }
        else
        {
            return array();;
        }
    }
     /*Cron for get Twenty Four Hours Exam Notification*/
    public function getBeforeTwoHoursExamNotifications() {
        $date1 = date("Y-m-d H:i:s", strtotime('+2 hours'));
        $date2 = date("Y-m-d H:i:s", strtotime('+2 hours +15 minutes'));
        $this->db->select('concat("exam_date"," ","exam_time") as edate');
        $this->db->from('exam');
        $this->db->where('exam_date_time>=',$date1);
        $this->db->where('exam_date_time<=',$date2);
        $this->db->where('status','1');
        $query=$this->db->get();
        if($query->num_rows()>0)
        {
            $examData=$query->result_array();
            for($i=0;$i<count($examData);$i++){
                $pass = "KidyView";
                $text = $examData[$i]['id'];
                $encryptedUrl=$this->encryptData($text,$pass);
                $this->load->model('teachers/Teacher_model');
                if($examData[$i]['class_id']>0){
                $getClassStudentData=$this->Teacher_model->getStudentByClassId($examData[$i]['class_id']);
                }
                $studentEmailArray=array();
                if (!empty($getClassStudentData)) {
                    foreach ($getClassStudentData as $studentData)
                    {
                        $student_id="ST-".$studentData['id'];
					    $isNotify=notificationSettingHelper($examData[$i]['school_id'],$student_id,'Exam');
                        $notificationData['receiver_id'] = "ST-".$studentData['id'];
                        $notificationData['sender_id'] = $examData[$i]['user_id'];
                        $notificationData['to_do_id'] = $examData[$i]['id'];
                        $notificationData['message'] = "2 hours left for ".$examData[$i]['name']." to submission.";
                        $notificationData['type'] = "exam";
                        $notificationData['url'] = "exam-details/".$encryptedUrl;
                        if(!empty($isNotify) && $isNotify->is_push==1){
                        $this->Teacher_model->add($notificationData,'notifications');
                        }
                        $studentEmail=$studentData['childemail'];
                        if($studentEmail!='' && (!empty($isNotify) && $isNotify->is_web==1) ){
                        $message = $this->load->view('emailtemplate/commonTemplate',$notificationData, true);
                        //$this->sendMail($studentEmail, "Your exam", $message);
                        sendKidyviewEmail($studentEmail,'','','', 'Your Exam', $message);
                        }
                        $getParentData=$this->Teacher_model->getParentData($studentData['id']);
                        if($getParentData){
                            $pnotificationData['receiver_id'] = "P-".$getParentData->id;
                            $pnotificationData['sender_id'] = $examData[$i]['user_id'];
                            $pnotificationData['to_do_id'] = $examData[$i]['id'];
                            $pnotificationData['message'] = "24 hours left for ".$examData[$i]['name']." to submission.";
                            $pnotificationData['type'] = "exam";
                            $pnotificationData['url'] = "exam-details/".$encryptedUrl;
                        $isParentNotify=notificationSettingHelper($assignmentData[$i]['school_id'],$pnotificationData['receiver_id'],'Project');
                        if(!empty($isParentNotify) && $isParentNotify->is_push==1){
                        $this->Teacher_model->add($pnotificationData,'notifications');
                        }
                        /* Email to parent */
                        if($getParentData->fatheremail!=''){
                            $parentEmail=$getParentData->fatheremail;
                        }else{
                            $parentEmail=$getParentData->motheremail;
                        }
                        $parentEmail="ytssss@yopmail.com";
                        if($parentEmail!=''){
                        $sendData['message'] = "Your child’s assessment is due in the next 24 hours.";
                        $sendData['pname']=isset($getParentData->fname) && $getParentData->fname!=''?$getParentData->fname:$getParentData->mname;
                        $message = $this->load->view('emailtemplate/cronAssismentTemplate',$sendData, true);
                        sendKidyviewEmail($parentEmail,'','','', 'Your Child Due Assignment', $message);
                        }
                     }
                
                    }
                }  
            }
        }
        else
        {
            return array();;
        }
    }
    function encryptData($text,$pass){
        $encryptedUrl = CryptoJSAES::encrypt($text, $pass);
        if(strpos($encryptedUrl, '/') !== false){
            $encryptedUrl = $this->encryptData($text,$pass);
        }
        return $encryptedUrl;
    }
    private function sendMail($to, $subject, $message) {
        $headers = 'MIME-Version: 1.0' . "\r\n";
        $headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
        $headers .= 'From: admin@kidyview.com' . "\r\n";
        return mail($to, $subject, $message, $headers);
    }
}
