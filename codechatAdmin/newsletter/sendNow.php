#! /usr/bin/env php

<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require '../lib/PHPMailer/src/Exception.php';
require '../lib/PHPMailer/src/PHPMailer.php';
require '../lib/PHPMailer/src/SMTP.php';

include('../../database.php');
$db = getDatabase();

while (true){
    sleep(60);
    $cmd = $db->prepare('SELECT pseudo, mail, title, content, sendTo WHERE sendDateTime is NULL AND sent = ?');
    $cmd->execute([0]);
    $sendMails = $cmd->fetchAll(PDO::FETCH_ASSOC);

    if ($sendMails['sendTo'] === 'all') {
        foreach ($sendMails as $mail) {
            $mail = new PHPMailer(true);
            $mail->isSMTP();
            $mail->Host = 'pro1.mail.ovh.net';
            $mail->SMTPAuth = true;
            $mail->Username = 'team@codechat.fr';
            $mail->Password = 'password';
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
            $mail->SMTPAutoTLS = true;
            $mail->Port = 587;

            $mail->setFrom('support@codechat.fr', 'codechat news');
            $mail->addAddress($mail['mail'], $mail['pseudo']);

            $mail->isHTML(true);
            $mail->Subject = $mail['title'];
            $mail->Body = $mail['content'];
            $mail->AltBody = $mail['content'];

            $mail->send();
        }
    }
}