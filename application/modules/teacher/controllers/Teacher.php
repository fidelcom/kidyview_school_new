<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Teacher extends MX_Controller {

    public function __construct() {
        parent::__construct();
        if ($this->session->userdata('teacher_data')['id']=='') {
            redirect('teacherlogin');
         }
        $this->load->model('teacher_model');
    }
    
	public function index() {
        $data = array();
        $teacher_id=$this->session->userdata('teacher_data')['id'];
        $data['TEACHERDATA']=$this->teacher_model->getLoginTeacherDetails($teacher_id);
        $this->load->view('index', $data);
    }
    public function dashboard() {
        $this->load->view('dashboard');
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
    public function classboardList() {
        $this->load->view('classboard/classboardlist');
    }
    public function createClassboard() {
        $this->load->view('classboard/createclassboard');
    }
    public function editClassboard() {
        $this->load->view('classboard/editclassboard');
    }
    public function viewPost() {
        $this->load->view('classboard/viewpost');
    }
    public function assignmentList() {
        $this->load->view('assignment/assignmentlist');
    }
    public function editAssignment() {
        $this->load->view('assignment/editassignment');
    }
    public function assignmentView() {
        $this->load->view('assignment/assignmentdetail');
    }
    public function createAssignment() {
        $this->load->view('assignment/createassignment');
    }
    
    public function submittedAssignmentList() {
        $this->load->view('assignment/submittedassignmentlist');
    }

    public function submitedassignmentView() {
        $this->load->view('assignment/submitedassignmentdetail');
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
    public function profile() {
        $this->load->view('teacherprofile');
    }
    public function calendarList() {
        //echo "cxc";die;
        $this->load->view('calendar/calendarlist');
    }
    public function scheduleList() {
        $this->load->view('classschedule/schedulelist');
    }
    public function examList() {
        $this->load->view('exam/examlist');
    }
    public function examDetails() {
        $this->load->view('exam/examdetails');
    }
    public function submittedExamList() {
        $this->load->view('exam/submittedexamlist');
    }
    public function submittedExamDetails() {
        $this->load->view('exam/submittedexamdetails');
    }
    public function notificationList() {
        $this->load->view('notification/notification-list');
    }
    public function projectList() {
        $this->load->view('project/projectlist');
    }
    public function editProject() {
        $this->load->view('project/editproject');
    }
    public function projectView() {
        $this->load->view('project/projectdetail');
    }
    public function createProject() {
        $this->load->view('project/createproject');
    }
    
    public function submittedProjectList() {
        $this->load->view('project/submittedprojectlist');
    }

    public function submitedprojectView() {
        $this->load->view('project/submitedprojectdetail');
    }
    public function notificationSettings() {
        $this->load->view('setting/notification-settings');
    }
    public function result() {
        $this->load->view('result/result-list');
    }
    public function resultView() {
        $this->load->view('result/result-details');
    }
    public function logout(){
        $items['teacher_data'] = array('id'=>'');
        $this->session->unset_userdata('teacher_data');
        redirect('teacherlogin');
    }
    public function lessonnote() {
        $this->load->view('lessonnote');
    }
     public function editlessonnote() {
        $this->load->view('editlessonnote');
    }
     public function lessonnotelist() {
        $this->load->view('lessonnotelist');
    }
     public function sharedlessonlist() {
        $this->load->view('sharedlessonlist');
    }
     public function editsharedlesson() {
        $this->load->view('editsharedlesson');
    }
    public function viewsharednote() {
        $this->load->view('viewsharednote');
    }
    public function viewdnote() {
        $this->load->view('viewdnote');
    }
    
    
    
   
}
