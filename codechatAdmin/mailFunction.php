<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'lib/PHPMailer/src/Exception.php';
require 'lib/PHPMailer/src/PHPMailer.php';
require 'lib/PHPMailer/src/SMTP.php';

function sendMail($setFromMail, $setFromPseudo, $userMail, $user, $attachementName, $attachementPath, $subject, $body, $bodyNoHtml, $path){

    try {
        $mail = new PHPMailer(true);
        $mail->isSMTP();
        $mail->Host       = 'pro1.mail.ovh.net';
        $mail->SMTPAuth   = true;
        $mail->Username   = 'support@codechat.fr';
        $mail->Password   = 'Azerty11!';
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