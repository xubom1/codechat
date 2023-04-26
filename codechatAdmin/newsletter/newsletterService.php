

<?php

//#! /usr/bin/env php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require '../../lib/PHPMailer/src/Exception.php';
require '../../lib/PHPMailer/src/PHPMailer.php';
require '../../lib/PHPMailer/src/SMTP.php';

include('../../database.php');
$db = getDatabase();

$sendMail = $db->prepare('SELECT * FROM newsletter WHERE sent = 0');

$sendMail->execute([]);
$getMail = $sendMail->fetchAll(PDO::FETCH_ASSOC);

date_default_timezone_set('Europe/Paris');

$date = date('H:i:s');
$newDate = date('H:i:s', strtotime($date. ' +1 minutes'));


foreach ($getMail as $mail){
    if ($mail['sendDateTime'] >= date('Y-m-d H:m:s') && $mail['sendDateTime'] <= $newDate){
        var_dump($mail);
    }
}