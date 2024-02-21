<?php
defined('BASEPATH') OR exit('No direct script access allowed');
require APPPATH . '/libraries/REST_Controller.php';

class Teacherapp extends REST_Controller {

    public $error = array();
    public $data = array();

    function __construct() {
        parent::__construct();
        $this->token->validate();
        $this->load->library("security");
        $this->load->library('form_validation');
        $this->load->model('teacherapp_model', 'teacherapp');
        $this->load->helper('common_helper');
    }

    public function getclassListBySchoolId_get() {
        $schoolId = $this->input->get('schoolId');
        $classResult = $this->teacherapp->getclassListBySchoolId($schoolId);

        if (!empty($classResult)) {
            $return['success'] = "true";
            $return['title'] = "success";
            $return['message'] = "Record found successfully.";
            $return['classData'] = $classResult;
            $return['error'] = $this->error;
            $this->response($return, REST_Controller::HTTP_OK);
        }
        $return['data'] = $this->data;
        $return['success'] = "false";
        $return['title'] = "error";
        $return['message'] = "No record found";
        $return['error'] = $this->error;
        $this->response($return, REST_Controller::HTTP_BAD_REQUEST);
    }

    public function getStudentListByClassId_get() {
        $classId = $this->input->get('classId');
        $studentResult = $this->teacherapp->getStudentListByClassId($classId);

        if (!empty($studentResult)) {
            $return['success'] = "true";
            $return['title'] = "success";
            $return['message'] = "Record found successfully.";
            $return['studentData'] = $studentResult;
            $return['error'] = $this->error;
            $this->response($return, REST_Controller::HTTP_OK);
        }
        else {
            $return['success'] = "true";
            $return['title'] = "success";
            $return['message'] = "No student in this class.";
            $return['studentData'] = array();
            $return['error'] = $this->error;
            $this->response($return, REST_Controller::HTTP_OK); 
        }        
    }
    public function studentList_get() {
        $classId = $this->input->get('classId');
        $studentResult = $this->teacherapp->studentList();

        if (!empty($studentResult)) {
            $return['success'] = "true";
            $return['title'] = "success";
            $return['message'] = "Record found successfully.";
            $return['studentData'] = $studentResult;
            $return['error'] = $this->error;
            $this->response($return, REST_Controller::HTTP_OK);
        }
        $return['data'] = $this->data;
        $return['success'] = "false";
        $return['title'] = "error";
        $return['message'] = "No record found";
        $return['error'] = $this->error;
        $this->response($return, REST_Controller::HTTP_BAD_REQUEST);
    }

    public function getEventById_get() {
        $eventId = $this->input->get('eventId');
        $eventResult = $this->teacherapp->getEventById($eventId);

        if (!empty($eventResult)) {
            $return['success'] = "true";
            $return['title'] = "success";
            $return['message'] = "Record found successfully.";
            $return['eventData'] = $eventResult;
            $return['error'] = $this->error;
            $this->response($return, REST_Controller::HTTP_OK);
        }
        $return['data'] = $this->data;
        $return['success'] = "false";
        $return['title'] = "error";
        $return['message'] = "No record found";
        $return['error'] = $this->error;
        $this->response($return, REST_Controller::HTTP_BAD_REQUEST);
    }

    public function viewTeacherProfileById_get() {
        $teacherId = $this->input->get('teacherId');
        $teacherResult = $this->teacherapp->viewTeacherProfileById($teacherId);
        $return['success'] = "true";
        $return['title'] = "success";
        $return['message'] = $teacherResult ? 'Record found successfully.' : "No record found.";
        $return['teacherData'] = $teacherResult ? $teacherResult : array();
        $return['error'] = $this->error;
        $this->response($return, REST_Controller::HTTP_OK);
    }

    public function articleList_get($schoolId = '', $user_id = '', $usertype = '') {
        $articleResult = $this->teacherapp->articleList($schoolId, $user_id, $usertype);
        $return['success'] = "true";
        $return['title'] = "success";
        $return['message'] = $articleResult ? 'Record found successfully.' : "No record found.";
        $return['articleData'] = $articleResult ? $articleResult : array();
        $return['error'] = $this->error;
        $this->response($return, REST_Controller::HTTP_OK);
    }

    public function viewArticleDetails_get() {
        $articleId = $this->input->get('articleId');
        $user_id = $this->token->user_id;
        $user_type = 'teacher';
        $articleResult = $this->teacherapp->viewArticleDetails($articleId, $user_id, $user_type);
        $return['success'] = "true";
        $return['title'] = "success";
        $return['message'] = $articleResult ? 'Record found successfully.' : "No record found.";
        $return['articleData'] = $articleResult ? $articleResult : array();
        $return['error'] = $this->error;
        $this->response($return, REST_Controller::HTTP_OK);
    }

    public function createevent_post() {
        $postData = json_decode(file_get_contents('php://input'), true);
        if ($postData == '') {
            $postData = $_POST;
        }
        //print_r($postData);die;
        $postData = $this->security->xss_clean($postData);
        $this->form_validation->set_error_delimiters('', '');
        $this->form_validation->set_data($postData);

        $this->form_validation->set_rules('class_id', 'Class', 'trim|required');
        $this->form_validation->set_rules('student_id[]', 'Student', 'trim|required|callback_student_check',array('student_check' => 'Please select student.'));
        $this->form_validation->set_rules('event_title', 'Event title', 'trim|required');
        $this->form_validation->set_rules('location', 'Location', 'trim|required');
        $this->form_validation->set_rules('time', 'Time', 'trim|required');
        $this->form_validation->set_rules('date', 'Date', 'trim|required');
        $this->form_validation->set_rules('teacher_id', 'teacher id', 'trim|required');

        if ($this->form_validation->run() === false) {
            $this->error = $this->form_validation->error_array();
            $message = validation_errors();
            $return['success'] = "false";
            $return['title'] = "error";
            $return['message'] = "$message";
            $return['error'] = $this->error;
            $return['data'] = (object) $this->data;
            $this->response($return, REST_Controller::HTTP_BAD_REQUEST);
        }
        $eventData = array();
        $eventData['school_id'] = $postData['school_id'];
        $eventData['teacher_id'] = $postData['teacher_id'];

        if ($eventData['teacher_id'] != '') {
            $eventData['class_id'] = $postData['class_id'];
            $eventData['child_id'] = implode(',', $postData['student_id']);
        }
        $eventData['title'] = $postData['event_title'];
        $eventData['address'] = $postData['location'];
        $eventData['time'] = $postData['time'];
        $eventData['date'] = $postData['date'];
        $eventData['description'] = $postData['description'];

        $uploadPath = 'img/event/';
        $config['upload_path'] = $uploadPath;
        $config['allowed_types'] = '*';
        $config['max_size'] = 50000;
        $config['encrypt_name'] = TRUE;

        $this->load->library('upload', $config);
        $this->upload->initialize($config);
        if (!empty($_FILES['pic']['name'])) {
            if (!$this->upload->do_upload('pic')) {
                $uploaderror = $this->upload->display_errors();
                $return['success'] = "false";
                $return['message'] = $uploaderror;
                $return['error'] = $this->error;
                $return['data'] = $this->data;
                $this->response($return, REST_Controller::HTTP_BAD_REQUEST);
            } else {
                $uplodimg = $this->upload->data();
                $eventData['pic'] = $uplodimg['file_name'];
            }
        }
        $result = $this->teacherapp->createEvent($eventData);
        if ($result) {
            $this->data = $result;
            $return['success'] = "true";
            $return['title'] = "success";
            $return['message'] = "Event successfully created.";
            $return['error'] = (object) $this->error;
            $return['data'] = $this->data;

            $this->response($return, REST_Controller::HTTP_OK);
        }

        $return['success'] = "false";
        $return['title'] = "error";
        $return['message'] = "Event not created.";
        $return['error'] = (object) $this->error;
        $return['data'] = (object) $this->data;

        $this->response($return, REST_Controller::HTTP_BAD_REQUEST);
    }
    
    public function student_check($arr)
    {
        if(empty($arr))
        {
            return false;
        }
        else
        {
            return true;
        }
    }

    public function updateevent_post() {
        $postData = json_decode(file_get_contents('php://input'), true);
        if ($postData == '') {
            $postData = $_POST;
        }
        $postData = $this->security->xss_clean($postData);
        $this->form_validation->set_error_delimiters('', '');
        $this->form_validation->set_data($postData);
        $this->form_validation->set_rules('event_id', 'Event Id', 'trim|required');
        $this->form_validation->set_rules('class_id', 'Class', 'trim|required');
        $this->form_validation->set_rules('student_id[]', 'Student', 'trim|required|callback_student_check',array('student_check' => 'Please select student.'));
        $this->form_validation->set_rules('event_title', 'Event title', 'trim|required');
        $this->form_validation->set_rules('location', 'Location', 'trim|required');
        $this->form_validation->set_rules('time', 'Time', 'trim|required');
        $this->form_validation->set_rules('date', 'Date', 'trim|required');
        $this->form_validation->set_rules('teacher_id', 'teacher id', 'trim|required');

        if ($this->form_validation->run() === false) {
            $this->error = $this->form_validation->error_array();
            $message = validation_errors();
            $return['success'] = "false";
            $return['title'] = "error";
            $return['message'] = "$message";
            $return['error'] = $this->error;
            $return['data'] = (object) $this->data;
            $this->response($return, REST_Controller::HTTP_BAD_REQUEST);
        }
        $eventData = array();
        $eventData['school_id'] = $postData['school_id'];
        $eventData['teacher_id'] = $postData['teacher_id'];
        if ($eventData['teacher_id'] != '') {
            $eventData['class_id'] = $postData['class_id'];
            $eventData['child_id'] = implode(',', $postData['student_id']);
        }
        $eventData['title'] = $postData['event_title'];
        $eventData['address'] = $postData['location'];
        $eventData['time'] = $postData['time'];
        $eventData['date'] = $postData['date'];
        $eventData['description'] = $postData['description'];

        $uploadPath = 'img/event/';
        $config['upload_path'] = $uploadPath;
        $config['allowed_types'] = '*';
        $config['max_size'] = 50000;
        $config['encrypt_name'] = TRUE;

        $this->load->library('upload', $config);
        $this->upload->initialize($config);
        if (!empty($_FILES['pic']['name'])) {
            if (!$this->upload->do_upload('pic')) {
                $uploaderror = $this->upload->display_errors();
                $return['success'] = "false";
                $return['message'] = $uploaderror;
                $return['error'] = $this->error;
                $return['data'] = $this->data;
                $this->response($return, REST_Controller::HTTP_BAD_REQUEST);
            } else {
                $uplodimg = $this->upload->data();
                $eventData['pic'] = $uplodimg['file_name'];
            }
        }
        $result = $this->teacherapp->updateEvent($eventData, $postData['event_id']);
        if ($result) {
            $this->data = $result;
            $return['success'] = "true";
            $return['title'] = "success";
            $return['message'] = "Event successfully updated.";
            $return['error'] = (object) $this->error;
            $return['data'] = $this->data;

            $this->response($return, REST_Controller::HTTP_OK);
        }

        $return['success'] = "false";
        $return['title'] = "error";
        $return['message'] = "Event not ypdated.";
        $return['error'] = (object) $this->error;
        $return['data'] = (object) $this->data;

        $this->response($return, REST_Controller::HTTP_BAD_REQUEST);
    }

