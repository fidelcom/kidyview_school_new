<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Student extends MX_Controller {

    public function __construct() {
        parent::__construct();
        if ($this->session->userdata('is_logged_in') != 'true' ||$this->session->userdata('student_role') != 'student') {
           redirect('studentlogin');
        }
        $this->load->model('student_model');
      
    }
   
	public function index() {
        $data = array();
        $student_id=$this->session->userdata('student_data')['id'];
        $data['STUDENTDATA']=$this->student_model->getLoginStudentDetails($student_id);
        $this->load->view('index', $data);
    }
    public function dashboard() {
        $this->load->view('dashboard');
    }
    public function studentProfile() {
        $this->load->view('studentprofile');
    }
    public function assignmentList() {
        $this->load->view('assignment/assignmentlist');
    }
    public function assignmentView() {
        $this->load->view('assignment/assignmentdetail');
    }
    public function submitAssignment() {
        $this->load->view('assignment/submitassignment');
    }
    public function submitAssignmentList() {
        $this->load->view('assignment/submitassignmentlist');
    }
    public function submitassignmentView() {
        $this->load->view('assignment/submitassignmentdetail');
    }
    public function teacherList() {
        $this->load->view('teacher/teacherlist');
    }
    public function studentList() {
        $this->load->view('students/studentlist');
    }
    public function teacherView() {
        $this->load->view('teacher/teacherdetails');
    }
    public function studentView() {
        $this->load->view('students/studentdetails');
    }
    public function editsubmitassignment() {
        $this->load->view('assignment/editsubmitassignment');
    }
    public function classboardList() {
        $this->load->view('classboard/classboardlist');
    }
    public function viewPost() {
        $this->load->view('classboard/viewpost');
    }
    public function messageList() {
        $this->load->view('message/messagelist');
    }
    public function sendMessage() {
        $this->load->view('message/sendmessage');
    }
    public function conversation() {
        $this->load->view('message/conversation');
    }
    public function subjectDetail() {
        $this->load->view('subjectdetails');
    }
    public function todoList() {
        $this->load->view('todolist');
    }
    public function calendarList() {
        $this->load->view('calendar/calendarlist');
    }
    public function scheduleList() {
        $this->load->view('classschedule/schedulelist');
    }
    public function faqList() {
        $this->load->view('faqlist');
    }
    public function goalList() {
        $this->load->view('goals/goallist');
    }
    public function goalDetails() {
        $this->load->view('goals/goaldetails');
    }
    public function giftList() {
        $this->load->view('gift/giftlist');
    }
    public function giftDetails() {
        $this->load->view('gift/giftdetails');
    }
    public function examList() {
        $this->load->view('exam/examlist');
    }
    public function examDetails() {
        
        $this->load->view('exam/examdetails');
    }
    public function examStart() {
        $this->load->view('exam/examstart');
    }
    public function editExam() {
        $this->load->view('exam/editexam');
    }
    public function logout(){
        $items['student_data'] = array('id'=>'');
        $this->session->unset_userdata('student_data');
        $this->session->unset_userdata('student_role');
        $this->session->unset_userdata('is_logged_in');
        redirect('studentlogin');
    }
   
}
