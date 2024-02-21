<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Token {

    public function __construct() {
        $this->CI = & get_instance();
        $this->user_id = NULL;
        $this->expire = NULL;
        $this->user_details = NULL;
		$this->school_id = NULL;
		$this->user_type = NULL;
		$this->subscription_id = NULL;
    }

    public function validate_old() {
        //echo 'hello'; die;
        if ($this->CI->input->server('HTTP_TOKEN')) {
            //var_dump($this->CI->settings->decryptString($this->CI->input->server('HTTP_TOKEN'))); die;

            if ($this->CI->settings->decryptString($this->CI->input->server('HTTP_TOKEN'))) {
                $token = explode("#", $this->CI->settings->decryptString($this->CI->input->server('HTTP_TOKEN')));
                if (isset($token[0]) && isset($token[0])) {
                    $this->user_id = $token[0];
                    $this->expire = $token[1];

                    if ($this->expire > date("Y-m-d H:i:s")) {
                        //$this->user_details = $this->CI->db->select("id, user_id, email, first_name, last_name, phone, pic")->where('user_id', $this->user_id)->get('user')->row();
                        return true;
                    } else {
                        header("HTTP/1.0 403 Forbidden");
                        echo '{"status":false,"error":"Token Expired"}';
                        die;
                    }
                }
            } else {
                header("HTTP/1.0 403 Forbidden");
                echo '{"status":false,"error":"Invalid Token"}';
                die;
            }
        } else {
            header("HTTP/1.0 403 Forbidden");
            echo '{"status":false,"error":""}';
            die;
        }
    }
    public function validate() {
        if ($this->CI->input->server('HTTP_TOKEN')) {
            if ($this->CI->settings->decryptString($this->CI->input->server('HTTP_TOKEN'))) {
                $token = explode("#", $this->CI->settings->decryptString($this->CI->input->server('HTTP_TOKEN')));
               // print_r($token);die;
                if (isset($token[0]) && isset($token[0])) {
                    $this->user_id = $token[0];
                    $this->expire = $token[1];
                    $this->school_id = $token[3];
                    $this->user_type = $token[4];
					$this->subscription_id = isset($token[5]) && $token[5]!=''?$token[5]:'';
                    if (strtotime($this->expire) > strtotime(date("Y-m-d H:i:s"))) {
						
						if($this->user_type=='school'){
						  $chkSubscription=$this->CI->subscription->check_subscription($this->school_id,$this->subscription_id);
						  echo $chkSubscription;die;
						  if($chkSubscription==0){
							header("HTTP/1.0 403 Forbidden");
							echo '{"status":0,"message":"Your subscription has been expired."}';
							die;
						  }
						  if($chkSubscription==2){
							header("HTTP/1.0 403 Forbidden");
							echo '{"status":2,"message":"Your paid subscription has been switched to free subscription."}';
							die;
						  }
						}
                        //$this->user_details = $this->CI->db->select("id, user_id, email, first_name, last_name, phone, pic")->where('user_id', $this->user_id)->get('user')->row();
                        return true;
                    } else {
                        header("HTTP/1.0 401 Forbidden");
                        echo '{"status":false,"error":"Token Expired"}';
                        die;
                    }
                }
            } else {
                header("HTTP/1.0 401 Forbidden");
                echo '{"status":false,"error":"Invalid Token"}';
                die;
            }
        } else {
            header("HTTP/1.0 401 Forbidden");
            echo '{"status":false,"error":"Please send valid token"}';
            die;
        }
    }
    
    public function parent_validate() {
        if ($this->CI->input->server('HTTP_TOKEN')) {
            if ($this->CI->settings->decryptString($this->CI->input->server('HTTP_TOKEN'))) {
                $token = explode("#", $this->CI->settings->decryptString($this->CI->input->server('HTTP_TOKEN')));
                if (isset($token[0]) && isset($token[0]) && isset($token[5])) {
                    $this->parent_id = $token[0];
                    $this->user_id = $token[0];
                    $this->expire = $token[1];
                    $this->student_id = $token[3];
                    $this->school_id = $token[4];
                    $this->user_type = $token[5];
                    if ($this->expire > date("Y-m-d H:i:s")) {
                        return true;
                    } else {
                        header("HTTP/1.0 403 Forbidden");
                        echo '{"status":false,"error":"Token Expired"}';
                        die;
                    }
                }
            } else {
                header("HTTP/1.0 403 Forbidden");
                echo '{"status":false,"error":"Invalid Token"}';
                die;
            }
        } else {
            header("HTTP/1.0 403 Forbidden");
            echo '{"status":false,"error":"Please send valid token"}';
            die;
        }
    }
	
	

}
