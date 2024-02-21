<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Settings {
    public function __construct()
    {
           $this->CI =& get_instance();
           $this->encryption = $this->CI->config->config['encyption_version'][$this->CI->config->config['encyption_version']['active']];
           $query = $this->CI->db->get('settings');
           
           $data['Settings'] = $query->row();
           
           $this->CI->session->set_userdata($data);
    }
    
    public function encryptString($plaintext)
    {
        $tmpStr= $plaintext;
        $version = $this->encryption['version'];
        $key = $this->encryption['key'];

        $plaintext = $version."#".$plaintext;
        $ivlen = openssl_cipher_iv_length($cipher="AES-128-CBC");
        $iv = openssl_random_pseudo_bytes($ivlen);
        $ciphertext_raw = openssl_encrypt($plaintext, $cipher, $key, $options=OPENSSL_RAW_DATA, $iv);
        $hmac = hash_hmac('sha256', $ciphertext_raw, $key, $as_binary=true);
        $ciphertext = base64_encode( $iv.$hmac.$ciphertext_raw );
        if($this->validEncryption($ciphertext))
        {
            return trim($ciphertext,"=");
        }
        else
        {
            return trim($this->encryptString($tmpStr),"=");
        }
    }
    
    private function validEncryption($str)
    {
        if(stristr($str, "/"))
        {
            return false;
        }
        else
        {
            return true;
        }
    }

    public function decryptString($ciphertext)
    {
        $version = $this->encryption['version'];
        $key = $this->encryption['key'];
        
        $c = base64_decode($ciphertext);
        $ivlen = openssl_cipher_iv_length($cipher="AES-128-CBC");
        $iv = substr($c, 0, $ivlen);
        $hmac = substr($c, $ivlen, $sha2len=32);
        $ciphertext_raw = substr($c, $ivlen+$sha2len);
        $original_plaintext = openssl_decrypt($ciphertext_raw, $cipher, $key, $options=OPENSSL_RAW_DATA, $iv);
        $calcmac = hash_hmac('sha256', $ciphertext_raw, $key, $as_binary=true);
        if (hash_equals($hmac, $calcmac))//PHP 5.6+ timing attack safe comparison
        {
            //echo $original_plaintext; die;
			//return ltrim($original_plaintext, $version."#");
			return substr($original_plaintext, 4);
            //return $original_plaintext;
        }
        else
        {
            return false;
        }
    }
  
}



