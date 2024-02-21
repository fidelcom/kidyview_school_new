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
    public function logout(){
        $items['student_data'] = array('id'=>'');
        $this->session->unset_userdata('student_data');
        $this->session->unset_userdata('student_role');
        $this->session->unset_userdata('is_logged_in');
        redirect('studentlogin');
    }
   
}
