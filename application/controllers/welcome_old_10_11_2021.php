<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Welcome extends CI_Controller {


    public function test() 
    {
        $to = "rizwan.khan@chawtechsolutions.com";
        $subject = "Email Test custom functions"  ;
        $body = "Testing emais send from custom functions";
        if(sendSmtpCustomEmail($to, $subject, $body)){
        echo 'Your Email has successfully been from from custom functions.';
        } else {
        echo 'not sent from custom functions.';
      } 
        
        ///phpinfo(); die;
//        echo "<br>";
//        echo $str =  $this->settings->encryptString("Hello");
//        echo "<br>";
//        echo $this->settings->decryptString($str);
    } 
    
    
    

    
    
    
    
    public function index() {
        $this->load->helper('url');

        $this->load->view('welcome_message');
    }
    
    
    public function makepdf() {
        $mpdf = $mpdf = new \Mpdf\Mpdf(['format' => 'Legal']);
        $html = $this->load->view('testpdf', [], true);
        $mpdf->WriteHTML($html);
        //$mpdf->Output(); // opens in browser
        $mpdf->Output('arjun.pdf','D'); // it downloads the file into the user system, with give name
    }

}
