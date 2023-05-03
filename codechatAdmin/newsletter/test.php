<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require '../lib/PHPMailer/src/Exception.php';
require '../lib/PHPMailer/src/PHPMailer.php';
require '../lib/PHPMailer/src/SMTP.php';

$mail = new PHPMailer(true);

try {
    $mail->isSMTP();
    $mail->SMTPDebug = 2;
    $mail->Host       = 'pro1.mail.ovh.net';
    $mail->SMTPAuth   = true;
    $mail->Username   = 'support@codechat.fr';
    $mail->Password   = 'password';
    $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
    $mail->SMTPAutoTLS = true;
    $mail->Port       = 587;

    $mail->setFrom('support@codechat.fr', 'codechat news');
    $mail->addAddress('s.rakulan04@gmail.com', 'Rakulan');

    //$mail->isHTML(true);
    $mail->Subject = 'Test 01';
    $mail->Body    = 'Test';

    $mail->send();
    echo 'Message has been sent';
} catch (Exception $e) {
    echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
}