    public function saveTeacherPersonalDetail_post() {
        $postData = json_decode(file_get_contents('php://input'), true);
        if ($postData == '') {
            $postData = $_POST;
        }
        $postData = $this->security->xss_clean($postData);
        $this->form_validation->set_data($postData);
        $this->form_validation->set_error_delimiters('', '');
        $this->form_validation->set_rules('teachermname', 'Middle Name', 'trim');
        $this->form_validation->set_rules('teachergender', 'Gender', 'trim|required');
        $this->form_validation->set_rules('teacheraddress', 'Address', 'trim|required');
        $this->form_validation->set_rules('tcity', 'Location', 'trim');
        $this->form_validation->set_rules('tstate', 'Time', 'trim');
        $this->form_validation->set_rules('tcountry', 'Date', 'trim');
        $this->form_validation->set_rules('tpincode', 'Date', 'trim');
        if ($postData['photoAlreadyExit'] == '') {
            $this->form_validation->set_rules('teacherphoto', 'Photo', 'trim|required');
        }

        $this->form_validation->set_rules('maritalStatus', 'Marital Status', 'trim|required');
        $this->form_validation->set_rules('spousename', 'Spouse Name', 'trim|required');
        $this->form_validation->set_rules('spousenumber', 'Spouse Number', 'trim|required');
        //$this->form_validation->set_rules('date_of_joining', 'Date Of Joining', 'trim|required');
        $this->form_validation->set_rules('bloodgroup', 'Blood Group', 'trim');
        $this->form_validation->set_rules('date_of_birth', 'Date Of Birth', 'trim|required');
        $this->form_validation->set_rules('religion', 'Religion', 'trim');
        //$this->form_validation->set_rules('schoolType[]', 'School Type', 'trim|required');
        //$this->form_validation->set_rules('assignclassteacher[]', 'Assign Teacher Class', 'trim|required');
        //$this->form_validation->set_rules('subjectteacher', 'Subject Teacher', 'trim');
        if (empty($_FILES['certificate']['name'])) {
            $this->form_validation->set_rules('certificate', 'Certificate', 'trim');
        }
        if ($postData['documentAlreadyExit'] == '') {
            $this->form_validation->set_rules('document', 'document', 'trim|required');
        }
        $this->form_validation->set_rules('schoolId', 'School Id', 'trim|required');
        if ($this->form_validation->run() === false) {
            $this->error = $this->form_validation->error_array();
            $message = validation_errors();
            $return['success'] = "false";
            $return['title'] = "error";
            $return['message'] = "$message";
            $return['error'] = $this->error;
            $return['data'] = (object) $this->data;
            $this->response($return, REST_Controller::HTTP_BAD_REQUEST);
        }
        $schoolType = '';
        if (!empty($postData['schoolType'])) {
            $schoolType = implode(',', $postData['schoolType']);
        }
        $assignclassteacher = '';
        if (!empty($postData['assignclassteacher'])) {
            $assignclassteacher = implode(',', $postData['assignclassteacher']);
        }
        $teacherData = array();
        $teacherData['teachermname'] = $postData['teachermname'];
        $teacherData['teachergender'] = $postData['teachergender'];
        $teacherData['teacheraddress'] = $postData['teacheraddress'];
        $teacherData['tcity'] = $postData['tcity'];
        $teacherData['tcountry'] = $postData['tcountry'];
        $eventData['tpincode'] = $postData['tpincode'];
        $teacherData['maritalStatus'] = $postData['maritalStatus'];
        $teacherData['spousename'] = $postData['spousename'];
        $teacherData['spousenumber'] = $postData['spousenumber'];
        //$teacherData['date_of_joining'] 	= $postData['date_of_joining'];
        $teacherData['bloodgroup'] = $postData['bloodgroup'];
        $teacherData['date_of_birth'] = $postData['date_of_birth'];
        $teacherData['religion'] = $postData['religion'];
        //$teacherData['schoolType'] 			= $schoolType;
        //$teacherData['subjectteacher'] 		= $postData['subjectteacher'];
        $teacherData['schoolId'] = $postData['schoolId'];
        //$teacherData['assignclassteacher'] 	= $assignclassteacher;

        /* teacher profile image */
        $uploadPath = 'img/teacher/';
        $config['upload_path'] = $uploadPath;
        $config['allowed_types'] = '*';
        $config['max_size'] = 50000;
        $config['encrypt_name'] = TRUE;

        $this->load->library('upload', $config);
        $this->upload->initialize($config);
        /* teacher profile image */
        if (!empty($_FILES['teacherphoto']['name'])) {
            if (!$this->upload->do_upload('teacherphoto')) {
                $uploaderror = $this->upload->display_errors();
                $return['success'] = "false";
                $return['message'] = $uploaderror;
                $return['error'] = $this->error;
                $return['data'] = $this->data;
                $this->response($return, REST_Controller::HTTP_BAD_REQUEST);
            } else {
                $uplodimg = $this->upload->data();
                $teacherData['teacherphoto'] = $uplodimg['file_name'];
            }
        }

        /* certificate profile image */
        if (!empty($_FILES['certificate']['name'])) {
            if (!$this->upload->do_upload('certificate')) {
                $uploaderror = $this->upload->display_errors();
                $return['success'] = "false";
                $return['message'] = $uploaderror;
                $return['error'] = $this->error;
                $return['data'] = $this->data;
                $this->response($return, REST_Controller::HTTP_BAD_REQUEST);
            } else {
                $uplodimg = $this->upload->data();
                $teacherData['certificate'] = $uplodimg['file_name'];
            }
        }

        /* certificate profile image */
        if (!empty($_FILES['document']['name'])) {
            if (!$this->upload->do_upload('document')) {
                $uploaderror = $this->upload->display_errors();
                $return['success'] = "false";
                $return['message'] = $uploaderror;
                $return['error'] = $this->error;
                $return['data'] = $this->data;
                $this->response($return, REST_Controller::HTTP_BAD_REQUEST);
            } else {
                $uplodimg = $this->upload->data();
                $teacherData['document'] = $uplodimg['file_name'];
            }
        }
        $result = $this->teacherapp->saveTeacherPersonalDetail($teacherData, $postData['teacherId']);
        if ($result) {
            $this->data = $result;
            $return['success'] = "true";
            $return['title'] = "success";
            $return['message'] = "Teacher successfully updated.";
            $return['error'] = (object) $this->error;
            $return['data'] = $this->data;

            $this->response($return, REST_Controller::HTTP_OK);
        }

        $return['success'] = "false";
        $return['title'] = "error";
        $return['message'] = "Teacher not updated.";
        $return['error'] = (object) $this->error;
        $return['data'] = (object) $this->data;

        $this->response($return, REST_Controller::HTTP_BAD_REQUEST);
    }

    public function saveTeacherProfessionalDetail_post() {
        $postData = json_decode(file_get_contents('php://input'), true);
        if ($postData == '') {
            $postData = $_POST;
        }
        $postData = $this->security->xss_clean($postData);
        $this->form_validation->set_data($postData);
        $this->form_validation->set_error_delimiters('', '');
        $this->form_validation->set_rules('date_of_joining', 'Date Of Joining', 'trim|required');
        $this->form_validation->set_rules('schoolType[]', 'School Type', 'trim|required');
        $this->form_validation->set_rules('assignclassteacher[]', 'Assign Teacher Class', 'trim|required');
        $this->form_validation->set_rules('subjectteacher', 'Subject Teacher', 'trim');
        $this->form_validation->set_rules('workexperience', 'Work Experience', 'trim|required');
        $this->form_validation->set_rules('schoolId', 'School Id', 'trim|required');
        $this->form_validation->set_rules('teacherId', 'Teacher Id', 'trim|required');
        if ($this->form_validation->run() === false) {
            $this->error = $this->form_validation->error_array();
            $message = validation_errors();
            $return['success'] = "false";
            $return['title'] = "error";
            $return['message'] = "$message";
            $return['error'] = $this->error;
            $return['data'] = (object) $this->data;
            $this->response($return, REST_Controller::HTTP_BAD_REQUEST);
        }
        $schoolType = '';
        $assignclassteacher = '';
        if (!empty($postData['schoolType'])) {
            $schoolType = implode(',', $postData['schoolType']);
        }
        if (!empty($postData['assignclassteacher'])) {
            $assignclassteacher = implode(',', $postData['assignclassteacher']);
        }
        $teacherData = array();
        $teacherData['date_of_joining'] = $postData['date_of_joining'];
        $teacherData['schoolType'] = $schoolType;
        $teacherData['subjectteacher'] = isset($postData['subjectteacher']) ? $postData['subjectteacher'] : '';
        $teacherData['schoolId'] = $postData['schoolId'];
        $teacherData['assignclassteacher'] = $assignclassteacher;
        $teacherData['workexperience'] = isset($postData['workexperience']) ? $postData['workexperience'] : '';
        $teacherId = isset($postData['teacherId']) ? $postData['teacherId'] : '';
        $result = $this->teacherapp->saveTeacherPersonalDetail($teacherData, $teacherId);
        if ($result) {
            $this->data = $result;
            $return['success'] = "true";
            $return['title'] = "success";
            $return['message'] = "Teacher details successfully updated.";
            $return['error'] = (object) $this->error;
            $return['data'] = $this->data;

            $this->response($return, REST_Controller::HTTP_OK);
        }
        $return['success'] = "false";
        $return['title'] = "error";
        $return['message'] = "Teacher details not updated.";
        $return['error'] = (object) $this->error;
        $return['data'] = (object) $this->data;
        $this->response($return, REST_Controller::HTTP_BAD_REQUEST);
    }

