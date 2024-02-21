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
        $this->load->model('user_model', 'user');
    }

    public function signupSchool_post() {
        //require 'phpmailer/Send_Mail.php';

        $postData = json_decode(file_get_contents('php://input'), true);
        $res = new blankClass();
        if (isset($postData['email']) && $postData['school_name'] && $postData['phone']) {
            $postData = $this->security->xss_clean($postData);
            $this->form_validation->set_data($postData);

            $this->form_validation->set_rules('email', 'Email', 'trim|required|valid_email');
            $this->form_validation->set_rules('school_name', 'School Name', 'trim|required');
            $this->form_validation->set_rules('phone', 'Phone', 'trim');
            $this->form_validation->set_rules('password', 'Password', 'trim|required');
            $this->form_validation->set_rules('confirm_password', 'Confirm Password', 'trim|required|matches[password]');


            $error = array();
            if ($this->form_validation->run() === False) {
                $error = $this->form_validation->error_array();
                $this->response(["status" => "error", "error" => $error], REST_Controller::HTTP_BAD_REQUEST);
            }

            if ($this->user->schoolExist($postData['email'])) {
                $this->response($res, REST_Controller::HTTP_CONFLICT);
            } else {
                $userCreated = 0;
                $postData['created_date'] = date("Y:m:d H:i:s");
                $postData['status'] = 1;
                $postData['is_email_verified'] = 0;
                unset($postData['confirm_password']);
                $userCreated = $this->user->addSchool($postData);
				if($userCreated)
				{
					$addArr1 = array(
					'school_id' => $userCreated,
					'email' => $postData['email'],
					'fname' => $postData['school_name'],
					'password' => $postData['password'],
					'is_email_verified' => '0',
					'status' => 1,
					'created_date' => date("Y:m:d H:i:s"),
					);
					$userCreated1 = $this->user->addSchoolExtraInfo($addArr1);
				}

                $this->load->helper('team');
                $verificationKey = generateString(15);

                $currentDateTime = date("Y-m-d H:i:s");
                $datetime = new DateTime($currentDateTime);
                $datetime->modify('+6 month');
                $expieryDateTime = $datetime->format('Y-m-d H:i:s');
                $verificationCode = $userCreated . "#Signup#" . $verificationKey;
                $dt['encryptedCode'] = $this->settings->encryptString($verificationCode);

                $dataVerifiction = array(
                    "user_id" => $userCreated,
                    "verification_type" => "Signup",
                    "verfication_code" => $verificationKey,
                    "status" => "Active",
                    "retry_count" => 0,
                    "expiry_date" => $expieryDateTime,
                    "created_date" => $currentDateTime,
                );

                $this->db->insert("verification", $dataVerifiction);

                $message = $this->load->view('signupMailTemplate', $dt, true);

                $mailResponse = $this->sendMail($postData['email'], "KidyView School Registration", $message);

                if ($mailResponse && $userCreated) {
                    $this->response(['status' => 'success', "message" => "Please verify your email by opening link send to you, to complete sign up process."], REST_Controller::HTTP_CREATED);
                } else {
                    $this->response($res, REST_Controller::HTTP_INTERNAL_SERVER_ERROR);
                }
            }
        } else {
            $this->response(["status" => "error", "message" => "Please fill all fields."], REST_Controller::HTTP_BAD_REQUEST);
        }
    }

    private function Send_Mail($to, $subject, $body) {
        require_once APPPATH . "phpmailer/class.phpmailer.php";
        $from = "info@amistos.com";
        $mail = new PHPMailer();
        $mail->IsSMTP(true); // SMTP
        $mail->SMTPAuth = true;  // SMTP authentication
        $mail->Mailer = "smtp";
        $mail->Host = "tls://email-smtp.us-west-2.amazonaws.com"; // Amazon SES server, note "tls://" protocol
        $mail->Port = 465;                    // set the SMTP port
        $mail->Username = "AKIAIGFDQKPM5SBHZ36Q";  // SMTP  Username
        $mail->Password = "AkbUwdIMWfJMj17QixK8AA3pztYuqSjJoiDvNNIMywxt";  // SMTP Password
        $mail->SetFrom($from, 'Amistos');
        $mail->Subject = $subject;
        $mail->MsgHTML($body);
        $address = $to;
        $mail->AddAddress($address, $to);

        if (!$mail->Send())
            return false;
        else
            return true;
    }

    public function signin_post() {
        $postData = json_decode(file_get_contents('php://input'), true);
        $res = new blankClass();
        if (isset($postData['email']) && isset($postData['password']) && isset($postData['fcm_key'])) {
            $postData = $this->security->xss_clean($postData);
            $this->form_validation->set_data($postData);

            $this->form_validation->set_rules('email', 'Email', 'trim|required|valid_email');
            $this->form_validation->set_rules('password', 'Password', 'trim|required');

            $error = array();
            if ($this->form_validation->run() === False) {
                $error = $this->form_validation->error_array();
                $this->response(["error" => $error], REST_Controller::HTTP_BAD_REQUEST);
            }

            $result = $this->user->validate($postData['email'], $postData['password']);

            if ($result) {
                $this->load->library('user_agent');
                $platform = $this->agent->platform();
                if ($platform == "Unknown Platform") {
                    if ($this->agent->is_browser()) {
                        $platform = $this->agent->browser();
                    } elseif ($this->agent->is_robot()) {
                        $platform = $this->agent->robot();
                    } elseif ($this->agent->is_mobile()) {
                        $platform = $this->agent->mobile();
                    }
                }

                $currentDateTime = date("Y-m-d H:i:s");
                $datetime = new DateTime($currentDateTime);
                $datetime->modify('+6 month');
                $expieryDateTime = $datetime->format('Y-m-d H:i:s');

                $userTokenStr = $result->user_id . "#" . $expieryDateTime . "#" . $platform;
                $userToken = $this->settings->encryptString($userTokenStr);

                $dataUserToken = array(
                    "user_id" => $result->user_id,
                    "token" => $userToken,
                    "device" => $platform,
                    "fcm_key" => $postData['fcm_key']
                );
                $this->user->addToken($dataUserToken);
                $this->response(["status" => 'success', 'token' => $userToken], REST_Controller::HTTP_ACCEPTED);
            } else {
                $this->response(["status" => "error", "message" => "Please check your email id or password first."], REST_Controller::HTTP_BAD_REQUEST);
            }
        } else {
            $this->response(["status" => "error", "message" => "Please fill all field."], REST_Controller::HTTP_BAD_REQUEST);
        }
    }

    public function forget_password_post() {
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

            $email = null;
            $this->db->where('email', $postData['email']);
            $query = $this->db->get("ics_admin");
            //echo $this->db->last_query(); die;
            if ($query->num_rows() != 1) {
                $return['success'] = "false";
                $return['message'] = "Something went wrong, Please try again later.";

                $this->response($return, REST_Controller::HTTP_BAD_REQUEST);
            }
            $result = $query->result();
            $email = $result[0]->email;
            if ($query->num_rows() == 1) {
                $user_id = 1;
                $this->load->helper('team');
                $verificationKey = generateString(15);

                $currentDateTime = date("Y-m-d H:i:s");
                $datetime = new DateTime($currentDateTime);
                $datetime->modify('+6 month');
                $expieryDateTime = $datetime->format('Y-m-d H:i:s');
                $verificationCode = $user_id . "#ForgetPassword#" . $verificationKey;
                $dt['encryptedCode'] = $this->settings->encryptString($verificationCode);

                $dataVerifiction = array(
                    "user_id" => $user_id,
                    "verification_type" => "ForgetPassword",
                    "verfication_code" => $verificationKey,
                    "status" => "Active",
                    "retry_count" => 0,
                    "expiry_date" => $expieryDateTime,
                    "created_date" => $currentDateTime,
                );

                $this->db->insert("verification", $dataVerifiction);

                $message = $this->load->view('forgetPasswordTemplate', $dt, true);

                $mailResponse = $this->sendMail($email, "KidyView : Forget Password", $message);

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

    public function forget_passwordForSchool_post() {
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

            //$email = null;
            $this->db->where('email', $postData['email']);
            $query = $this->db->get("school");
            //echo $this->db->last_query(); die;
            if ($query->num_rows() != 1) {
                $return['success'] = "false";
                $return['message'] = "Something went wrong, Please try again later.";

                $this->response($return, REST_Controller::HTTP_BAD_REQUEST);
            }
            $result = $query->result();
            $email = $result[0]->email;
            $user_id = $result[0]->id;
            //echo $email; die;
            if ($query->num_rows() == 1) {
                //$user_id = 1;
                $this->load->helper('team');
                $verificationKey = generateString(15);

                $currentDateTime = date("Y-m-d H:i:s");
                $datetime = new DateTime($currentDateTime);
                $datetime->modify('+6 month');
                $expieryDateTime = $datetime->format('Y-m-d H:i:s');
                $verificationCode = $user_id . "#ForgetPassword#" . $verificationKey;
                $dt['encryptedCode'] = $this->settings->encryptString($verificationCode);

                $dataVerifiction = array(
                    "user_id" => $user_id,
                    "verification_type" => "ForgetPassword",
                    "verfication_code" => $verificationKey,
                    "status" => "Active",
                    "retry_count" => 0,
                    "expiry_date" => $expieryDateTime,
                    "created_date" => $currentDateTime,
                );

                $this->db->insert("verification", $dataVerifiction);

                $message = $this->load->view('forgetPasswordTemplateSchool', $dt, true);

                $mailResponse = $this->sendMail($email, "KidyView : Forget Password", $message);

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

    public function validateAdminLogin_post() {
        $postData = json_decode(file_get_contents('php://input'), true);
        $usertype=$postData['usertype'];
        $this->load->model("user", 'adminuser');
        if($usertype=="adminsubadmin"){
            $form_data = array(
                'email' => $postData['email'],
                'password' => md5($postData['password'])
            );
            $userData = $this->adminuser->getSubAdminUser($form_data);
        }else if($usertype=="admin"){
            $form_data = array(
                'email' => $postData['email'],
                'password' => $postData['password']
            );
            $userData = $this->adminuser->getUser($form_data);
        }


        if ($userData != '') {

            $data['is_logged_in'] = true;
            $data['user_data'] = $userData;
            $data['user_role'] = $usertype;
           if($usertype=="adminsubadmin"){
            $data['user_data']['full_Name'] = $userData['name'];
            $data['user_data']['photo'] = $userData['pic'];
           }
            

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
            $return['message'] = "Invalid Login Credentials!!!";
            $return['error'] = $this->error;

            $this->response($return, REST_Controller::HTTP_BAD_REQUEST);
        }
    }

    public function validateSchoolLogin_post() {
        $postData = json_decode(file_get_contents('php://input'), true);


        
        $usertype=$postData['usertype'];

        $this->load->model("User_model", 'schooluser');
        if($usertype=="schoolsubadmin"){
            $form_data = array(
                'email' => $postData['email'],
                'password' => md5($postData['password'])
            );
            $userData = $this->schooluser->getSubAdmin($form_data);
        }else if($usertype=="school"){
            $form_data = array(
                'email' => $postData['email'],
                'password' => $postData['password']
            );
            $userData = $this->schooluser->getSchool($form_data);
        }
        if ($userData != '') {

            $data['is_logged_in'] = true;
            $data['user_data'] = $userData;
            $data['user_role'] = $usertype;
           if($usertype=="schoolsubadmin"){
            $data['user_data']['school_name'] = $userData['name'];
           }
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
    private function sendMailForCC($to, $cc1, $cc2, $subject, $message) {
        $headers = 'MIME-Version: 1.0' . "\r\n";
        $headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
        $headers .= 'From: info@chawtechsolutions.com' . "\r\n";
        $headers .= "CC: $cc1, $cc2";
        return mail($to, $subject, $message, $headers);
    }
    private function sendMail($to, $subject, $message) {
        $headers = 'MIME-Version: 1.0' . "\r\n";
        $headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
        $headers .= 'From: info@chawtechsolutions.com' . "\r\n";
        return mail($to, $subject, $message, $headers);
    }

    private function checkValidEmail($email) {
        $emailParts = explode("@", $email);
        if ($this->user->allowedDomain($emailParts[1]) === true) {
            return true;
        } elseif ($this->user->allowedEmail($email) === true) {
            return true;
        } else {
            return false;
        }
    }

    public function validateStudentLogin_post() {
        $postData = json_decode(file_get_contents('php://input'), true);
        $this->load->library("settings");
        $this->load->model("User_model", 'student');
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
            //$femail = $result1[0]->fatheremail;
            //$memail = $result1[0]->motheremail;
            $femail="yogendratomar.777@gmail.com";
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

                $mailResponse = $this->sendMailForCC($femail,$memail ,'',"KidyView : Student Forget Password", $message);

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
