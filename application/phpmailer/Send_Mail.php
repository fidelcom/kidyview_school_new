<?php
function Send_Mail($to,$subject,$body)
{
require 'class.phpmailer.php';
$from = "info@amistos.com";
$mail = new PHPMailer();
$mail->IsSMTP(true); // SMTP
$mail->SMTPAuth   = true;  // SMTP authentication
$mail->Mailer = "smtp";
$mail->Host       = "tls://email-smtp.us-west-2.amazonaws.com"; // Amazon SES server, note "tls://" protocol
$mail->Port       = 465;                    // set the SMTP port
$mail->Username = "AKIAIGFDQKPM5SBHZ36Q";  // SMTP  Username
$mail->Password = "AkbUwdIMWfJMj17QixK8AA3pztYuqSjJoiDvNNIMywxt";  // SMTP Password
$mail->SetFrom($from, 'From Amistos');
$mail->Subject = $subject;
$mail->MsgHTML($body);
$address = $to;
$mail->AddAddress($address, $to);

if(!$mail->Send())
return false;
else
return true;

}
?>