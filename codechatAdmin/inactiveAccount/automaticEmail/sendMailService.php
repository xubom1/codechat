#!/usr/bin/php

<?php

function Database(){
    try{
        $db = new PDO(
            'mysql:host=localhost;dbname=codechat;charset=utf8',
            'root',
            'esgi',
            [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]
        );
    }
    catch (Exception $e){
        die("failed to connect to the database !\n errors : " . $e->getMessage());
    }
    return $db;
}

$db = Database();

include('../../mailFunction.php');

date_default_timezone_set('Europe/Paris');

while(true){
    sleep(60);
    $cmd = $db->prepare('SELECT * FROM send WHERE id = 1');
    $cmd->execute([]);
    $get = $cmd->fetchAll(PDO::FETCH_ASSOC)[0];

    if ($get) {

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
                        $body = 'Hello ' . $user['pseudo'] . ',<br> Your account will be deleted if you do not log in. Here is the access link: codechat.fr';
                        sendMail('support@codechat.fr', 'Codechat Support', $user['mail'], $user['pseudo'], NULL, NULL, $subject, $body, $body);
                    }
                    $update = $db->prepare('UPDATE send SET lastUpdate = ? WHERE id = ?');
                    $update->execute([date('Y-m-d'), 1]);
                }
            }
        }



    }
}
