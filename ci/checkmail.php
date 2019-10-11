<?php
$from = 'info@reters.com';
$to = 'rihanna@europe.com';
// $to = 'gary_vinu@yahoo.com';
$subject = 'Test Sub';
$htmlBody = 'Test Message';

echo '<br>--------------------------';

include_once 'Mail.php';
include_once 'Mail/mime.php';
$em = Mail::factory('sendmail');
$headers = array('From'=>$from, 'To'=>$to, 'Subject'=>$subject);
$mime = new Mail_Mime();
//$mime->setTxtBody($plainBody);
$mime->setHtmlBody($htmlBody);
$message = $mime->get();
$headers = $mime->headers($headers);
$mail = $em->send($to, $headers, $message);
var_dump($mail);

/* include_once("class.phpmailer.php");
	
$mail = new PHPMailer();
	
$mail->IsSMTP();  // telling the class to use SMTP
// $mail->Host     = "relay-hosting.secureserver.net"; // SMTP server

$mail->Host = 'tls://smtp.gmail.com';
$mail->SMTPAuth = true;
$mail->Username = 'vinu@teamtweaks.com';
$mail->Password = '04651cattt';
	
$mail->SetFrom($from, 'Gary Wilson');
//$mail->From     = $from;
$mail->AddAddress($to);
$mail->IsHTML(true);
$mail->Subject  = $subject;
$mail->Body     = $htmlBody;
$mail->WordWrap = 50;
	
var_dump($mail->Send()); */

?>