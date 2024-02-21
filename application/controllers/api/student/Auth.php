<?php
defined('BASEPATH') OR exit('No direct script access allowed');

require APPPATH . '/libraries/REST_Controller.php';

class Auth extends REST_Controller {

    public $error = array();
    public $data = array();

    function __construct() {
        parent::__construct();
        $this->load->library("security");
        $this->load->library('form_validation');
        $this->load->model('students/Student_model', 'student');
    }

    private function sendMailForCC($to, $cc1, $cc2, $subject, $message) {
        $headers = 'MIME-Version: 1.0' . "\r\n";
        $headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
        $headers .= 'From: admin@kidyview.com' . "\r\n";
        $headers .= "CC: $cc1, $cc2";
        return mail($to, $subject, $message, $headers);
    }
  

    public function validateStudentLogin_post() {
        $postData = json_decode(file_get_contents('php://input'), true);
        $this->load->library("settings");
        $this->load->model("students/Student_model", 'student');
            $form_data = array(
                'child_login_id' => $postData['username']
                //'password' => $postData['password']
            );
            $userData = $this->student->getStudent($form_data);
        if (!empty($userData) && $this->settings->decryptString($userData['password']) ==$postData['password']) {

            $data['is_logged_in'] = true;
            $data['student_data'] = array('id'=>$userData['id']);
            $data['student_role'] = 'student';
            $this->session->set_userdata($data);
            //print_r($this->session->all_userdata()); die;
            $return['status'] = 200;
            $return['success'] = "true";
            $return['message'] = "Login SuccessFully";
            $return['error'] = $this->error;

            $this->response($return, REST_Controller::HTTP_OK);
        } else {
            $this->error = $this->form_validation->error_array();

            $return['status'] = 400;
            $return['success'] = "false";
            $return['message'] = "Invalid Login Credentials!!!";
            $return['error'] = $this->error;

            $this->response($return, REST_Controller::HTTP_BAD_REQUEST);
        }
    }

    public function forget_passwordForStudent_post() {
        $postData = json_decode(file_get_contents('php://input'), true);
        $res = new blankClass();
        if (isset($postData['email'])) {
            $postData = $this->security->xss_clean($postData);

            $this->form_validation->set_data($postData);

            $this->form_validation->set_rules('email', 'email', 'trim|required');

            $error = array();

            if ($this->form_validation->run() === False) {
                $error = $this->form_validation->error_array();
                $this->response(["error" => $error], REST_Controller::HTTP_BAD_REQUEST);
            }
            $this->db->where('child_login_id', $postData['email']);
            $query = $this->db->get("child");
            $result = $query->result();
            if ($query->num_rows() != 1) {
                $return['success'] = "false";
                $return['message'] = "Something went wrong, Please try again later.";

                $this->response($return, REST_Controller::HTTP_BAD_REQUEST);
            }
            $child_id = $result[0]->id;
            $child_email_id=$result[0]->childemail;
            $parent_id = $result[0]->parent_id;
            //$email = null;
            $this->db->where('id', $parent_id);
            $query1 = $this->db->get("parent");
            //echo $this->db->last_query(); die;
            if ($query1->num_rows() != 1) {
                $return['success'] = "false";
                $return['message'] = "Something went wrong, Please try again later.";

                $this->response($return, REST_Controller::HTTP_BAD_REQUEST);
            }
            $result1 = $query1->result();
            $femail = $result1[0]->fatheremail;
            $memail = $result1[0]->motheremail;
            //$femail="yogendratomar.777@gmail.com";
            if ($query1->num_rows() != 1) {
                $return['success'] = "false";
                $return['message'] = "Something went wrong, Please try again later.";

                $this->response($return, REST_Controller::HTTP_BAD_REQUEST);
            }
            //echo $email; die;
            if ($query->num_rows() == 1) {
                //$user_id = 1;
                $this->load->helper('team');
                $verificationKey = generateString(15);

                $currentDateTime = date("Y-m-d H:i:s");
                $datetime = new DateTime($currentDateTime);
                $datetime->modify('+6 month');
                $expieryDateTime = $datetime->format('Y-m-d H:i:s');
                $verificationCode = $child_id . "#ForgetPassword#" . $verificationKey;
                $dt['encryptedCode'] = $this->settings->encryptString($verificationCode);

                $dataVerifiction = array(
                    "user_id" => $child_id,
                    "verification_type" => "ForgetPassword",
                    "verfication_code" => $verificationKey,
                    "status" => "Active",
                    "retry_count" => 0,
                    "expiry_date" => $expieryDateTime,
                    "created_date" => $currentDateTime,
                );

                $this->db->insert("child_verification", $dataVerifiction);

                $message = $this->load->view('forgetPasswordTemplateStudent', $dt, true);

                //$mailResponse = $this->sendMailForCC($femail,$memail ,$child_email_id,"KidyView : Student Forget Password", $message);
                $mailResponse = sendKidyviewEmail($femail,$memail,$child_email_id,'','KidyView : Student Forget Password', $message);
                if ($mailResponse) {
                    $return['success'] = "success";
                    $return['message'] = "Please check your email, A password reset link has been send to your email id.";
                    $this->response($return, REST_Controller::HTTP_OK);
                } else {
                    $this->response($res, REST_Controller::HTTP_INTERNAL_SERVER_ERROR);
                }
            } else {
                $return['success'] = "false";
                $return['message'] = "Email id not exist.";

                $this->response($return, REST_Controller::HTTP_UNAUTHORIZED);
            }
        } else {
            $return['success'] = "false";
            $return['message'] = "Something went wrong, Please try again later.";

            $this->response($return, REST_Controller::HTTP_BAD_REQUEST);
        }
    }

}
