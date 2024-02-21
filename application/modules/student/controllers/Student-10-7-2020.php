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
    public function studentprofile() {
        $this->load->view('studentprofile');
    }
    public function logout(){
        $items['student_data'] = array('id'=>'');
        $this->session->unset_userdata('student_data');
        $this->session->unset_userdata('student_role');
        $this->session->unset_userdata('is_logged_in');
        redirect('studentlogin');
    }
   
}
