<?php
include('../../pages/utils.php');
checkSessionAdminElseLogin('.');

include('../../../database.php');
$db = getDatabase();

include('../../mailFunction.php');

date_default_timezone_set('Europe/Paris');

$cmd = $db->prepare('SELECT * FROM send WHERE id = 1');
$cmd->execute([]);
$get = $cmd->fetchAll(PDO::FETCH_ASSOC)[0];

if ($get) {
    echo 'Envoyer le mail dans ' . $get['month'] . ' mois et ' . $get['day'] . ' jour.<br>';

    // next date
    $newMonth = date('Y-m-d', strtotime($get['lastSendDate']. ' + ' . $get['month'] . ' months'));
    $newDate = date('Y-m-d', strtotime($newMonth. ' + ' . $get['day'] . ' days'));

    // next time
    $newHour = date('H:i:s', strtotime($get['lastSendTime'] . ' + ' . $get['hour'] . 'hour'));
    $newTime = date('H:i:s', strtotime($newHour. ' +' . $get['minute'] . 'minutes'));

    if ($newDate === date('Y-m-d')){
        if ($newTime == date('H:i'.':00')){
            $getUser = $db->prepare('SELECT id, pseudo, mail FROM user WHERE lastLogin < ?');
            $getUser->execute([$get['date']]);
            $showAll = $getUser->fetchAll(PDO::FETCH_ASSOC);
            if ($showAll) {
                $subject = 'Your account gonna be deleted';
                foreach ($showAll as $user) {
                    $body = 'Hello ' . $user['pseudo'] . '<br> Your account will be deleted if you do not log in. Here is the access link: codechat.fr';
                    sendMail('support@codechat.fr', 'Codechat Support', $user['mail'], $user['pseudo'], NULL, NULL, $subject, $body, $body);
                    echo $user['pseudo'];
                }
            }
        }
    }



}