<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require '../lib/PHPMailer/src/Exception.php';
require '../lib/PHPMailer/src/PHPMailer.php';
require '../lib/PHPMailer/src/SMTP.php';

$mail = new PHPMailer();

$mail->IsSMTP();                       // telling the class to use SMTP

$mail->SMTPDebug = 1;
// 0 = no output, 1 = errors and messages, 2 = messages only.

$mail->SMTPAuth = true;                // enable SMTP authentication
$mail->SMTPSecure = "tls";              // sets the prefix to the servier
$mail->Host = "pro1.mail.ovh.net";        // sets Gmail as the SMTP server
$mail->Port = 587;                     // set the SMTP port for the GMAIL

$mail->Username = "team@codechat.fr";  // Gmail username
$mail->Password = "Respons11!";      // Gmail password

$mail->CharSet = 'windows-1250';
$mail->SetFrom ('info@example.com', 'Example.com Information');
$mail->AddBCC ( 'sales@example.com', 'Example.com Sales Dep.');
$mail->Subject = 'hello';
$mail->ContentType = 'text/plain';
$mail->IsHTML(false);

$mail->Body = 'hello world';
// you may also use $mail->Body = file_get_contents('your_mail_template.html');

$mail->AddAddress ('s.rakulan04@gmail.com', 'Rakulan');
// you may also use this format $mail->AddAddress ($recipient);

if(!$mail->Send())
{
$error_message = "Mailer Error: " . $mail->ErrorInfo;
} else
{
$error_message = "Successfully sent!";
}