    public function saveTeacherProfessionalExperience_post() {
        $postData = json_decode(file_get_contents('php://input'), true);
        if ($postData == '') {
            $postData = $_POST;
        }
        $postData = $this->security->xss_clean($postData);
        $this->form_validation->set_data($postData);
        $this->form_validation->set_error_delimiters('', '');

        $workEeperdata['schoolname'] = $_POST['schoolname'];
        $workEeperdata['numberofyears'] = $_POST['numberofyears'];
        $workEeperdata['designation'] = $_POST['designation'];
        $workEeperdata['datefrom'] = $_POST['datefrom'];
        $workEeperdata['dateto'] = $_POST['dateto'];
        $workEeperdata['teacher_id'] = $postData['teacherId'];
        $workEeperdata['schoolId'] = $postData['schoolId'];
        $uploadPath = 'img/teacher/experience/';
        $config['upload_path'] = $uploadPath;
        $config['allowed_types'] = '*';
        $config['max_size'] = 50000;
        $config['encrypt_name'] = TRUE;
        $this->load->library('upload', $config);
        $this->upload->initialize($config);
        if (!empty($_FILES['employercertificate'])) {
            if ($this->upload->do_upload('employercertificate')) {
                $uplodimg = $this->upload->data();
                $workEeperdata['employercertificate'] = $uplodimg['file_name'];
            }
        }
        if ($_POST['id'] != '') {
            $result = $this->teacherapp->saveTeacherProfessionalDetail($workEeperdata, $_POST['id']);
        } else {
            $result = $this->teacherapp->addTeacherProfessionalData($workEeperdata);
        }

        if ($result) {
            $this->data = $result;
            $return['success'] = "true";
            $return['title'] = "success";
            $return['message'] = "Teacher successfully updated.";
            $return['error'] = (object) $this->error;
            $return['data'] = $this->data;

            $this->response($return, REST_Controller::HTTP_OK);
        }

        $return['success'] = "false";
        $return['title'] = "error";
        $return['message'] = "Teacher not updated.";
        $return['error'] = (object) $this->error;
        $return['data'] = (object) $this->data;

        $this->response($return, REST_Controller::HTTP_BAD_REQUEST);
    }

    public function saveTeacherProfessionalQulification_post() {
        $postData = json_decode(file_get_contents('php://input'), true);
        if ($postData == '') {
            $postData = $_POST;
        }
        $postData = $this->security->xss_clean($postData);
        $this->form_validation->set_data($postData);
        $this->form_validation->set_error_delimiters('', '');

        $qulificationData['qualification'] = $_POST['qualification'];
        $qulificationData['yearofpassing'] = $_POST['yearofpassing'];
        $qulificationData['percentage'] = $_POST['percentage'];
        $qulificationData['board'] = $_POST['board'];
        $qulificationData['teacher_id'] = $postData['teacherId'];
        $qulificationData['schoolId'] = $postData['schoolId'];
        $uploadPath = 'img/teacher/education/';
        $config['upload_path'] = $uploadPath;
        $config['allowed_types'] = '*';
        $config['max_size'] = 50000;
        $config['encrypt_name'] = TRUE;
        $this->load->library('upload', $config);
        $this->upload->initialize($config);
        if (!empty($_FILES['certificate'])) {
            if ($this->upload->do_upload('certificate')) {
                $uplodimg = $this->upload->data();
                $qulificationData['certificate'] = $uplodimg['file_name'];
            }
        }
        if ($_POST['id'] != '') {
            $result = $this->teacherapp->saveTeacherProfessionalExperienceDetail($qulificationData, $_POST['id']);
        } else {
            $result = $this->teacherapp->addTeacherProfessionalExperienceData($qulificationData);
        }

        if ($result) {
            $this->data = $result;
            $return['success'] = "true";
            $return['title'] = "success";
            $return['message'] = "Education successfully updated.";
            $return['error'] = (object) $this->error;
            $return['data'] = $this->data;

            $this->response($return, REST_Controller::HTTP_OK);
        }

        $return['success'] = "false";
        $return['title'] = "error";
        $return['message'] = "Education not updated.";
        $return['error'] = (object) $this->error;
        $return['data'] = (object) $this->data;

        $this->response($return, REST_Controller::HTTP_BAD_REQUEST);
    }

    public function eventList_get() {
        $schoolId = $this->input->get('schoolId');
        $cresult = $this->teacherapp->getpasteventsList($schoolId);
        $cresult1 = $this->teacherapp->getupcomingeventsList($schoolId);
        if ($cresult != '' || $cresult1 != '') {
            $return['success'] = "true";
            $return['title'] = "success";
            $return['message'] = "list get successfully";
            $return['pastEventdata'] = $cresult;
            $return['upcomingEventdata'] = $cresult1;
            $return['error'] = $this->error;
            $this->response($return, REST_Controller::HTTP_OK);
        }

        $return['data'] = $this->data;
        $return['success'] = "false";
        $return['title'] = "error";
        $return['message'] = "Something went wrong.";
        $return['error'] = $this->error;
        $this->response($return, REST_Controller::HTTP_BAD_REQUEST);
    }

    public function teacherGenderList_get() {
        $genderArray = array('Male', 'Female');

        if (!empty($genderArray)) {
            $return['success'] = "true";
            $return['title'] = "success";
            $return['message'] = "Gender List";
            $return['gender'] = $genderArray;
            $return['error'] = $this->error;
            $this->response($return, REST_Controller::HTTP_OK);
        }
        $return['data'] = $this->data;
        $return['success'] = "false";
        $return['title'] = "error";
        $return['message'] = "Something went wrong.";
        $return['error'] = $this->error;
        $this->response($return, REST_Controller::HTTP_BAD_REQUEST);
    }

    public function teacherMaritalStatus_get() {
        $maritalStatusArray = array('Single', 'Married', 'Divorced');
        if (!empty($maritalStatusArray)) {
            $return['success'] = "true";
            $return['title'] = "success";
            $return['message'] = "Marital List";
            $return['marital'] = $maritalStatusArray;
            $return['error'] = $this->error;
            $this->response($return, REST_Controller::HTTP_OK);
        }
        $return['data'] = $this->data;
        $return['success'] = "false";
        $return['title'] = "error";
        $return['message'] = "Something went wrong.";
        $return['error'] = $this->error;
        $this->response($return, REST_Controller::HTTP_BAD_REQUEST);
    }

    public function teacherBloodGroupList_get() {
        $getBloodgroupList = $this->teacherapp->getCommonList('bloodgroup');
        if (!empty($getBloodgroupList)) {
            $return['success'] = "true";
            $return['title'] = "success";
            $return['message'] = "Blood group List";
            $return['bloodgroup'] = $getBloodgroupList;
            $return['error'] = $this->error;
            $this->response($return, REST_Controller::HTTP_OK);
        }
        $return['data'] = $this->data;
        $return['success'] = "false";
        $return['title'] = "error";
        $return['message'] = "Something went wrong.";
        $return['error'] = $this->error;
        $this->response($return, REST_Controller::HTTP_BAD_REQUEST);
    }

    public function teacherSchoolTypeList_get() {
    	$schoolType =  $this->input->get('id');
    	
    	if(!isset($schoolType))
    	{
            //echo $schoolType;die;
	        $teacherSchoolTypeList = $this->teacherapp->getCommonList('schooltype');
	    
	        $return['success'] = "true";
            $return['title'] = "success";
            $return['message'] = "School Type List";
            $return['schoolType'] = $teacherSchoolTypeList;
            $return['error'] = $this->error;
            $this->response($return, REST_Controller::HTTP_OK);
    	}else{
	    	$getClassList = $this->teacherapp->getSchoolTypeClassList($schoolType);
	    
	        $return['success'] = "true";
            $return['title'] = "success";
            $return['message'] = !empty($getClassList) ? "Class List" : "No class found";
            $return['classList'] = !empty($getClassList) ? $getClassList : array();
            $return['error'] = $this->error;
            $this->response($return, REST_Controller::HTTP_OK);
    	}
        // $return['data'] = $this->data;
        // $return['success'] = "false";
        // $return['title'] = "error";
        // $return['message'] = "Something went wrong.";
        // $return['error'] = $this->error;
        // $this->response($return, REST_Controller::HTTP_BAD_REQUEST);
    }

    public function getClassList_get($schoolId) {
        $getClassList_get = $this->teacherapp->getClassList($schoolId, 'class');
        if (!empty($getClassList_get)) {
            $return['success'] = "true";
            $return['title'] = "success";
            $return['message'] = "Class List";
            $return['classList'] = $getClassList_get;
            $return['error'] = $this->error;
            $this->response($return, REST_Controller::HTTP_OK);
        }
        $return['data'] = $this->data;
        $return['success'] = "false";
        $return['title'] = "error";
        $return['message'] = "Something went wrong.";
        $return['error'] = $this->error;
        $this->response($return, REST_Controller::HTTP_BAD_REQUEST);
    }

    public function getSubjectList_get($schoolId) {
        $getSubjectList = $this->teacherapp->getSubjectList($schoolId, 'subjects');
        if (!empty($getSubjectList)) {
            $return['success'] = "true";
            $return['title'] = "success";
            $return['message'] = "Subject List";
            $return['subjectList'] = $getSubjectList;
            $return['error'] = $this->error;
            $this->response($return, REST_Controller::HTTP_OK);
        }
        $return['data'] = $this->data;
        $return['success'] = "false";
        $return['title'] = "error";
        $return['message'] = "Something went wrong.";
        $return['error'] = $this->error;
        $this->response($return, REST_Controller::HTTP_BAD_REQUEST);
    }

    public function insertarticlecomment_post() {
        $postData = json_decode(file_get_contents('php://input'), true);
        if ($postData == '') {
            $postData = $_POST;
        }
        $postData = $this->security->xss_clean($postData);
        $this->form_validation->set_error_delimiters('', '');
        $this->form_validation->set_data($postData);
        $this->form_validation->set_rules('comment', 'Comment', 'trim|required');
        $this->form_validation->set_rules('schoolId', 'School Id', 'trim|required');
        $this->form_validation->set_rules('article_id', 'Article Id', 'trim|required');
        $this->form_validation->set_rules('user_type', 'User Type', 'trim|required');
        $this->form_validation->set_rules('user_id', 'User Id', 'trim|required');

        if ($this->form_validation->run() === false) {
            $this->error = $this->form_validation->error_array();
            $message = validation_errors();
            $return['success'] = "false";
            $return['title'] = "error";
            $return['message'] = "$message";
            $return['error'] = $this->error;
            $return['data'] = (object) $this->data;
            $this->response($return, REST_Controller::HTTP_BAD_REQUEST);
        }
        $commentData = array();
        $commentData['schoolId'] = $postData['schoolId'];
        $commentData['article_id'] = $postData['article_id'];
        if ($postData['user_type'] == 'teacher') {
            $commentData['user_id'] = "T-" . $postData['user_id'];
        } elseif ($postData['user_type'] == 'parent') {
            $commentData['user_id'] = "P-" . $postData['user_id'];
        }
        $commentData['user_type'] = $postData['user_type'];
        $commentData['comment'] = $postData['comment'];
        $commentData['status'] = '1';
        $commentData['created_time'] = date("Y-m-d H:i:s");
        $result = $this->teacherapp->inserArticleComment($commentData);
        if ($result) {
            $this->data = $result;
            $return['success'] = "true";
            $return['title'] = "success";
            $return['message'] = "Comment successfully submitted.";
            $return['error'] = (object) $this->error;
            $return['data'] = $this->data;

            $this->response($return, REST_Controller::HTTP_OK);
        }

        $return['success'] = "false";
        $return['title'] = "error";
        $return['message'] = "Comment not submitted.";
        $return['error'] = (object) $this->error;
        $return['data'] = (object) $this->data;

        $this->response($return, REST_Controller::HTTP_BAD_REQUEST);
    }

