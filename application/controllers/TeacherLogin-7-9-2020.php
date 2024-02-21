<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class TeacherLogin extends CI_Controller {

    public function __construct() {
        parent::__construct();
    }

    public function index($page = 'login') {
        $data['title'] = ucfirst($page); // Capitalize the first letter
        $data['image'] = $this->getImage();
        $this->load->view("teacherLogin", $data);
    }
    
    private function getImage(){
        $this->db->where("id",3);
        $query = $this->db->get("login_image");
        
        if($query->num_rows() == 1)
        {
            return $query->row()->image;
        }
        else
        {
            return 'kids.jpg';
        }
    }

}
