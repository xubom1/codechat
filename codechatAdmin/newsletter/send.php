<?php
include('../pages/utils.php');
include('../pages/template.php');
checkSessionAdminElseLogin('../');

include('../../database.php');
$db = getDatabase();

$cmd = $db->prepare('SELECT pseudo, mail FROM user WHERE wantNews=?');
$cmd->execute([1]);
$users = $cmd->fetch();

$subject = $_POST['subject'];
$text = $_POST['text'];

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require '../../lib/PHPMailer/src/Exception.php';
require '../../lib/PHPMailer/src/PHPMailer.php';
require '../../lib/PHPMailer/src/SMTP.php';

//Create an instance; passing `true` enables exceptions
$mail = new PHPMailer(true);

foreach($users as $user){
    $mail->isSMTP();                                            //Send using SMTP
    $mail->Host        = 'pro1.mail.ovh.net';                     //Set the SMTP server to send through
    $mail->SMTPAuth    = true;                                   //Enable SMTP authentication
    $mail->Username    = 'team@codechat.fr';                     //SMTP username
    $mail->Password    = 'Respons11!';
    $mail->SMTPAutoTLS = false;
    $mail->SMTPSecure  = PHPMailer::ENCRYPTION_STARTTLS;
    $mail->Port        = 587;

    //Recipients
    $mail->setFrom('team@codechat.fr', 'Team Codechat');
    $mail->addAddress($user['mail'], $user['pseudo']);

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
    }