    public function insertarticlelike_post() {
        $postData = json_decode(file_get_contents('php://input'), true);
        if ($postData == '') {
            $postData = $_POST;
        }
        $postData = $this->security->xss_clean($postData);
        $this->form_validation->set_error_delimiters('', '');
        $this->form_validation->set_data($postData);
        $this->form_validation->set_rules('schoolId', 'School Id', 'trim|required');
        $this->form_validation->set_rules('article_id', 'Article Id', 'trim|required');
        $this->form_validation->set_rules('user_type', 'User Type', 'trim|required');
        $this->form_validation->set_rules('user_id', 'User Id', 'trim|required');

        if ($this->form_validation->run() === false) {
            $this->error = $this->form_validation->error_array();
            $message = validation_errors();
            $return['success'] = "false";
            $return['title'] = "error";
            $return['message'] = "$message";
            $return['error'] = $this->error;
            $return['data'] = (object) $this->data;
            $this->response($return, REST_Controller::HTTP_BAD_REQUEST);
        }
        $likeData = array();
        $likeData['schoolId'] = $postData['schoolId'];
        $likeData['article_id'] = $postData['article_id'];
        $likeData['user_id'] = $postData['user_id'];
        /* if($postData['user_type']=='teacher'){
          $likeData['user_id'] 		= "T-".$postData['user_id'];
          }elseif($postData['user_type']=='parent'){
          $likeData['user_id'] 		= "P-".$postData['user_id'];
          } */
        $likeData['user_type'] = $postData['user_type'];
        $likeData['status'] = '1';

        $checkArticleLike = $this->teacherapp->isUserLike($likeData);
        if ($checkArticleLike > 0) {
            $this->teacherapp->deleteUserLike($likeData);
            $return['success'] = "true";
            $return['title'] = "success";
            $return['message'] = "Already like.";
            $return['error'] = (object) $this->error;
            $return['data'] = 0;
            $this->response($return, REST_Controller::HTTP_OK);
        }
        $result = $this->teacherapp->inserArticleLike($likeData);
        if ($result) {
            $this->data = $result;
            $return['success'] = "true";
            $return['title'] = "success";
            $return['message'] = "Like successfully submitted.";
            $return['error'] = (object) $this->error;
            $return['data'] = 1;
            $this->response($return, REST_Controller::HTTP_OK);
        }

        $return['success'] = "false";
        $return['title'] = "error";
        $return['message'] = "Like not submitted.";
        $return['error'] = (object) $this->error;
        $return['data'] = (object) $this->data;

        $this->response($return, REST_Controller::HTTP_BAD_REQUEST);
    }

    public function insertArticleViewUser_get($schoolId = '', $articleId = '', $user_id = '', $user_type = '') {
        $viewArr = array();
        $viewArr['article_id'] = $articleId;
        $viewArr['schoolId'] = $schoolId;
        $viewArr['user_id'] = $user_id;
        $viewArr['user_type'] = $user_type;
        $checkUserView = $this->teacherapp->isUserView($viewArr);
        if ($checkUserView == 0) {
            $view_insert = $this->teacherapp->insertArticleViewUser($viewArr);
            if ($view_insert) {
                $return['success'] = "true";
                $return['title'] = "success";
                $return['message'] = "View Added";
                $return['view'] = $view_insert;
                $return['error'] = $this->error;
                $this->response($return, REST_Controller::HTTP_OK);
            }
        } else {
            $return['success'] = "true";
            $return['title'] = "success";
            $return['message'] = "View already Added";
            $return['view'] = 0;
            $return['error'] = $this->error;
            $this->response($return, REST_Controller::HTTP_OK);
        }
        $return['data'] = $this->data;
        $return['success'] = "false";
        $return['title'] = "error";
        $return['message'] = "Something went wrong.";
        $return['error'] = $this->error;
        $this->response($return, REST_Controller::HTTP_BAD_REQUEST);
    }

    public function addAlbum_post() {

        $postData = json_decode(file_get_contents('php://input'), true);
        if ($postData == '') {
            $postData = $_POST;
        }
        
        $totalImageSize = 0;
        $maxalbumphotosize = 2000;
        $imageArray = array('image/jpg', 'image/jpeg', 'image/gif', 'image/png', 'image/JPEG', 'image/JPG');

        if (!empty($_FILES['albumphoto'])) {
            for ($i = 0; $i < count($_FILES['albumphoto']['name']); $i++) {
                if ($_FILES['albumphoto']['name'][$i] != '') {
                    $size = $_FILES['albumphoto']['size'][$i];
                    $type = $_FILES['albumphoto']['type'][$i];
                    /* if(!in_array($type,$imageArray)){
                      $this->error 			= $this->form_validation->error_array();
                      $message 				= validation_errors();
                      $return['success'] 		= "false";
                      $return['title'] 		= "error";
                      $return['message'] 		= "File size not supported.Please select valid type.";
                      $return['error'] 		= $this->error;
                      $this->response($return, REST_Controller::HTTP_BAD_REQUEST);
                      } */
                    $totalImageSize = $totalImageSize + $size;
                }
            }
            $totalalbumphotosize = $totalImageSize / (1024 * 1024);
            if ($totalalbumphotosize > $maxalbumphotosize) {
                $this->error = $this->form_validation->error_array();
                $message = validation_errors();
                $return['success'] = "false";
                $return['title'] = "error";
                $return['message'] = "File size not greater than 20MB.";
                $return['error'] = $this->error;
                $this->response($return, REST_Controller::HTTP_BAD_REQUEST);
            }
        }

        /* check video size */
        $totalVideoSize = 0;
        $maxalbumvideosize = 2000;
        $videoArray = array('video/mp4', 'video/MP4,video/3gp', 'video/3GP', 'video/mkv', 'video/MKV');
        if (!empty($_FILES['albumvideo'])) {
            for ($i = 0; $i < count($_FILES['albumvideo']['name']); $i++) {
                if ($_FILES['albumvideo']['name'][$i] != '') {
                    $videosize = $_FILES['albumvideo']['size'][$i];
                    $videotype = $_FILES['albumvideo']['type'][$i];
                    /* if(!in_array($videotype,$videoArray)){
                      $this->error 			= $this->form_validation->error_array();
                      $message 				= validation_errors();
                      $return['success'] 		= "false";
                      $return['title'] 		= "error";
                      $return['message'] 		= "File size not supported.Please select valid type.";
                      $return['error'] 		= $this->error;
                      $this->response($return, REST_Controller::HTTP_BAD_REQUEST);
                      } */
                    $totalVideoSize = $totalVideoSize + $videosize;
                }
            }
            $totalalbumvideosize = $totalVideoSize / (1024 * 1024);
            if ($totalalbumvideosize > $maxalbumvideosize) {
                $this->error = $this->form_validation->error_array();
                $message = validation_errors();
                $return['success'] = "false";
                $return['title'] = "error";
                $return['message'] = "File size not greater than 20MB.";
                $return['error'] = $this->error;
                $this->response($return, REST_Controller::HTTP_BAD_REQUEST);
            }
        }
        $postData = $this->security->xss_clean($postData);
        $this->form_validation->set_error_delimiters('', '');
        $this->form_validation->set_data($postData);
        $this->form_validation->set_rules('title', 'Title', 'trim|required');
        $this->form_validation->set_rules('description', 'Description', 'trim|required');
        $this->form_validation->set_rules('schoolId', 'School Id', 'required');
        $this->form_validation->set_rules('teacher_id', 'Teacher Id', 'required');

        if ($this->form_validation->run() === false) {
            $this->error = $this->form_validation->error_array();
            $message = validation_errors();
            $return['success'] = "false";
            $return['title'] = "error";
            $return['message'] = "$message";
            $return['error'] = $this->error;
            $return['data'] = (object) $this->data;
            $this->response($return, REST_Controller::HTTP_BAD_REQUEST);
        }
        $albumData = array();
        $albumData['title'] = $postData['title'];
        $albumData['description'] = $postData['description'];
        $albumData['schoolId'] = $postData['schoolId'];
        $albumData['teacher_id'] = $postData['teacher_id'];
        $albumData['status'] = 1;
        $albumData['created_at'] =  date('l, F dS Y');
        $arrPhoto = array();
        if (!empty($_FILES['albumphoto'])) {

            $uploadPath = 'img/album/';
            $config['upload_path'] = $uploadPath;
            $config['allowed_types'] = 'jpg|jpeg|gif|png';
            $config['max_size'] = 500000;
            $config['encrypt_name'] = TRUE;
            $this->load->library('upload', $config);
            $this->upload->initialize($config);
            for ($i = 0; $i < count($_FILES['albumphoto']['name']); $i++) {
                if ($_FILES['albumphoto']['name'][$i] != '') {
                    $_FILES['file']['name'] = $_FILES['albumphoto']['name'][$i];
                    $_FILES['file']['type'] = $_FILES['albumphoto']['type'][$i];
                    $_FILES['file']['tmp_name'] = $_FILES['albumphoto']['tmp_name'][$i];
                    $_FILES['file']['error'] = $_FILES['albumphoto']['error'][$i];
                    $_FILES['file']['size'] = $_FILES['albumphoto']['size'][$i];

                    if ($this->upload->do_upload('file')) {
                        $uplodimg = $this->upload->data();
                        $albumPhotoData = array();
                        $albumPhotoData['albumId'] = '';
                        $albumPhotoData['attachment'] = $uplodimg['file_name'];
                        ;
                        $albumPhotoData['attachment_type'] = "image";
                        $albumPhotoData['status'] = 1;
                        array_push($arrPhoto,$albumPhotoData);
                    } else {
                        $uploaderror = $this->upload->display_errors();
                        $return['success'] = "false";
                        $return['message'] = $uploaderror;
                        $return['error'] = $this->error;
                        $return['data'] = $this->data;
                        $this->response($return, REST_Controller::HTTP_BAD_REQUEST);
                    }
                }
            }
        }
        $arrVideo = array();
        if (!empty($_FILES['albumvideo'])) {
            $uploadPath = 'img/album/';
            $config['upload_path'] = $uploadPath;
            $config['allowed_types'] = 'mp4|MP4|3gp|3GP|mkv|MKV||MOV|mov|mpeg|MPEG';
            $config['max_size'] = 500000;
            $config['encrypt_name'] = TRUE;
            $this->load->library('upload', $config);
            $this->upload->initialize($config);
            for ($i = 0; $i < count($_FILES['albumvideo']['name']); $i++) {
                if ($_FILES['albumvideo']['name'][$i] != '') {
                    $_FILES['video']['name'] = $_FILES['albumvideo']['name'][$i];
                    $_FILES['video']['type'] = $_FILES['albumvideo']['type'][$i];
                    $_FILES['video']['tmp_name'] = $_FILES['albumvideo']['tmp_name'][$i];
                    $_FILES['video']['error'] = $_FILES['albumvideo']['error'][$i];
                    $_FILES['video']['size'] = $_FILES['albumvideo']['size'][$i];
                    if ($this->upload->do_upload('video')) {
                        $uplodimg = $this->upload->data();
                        $albumVideoData = array();
                        $albumVideoData['albumId'] = '';
                        $albumVideoData['attachment'] = $uplodimg['file_name'];
                        ;
                        $albumVideoData['attachment_type'] = "video";
                        $albumVideoData['status'] = 1;
                        array_push($arrVideo,$albumVideoData);
                    }
                    else {
                        $uploaderror = $this->upload->display_errors();
                        $return['success'] = "false";
                        $return['message'] = $uploaderror;
                        $return['error'] = $this->error;
                        $return['data'] = $this->data;
                        $this->response($return, REST_Controller::HTTP_BAD_REQUEST);
                    }
                }
            }
        }
        
        $albumId = $this->teacherapp->addNewAlbum($albumData, 'album');
        $this->data = $albumId;
        if ($albumId) {
            if (!empty($arrPhoto)) {
                foreach ($arrPhoto as $photoData)
                {
                    $photoData['albumId'] = $albumId;
                    $this->teacherapp->addAlbum($photoData, 'album_attachment');
                }
            }
            if (!empty($arrVideo)) {
                foreach ($arrVideo as $videoData)
                {
                    $videoData['albumId'] = $albumId;
                    $this->teacherapp->addAlbum($videoData, 'album_attachment');
                }
            }

            $return['success'] = "true";
            $return['title'] = "success";
            $return['message'] = "Album added successfully.";
            $return['error'] = (object) $this->error;
            $return['data'] = $this->data;
            $this->response($return, REST_Controller::HTTP_OK);
        }
        $return['success'] = "false";
        $return['title'] = "error";
        $return['message'] = "Album not added.";
        $return['error'] = (object) $this->error;
        $return['data'] = (object) $this->data;

        $this->response($return, REST_Controller::HTTP_BAD_REQUEST);
    }

