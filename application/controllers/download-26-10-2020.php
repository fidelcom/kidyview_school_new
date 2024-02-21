<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Download extends CI_Controller {

    public function index() {
      
    }

    public function assignmentdownload($id='') {
        $this->load->model('students/Student_model','model');
        $assignmentData=$this->model->getAssignmentDetails($id);
        print_r($assignmentData);die;
        $this->load->library('zip');
        $path = 'img/noImage.png';
        $path1 = 'img/default-profilePic.png';
        $this->zip->read_file($path);
        $this->zip->read_file($path1);
// Download the file to your desktop. Name it "my_backup.zip"
        $this->zip->download('my_backup.zip');
    }
    

}
