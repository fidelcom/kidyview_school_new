<?php  defined('BASEPATH') OR exit('No direct script access allowed');
	
	class TeacherLogin extends CI_Controller {
		
        public function __construct()
        {
			parent::__construct();
		
		}
		
		public function index($page = 'login')
		{
			$data['title'] = ucfirst($page); // Capitalize the first letter
			$this->load->model('teachers/Teacher_model','model');
			$data['loginImage']=$this->model->loginImage();
			$this->load->view("teacherLogin", $data);
		}
        
	
	}