    public function getAlbumDataList_get($school_id = '', $teacher_id = '') {
        $albumData = $this->teacherapp->getAlbumDataList($school_id, $teacher_id);

        $return['success'] = "true";
        $return['title'] = "success";
        $return['message'] = $albumData ? "Album List" : "No album list yet";
        $return['albumList'] = $albumData;
        $return['error'] = $this->error;
        $this->response($return, REST_Controller::HTTP_OK);
    }

    public function getAttachmentByAlbumId_get($album_id = '', $userType = 'teacher', $userId = '') {
        if($userId == '')
        {
            $userId = $this->token->user_id;
        }
        $albumDetailData = $this->teacherapp->getAttachmentByAlbumId($album_id, $userType, $userId);
        $return['success'] = "true";
        $return['title'] = "success";
        $return['message'] = $albumDetailData ? "Album Detail" : "No album list yet";
        $return['albumList'] = $albumDetailData;
        $return['error'] = $this->error;
        $this->response($return, REST_Controller::HTTP_OK);
    }

    public function updateAlbumData_post() {
        $postData = json_decode(file_get_contents('php://input'), true);
        if ($postData == '') {
            $postData = $_POST;
        }
        $postData = $this->security->xss_clean($postData);
        $this->form_validation->set_error_delimiters('', '');
        $this->form_validation->set_data($postData);

        $this->form_validation->set_rules('id', 'Album Id', 'trim|required');
        $this->form_validation->set_rules('title', 'Title', 'trim|required');
        $this->form_validation->set_rules('description', 'Description', 'trim|required');

        if ($this->form_validation->run() === false) {
            $this->error = $this->form_validation->error_array();
            $message = validation_errors();
            $return['success'] = "false";
            $return['title'] = "error";
            $return['message'] = "$message";
            $return['error'] = $this->error;
            $return['data'] = (object) $this->data;
            $this->response($return, REST_Controller::HTTP_BAD_REQUEST);
        }
        $albumData = array();
        $albumId = $postData['id'];
        $albumData['title'] = $postData['title'];
        $albumData['description'] = $postData['description'];
        $result = $this->teacherapp->updateAlbumData($albumData, $albumId);
        if ($result) {
            $this->data = $result;
            $return['success'] = "true";
            $return['title'] = "success";
            $return['message'] = "Album successfully updated.";
            $return['error'] = (object) $this->error;
            $return['data'] = $this->data;
            $this->response($return, REST_Controller::HTTP_OK);
        }
        $return['success'] = "false";
        $return['title'] = "error";
        $return['message'] = "Album not updated.";
        $return['error'] = (object) $this->error;
        $return['data'] = (object) $this->data;
        $this->response($return, REST_Controller::HTTP_BAD_REQUEST);
    }

    public function deleteAttachmentById_get($attachment_id = '', $attachment_name = '') {
        $deleteData = $this->teacherapp->deleteAttachmentById($attachment_id);
        if ($deleteData) {
            $uploadPath = 'img/album/';
            $file = $uploadPath . $attachment_name;
            if (is_file($file)) {
                unlink($file);
            }
            $return['success'] = "true";
            $return['title'] = "success";
            $return['message'] = "Delete attachment Successfully.";
            $return['albumList'] = $deleteData;
            $return['error'] = $this->error;
            $this->response($return, REST_Controller::HTTP_OK);
        }
        $return['success'] = "false";
        $return['title'] = "error";
        $return['message'] = "Something wrong.";
        $return['error'] = (object) $this->error;
        $return['data'] = (object) $this->data;
        $this->response($return, REST_Controller::HTTP_BAD_REQUEST);
    }

    public function deleteAttachmentByName_get($attachment_name = '') {
        $uploadPath = 'img/album/';
        $file = $uploadPath . $attachment_name;
        if (is_file($file)) {
            unlink($file);
            $return['success'] = "true";
            $return['title'] = "success";
            $return['message'] = "Delete attachment successfully.";
            $return['error'] = $this->error;
            $this->response($return, REST_Controller::HTTP_OK);
        } else {
            $return['success'] = "false";
            $return['title'] = "error";
            $return['message'] = "Attachment not exist.";
            $return['error'] = (object) $this->error;
            $return['data'] = (object) $this->data;
            $this->response($return, REST_Controller::HTTP_BAD_REQUEST);
        }
    }

