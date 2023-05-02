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
    $mail->Username   = 'team@codechat.fr';
    $mail->Password   = 'Respons11!';
    $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
    $mail->SMTPAutoTLS = true;
    $mail->Port       = 587;

    $mail->setFrom('team@codechat.fr', 'codechat news');
    $mail->addAddress('s.rakulan04@gmail.com', 'Rakulan');

    $mail->isHTML(true);
    $mail->Subject = 'Test 01';
    $mail->Body    = 'Message de <b>Test</b>';
    $mail->AltBody = 'Ceci est un message de test';

    $mail->send();
    echo 'Message has been sent';
} catch (Exception $e) {
    echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
}