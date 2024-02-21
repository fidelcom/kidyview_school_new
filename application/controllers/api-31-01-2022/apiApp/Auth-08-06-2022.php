<?php

defined('BASEPATH') OR exit('No direct script access allowed');


require APPPATH . '/libraries/REST_Controller.php';
include APPPATH . 'third_party/plivo/vendor/autoload.php';

use Plivo\RestClient;

//include APPPATH .'third_party/plivo/vendor/plivo/plivo-php/src/Plivo/RestClient.php';
class Auth extends REST_Controller {

    public $error = array();
    public $data = array();

    function __construct() {
        parent::__construct();
        $this->load->library("security");
        $this->load->library('form_validation');
        $this->load->model('user_model_app', 'user');
    }

    private function sendMail($to, $subject, $message) {
        $headers = 'MIME-Version: 1.0' . "\r\n";
        $headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
        $headers .= 'From: admin@kidyview.com' . "\r\n";
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

    public function country_get() {
        $cresult = $this->user->getCountryList();

        if ($cresult) {
            $return['success'] = "true";
            $return['title'] = "success";
            $return['message'] = "country list get successfully";
            $return['data'] = $cresult;
            $return['error'] = $this->error;
            $this->response($return, REST_Controller::HTTP_OK);
        }

        $return['data'] = $this->data;
        $return['success'] = "false";
        $return['title'] = "error";
        $return['message'] = "Something went wrong.";
        $return['error'] = $this->error;
        $this->response($return, REST_Controller::HTTP_OK);
    }

    public function resendotp_post() {
        $postData = json_decode(file_get_contents('php://input'), true);
        $res = new blankClass();
        if ((isset($postData['email']) || isset($postData['phnno'])) && (isset($postData['fcm_key']))) {
            $postData = $this->security->xss_clean($postData);
            $this->form_validation->set_data($postData);


            $result = $this->user->validate($postData['email'], $postData['phnno']);

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

                $toemail = $result->teacheremail;
                $currentDateTime = date("Y-m-d H:i:s");
                $datetime = new DateTime($currentDateTime);
                $datetime->modify('+6 month');
                $expieryDateTime = $datetime->format('Y-m-d H:i:s');

                $userTokenStr = $result->id . "#" . $expieryDateTime . "#" . $platform;
                $userToken = $this->settings->encryptString($userTokenStr);

                $otp = $this->generateRandomString(4);
                $dataUserToken = array(
                    "user_id" => $result->id,
                    "token" => $userToken,
                    "device" => $platform,
                    "device_type" => $postData['device_type'],
                    "fcm_key" => $postData['fcm_key'],
                    "user_type" => $postData['user_type']
                );
                $this->user->addToken($dataUserToken);
                $user_id = $result->id;
                $updateArr = array('otp' => $otp);
                $result = $this->user->editTeacher($updateArr, $result->id);
                /* send otp on phone */
                if ($postData['phnno']) {
                    
                    //$client = new RestClient("MANMVKN2MWZMFMMTEYMD", "MTVkNDdkNzBlNWM2NTM2YjllOGE4NWYwMzBkNTE1");
                    $client = new RestClient(PLIVO_AUTH_ID, PLIVO_AUTH_TOKEN);
                    //print_r($client);die;
                    $response = $client->messages->create('+19709844629', array($postData['phnno']), $otp . ' is your Kidy View login OTP. OTP is confidential.', array("url" => "http://foo.com/sms_status/"));
                    
                    
                    //if($response->_message == 'queued')
                    // {
                    $return['success'] = "true";
                    //$return['m']=$response->_message;
                    $return['title'] = "success";
                    $return['message'] = "Please check phone.";
                    $return['error'] = (object) $this->error;
                    $return['data'] = $this->data;
                    $return['user_id'] = "$user_id";
                    $return['status'] = "success";
                    $return['token'] = "$userToken";

                    $this->response($return, REST_Controller::HTTP_ACCEPTED);
                    // }
                    // else
                    //{
                    //   $this->response(["status" => "error", "message" => "OTP not send please try again."], REST_Controller::HTTP_BAD_REQUEST);
                    //}
                }

                /* end send otp on phone */
                /* send otp on mail */
                $mailsent = false;
                $maildata = array('otp' => $otp);

                /* codeigniter mail  */
                $message = $this->load->view('app/member-otp.php', $maildata, TRUE);

                if ($this->sendMail($toemail, 'Kidyview - OTP', $message)) {
                    $mailsent = true;
                }

                $return['success'] = "true";
                $return['title'] = "success";
                $return['message'] = "Please check your email.";
                $return['error'] = (object) $this->error;
                $return['data'] = $this->data;
                $return['user_id'] = "$user_id";
                $return['status'] = "success";
                $return['token'] = "$userToken";

                $this->response($return, REST_Controller::HTTP_ACCEPTED);
            } else {
                $this->response(["status" => "error", "message" => "Please check your email id."], REST_Controller::HTTP_BAD_REQUEST);
            }
        } else {
            $this->response(["status" => "error", "message" => "Please fill all field."], REST_Controller::HTTP_BAD_REQUEST);
        }
    }

