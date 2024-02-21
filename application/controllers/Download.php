<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Download extends CI_Controller {

    public function index() {
        $sid = "AC88b2bb2733f6fc92a17f45b40060b5e9"; // Your Account SID from www.twilio.com/console
        $token = "39c44944860d5aa86687b7d8c35bb773"; // Your Auth Token from www.twilio.com/console
        
        $client = new Twilio\Rest\Client($sid, $token);
        $client->messages->create(
            // the number you'd like to send the message to
            '+918744030241',
            [
                // A Twilio phone number you purchased at twilio.com/console
                'from' => '+19033001178',
                // the body of the text message you'd like to send
                'body' => 'Hey Jenny! Good luck on the bar exam!'
            ]
        );
        echo '</pre>';
        print_r($client);
    }

    public function assignmentdownload($id='') {
        $assignmentData=$this->getAssignmentAttachData($id);
        if(!empty($assignmentData)){
        $this->load->library('zip');
        $path = 'img/assignment/';
        for($i=0;$i<count($assignmentData['attachment']);$i++){
            $this->zip->read_file($path.$assignmentData['attachment'][$i]['attachment']);
            }
            $this->zip->download('assignment-'.$assignmentData['title'].'.zip');
        }
    }
    public function submitassignmentdownload($id='',$student_id='') {
        $assignmentData=$this->getSubmittedAssignmentAttachData($id);
        //echo $this->db->last_query();die;
        if(!empty($assignmentData)){
        $this->load->library('zip');
        $path = 'img/submitassignment/';
        for($i=0;$i<count($assignmentData['attachment']);$i++){
            $this->zip->read_file($path.$assignmentData['attachment'][$i]['attachment']);
            }
            $this->zip->download('submitassignment-'.$assignmentData['title'].'.zip');
        }
    }

    public function getAssignmentAttachData($id){
            $this->db->select("id,title");
            $this->db->from("assignment");
            $this->db->where("id",$id);
            $query = $this->db->get();
            if($query->num_rows()>0)
            {
                $data=$query->result_array();
                for($v=0; $v<count($data); $v++)
                {
                    $data[$v]['attachment']= $this->getAttachmet($data[$v]['id']);
            
                }
                return $data[0];
            }
            else
            {
                return array();;
            }
        }
        public function getAttachmet($assignment_id=''){
            $this->db->select("attachment");
            $this->db->from("assignment_attachment");
            $this->db->where("assignment_id",$assignment_id);
            $query = $this->db->get();
            if($query->num_rows()>0)
            {
                return $data=$query->result_array();
            }
            else
            {
                return array();;
            }

        }
        public function getSubmittedAssignmentAttachData($id){
            $this->db->select("a.id,a.title");
            $this->db->from("assignment a");
            $this->db->join('assignment_submission ast','ast.assignment_id=a.id','INNER');
            $this->db->where("ast.id",$id);
            $query = $this->db->get();
            if($query->num_rows()>0)
            {
                $data=$query->result_array();
                for($v=0; $v<count($data); $v++)
                {
                    $data[$v]['attachment']= $this->getSubmittedAttachmet($id);
            
                }
                return $data[0];
            }
            else
            {
                return array();;
            }
        }
        public function getSubmittedAttachmet($assignment_id='',$student_id=''){
            $this->db->select("attachment");
            $this->db->from("submission_attachment");
            $this->db->where("assignment_id",$assignment_id);
            $query = $this->db->get();
            if($query->num_rows()>0)
            {
                return $data=$query->result_array();
            }
            else
            {
                return array();;
            }

        }
        /*download project*/
        public function projectdownload($id='') {
            $assignmentData=$this->getProjectAttachData($id);
           //print_r($assignmentData);die;
            if(!empty($assignmentData)){
            $this->load->library('zip');
            $path = 'img/project/';
            for($i=0;$i<count($assignmentData['attachment']);$i++){
                $this->zip->read_file($path.$assignmentData['attachment'][$i]['attachment']);
                }
                $this->zip->download('project-'.$assignmentData['title'].'.zip');
            }
        }
        public function submitprojectdownload($id='',$student_id='') {
            $assignmentData=$this->getSubmittedProjectAttachData($id);
            //echo $this->db->last_query();die;
            if(!empty($assignmentData)){
            $this->load->library('zip');
            $path = 'img/submitproject/';
            for($i=0;$i<count($assignmentData['attachment']);$i++){
                $this->zip->read_file($path.$assignmentData['attachment'][$i]['attachment']);
                }
                $this->zip->download('submitproject-'.$assignmentData['title'].'.zip');
            }
        }
    
        public function getProjectAttachData($id){
                $this->db->select("id,title");
                $this->db->from("project");
                $this->db->where("id",$id);
                $query = $this->db->get();
                if($query->num_rows()>0)
                {
                    $data=$query->result_array();
                    for($v=0; $v<count($data); $v++)
                    {
                        $data[$v]['attachment']= $this->getProjectAttachmet($data[$v]['id']);
                
                    }
                    return $data[0];
                }
                else
                {
                    return array();;
                }
            }
            public function getProjectAttachmet($assignment_id=''){
                $this->db->select("attachment");
                $this->db->from("project_attachment");
                $this->db->where("project_id",$assignment_id);
                $query = $this->db->get();
                if($query->num_rows()>0)
                {
                    return $data=$query->result_array();
                }
                else
                {
                    return array();;
                }
    
            }
            public function getSubmittedProjectAttachData($id){
                $this->db->select("a.id,a.title");
                $this->db->from("project a");
                $this->db->join('project_submission ast','ast.project_id=a.id','INNER');
                $this->db->where("ast.id",$id);
                $query = $this->db->get();
                if($query->num_rows()>0)
                {
                    $data=$query->result_array();
                    for($v=0; $v<count($data); $v++)
                    {
                        $data[$v]['attachment']= $this->getSubmittedProjectAttachmet($id);
                
                    }
                    return $data[0];
                }
                else
                {
                    return array();;
                }
            }
            public function getSubmittedProjectAttachmet($assignment_id='',$student_id=''){
                $this->db->select("attachment");
                $this->db->from("project_submission_attachment");
                $this->db->where("project_id",$assignment_id);
                $query = $this->db->get();
                if($query->num_rows()>0)
                {
                    return $data=$query->result_array();
                }
                else
                {
                    return array();;
                }
    
            }
            public function lessondownload($id='') {
                $assignmentData=$this->getLessonAttachData($id);
                if(!empty($assignmentData)){
                $this->load->library('zip');
                $path = 'img/teacher/lessonnote/';
                for($i=0;$i<count($assignmentData['attachment']);$i++){
                    $this->zip->read_file($path.$assignmentData['attachment'][$i]['attachment']);
                    }
                    $this->zip->download('lesson-note'.$assignmentData['topic'].'.zip');
                }
            }
            public function getLessonAttachData($id){
                $this->db->select("id,topic");
                $this->db->from("lesson_note");
                $this->db->where("id",$id);
                $query = $this->db->get();
                if($query->num_rows()>0)
                {
                    $data=$query->result_array();
                    for($v=0; $v<count($data); $v++)
                    {
                        $data[$v]['attachment']= $this->getLessonAttachmet($data[$v]['id']);
                
                    }
                    return $data[0];
                }
                else
                {
                    return array();;
                }
            }
            public function getLessonAttachmet($lesson_id=''){
                $this->db->select("attachment");
                $this->db->from("lesson_note_attachment");
                $this->db->where("noteid",$lesson_id);
                $query = $this->db->get();
                if($query->num_rows()>0)
                {
                    return $data=$query->result_array();
                }
                else
                {
                    return array();;
                }
    
            }
            public function result($school_id='',$student_id='',$session_id='') {
                //error_reporting(0);
                //$student_id=57;
                //$school_id=20;
                error_reporting(0);
                $this->load->model('parent/Parentresult_model','model');
                $result = $this->model->getStudentResult($school_id, $student_id,$session_id);
                //echo $this->db->last_query();die;
                $data['result'] = $result;
                //prd($data);die;
                if ($result) {
                    //$this->load->view('marksheet', $data, true);
                    $mpdf = $mpdf = new \Mpdf\Mpdf(['format' => 'Legal']);
                    $html = $this->load->view('marksheet', $data, true);
                   // echo $html;die;
                    $mpdf->WriteHTML($html);
                    $filename = $student_id.substr(md5(date('Y-m-d')),-10).'_reportcard.pdf';
                    $mpdf->Output($filename, 'D');
                   

                    
                }
            }
            public  function getTermData($termListData,$termid) {
       
       
                $termArray = array();
                if(!empty($termListData)) {
                   $k=0; 
                   for($t=0;$t<count($termListData);$t++)   {  
                       if($termListData[$t]->term_id == $termid){
                        $termArray[$k] = $termListData[$t];
                        $k++;
                        
                       }
                   }
                }
                
               return $termArray; 
            }

}
