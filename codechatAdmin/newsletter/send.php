<?php
include('../pages/utils.php');
include('../pages/template.php');
checkSessionAdminElseLogin('../');

$subject = $_POST['subject'];
$text = $_POST['text'];

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require '../../lib/PHPMailer/src/Exception.php';
require '../../lib/PHPMailer/src/PHPMailer.php';
require '../../lib/PHPMailer/src/SMTP.php';

//Create an instance; passing `true` enables exceptions
$mail = new PHPMailer(true);

try {
    //Server settings
    $mail->SMTPDebug   = 2;                      //Enable verbose debug output
    $mail->isSMTP();                                            //Send using SMTP
    $mail->Host        = 'pro1.mail.ovh.net';                     //Set the SMTP server to send through
    $mail->SMTPAuth    = true;                                   //Enable SMTP authentication
    $mail->Username    = 'team@codechat.fr';                     //SMTP username
    $mail->Password    = 'Respons11!';
    $mail->SMTPAutoTLS = true;
    $mail->SMTPSecure  = PHPMailer::ENCRYPTION_STARTTLS;           //Enable implicit TLS encryption
    $mail->Port        = 587;                                    //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`

    //Recipients
    $mail->setFrom('team@codechat.fr', 'Team Codechat');
    $mail->addAddress('s.rakulan04@gmail.com', 'Rakulan');

    //Attachments
    //$mail->addAttachment('/var/tmp/file.tar.gz');         //Add attachments
    //$mail->addAttachment('/tmp/image.jpg', 'new.jpg');    //Optional name

    //Content
    $mail->isHTML(true);                                  //Set email format to HTML
    $mail->Subject = $subject;
    $mail->Body    = $text;
    $mail->AltBody = $text;

    $mail->send();
    echo 'Message has been sent';
} catch (Exception $e) {
    echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
}