<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class AdministratorLogin extends CI_Controller {

    public function __construct() {
        parent::__construct();

        $this->load->helper('cookie');
        if ($this->input->cookie('remember_user', TRUE)) {
            $this->input->cookie('remember_user', TRUE);
        }
    }

    public function index($page = 'login') {
        $data['title'] = ucfirst($page); // Capitalize the first letter
        $data['image'] = $this->getImage();
        $data['bgimage'] = $this->getBgImage();
        $this->load->view("administratorLogin", $data);
    }
    
    private function getImage(){
        $this->db->where("id",1);
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
    private function getBgImage(){
        $this->db->where("id",1);
        $query = $this->db->get("login_image");
        
        if($query->num_rows() == 1)
        {
            return $query->row()->bg_image;
        }
        else
        {
            return 'kids.jpg';
        }
    }
    public function fogetPassword($page = 'login') {

        $form_data = array('username' => $this->input->post('username'));
        $this->load->model('user');
        $userData = $this->user->getUser($form_data);

        $errorMessage = array();

        if (!$userData) {
            $errorMessage = array(
                'message_type' => 'error',
                'message' => 'User Name Not Found!!!',
                'color' => '#F78C8C'
            );
        } else {
            $username = $userData['username'];
            $password = $userData['password'];
            $email = $userData['email'];

            $subject = 'Password Recovery';


            $message = "<table width='600'>
				<tr>
				<td colspan=2><center><B>Account Detail</B></center></td>
				</tr>
				<tr>
				<td><B>User Name</B> </td><td>: " . $username . "</td>
				</tr>
				<tr>
				<td><B>Password</B> </td><td>: " . $password . "</td>
				</tr>
				</table>			
                ";
            // To send HTML mail, the Content-type header must be set
            $headers = 'MIME-Version: 1.0' . "\r\n";
            $headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";

            // Additional headers
            $headers .= 'From: info@amistos.com' . "\r\n";
            $to = $email;



            // Mail it
            $mail = mail($to, $subject, $message, $headers);

            if (!$mail) {
                $errorMessage = array(
                    'message_type' => 'Error',
                    'message' => 'Mail has been sent on your email id.',
                    'color' => '#F78C8C'
                );
            } else {
                $errorMessage = array(
                    'message_type' => 'Success',
                    'message' => 'Mail has been sent on your email id.',
                    'color' => '#E8F4D2'
                );
            }
        }

        $this->session->set_userdata($errorMessage);

        redirect('login');
    }

    public function validate_login() {
        $form_data = array(
            'username' => $this->input->post('UserName'),
            'password' => $this->input->post('Password')
        );
        $this->load->model('user');
        $userData = $this->user->getUser($form_data);


        if ($userData != false) {
            $remember = $this->input->post('remember');

            if ($remember == 'remember') {
                $this->input->set_cookie('remember_user', $this->input->post('UserName'), 3600);
                $this->input->set_cookie('remember_password', $this->input->post('Password'), 3600);
            }

            $data = array(
                'is_logged_in' => true,
                'user_data' => $userData,
                'user_role' => $userData['role']
            );

            $this->session->set_userdata($data);
            //print_r($data);
            //die;		
            switch ($userData['role']) {
                case 'admin':
                    redirect('owner');
                    exit;

                default :
                    redirect('administrator');
            }
        } else {
            $page = "administrator";
            $data['title'] = ucfirst($page); // Capitalize the first letter

            $errorMessage = array(
                'message_type' => 'error',
                'message' => 'Invalid Login Credentials!!!<br/>Please Enter Valid Credentials.',
                'color' => '#F78C8C'
            );
            $this->session->set_userdata($errorMessage);

            redirect('administrator');
        }
    }

}
