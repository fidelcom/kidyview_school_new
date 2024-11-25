<?php
defined('BASEPATH') OR exit('No direct script access allowed');
require APPPATH . '/libraries/REST_Controller.php';

class Message extends REST_Controller {

    public $error = array();
    public $data = array();

    function __construct() {
        parent::__construct();
        $this->token->parent_validate();
        $this->load->library("security");
        $this->load->library('firebases');
        $this->load->library('fcm');
        $this->load->library('form_validation');
        $this->load->model('parent/message_model');
        $this->load->helper('common_helper');
        $this->load->model('parent/Parent_model');
    }
    
    public function list_get(){
        $user = "P-".$this->token->user_id;
        $data = $this->message_model->allData($user);
        
        $return['success'] = "true";
        $return['title'] = "success";
        $return['message'] = "Record found successfully.";
        $return['data'] = $data;
        $return['error'] = $this->error;
        $this->response($return, REST_Controller::HTTP_OK);        
    }
    
    public function index_post() { 
        //echo json_encode($_FILES['files']);die;
        $postData = $_POST;
        $dataid = '';
                                       
        $postData = $this->security->xss_clean($postData);
        $this->form_validation->set_error_delimiters('', '');
        $this->form_validation->set_data($postData);
        //$this->form_validation->set_rules('subject', 'Subject', 'trim|required');
        $this->form_validation->set_rules('message', 'message', 'trim');
        $this->form_validation->set_rules('reciever', 'Reciever', 'trim|required');

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
                                
        $arrFiles = array();        
        if (!empty($_FILES['files'])){
            $uploadPath = 'img/message/';
            $config['upload_path'] = $uploadPath;
            $config['allowed_types'] = 'jpg|jpeg|gif|png|doc|docx|pdf|mp4|MP4|3gp|3GP|wmv|WMV|avi|AVI|flv|FLV|mkv|MKV|mov|MOV';
            $config['max_size'] = 50000000000;
            $config['encrypt_name'] = TRUE;
            $this->load->library('upload', $config);
            $this->upload->initialize($config);
            for ($i = 0; $i < count($_FILES['files']['name']); $i++) {
                if ($_FILES['files']['name'][$i] != '') {
                    $_FILES['file']['name'] = $_FILES['files']['name'][$i];
                    $_FILES['file']['type'] = $_FILES['files']['type'][$i];
                    $_FILES['file']['tmp_name'] = $_FILES['files']['tmp_name'][$i];
                    $_FILES['file']['error'] = $_FILES['files']['error'][$i];
                    $_FILES['file']['size'] = $_FILES['files']['size'][$i];

                    if ($this->upload->do_upload('file')) {
                        $uplodimg = $this->upload->data();
                        //print_r($uplodimg);
                        $fileData = array();
                        $fileData['message_id'] = '';
                        $fileData['file_name'] = $uplodimg['file_name'];  
                        array_push($arrFiles,$fileData);
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
        //echo json_encode($arrFiles);die;

        $formData = array();
        $recievers = explode(',', $postData['reciever']);    
        
        foreach ($recievers as $reciever)
        {
            if($reciever !='')
            {
                $formData['message'] = $postData['message'];                                    
                $formData['reciever'] = $reciever;                                    
                $formData['school_id'] = $this->token->school_id;                                    
                $formData['sender'] = "P-".$this->token->user_id;
                $formData['created_date'] = date("Y-m-d H:i:s");
                $dataid = $this->message_model->addMessage($formData);

                // Send Push Notification
                $tokenData = $this->db->get_where('user_token', ['user_id' => $reciever])->row();
                if ($tokenData) {
                    $this->sendPushNotification($tokenData->token, "New Message", $postData['message']);
                }

                if (!empty($arrFiles)) {
                    foreach ($arrFiles as $photoData)
                    {
                        $photoData['message_id'] = $dataid;
                        $photoId = $this->message_model->addAttachment($photoData);
                    }
                }
                $pass = "KidyView";
                $this->load->model('teachers/Teacher_model');
                $text = $dataid;
                $encryptedUrl=encryptData($text,$pass);
                //die;
                $user=$reciever;
                
                $isNotify=notificationSettingHelper($this->token->school_id,$user,'Chat');
                
                $notificationData['school_id'] = $this->token->school_id;
                $notificationData['receiver_id'] = $user;
                $notificationData['sender_id'] = "P-".$this->token->user_id;
                $notificationData['to_do_id'] = $dataid;
                $notificationData['message'] = "Parent initiate chat message for you.";
                $notificationData['type'] = "chat";
                if(!empty($isNotify) && $isNotify->user_type=='school'){
                $notificationData['url'] = "all-conversation/".$encryptedUrl;
                }else{
                    $notificationData['url'] = "conversation/".$encryptedUrl;    
                }
                if(!empty($isNotify) && $isNotify->is_push==1){
                $this->Teacher_model->add($notificationData,'notifications');
                    $tk = explode('-', $user);
//                        var_dump($tk);
                    $result = $this->Parent_model->parentFCMID($tk[1]);
                    $tokenData = $this->db->get_where('user_token', ['user_id' => $tk[1]])->row();
//                        var_dump($result);
                    $token = !empty($result->fcm_key) ? $result->fcm_key : '';
                    $message = $postData['message'];
                    $title = "A Parent initiate chat message for you";
                    $this->firebases->sendNotification($token, $title, $message);
//                        $this->model->add($notificationData, 'notifications');
//                    $notify =  $this->fcm->sendPushNotification($token, $title, $message);
                }
                $schoolEmail='';
                $schoolData=getSchoolDetails($this->token->school_id);
                if(!empty($schoolData)){
                $schoolEmail=$schoolData->email;
                //$schoolEmail='yogendratomar.777@gmail.com';
                }
                //echo $isNotify->is_web;die;
                if($schoolEmail!='' && (!empty($isNotify) && $isNotify->is_web==1)){
                $notificationData['user'] = "school";
                $message = $this->load->view('emailtemplate/commonTemplate',$notificationData, true);
                //sendMail($schoolEmail, $notificationData['message'], $message);
                sendKidyviewEmail($schoolEmail,'','','',$notificationData['message'], $message);
                }

            }
        }
        
        if ($dataid) {                        
            $return['success'] = "true";
            $return['title'] = "success";
            $return['message'] = "Message send successfully.";
            $return['error'] = (object) $this->error;
            $return['data'] = $this->data;
            $this->response($return, REST_Controller::HTTP_OK);
        }
        $return['success'] = "false";
        $return['title'] = "error";
        $return['message'] = "Message not send.";
        $return['error'] = (object) $this->error;
        $return['data'] = (object) $this->data;

        $this->response($return, REST_Controller::HTTP_BAD_REQUEST);
    }

    public function conversation_get($user_id = '') {
        $user1 = "P-".$this->token->user_id;
        $user2 = $user_id; 
        $messageData = $this->message_model->getConversation($user1,$user2);
        $userDetail = $this->message_model->userDetail($user2);
        
        $data = array(
            "user_detail"=>$userDetail,
            "conversation"=>$messageData
        );
        
        $return['success'] = "true";
        $return['title'] = "success";
        $return['message'] = $data ? "Message Detail" : "No data found";
        $return['data'] = $data;
        $return['error'] = $this->error;
        $this->response($return, REST_Controller::HTTP_OK);
    }
    
    public function users_get(){
        $user_id = "P-".$this->token->user_id; 
        $data = $this->message_model->users($user_id);
        
        $return['success'] = "true";
        $return['title'] = "success";
        $return['message'] = "All user list.";
        $return['data'] = $data;
        $return['error'] = $this->error;
        $this->response($return, REST_Controller::HTTP_OK);
    }
    
    public function index_delete($user2){
        $user1 = "P-".$this->token->user_id;
        $res = $this->message_model->deleteConversationMessage($user1,$user2);
        
        if($res)
        {
            $return['success'] = "true";
            $return['title'] = "success";
            $return['message'] = "Message deleted successfully.";
            $return['data'] = array();
            $return['error'] = $this->error;
            $this->response($return, REST_Controller::HTTP_OK);
        }
        else
        {
            $return['success'] = "false";
            $return['title'] = "error";
            $return['message'] = "Some error happen.";
            $return['data'] = array();
            $return['error'] = $this->error;
            $this->response($return, REST_Controller::HTTP_OK);
        }
    }

    private function sendPushNotification($token, $title, $body) {
        $url = 'https://fcm.googleapis.com/fcm/send';
        $serverKey = 'AAAA-yhUx78:APA91bEfw76JlVWCTr70GIc2kXpzQyrJcIm-3e0P1EH_gLKMBvR3Y4OH4ogdidklZFOQM5sIRjfYduppdefXBl7MVyeHqGZMj31e3nA6zKb_7oS7aSSOXpHU7d2iTj9d0u8PsPXLHYXo'; // Replace with your actual Firebase server key

        $notification = [
            'title' => $title,
            'body' => $body,
            'sound' => 'default'
        ];
        $data = [
            'to' => $token,
            'notification' => $notification
        ];

        $headers = [
            'Authorization: key=' . $serverKey,
            'Content-Type: application/json'
        ];

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));

        $result = curl_exec($ch);
        if ($result === FALSE) {
            die('Curl failed: ' . curl_error($ch));
        }
        curl_close($ch);
    }
}
