<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'lib/PHPMailer/src/Exception.php';
require 'lib/PHPMailer/src/PHPMailer.php';
require 'lib/PHPMailer/src/SMTP.php';


function sendMail($setFromMail, $setFromPseudo, $userMail, $user, $attachementName, $attachementPath, $subject, $body, $bodyNoHtml, $path){
    $password = file_get_contents('/var/www/html/mailpwd.txt');
    if (!$password) $password = file_get_contents('/home/nicolas/Documents/ESGI/1I3/mailpwd.txt');//second try
    if (!$password) header('location: '. $path .'?msg=can\'t find password&err=true');

    try {
        $mail = new PHPMailer(true);
        $mail->isSMTP();
        $mail->Host       = 'pro1.mail.ovh.net';
        $mail->SMTPAuth   = true;
        $mail->Username   = 'support@codechat.fr';
        $mail->Password   = $password;
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $mail->SMTPAutoTLS = true;
        $mail->Port       = 587;

        $mail->setFrom($setFromMail, $setFromPseudo);
        $mail->addAddress($userMail, $user);

        if (isset($attachementPath) AND isset($attachementName)){
            $mail->addAttachment($attachementPath, $attachementName);
        }

        $mail->isHTML(true);
        $mail->Subject = $subject;
        $mail->Body    = $body;
        $mail->AltBody = $bodyNoHtml;

        $mail->send();

        return 'ok';
    } catch (Exception $e){
        header('location: '. $path .'?msg=Mail not send&err=true');
        exit();
    }

}