    public function signin_post() {
        $postData = json_decode(file_get_contents('php://input'), true);
        $res = new blankClass();
        if ((isset($postData['email']) || isset($postData['phnno'])) && (isset($postData['fcm_key']))) {
            $postData = $this->security->xss_clean($postData);
            $this->form_validation->set_data($postData);

            $result = $this->user->validate($postData['email'], $postData['phnno']);
            // lq();
            //	var_dump($result); die;
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

                $toemail = $result->teacheremail;
                $currentDateTime = date("Y-m-d H:i:s");
                $datetime = new DateTime($currentDateTime);
                $datetime->modify('+6 month');
                $expieryDateTime = $datetime->format('Y-m-d H:i:s');

                $userTokenStr = $result->id . "#" . $expieryDateTime . "#" . $platform . "#" . $result->schoolId . "#Teacher";
                $userToken = $this->settings->encryptString($userTokenStr);

                $otp = $this->generateRandomString(4);
                $dataUserToken = array(
                    "user_id" => $result->id,
                    "token" => $userToken,
                    "device" => $platform,
                    "device_type" => $postData['device_type'],
                    "fcm_key" => $postData['fcm_key'],
                    "user_type" => $postData['user_type']
                );
                $this->user->addToken($dataUserToken);
                $user_id = $result->id;
                $updateArr = array('otp' => $otp);
                $result = $this->user->editTeacher($updateArr, $result->id);
                /* send otp on phone */
                if ($postData['phnno']) {
                    //$client = new RestClient("MANMVKN2MWZMFMMTEYMD", "MTVkNDdkNzBlNWM2NTM2YjllOGE4NWYwMzBkNTE1");
                    $client = new RestClient(PLIVO_AUTH_ID, PLIVO_AUTH_TOKEN);
                    $response = $client->messages->create('+19709844629', array($postData['phnno']), $otp . ' is your Kidy View login OTP. OTP is confidential.', array("url" => "http://foo.com/sms_status/"));
                    //print_r($response->_message);
                    //if($response->_message == 'queued')
                    // {
                    $return['success'] = "true";
                    $return['title'] = "success";
                    $return['message'] = "Please check phone.";
                    $return['error'] = (object) $this->error;
                    $return['data'] = $this->data;
                    $return['user_id'] = "$user_id";
                    $return['status'] = "success";
                    $return['token'] = "$userToken";
                    $return['response'] = $response;

                    $this->response($return, REST_Controller::HTTP_ACCEPTED);
                }

                /* end send otp on phone */
                /* send otp on mail */
                $mailsent = false;
                $maildata = array('otp' => $otp);

                /* codeigniter mail  */
                $message = $this->load->view('app/member-otp.php', $maildata, TRUE);

                if ($this->sendMail($toemail, 'Kidyview - OTP', $message)) {
                    $mailsent = true;
                }

                $return['success'] = "true";
                $return['title'] = "success";
                $return['message'] = "Please check your email.";
                $return['error'] = (object) $this->error;
                $return['data'] = $this->data;
                $return['user_id'] = "$user_id";
                $return['status'] = "success";
                $return['token'] = "$userToken";

                $this->response($return, REST_Controller::HTTP_ACCEPTED);
            } else {
                $this->response(["status" => "error", "message" => "Email ID does not exist"], REST_Controller::HTTP_BAD_REQUEST);
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
        $this->form_validation->set_rules('fcm_key', 'Fcm Key', 'trim|required');
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

        $otp = $postData['otp'];
        $user_id = $postData['user_id'];

        $fcm_key = $postData['fcm_key'];
        $user_type = $postData['user_type'];
        
        ########## For static Otp #############
        $otpQuery = $this->db->query("select * from teacher where id = '".$user_id."'");
        $otpData = $otpQuery->row();
        #########################################
        
        //if($otp == '12345' && isset($otpData->teacheremail) && $otpData->teacheremail=='nikhil51423@gmail.com')
        if($otp == '123456' && isset($otpData->teacheremail) && $otpData->teacheremail=='kabirsharma759@gmail.com')
        $result = $otpData;
        else
        $result = $this->user->isotpvalid($otp, $user_id);
        //echo '<pre>';print_R($result); die;

        if ($result) {
            $this->load->library('user_agent');
            if ($this->agent->is_browser()) {
                $agent = $this->agent->browser();
            } elseif ($this->agent->is_robot()) {
                $agent = $this->agent->robot();
            } elseif ($this->agent->is_mobile()) {
                $device = $this->agent->mobile();
            } else {
                $agent = $this->agent->mobile();
            }

            $additional_data = array(
                'otp' => NULL
            );

            $this->user->editTeacher($additional_data, $result->id);

            $this->data = $result;

            $return['success'] = "true";
            $return['title'] = "success";
            $return['message'] = "successfully login";
            $return['error'] = (object) $this->error;
            $return['data'] = $this->data;

            $this->response($return, REST_Controller::HTTP_OK);
        }

        $return['success'] = "false";
        $return['title'] = "error";
        $return['message'] = "Otp is wrong.";
        $return['error'] = (object) $this->error;
        $return['data'] = (object) $this->data;

        $this->response($return, REST_Controller::HTTP_BAD_REQUEST);
    }

}