    public function addAttachmentByAlbumId_post() {
        $postData = json_decode(file_get_contents('php://input'), true);
        if ($postData == '') {
            $postData = $_POST;
        }
        $postData = $this->security->xss_clean($postData);
        $this->form_validation->set_error_delimiters('', '');
        $this->form_validation->set_data($postData);
        $this->form_validation->set_rules('albumId', 'Album Id', 'trim|required');

        if ($this->form_validation->run() === false) {
            $this->error = $this->form_validation->error_array();
            $message = validation_errors();
            $return['success'] = "false";
            $return['title'] = "error";
            $return['message'] = "$message";
            $return['error'] = $this->error;
            $return['data'] = (object) $this->data;
            $this->response($return, REST_Controller::HTTP_BAD_REQUEST);
        }
        $totalImageSize = 0;
        $maxalbumphotosize = 20;
        $imageArray = array('image/jpg', 'image/jpeg', 'image/gif', 'image/png');
        if (!empty($_FILES['albumphoto'])) {
            for ($i = 0; $i < count($_FILES['albumphoto']['name']); $i++) {
                if ($_FILES['albumphoto']['name'][$i] != '') {
                    $size = $_FILES['albumphoto']['size'][$i];
                    $type = $_FILES['albumphoto']['type'][$i];
                    /* if(!in_array($type,$imageArray)){
                      $this->error 			= $this->form_validation->error_array();
                      $message 				= validation_errors();
                      $return['success'] 		= "false";
                      $return['title'] 		= "error";
                      $return['message'] 		= "File size not supported.Please select valid type.";
                      $return['error'] 		= $this->error;
                      $this->response($return, REST_Controller::HTTP_BAD_REQUEST);
                      } */
                    $totalImageSize = $totalImageSize + $size;
                }
            }

            $totalalbumphotosize = $totalImageSize / (1024 * 1024);
            if ($totalalbumphotosize > $maxalbumphotosize) {
                $this->error = $this->form_validation->error_array();
                $message = validation_errors();
                $return['success'] = "false";
                $return['title'] = "error";
                $return['message'] = "File size not greater than 20MB.";
                $return['error'] = $this->error;
                $this->response($return, REST_Controller::HTTP_BAD_REQUEST);
            }
        }
        /* check video size */
        $totalVideoSize = 0;
        $maxalbumvideosize = 20;
        $videoArray = array('video/mp4', 'video/MP4,video/3gp', 'video/3GP', 'video/mkv', 'video/MKV');
        if (!empty($_FILES['albumvideo'])) {
            for ($i = 0; $i < count($_FILES['albumvideo']['name']); $i++) {
                if ($_FILES['albumvideo']['name'][$i] != '') {
                    $videosize = $_FILES['albumvideo']['size'][$i];
                    $videotype = $_FILES['albumvideo']['type'][$i];
                    /* if(!in_array($videotype,$videoArray)){
                      $this->error 			= $this->form_validation->error_array();
                      $message 				= validation_errors();
                      $return['success'] 		= "false";
                      $return['title'] 		= "error";
                      $return['message'] 		= "File size not supported.Please select valid type.";
                      $return['error'] 		= $this->error;
                      $this->response($return, REST_Controller::HTTP_BAD_REQUEST);
                      } */
                    $totalVideoSize = $totalVideoSize + $videosize;
                }
            }
            $totalalbumvideosize = $totalVideoSize / (1024 * 1024);
            if ($totalalbumvideosize > $maxalbumvideosize) {
                $this->error = $this->form_validation->error_array();
                $message = validation_errors();
                $return['success'] = "false";
                $return['title'] = "error";
                $return['message'] = "File size not greater than 20MB.";
                $return['error'] = $this->error;
                $this->response($return, REST_Controller::HTTP_BAD_REQUEST);
            }
        }
        if ($totalImageSize == 0 AND $totalVideoSize == 0) {
            $this->error = $this->form_validation->error_array();
            $message = validation_errors();
            $return['success'] = "false";
            $return['title'] = "error";
            $return['message'] = "Atleast one photo or one video is required.";
            $return['error'] = $this->error;
            $return['data'] = (object) $this->data;
            $this->response($return, REST_Controller::HTTP_BAD_REQUEST);
        }
        $this->data = $postData['albumId'];
        if ($postData['albumId'] != '') {
            if (!empty($_FILES['albumphoto'])) {

                $uploadPath = 'img/album/';
                $config['upload_path'] = $uploadPath;
                $config['allowed_types'] = 'jpg|jpeg|gif|png';
                $config['max_size'] = 50000;
                $config['encrypt_name'] = TRUE;
                $this->load->library('upload', $config);
                $this->upload->initialize($config);
                for ($i = 0; $i < count($_FILES['albumphoto']['name']); $i++) {
                    if ($_FILES['albumphoto']['name'][$i] != '') {
                        $_FILES['file']['name'] = $_FILES['albumphoto']['name'][$i];
                        $_FILES['file']['type'] = $_FILES['albumphoto']['type'][$i];
                        $_FILES['file']['tmp_name'] = $_FILES['albumphoto']['tmp_name'][$i];
                        $_FILES['file']['error'] = $_FILES['albumphoto']['error'][$i];
                        $_FILES['file']['size'] = $_FILES['albumphoto']['size'][$i];
                        if ($this->upload->do_upload('file')) {
                            $uplodimg = $this->upload->data();
                            $albumPhotoData = array();
                            $albumPhotoData['albumId'] = $postData['albumId'];
                            $albumPhotoData['attachment'] = $uplodimg['file_name'];
                            ;
                            $albumPhotoData['attachment_type'] = "image";
                            $albumPhotoData['status'] = 1;
                            $albumPhotoId = $this->teacherapp->addAlbum($albumPhotoData, 'album_attachment');
                        } else {
                            $uploaderror = $this->upload->display_errors();
                            $return['success'] = "false";
                            $return['message'] = $uploaderror;
                            $return['error'] = $this->error;
                            $return['data'] = $this->data;
                            $this->response($return, REST_Controller::HTTP_BAD_REQUEST);
                        }
                    }
                }
            }
            if (!empty($_FILES['albumvideo'])) {
                $uploadPath = 'img/album/';
                $config['upload_path'] = $uploadPath;
                $config['allowed_types'] = 'mp4|MP4|3gp|3GP|mkv|MKV||MOV|mov|mpeg|MPEG';
                $config['max_size'] = 500000;
                $config['encrypt_name'] = TRUE;
                $this->load->library('upload', $config);
                $this->upload->initialize($config);
                for ($i = 0; $i < count($_FILES['albumvideo']['name']); $i++) {
                    if ($_FILES['albumvideo']['name'][$i] != '') {
                        $_FILES['video']['name'] = $_FILES['albumvideo']['name'][$i];
                        $_FILES['video']['type'] = $_FILES['albumvideo']['type'][$i];
                        $_FILES['video']['tmp_name'] = $_FILES['albumvideo']['tmp_name'][$i];
                        $_FILES['video']['error'] = $_FILES['albumvideo']['error'][$i];
                        $_FILES['video']['size'] = $_FILES['albumvideo']['size'][$i];
                        if ($this->upload->do_upload('video')) {
                            $uplodimg = $this->upload->data();
                            $albumVideoData = array();
                            $albumVideoData['albumId'] = $postData['albumId'];
                            $albumVideoData['attachment'] = $uplodimg['file_name'];
                            ;
                            $albumVideoData['attachment_type'] = "video";
                            $albumVideoData['status'] = 1;
                            $albumVideoId = $this->teacherapp->addAlbum($albumVideoData, 'album_attachment');
                        }
                    }
                }
            }

            $return['success'] = "true";
            $return['title'] = "success";
            $return['message'] = "Album added successfully.";
            $return['error'] = (object) $this->error;
            $return['data'] = $this->data;
            $this->response($return, REST_Controller::HTTP_OK);
        }
        $return['success'] = "false";
        $return['title'] = "error";
        $return['message'] = "Album not added.";
        $return['error'] = (object) $this->error;
        $return['data'] = (object) $this->data;

        $this->response($return, REST_Controller::HTTP_BAD_REQUEST);
    }

    public function deleteEventById_get($event_id = '', $image = '') {
        $deleteData = $this->teacherapp->deleteEventById($event_id);
        if ($deleteData) {
            if ($image != '') {
                $uploadPath = 'img/event/';
                $file = $uploadPath . $image;
                if (is_file($file)) {
                    unlink($file);
                }
            }
            $return['success'] = "true";
            $return['title'] = "success";
            $return['message'] = "Delete image Successfully.";
            $return['albumList'] = $deleteData;
            $return['error'] = $this->error;
            $this->response($return, REST_Controller::HTTP_OK);
        }
        $return['success'] = "false";
        $return['title'] = "error";
        $return['message'] = "Something wrong.";
        $return['error'] = (object) $this->error;
        $return['data'] = (object) $this->data;
        $this->response($return, REST_Controller::HTTP_BAD_REQUEST);
    }

    public function getThoughtOfTheDay_get($school_id = '', $teacher_id = '') {
        $albumData=array();
        $albumData = $this->teacherapp->getThoughtOfTheDay($school_id, $parent_id = '');
        $schoolData = $this->teacherapp->getSchool($school_id);
        if(!empty($schoolData)){
        $albumData['school_name']=$schoolData['school_name'];
        $albumData['school_pic']=$schoolData['school_pic'];
        }
        //echo $schoolData->school_name;die;
        $return['success'] = "true";
        $return['title'] = "success";
        $return['message'] = $albumData ? "List" : "No list yet";
        $return['albumList'] = $albumData;
        $return['error'] = $this->error;
        $this->response($return, REST_Controller::HTTP_OK);
    }

    public function insertalbumcomment_post() {
        $postData = json_decode(file_get_contents('php://input'), true);
        if ($postData == '') {
            $postData = $_POST;
        }

        $postData = $this->security->xss_clean($postData);
        $this->form_validation->set_error_delimiters('', '');
        $this->form_validation->set_data($postData);
        $this->form_validation->set_rules('album_id', 'Album Id', 'trim|required');
        $this->form_validation->set_rules('attachment_id', 'Attachment Id', 'trim|required');
        $this->form_validation->set_rules('schoolId', 'School Id', 'trim|required');
        $this->form_validation->set_rules('user_id', 'User Id', 'trim|required');
        $this->form_validation->set_rules('user_type', 'User Type', 'trim|required');
        $this->form_validation->set_rules('comment', 'Comment', 'trim|required');

        if ($this->form_validation->run() === false) {
            $this->error = $this->form_validation->error_array();
            $message = validation_errors();
            $return['success'] = "false";
            $return['title'] = "error";
            $return['message'] = "$message";
            $return['error'] = $this->error;
            $return['data'] = (object) $this->data;
            $this->response($return, REST_Controller::HTTP_BAD_REQUEST);
        }
        $commentData = array();
        $commentData['album_id'] = $postData['album_id'];
        $commentData['attachment_id'] = $postData['attachment_id'];
        $commentData['schoolId'] = $postData['schoolId'];
        if ($postData['user_type'] == 'teacher') {
            $commentData['user_id'] = "T-" . $postData['user_id'];
        } elseif ($postData['user_type'] == 'parent') {
            $commentData['user_id'] = "P-" . $postData['user_id'];
        }
        $commentData['user_type'] = $postData['user_type'];
        $commentData['comment'] = $postData['comment'];
        $commentData['status'] = '1';
        $commentData['created_time'] = date("Y-m-d H:i:s");
        $result = $this->teacherapp->insertAlbumComment($commentData);
        if ($result) {
            $this->data = $result;
            $return['success'] = "true";
            $return['title'] = "success";
            $return['message'] = "Comment successfully submitted.";
            $return['error'] = (object) $this->error;
            $return['data'] = $this->data;

            $this->response($return, REST_Controller::HTTP_OK);
        }

        $return['success'] = "false";
        $return['title'] = "error";
        $return['message'] = "Comment not submitted.";
        $return['error'] = (object) $this->error;
        $return['data'] = (object) $this->data;

        $this->response($return, REST_Controller::HTTP_BAD_REQUEST);
    }

    public function insertalbumlike_post() {
        $postData = json_decode(file_get_contents('php://input'), true);
        if ($postData == '') {
            $postData = $_POST;
        }
        $postData = $this->security->xss_clean($postData);
        $this->form_validation->set_error_delimiters('', '');
        $this->form_validation->set_data($postData);
        $this->form_validation->set_rules('album_id', 'Album Id', 'trim|required');
        $this->form_validation->set_rules('attachment_id', 'Attachment Id', 'trim|required');
        $this->form_validation->set_rules('schoolId', 'School Id', 'trim|required');
        $this->form_validation->set_rules('user_id', 'User Id', 'trim|required');
        $this->form_validation->set_rules('user_type', 'User Type', 'trim|required');

        if ($this->form_validation->run() === false) {
            $this->error = $this->form_validation->error_array();
            $message = validation_errors();
            $return['success'] = "false";
            $return['title'] = "error";
            $return['message'] = "$message";
            $return['error'] = $this->error;
            $return['data'] = (object) $this->data;
            $this->response($return, REST_Controller::HTTP_BAD_REQUEST);
        }
        $commentData = array();
        $commentData['album_id'] = $postData['album_id'];
        $commentData['attachment_id'] = $postData['attachment_id'];
        $commentData['schoolId'] = $postData['schoolId'];
        if ($postData['user_type'] == 'teacher') {
            $commentData['user_id'] = "T-" . $postData['user_id'];
        } elseif ($postData['user_type'] == 'parent') {
            $commentData['user_id'] = "P-" . $postData['user_id'];
        }
        $commentData['user_type'] = $postData['user_type'];
        $commentData['status'] = '1';

        /* echo "<pre>";
          print_r($commentData);
          echo "</pre>"; exit; */
        $checkArticleLike = $this->teacherapp->isAlbumUserLike($commentData);
        if ($checkArticleLike > 0) {
            $this->teacherapp->deleteAlbumUserLike($commentData);
            $return['success'] = "true";
            $return['title'] = "success";
            $return['message'] = "Already like.";
            $return['error'] = (object) $this->error;
            $return['data'] = 0;
            $this->response($return, REST_Controller::HTTP_OK);
        }
        $result = $this->teacherapp->insertAlbumLike($commentData);
        if ($result) {
            $this->data = $result;
            $return['success'] = "true";
            $return['title'] = "success";
            $return['message'] = "Successfull";
            $return['error'] = (object) $this->error;
            $return['data'] = $this->data;

            $this->response($return, REST_Controller::HTTP_OK);
        }

        $return['success'] = "false";
        $return['title'] = "error";
        $return['message'] = "Not successfull";
        $return['error'] = (object) $this->error;
        $return['data'] = (object) $this->data;

        $this->response($return, REST_Controller::HTTP_BAD_REQUEST);
    }

