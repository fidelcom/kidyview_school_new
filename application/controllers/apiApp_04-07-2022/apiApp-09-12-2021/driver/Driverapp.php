<?php
	defined('BASEPATH') OR exit('No direct script access allowed');
	require APPPATH . '/libraries/REST_Controller.php';
	class Teacherapp extends REST_Controller {
		
		public $error = array();
		public $data = array();
		
		function __construct() {
			parent::__construct();
			$this->load->library("security");
			$this->load->library('form_validation');
			$this->load->model('teacherapp_model', 'teacherapp');
		}
		
		public function getclassListBySchoolId_get()
		{
			$schoolId = $this->input->get('schoolId');
			$classResult= $this->teacherapp->getclassListBySchoolId($schoolId);
			
			if(!empty($classResult))
			{
				$return['success'] 			= "true";
				$return['title'] 			= "success";
				$return['message'] 			= "Record found successfully.";
				$return['classData']		= $classResult;
				$return['error']			= $this->error;
				$this->response($return, REST_Controller::HTTP_OK);
			}
			$return['data']			= $this->data;
			$return['success'] 		= "false";
			$return['title'] 		= "error";
			$return['message'] 		= "No record found";
			$return['error']		= $this->error;
			$this->response($return, REST_Controller::HTTP_BAD_REQUEST);
		}
		
		public function getStudentListByClassId_get()
		{
			$classId = $this->input->get('classId');
			$studentResult= $this->teacherapp->getStudentListByClassId($classId);
			
			if(!empty($studentResult))
			{
				$return['success'] 			= "true";
				$return['title'] 			= "success";
				$return['message'] 			= "Record found successfully.";
				$return['studentData']		= $studentResult;
				$return['error']			= $this->error;
				$this->response($return, REST_Controller::HTTP_OK);
			}
			$return['data']			= $this->data;
			$return['success'] 		= "false";
			$return['title'] 		= "error";
			$return['message'] 		= "No record found";
			$return['error']		= $this->error;
			$this->response($return, REST_Controller::HTTP_BAD_REQUEST);
		}
		
		public function getEventById_get()
		{
			$eventId = $this->input->get('eventId');
			$eventResult= $this->teacherapp->getEventById($eventId);
			
			if(!empty($eventResult))
			{
				$return['success'] 			= "true";
				$return['title'] 			= "success";
				$return['message'] 			= "Record found successfully.";
				$return['eventData']		= $eventResult;
				$return['error']			= $this->error;
				$this->response($return, REST_Controller::HTTP_OK);
			}
			$return['data']			= $this->data;
			$return['success'] 		= "false";
			$return['title'] 		= "error";
			$return['message'] 		= "No record found";
			$return['error']		= $this->error;
			$this->response($return, REST_Controller::HTTP_BAD_REQUEST);
		}
		
		public function createevent_post()
	    {
			$postData = json_decode(file_get_contents('php://input'), true);
			if($postData == '')
			{
				$postData = $_POST;
			}
			$postData = $this->security->xss_clean($postData);
			$this->form_validation->set_data($postData);
			
			$this->form_validation->set_rules('class_id', 'Class', 'trim|required');
			$this->form_validation->set_rules('student_id', 'Student', 'trim|required');
			$this->form_validation->set_rules('event_title', 'Event title', 'trim|required');
			$this->form_validation->set_rules('location', 'Location', 'trim|required');
			$this->form_validation->set_rules('time', 'Time', 'trim|required');
			$this->form_validation->set_rules('date', 'Date', 'trim|required');
			
			if($this->form_validation->run() === false)
			{	
				$this->error 			= $this->form_validation->error_array();
				$message 				= validation_errors();
				$return['success'] 		= "false";
				$return['title'] 		= "error";
				$return['message'] 		= "$message";
				$return['error'] 		= $this->error;
				$return['data'] 		= (object)$this->data;
				$this->response($return, REST_Controller::HTTP_BAD_REQUEST);
			}
			$eventData=array();
			$eventData['school_id'] 	= $postData['school_id'];
			$eventData['teacher_id'] 	= $postData['teacher_id'];
			if($eventData['teacher_id']!='' && $eventData['school_id']=''){
			$eventData['class_id'] 		= $postData['class_id'];
			$eventData['child_id'] 		= $postData['student_id'];
			}
			$eventData['title'] 		= $postData['event_title'];
			$eventData['address'] 		= $postData['location'];
			$eventData['time'] 			= $postData['time'];
			$eventData['date'] 			= $postData['date'];
			$eventData['description'] 	= $postData['description'];
			
			$uploadPath = 'img/event/';
			$config['upload_path'] 	    = $uploadPath;
			$config['allowed_types'] 	='*';
			$config['max_size'] 		= 50000;
			$config['encrypt_name'] 	= TRUE;

			$this->load->library('upload', $config);
			$this->upload->initialize($config);
			if( !  empty($_FILES['pic']['name']) )
			{
			if ( ! $this->upload->do_upload('pic')){
			$uploaderror 			= $this->upload->display_errors();
			$return['success'] 		= "false";
			$return['message'] 		= $uploaderror;
			$return['error'] 		= $this->error;
			$return['data'] 		= $this->data;		
			$this->response($return, REST_Controller::HTTP_BAD_REQUEST);
			}else{
			$uplodimg 	= $this->upload->data();
			$eventData['pic'] 		= $uplodimg['file_name'];
			}
			}
			$result = $this->teacherapp->createEvent($eventData);
			if($result)
			{
				$this->data 			= $result;
				$return['success'] 		= "true";
				$return['title'] 		= "success";
				$return['message'] 		= "Event successfully created.";
				$return['error'] 		= (object)$this->error;
				$return['data'] 		= $this->data;
				
				$this->response($return, REST_Controller::HTTP_OK);
			}
			
			$return['success'] 		= "false";
			$return['title'] 		= "error";
			$return['message'] 		= "Event not created.";
			$return['error'] 		= (object)$this->error;
			$return['data'] 		= (object)$this->data;
			
			$this->response($return, REST_Controller::HTTP_BAD_REQUEST);
		}
		
		public function eventList_get()
		{
			$schoolId = $this->input->get('schoolId');
			$cresult = $this->teacherapp->getpasteventsList($schoolId);
			$cresult1 = $this->teacherapp->getupcomingeventsList($schoolId);
			if($cresult != '' || $cresult1 != '')
			{
				$return['success'] 			= "true";
				$return['title'] 			= "success";
				$return['message'] 			= "list get successfully";
				$return['pastEventdata']	= $cresult;
				$return['upcomingEventdata']= $cresult1;
				$return['error']			= $this->error;
				$this->response($return, REST_Controller::HTTP_OK);
			}
			
			$return['data']			= $this->data;
			$return['success'] 		= "false";
			$return['title'] 		= "error";
			$return['message'] 		= "Something went wrong.";
			$return['error']		= $this->error;
			$this->response($return, REST_Controller::HTTP_BAD_REQUEST);
		}
		
	
	}
