

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



var_dump($getMail);