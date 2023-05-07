<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'lib/PHPMailer/src/Exception.php';
require 'lib/PHPMailer/src/PHPMailer.php';
require 'lib/PHPMailer/src/SMTP.php';


function mail($setFromMail, $setFromPseudo, array $users, $subject, $body, $bodyNoHtml){
    $mail = new PHPMailer(true);
    $mail->isSMTP();
    $mail->Host       = 'pro1.mail.ovh.net';
    $mail->SMTPAuth   = true;
    $mail->Username   = 'team@codechat.fr';
    $mail->Password   = 'Respons11!';
    $mail->SMTPAutoTLS = false;
    $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;
    $mail->Port       = 587;

    //Recipients
    $mail->setFrom($setFromMail, $setFromPseudo);

    foreach ($users as $user) {
        $mail->addAddress($user, $user);
    }



    $mail->addAttachment('/var/tmp/file.tar.gz');
    $mail->addAttachment('/tmp/image.jpg', 'new.jpg');

    //Content
    $mail->isHTML(true);
    $mail->Subject = $subject;
    $mail->Body    = $body;
    $mail->AltBody = $bodyNoHtml;

    $mail->send();
}