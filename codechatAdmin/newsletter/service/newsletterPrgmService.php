#! /usr/bin/env php

<?php

include('/var/www/html/codechat/database.php');
$db = getDatabase();

include('/var/www/html/codechat/codechatAdmin/mailFunction.php');

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
            sendMail('newsletter@codechat.fr', 'Newsletter', $user['mail'], $user['pseudo'], NULL, NULL, $mail['title'], $mail['content'], $mail['content'], NULL);
        }
        $cmd = $db->prepare('UPDATE newsletter SET sent = 1 WHERE id = ?');
        $cmd->execute([$mail['id']]);
    }

}