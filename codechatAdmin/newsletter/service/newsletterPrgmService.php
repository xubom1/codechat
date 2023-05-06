#! /usr/bin/env php

<?php

include('/var/www/html/codechat/database.php');
$db = getDatabase();

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require '/var/www/html/codechat/codechatAdmin/lib/PHPMailer/src/Exception.php';
require '/var/www/html/codechat/codechatAdmin/lib/lib/PHPMailer/src/PHPMailer.php';
require '/var/www/html/codechat/codechatAdmin/lib/lib/PHPMailer/src/SMTP.php';


function sendMailP($setFromMail, $setFromPseudo, $userMail, $user, $attachementName, $attachementPath, $subject, $body, $bodyNoHtml){
    $mail = new PHPMailer(true);
    $mail->isSMTP();
    $mail->Host       = 'pro1.mail.ovh.net';
    $mail->SMTPAuth   = true;
    $mail->Username   = 'support@codechat.fr';
    $mail->Password   = 'password';
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
}

$sendMail = $db->prepare('SELECT * FROM newsletter WHERE sent = 0 AND NOT deleted AND sendDateTime IS NOT NULL');
$sendMail->execute([]);
$getMail = $sendMail->fetchAll(PDO::FETCH_ASSOC);

$cmd = $db->prepare('SELECT pseudo, mail FROM user;');
$cmd->execute([]);
$getUser = $cmd->fetchAll(PDO::FETCH_ASSOC);

date_default_timezone_set('Europe/Paris');

foreach ($getMail as $mail){
    if ($mail['sendDateTime'] <= date('Y-m-d H:i')){
        foreach ($getUser as $user) {
            sendMailP('newsletter@codechat.fr', 'Newsletter', $user['mail'], $user['pseudo'], NULL, NULL, $mail['title'], $mail['content'], $mail['content'], NULL);
        }
        $cmd = $db->prepare('UPDATE newsletter SET sent = 1 WHERE id = ?');
        $cmd->execute([$mail['id']]);
    }

}