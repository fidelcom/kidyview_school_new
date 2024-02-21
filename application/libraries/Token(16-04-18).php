<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Token {
    public function __construct()
    {
           $this->CI =& get_instance();  
           $this->user_id = NULL;
           $this->expire = NULL;
    }
    
    public function validate()
    {
        
        if($this->CI->input->server('HTTP_TOKEN'))
        {
            if($this->CI->settings->decryptString($this->CI->input->server('HTTP_TOKEN')))
            {
                $token = explode("#", $this->CI->settings->decryptString($this->CI->input->server('HTTP_TOKEN')));

                if(isset($token[0]) && isset($token[0]))
                {
                    $this->user_id = $token[0];
                    $this->expire = $token[1];
                    if($this->expire > date("Y-m-d H:i:s"))
                    {
                        return true;
                    }
                    else
                    {
                        header("HTTP/1.0 403 Forbidden");
                        echo '{"status":false,"error":"Token Expired"}';                    
                        die;
                    }
                }
            }
            else
            {
                header("HTTP/1.0 403 Forbidden");
                echo '{"status":false,"error":"Invalid Token"}';
                die;
               
            }
        }
        else
        {
            header("HTTP/1.0 403 Forbidden");
            echo '{"status":false,"error":"Please send valid key"}';
            die;
        }
        
    }    
      
}