    public function contactforms_post() {
        $postData = json_decode(file_get_contents('php://input'), true);
        if ($postData == '') {
            $postData = $_POST;
        }

        $postData = $this->security->xss_clean($postData);
        $this->form_validation->set_error_delimiters('', '');
        $this->form_validation->set_data($postData);
        $this->form_validation->set_rules('first_name', 'First Name', 'trim|required');
        $this->form_validation->set_rules('organization', 'Organization', 'trim|required');
        $this->form_validation->set_rules('phone', 'Phone', 'trim|required|min_length[10]|numeric');
        $this->form_validation->set_rules('email', 'Email', 'trim|required|valid_email');
        $this->form_validation->set_rules('message', 'Message', 'trim|required');
        $this->form_validation->set_rules('user_id', 'User Id', 'trim|required');
        $this->form_validation->set_rules('user_type', 'User Type', 'trim|required');

        if ($this->form_validation->run() === false) {
            $this->error = $this->form_validation->error_array();
            $message = validation_errors();
            $return['success'] = "false";
            $return['title'] = "error";
            $return['message'] = "$message";
            $return['error'] = $this->error;
            $return['data'] = (object) $this->data;
            $this->response($return, REST_Controller::HTTP_BAD_REQUEST);
        }
        $commentData = array();
        $commentData['first_name'] = $postData['first_name'];
        $commentData['last_name'] = (!empty($postData['last_name'])) ? $postData['last_name'] : '';

        $commentData['organization'] = $postData['organization'];
        $commentData['phone'] = $postData['phone'];
        $commentData['email'] = $postData['email'];

        $commentData['employee_strength'] = (!empty($postData['employee_strength'])) ? $postData['employee_strength'] : '';
        $commentData['owner'] = (!empty($postData['owner'])) ? $postData['owner'] : '';

        $commentData['message'] = $postData['message'];
        if ($postData['user_type'] == 'teacher') {
            $commentData['user_id'] = "T-" . $postData['user_id'];
        } elseif ($postData['user_type'] == 'parent') {
            $commentData['user_id'] = "P-" . $postData['user_id'];
        }
        $commentData['user_type'] = $postData['user_type'];

        $adminEmail = getAdminEmail()->email;

        $viewDataArr = array(
            'fname' => $commentData['first_name'],
            'lname' => $commentData['last_name'],
            'organization' => $commentData['organization'],
            'phone' => $commentData['phone'],
            'email' => $commentData['email'],
            'emp_strength' => $commentData['employee_strength'],
            'owner' => $commentData['owner'],
            'message' => $commentData['message']
        );
        $viewData = $this->load->view('contactTemplate', $viewDataArr, true);
        $mailData = array(
            'subject' => 'Enquiry Form Submitted',
            'to' => $adminEmail,
            'from' => $postData['email'],
            'message' => $viewData
        );

        $result = $this->teacherapp->insertTeacherContact($commentData);
        if ($result) {
            $mail = send_email($mailData);
            if ($mail) {
                $this->data = $result;
                $return['success'] = "true";
                $return['title'] = "success";
                $return['message'] = "Your contact has been submitted successfully and we will get you soon.";
                $return['error'] = (object) $this->error;
                $return['data'] = $this->data;

                $this->response($return, REST_Controller::HTTP_OK);
            }
        }

        $return['success'] = "false";
        $return['title'] = "error";
        $return['message'] = "Sorry! Something went wrong, please try again.";
        $return['error'] = (object) $this->error;
        $return['data'] = (object) $this->data;

        $this->response($return, REST_Controller::HTTP_BAD_REQUEST);
    }

    public function getAlbumCommentById_get($albumId = '', $attachId = '', $schoolId = '', $userid = '', $userType = '') {
        $albumId = $this->input->get('albumId');
        $attachId = $this->input->get('attachId');
        $userid = $this->input->get('userid');
        $userType = $this->input->get('userType');
        $schoolId = $this->input->get('schoolId');
        $getAttachmentDetail = $this->teacherapp->getAttachmentDetail($albumId, $attachId, $schoolId, $userid, $userType);
        $getComments = $this->teacherapp->getAttachmentComments($albumId, $attachId);

        if ($getAttachmentDetail) {
            $return['success'] = "true";
            $return['title'] = "success";
            $return['message'] = "Success";
            $return['attachmentData'] = $getAttachmentDetail;
            $return['albumComment'] = $getComments;
            $return['error'] = $this->error;
            $this->response($return, REST_Controller::HTTP_OK);
        }
        $return['success'] = "false";
        $return['title'] = "error";
        $return['message'] = "Failure";
        $return['error'] = (object) $this->error;
        $return['data'] = (object) $this->data;
        $this->response($return, REST_Controller::HTTP_BAD_REQUEST);
    }
    
