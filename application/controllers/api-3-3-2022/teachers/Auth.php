<?php
defined('BASEPATH') OR exit('No direct script access allowed');

require APPPATH . '/libraries/REST_Controller.php';
include APPPATH . 'third_party/plivo/vendor/autoload.php';
use Plivo\RestClient;

class Auth extends REST_Controller {

    public $error = array();
    public $data = array();

    function __construct() {
        parent::__construct();
        $this->load->library("security");
        $this->load->library('form_validation');
        $this->load->model('teachers/teacher_model', 'teacher');
    }
    public function validateTeacherLogindd_post() {
        $postData = json_decode(file_get_contents('php://input'), true);
        $res = new blankClass();
        if ((isset($postData['email']) || isset($postData['phnno']))) {
            $postData = $this->security->xss_clean($postData);
            $this->form_validation->set_data($postData);
            $result = $this->teacher->validate($postData['email'], $postData['phnno']);
            
            if ($result) {
                $toemail = $result->teacheremail;
                $user_id = $result->id;
                $otp = $this->generateRandomString(4);
                $updateArr = array('otp' => $otp);
                $result = $this->teacher->editTeacher($updateArr, $result->id);
                /* send otp on phone */
                if ($postData['phnno']) {
                    $client = new RestClient("MANMVKN2MWZMFMMTEYMD", "MTVkNDdkNzBlNWM2NTM2YjllOGE4NWYwMzBkNTE1");
                    $response = $client->messages->create('+19709844629', array($postData['phnno']), $otp . ' as your login OTP. OTP is confidential.', array("url" => "http://foo.com/sms_status/"));
                    $return['success'] = "true";
                    $return['title'] = "success";
                    $return['message'] = "OTP has been send to you on your on your Mobile Number.Please enter it below";
                    $return['error'] = (object) $this->error;
                    $return['data'] = $this->data;
                    $return['user_id'] = "$user_id";
                    $return['status'] = "success";

                    $this->response($return, REST_Controller::HTTP_OK);
                }

                /* end send otp on phone */
                /* send otp on mail */
                $mailsent = false;
                $maildata = array('otp' => $otp);

                /* codeigniter mail  */
                $message = $this->load->view('teacher-otp.php', $maildata, TRUE);

                if ($this->sendMail($toemail, 'Kidyview - OTP', $message)) {
                    $mailsent = true;
                }

                $return['success'] = "true";
                $return['title'] = "success";
                $return['message'] = "OTP has been send to you on your on your Email Id.Please enter it below";
                $return['error'] = (object) $this->error;
                $return['data'] = $this->data;
                $return['user_id'] = "$user_id";
                $return['status'] = "success";

                $this->response($return, REST_Controller::HTTP_OK);
            } else {
                if($postData['phnno']!=''){
                    $msg="Please check your phone number first.";
                }
                if($postData['email']!=''){
                    $msg="Please check your email first.";
                }
                $this->response(["status" => "error", "message" => $msg], REST_Controller::HTTP_BAD_REQUEST);
           }
        } else {
            $this->response(["status" => "error", "message" => "Please fill all field."], REST_Controller::HTTP_BAD_REQUEST);
        }
    }
    public function generateRandomString($length) {
        if (!$length) {
            return false;
        }
        $characters = '0123456789';
        $charactersLength = strlen($characters);
        $randomString = '';

        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }
        return $randomString;
    }
   
    public function verifyotp_post() {
        $postData = json_decode(file_get_contents('php://input'), true);
        $res = new blankClass();
        $postData = $this->security->xss_clean($postData);
        $this->form_validation->set_data($postData);
        $this->form_validation->set_error_delimiters('', '');
        $this->form_validation->set_rules('otp', 'OTP', 'trim|required');
        $this->form_validation->set_rules('user_id', 'user id', 'trim|required|numeric');
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

        $otp = $postData['otp'];
        $user_id = $postData['user_id'];
        $result = $this->teacher->isotpvalid($otp, $user_id);
        if ($result) {
            $additional_data = array(
                'otp' => NULL
            );
            $this->teacher->editTeacher($additional_data, $result->id);
            $data['teacher_data'] = array('id'=>$result->id);
            $this->session->set_userdata($data);
            $return['success'] = "true";
            $return['title'] = "success";
            $return['message'] = "successfully login";
            $return['error'] = (object) $this->error;
            $this->response($return, REST_Controller::HTTP_OK);
        }

        $return['success'] = "false";
        $return['title'] = "error";
        $return['message'] = "Incorrect OTP.";
        $return['error'] = (object) $this->error;

        $this->response($return, REST_Controller::HTTP_BAD_REQUEST);
    }
    public function validateTeacherLogin_post() {
        $postData = json_decode(file_get_contents('php://input'), true);
        $postData = $this->security->xss_clean($postData);
        $this->form_validation->set_data($postData);
        $this->form_validation->set_error_delimiters('', '');
        $this->form_validation->set_rules('username', 'Email Address', 'trim|required|valid_email');
        $this->form_validation->set_rules('password', 'Password', 'trim|required');
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
        $this->load->library("settings");
        $this->load->model("Teacher_model", 'teacher');
            $form_data = array(
                'teacheremail' => $postData['username']
            );
            $userData = $this->teacher->getTeacher($form_data);
        if (!empty($userData) && $this->settings->decryptString($userData['password']) ==$postData['password']) {

            $data['is_logged_in'] = true;
            $data['teacher_data'] = array('id'=>$userData['id']);
            $this->session->set_userdata($data);
            $return['status'] = 200;
            $return['success'] = "true";
            $return['message'] = "Login SuccessFully";
            $return['error'] = $this->error;

            $this->response($return, REST_Controller::HTTP_OK);
        } else {
            $this->error = $this->form_validation->error_array();

            $return['status'] = 400;
            $return['success'] = "false";
            $return['message'] = "Invalid Login Credentials";
            $return['error'] = $this->error;

            $this->response($return, REST_Controller::HTTP_BAD_REQUEST);
        }
    }

    public function forget_passwordForTeacher_post() {
        $postData = json_decode(file_get_contents('php://input'), true);
        $res = new blankClass();
        $this->load->library("settings");
        if (isset($postData['email'])) {
            $postData = $this->security->xss_clean($postData);

            $this->form_validation->set_data($postData);
            $this->form_validation->set_rules('email', 'email', 'trim|required');
            $error = array();

            if ($this->form_validation->run() === False) {
                $error = $this->form_validation->error_array();
                $message = validation_errors();
                $return['success'] = "false";
                $return['title'] = "error";
                $return['message'] = "$message";
                $return['error'] = $this->error;
                $return['data'] = (object) $this->data;
                $this->response($return, REST_Controller::HTTP_BAD_REQUEST);
            }
            $this->db->where('teacheremail', $postData['email']);
            $query = $this->db->get("teacher");
            $result = $query->result();
            if ($query->num_rows() != 1) {
                $return['success'] = "false";
                $return['title'] = "error";
                $return['message'] = "Something went wrong, Please try again later.";
                $this->response($return, REST_Controller::HTTP_BAD_REQUEST);
            }
            $email=$postData['email'];
            if ($query->num_rows() == 1) {
                $this->load->helper('team');
                $verificationKey = generateString(15);
                $currentDateTime = date("Y-m-d H:i:s");
                $datetime = new DateTime($currentDateTime);
                $datetime->modify('+6 month');
                $expieryDateTime = $datetime->format('Y-m-d H:i:s');
                $verificationCode = $result[0]->id . "#ForgetPassword#" . $verificationKey;
                $dt['encryptedCode'] = $this->settings->encryptString($verificationCode);

                $dataVerifiction = array(
                    "user_id" => $result[0]->id ,
                    "verification_type" => "ForgetPassword",
                    "verfication_code" => $verificationKey,
                    "status" => "Active",
                    "retry_count" => 0,
                    "expiry_date" => $expieryDateTime,
                    "created_date" => $currentDateTime,
                );

                $this->db->insert("teacher_verification", $dataVerifiction);

                $message = $this->load->view('forgetPasswordTemplateTeacher', $dt, true);
                $mailResponse = $this->sendMail($email,"KidyView : Teacher Forget Password", $message);

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
    private function sendMail($to, $subject, $message) {
        $headers = 'MIME-Version: 1.0' . "\r\n";
        $headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
        $headers .= 'From: admin@kidyview.com' . "\r\n";
        return mail($to, $subject, $message, $headers);
    }

}
