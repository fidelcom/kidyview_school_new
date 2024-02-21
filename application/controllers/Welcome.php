<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Welcome extends CI_Controller {
  

     public function checkimg() 
     {
         $childphoto = '4446d5f863ec74d7f6025be87037c70be00.png';
         if(file_exists('./img/child/'.$childphoto))
            echo 'files exist';
         else
          echo 'files  not exist'.'chawtechsolutions.ch/kidyview/img/child/'.$childphoto;    
     }
    
    
    
    
    public function test() 
    {
        
        //$date = new DateTime();
        //$timeZone = $date->getTimezone();
        //echo $timeZone->getName();
        //echo date('Y-m-d H:i:s');

//        $getloc = json_decode(file_get_contents("http://ipinfo.io/"));
//        echo '<pre>';
//        print_r($getloc);
        
        
        //exit;
        
        
        $to = "rizwan.khan@chawtechsolutions.com";
        $subject = "Email Test custom functions"  ;
        $body = "Testing emais send from custom functions";
        if($this->sendkiddyEmail($to, $subject, $body)){
        echo 'Your Email has successfully been from from custom functions....';
        } //else {
        //echo 'not sent from custom functions...';
      //} 
        
        ///phpinfo(); die;
//        echo "<br>";
//        echo $str =  $this->settings->encryptString("Hello");
//        echo "<br>";
//        echo $this->settings->decryptString($str);
    } 
    
    
    
  public  function sendkiddyEmail($to, $subject,$body, $cc='',$bcc='') {
require_once APPPATH . "phpmailer/class.phpmailer.php";
$from = "admin@kidyview.com";
$mail = new PHPMailer();
$mail->IsSMTP(true); // SMTP
$mail->SMTPAuth = true;  // SMTP authentication
$mail->Mailer = "smtp";
$mail->Host = "smtp.mailgun.org"; // Amazon SES server, note "tls://" protocol
$mail->Port = 587;                    // set the SMTP port
$mail->Username = "postmaster@demosrv.co";  // SMTP  Username
$mail->Password = "75645fc5d1bdfd99196210018b5f5431-bdd08c82-c8235749";  // SMTP Password
$mail->SetFrom($from, 'TJSS');
$mail->Subject = $subject;
$mail->MsgHTML($body);
$address = $to;
$mail->AddAddress($address, $to);
if (!$mail->Send()){
echo  $mail->ErrorInfo;
}
else{
return true;
}
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