    public function schoolMeal_get() {
        $school_type = $this->input->get('school_type');
        $date = $this->input->get('date');
        $res = $this->teacherapp->getSchoolMeal($school_type,$date);

        if ($res) {
            $return['success'] = "true";
            $return['title'] = "success";
            $return['message'] = "Success";
            $return['data'] = $res;
            $return['error'] = $this->error;
            $this->response($return, REST_Controller::HTTP_OK);
        }
        $return['success'] = "true";
        $return['title'] = "success";
        $return['message'] = "No meal plan available for this date.";
        $return['data'] = json_decode('{ "id": "",
                                        "for_date": "2020-03-23",
                                        "breakfast": [],
                                        "snacks": [],
                                        "meal": []}');
        $return['error'] = $this->error;
        $this->response($return, REST_Controller::HTTP_OK);
    }
    public function getschoolMeal_get() {
	   $student_id = $this->input->get('student_id');
           $schoolid = $this->token->school_id;
            
           $res = $this->teacherapp->getMySchoolMeal($student_id);
           $isMeal = $this->teacherapp->checkMeal($schoolid,$student_id);
        if ($res) {
// prd($res);

        	$id             = !empty($res->id) ? $res->id : 0; 
	        $school_id      = !empty($res->school_id) ? $res->school_id : 0; 
	        $school_type    = !empty($res->school_type) ? $res->school_type : 0; 
	        $date 		    = !empty($res->for_date) ? $res->for_date : ''; 
	        $class_id       = !empty($res->class_id) ? $res->class_id : 0; 
	        $student_id     = !empty($res->student_id) ? $res->student_id : 0; 
	        $snacks         = !empty($res->snacks) ? 1 : 0;  
	        $breakfast      = !empty($res->breakfast) ? 1 : 0; 
	        $meal           = !empty($res->meal) ? 1 : 0; 
	        $other          = !empty($res->other) ? $res->other : 0; 

	        $resData = array(
	        	'id' 			=> $res->id,
	        	'breakfast' 	=> !empty($res->breakfast) ? $res->breakfast : 0,
	        	'meal' 			=> !empty($res->meal) ? $res->meal : 0,
	        	'snacks' 		=> !empty($res->snacks) ? $res->snacks : 0,
	        	'date' 			=> !empty($res->for_date) ? $res->for_date : ''
	        );
	        // prd($resData);
            $return['success'] = "true";
            $return['is_meal'] = $isMeal;
            $return['message'] = "Success";
            // $return['data'] = $res;
             $return['data'] = $resData;
            $return['error'] = $this->error;
            $this->response($return, REST_Controller::HTTP_OK);
        }else{
                $return['is_meal'] = $isMeal;
	        $return['success'] = "false";
	        $return['message'] = "No meal plan available for this date.";
	        $return['error'] = $this->error;
	        $this->response($return, REST_Controller::HTTP_BAD_REQUEST);
        }
    }
    public function schoolMeal_post() {
        $postData = json_decode(file_get_contents('php://input'), true);
        //print_r($postData);die;

        $postData = $this->security->xss_clean($postData);
        $this->form_validation->set_error_delimiters('', '');
        $this->form_validation->set_data($postData);
        $this->form_validation->set_rules('schoolId', 'School', 'trim|required');
        $this->form_validation->set_rules('classId', 'Class', 'trim|required');
        $this->form_validation->set_rules('student_id', 'Child', 'trim|required');
        $this->form_validation->set_rules('for_date', 'For Date', 'trim|required');
        $this->form_validation->set_rules('breakfast', 'Breakfast', 'trim|required');
        $this->form_validation->set_rules('snacks', 'Snacks', 'trim|required');
        $this->form_validation->set_rules('meal', 'Meal', 'trim|required');
        $this->form_validation->set_rules('breakfast_other', 'Breakfast other', 'trim');
        $this->form_validation->set_rules('snacks_other', 'Snacks other', 'trim');
        $this->form_validation->set_rules('meal_other', 'Meal other', 'trim');

        if ($this->form_validation->run() === false) {
            $this->error = $this->form_validation->error_array();
            $message = validation_errors();
            $return['success'] = "false";
            $return['title'] = "error";
            $return['message'] = "$message";
            $return['error'] = $this->error;
            $return['data'] = (object) $this->data;
            $this->response($return, REST_Controller::HTTP_BAD_REQUEST);
        }
        else
        {   if(isset($postData['saveforall']) && $postData['saveforall']==1){
            $res = $this->teacherapp->saveSchoolMealForAll($postData);
            }
            else{
            $res = $this->teacherapp->saveSchoolMeal($postData);
            }
            if($res == false)
            {
                $return['success'] = "false";
                $return['title'] = "error";
                $return['message'] = "Already Exist";
                $return['data'] = $res;
                $return['error'] = $this->error;
                $this->response($return, REST_Controller::HTTP_OK);
            }
            else
            {
                $return['success'] = "true";
                $return['title'] = "success";
                $return['message'] = "School Meal Saved";
                $return['data'] = $res;
                $return['error'] = $this->error;
                $this->response($return, REST_Controller::HTTP_OK);
            }
        }
    }    
    public function homeMeal_post() {
        $postData = json_decode(file_get_contents('php://input'), true);        

        $postData = $this->security->xss_clean($postData);
        $this->form_validation->set_error_delimiters('', '');
        $this->form_validation->set_data($postData);
        $this->form_validation->set_rules('schoolId', 'School', 'trim|required');
        $this->form_validation->set_rules('classId', 'Class', 'trim|required');
        $this->form_validation->set_rules('student_id', 'Child', 'trim|required');
        $this->form_validation->set_rules('for_date', 'For Date', 'trim|required');
        $this->form_validation->set_rules('breakfast', 'Breakfast', 'trim');
        $this->form_validation->set_rules('snacks', 'Snacks', 'trim');
        $this->form_validation->set_rules('meal', 'Meal', 'trim');
        $this->form_validation->set_rules('other', 'Other', 'trim');

        if ($this->form_validation->run() === false) {
            $this->error = $this->form_validation->error_array();
            $message = validation_errors();
            $return['success'] = "false";
            $return['title'] = "error";
            $return['message'] = "$message";
            $return['error'] = $this->error;
            $return['data'] = (object) $this->data;
            $this->response($return, REST_Controller::HTTP_BAD_REQUEST);
        }
        else
        {
            $res = $this->teacherapp->saveHomeMeal($postData);
            if($res == false)
            {
                $return['success'] = "false";
                $return['title'] = "error";
                $return['message'] = "Already Exist";
                $return['data'] = $res;
                $return['error'] = $this->error;
                $this->response($return, REST_Controller::HTTP_OK);
            }
            else
            {
                $return['success'] = "true";
                $return['title'] = "success";
                $return['message'] = "Home Meal Saved";
                $return['data'] = $res;
                $return['error'] = $this->error;
                $this->response($return, REST_Controller::HTTP_OK);
            }
        }
    }    
    public function homeMeal_get() {
        // $schoolId = $this->input->get('schoolId');
        $student_id = $this->input->get('student_id');
        // if($date == '')
        // {
        //     $date = date("Y-m-d");
        // }
        $res = $this->teacherapp->getHomeMeal($student_id);

        if ($res) {

	        $id             = !empty($res->id) ? $res->id : 0; 
	        $school_id      = !empty($res->school_id) ? $res->school_id : 0; 
	        $school_type    = !empty($res->school_type) ? $res->school_type : 0; 
	        $date 		    = !empty($res->for_date) ? $res->for_date : ''; 
	        $class_id       = !empty($res->class_id) ? $res->class_id : 0; 
	        $student_id     = !empty($res->student_id) ? $res->student_id : 0; 
	        $snacks         = !empty($res->snacks) ? 1 : 0; 
	        $breakfast      = !empty($res->breakfast) ? 1 : 0; 
	        $meal           = !empty($res->meal) ? 1 : 0; 
	        $other          = !empty($res->other) ? $res->other : ""; 



            $return['success'] = "true";
            $return['title'] = "success";
            $return['message'] = "Success";
            // $return['data'] = $res;
            $return['data'] = json_decode('{ 
                                        "id": "'.$id.'",
                                        "school_id": "'.$school_id.'",
                                        "school_type": "'.$school_type.'",
                                        "class_id": "'.$class_id.'",
                                        "student_id": "'.$student_id.'",
                                        "for_date": "'.$date.'",
                                        "breakfast": "'.$breakfast.'",
                                        "snacks": "'.$snacks.'",
                                        "meal": "'.$meal.'",
                                        "other": "'.$other.'" }');

            $return['error'] = $this->error;
            $this->response($return, REST_Controller::HTTP_OK);
        }
        $return['success'] = "false";
        $return['title'] = "error";
        $return['message'] = "No meal found";
        $return['error'] = (object) $this->error;
        $return['data'] = (object) $this->data;
        $this->response($return, REST_Controller::HTTP_BAD_REQUEST);
    }
    public function assignedClass_get() {   
        
        $res = $this->teacherapp->getAssignedClass();
        if ($res) {
            $return['success'] = "true";
            $return['title'] = "success";
            $return['message'] = "Success";
            $return['data'] = $res;
            $return['error'] = $this->error;
            $this->response($return, REST_Controller::HTTP_OK);
        }
        else
        {
            $return['success'] = "true";
            $return['title'] = "success";
            $return['message'] = "No Class is assigned to you.";
            $return['data'] = array();
            $return['error'] = $this->error;
            $this->response($return, REST_Controller::HTTP_OK);
        }
    }
    public function learningDevelopmentCategory_get() {   
        $class_id = $this->input->get('class_id');
        $res = $this->teacherapp->learningDevelopmentCategory($class_id);
        if ($res) {
            $return['success'] = "true";
            $return['title'] = "success";
            $return['message'] = "Success";
            $return['data'] = $res;
            $return['error'] = $this->error;
            $this->response($return, REST_Controller::HTTP_OK);
        }
        $return['success'] = "false";
        $return['title'] = "error";
        $return['message'] = "No data found.";
        $return['error'] = (object) $this->error;
        $return['data'] = (object) $this->data;
        $this->response($return, REST_Controller::HTTP_BAD_REQUEST);
    }
    public function learningDevelopmentQuestion_get() {   
        $category_id = $this->input->get('category_id');
        $res = $this->teacherapp->learningDevelopmentQuestion($category_id);
        if ($res) {
            $return['success'] = "true";
            $return['title'] = "success";
            $return['message'] = "Success";
            $return['data'] = $res;
            $return['error'] = $this->error;
            $this->response($return, REST_Controller::HTTP_OK);
        }
        $return['success'] = "false";
        $return['title'] = "error";
        $return['message'] = "No Data Found";
        $return['error'] = (object) $this->error;
        $return['data'] = (object) $this->data;
        $this->response($return, REST_Controller::HTTP_BAD_REQUEST);
    }
    public function learningDevelopmentInfo_get() {   
        $category_id = $this->input->get('category_id');
        $res = $this->teacherapp->learningDevelopmentInfo($category_id);
        if ($res) {
            $return['success'] = "true";
            $return['title'] = "success";
            $return['message'] = "Success";
            $return['data'] = $res;
            $return['error'] = $this->error;
            $this->response($return, REST_Controller::HTTP_OK);
        }
        $return['success'] = "true";
            $return['title'] = "success";
            $return['message'] = "No Data Found";
            $return['data'] = array();
            $return['error'] = $this->error;
            $this->response($return, REST_Controller::HTTP_OK);
    }
    
    public function learningDevelopment_post() {
        $postData = json_decode(file_get_contents('php://input'), true);
        //print_r($postData);die;

        $postData = $this->security->xss_clean($postData);
        $this->form_validation->set_error_delimiters('', '');
        $this->form_validation->set_data($postData);
        $this->form_validation->set_rules('question_id', 'Question ID', 'trim|required');
        $this->form_validation->set_rules('student_id', 'Sudent ID', 'trim|required');
        $this->form_validation->set_rules('answer', 'Answer', 'trim|required');
        $this->form_validation->set_rules('other_answer', 'Other', 'trim');

        if ($this->form_validation->run() === false) {
            $this->error = $this->form_validation->error_array();
            $message = validation_errors();
            $return['success'] = "false";
            $return['title'] = "error";
            $return['message'] = "$message";
            $return['error'] = $this->error;
            $return['data'] = (object) $this->data;
            $this->response($return, REST_Controller::HTTP_BAD_REQUEST);
        }
        else
        {
            $res = $this->teacherapp->saveLearningDevelopment($postData);
            //
            //Add Code to Send Notification to parent APP
            //
            if($res == false)
            {
                $return['success'] = "false";
                $return['title'] = "error";
                $return['message'] = "Some Error Happen.";
                $return['data'] = $res;
                $return['error'] = $this->error;
                $this->response($return, REST_Controller::HTTP_OK);
            }
            else
            {
                $return['success'] = "true";
                $return['title'] = "success";
                $return['message'] = "Information Saved";
                $return['data'] = $res;
                $return['error'] = $this->error;
                $this->response($return, REST_Controller::HTTP_OK);
            }
        }
    } 
    public function learningDevelopmentAnswer_post() {
        $postData = json_decode(file_get_contents('php://input'), true);
        

        $postData = $this->security->xss_clean($postData);
        $this->form_validation->set_error_delimiters('', '');
        $this->form_validation->set_data($postData);
        $this->form_validation->set_rules('question_id', 'Question ID', 'trim|required');
        $this->form_validation->set_rules('student_id', 'Sudent ID', 'trim|required');

        if ($this->form_validation->run() === false) {
            $this->error = $this->form_validation->error_array();
            $message = validation_errors();
            $return['success'] = "false";
            $return['title'] = "error";
            $return['message'] = "$message";
            $return['error'] = $this->error;
            $return['data'] = (object) $this->data;
            $this->response($return, REST_Controller::HTTP_BAD_REQUEST);
        }
        else
        {
            $res = $this->teacherapp->learningDevelopmentAnswer($postData);
            
            if($res == false)
            {
                $return['success'] = "false";
                $return['title'] = "error";
                $return['message'] = "No answer submitted.";
                $return['data'] = $res;
                $return['error'] = $this->error;
                $this->response($return, REST_Controller::HTTP_OK);
            }
            else
            {
                $return['success'] = "true";
                $return['title'] = "success";
                $return['message'] = "Saved answer.";
                $return['data'] = $res;
                $return['error'] = $this->error;
                $this->response($return, REST_Controller::HTTP_OK);
            }
        }
    } 
    public function learningDevelopment_get() {        
        $res = $this->teacherapp->learningDevelopmentList();
        if ($res) {
            $return['success'] = "true";
            $return['title'] = "success";
            $return['message'] = "Success";
            $return['data'] = $res;
            $return['error'] = $this->error;
            $this->response($return, REST_Controller::HTTP_OK);
        }
        $return['success'] = "true";
            $return['title'] = "success";
            $return['message'] = "No Data Found";
            $return['data'] = array();
            $return['error'] = $this->error;
            $this->response($return, REST_Controller::HTTP_OK);
    } 
}
