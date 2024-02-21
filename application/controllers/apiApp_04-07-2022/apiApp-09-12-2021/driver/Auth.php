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
        $this->load->model('driver/driver_model', 'user');
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

    private function sendMail($to, $subject, $message) {
        $headers = 'MIME-Version: 1.0' . "\r\n";
        $headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
        $headers .= 'From: admin@kidyview.com' . "\r\n";
        return mail($to, $subject, $message, $headers);
    }

    public function resetPassword_post() {

        $postData = json_decode(file_get_contents('php://input'), true);
        if (isset($postData['email']) && $postData['email'] != "") {

            $result = $this->user->checkuser($postData['email']);
            
            if ($result && $result->status == '1') {
                
                $newPass = $this->generateRandomString(7);
                $message = '<p>Dear ' . $result->driverfname . ', Your Kidy View  New Password :  ' . $newPass . ' </p>';
                $toemail = $postData['email'];
              
                if ($this->sendMail($toemail, 'Kidyview - Reset Password', $message)) {
                    
                    $updatePass = array('password' => $newPass);
                    $this->user->changePassword($result->id, $updatePass);
                    $return['success'] = "true";
                    $return['title'] = "success";
                    $return['message'] = "Password Reset Successfully.Please check your email.";
                    $return['error'] = (object) $this->error;
                    $return['status'] = "success";
                    $this->response($return, REST_Controller::HTTP_ACCEPTED);
                } else {
                    $this->response(["status" => "false", "title" => "error", "message" => "Unknown Error Occured To Password Reset."], REST_Controller::HTTP_BAD_REQUEST);
                }
            } else {
                $this->response(["status" => "false", "title" => "error", "message" => "Invalid Email Id or email Id not found."], REST_Controller::HTTP_BAD_REQUEST);
            }
        } else {
            $this->response(["status" => "false", "title" => "error", "message" => "Enter Your Valid Email ID."], REST_Controller::HTTP_BAD_REQUEST);
        }
    }

    public function signin_post() {
        $postData = json_decode(file_get_contents('php://input'), true);
        $postData = $this->security->xss_clean($postData);
        $this->form_validation->set_data($postData);
        $this->form_validation->set_error_delimiters('', '');

        $this->form_validation->set_rules('email', 'email id', 'trim|required');
        $this->form_validation->set_rules('password', 'password', 'trim|required');
        $this->form_validation->set_rules('fcm_key', 'Fcm Key', 'trim|required');
        $this->form_validation->set_rules('device_type', 'Device Type', 'trim|required');

        if ($this->form_validation->run() === false) {
            $this->error = $this->form_validation->error_array();
            $message = validation_errors();

            $return['success'] = "false";
            $return['title'] = "error";
            $return['message'] = "$message";
            $return['error'] = $this->error;
            $return['data'] = (object) $this->data;
            $this->response($return, REST_Controller::HTTP_BAD_REQUEST);
            exit;
        }

        if ((isset($postData['email']) || isset($postData['password'])) && (isset($postData['fcm_key'])) && (isset($postData['device_type']))) {

            $result = $this->user->validate($postData['email'], $postData['password']);

            if ($result && $result->status == '1') {
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

                $userTokenStr = $result->id . "#" . $expieryDateTime . "#" . $platform . "#" . $result->schoolId . "#Driver";
                $userToken = $this->settings->encryptString($userTokenStr);


                $dataUserToken = array(
                    "user_id" => $result->id,
                    "token" => $userToken,
                    "device" => $platform,
                    "device_type" => $postData['device_type'],
                    "fcm_key" => $postData['fcm_key'],
                    "user_type" => 'Driver'
                );


                $this->user->addToken($dataUserToken);
                $user_id = $result->id;

                $return['success'] = "true";
                $return['title'] = "success";
                $return['message'] = "successfully login";
                $return['error'] = (object) $this->error;
                $return['data'] = $userToken;
                $return['user_id'] = "$user_id";
                $return['status'] = "success";
                $this->response($return, REST_Controller::HTTP_ACCEPTED);
                exit;
            } elseif ($result && $result->status == '0') {
                $this->response(["status" => "false", "title" => "error", "message" => "Your account status is Inactive .Please contact School."], REST_Controller::HTTP_BAD_REQUEST);
            } else {
                $this->response(["status" => "false", "title" => "error", "message" => "Invalid Login Id Password"], REST_Controller::HTTP_BAD_REQUEST);
            }
        } else {
            $this->response(["status" => "false", "title" => "error", "message" => "Please fill all field."], REST_Controller::HTTP_BAD_REQUEST);
        }
    }

}
