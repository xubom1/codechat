<?php
include('../../pages/utils.php');
checkSessionAdminElseLogin('../..');

include('../../mailFunction.php');

if (!isset($_POST['pseudo']) && empty($_POST['pseudo'])
    || !isset($_POST['mail']) && empty($_POST['mail'])
    || !isset($_POST['title']) && empty($_POST['title'])
    || !isset($_POST['content']) && empty($_POST['content'])){
    header('location: ../index.php?msg=Error&err=true');
    exit;
}

$send = sendMail('support@codechat.fr', 'Codechat Support', $_POST['mail'], $_POST['pseudo'], NULL, NULL, $_POST['title'], $_POST['content'], $_POST['content'], '../index.php');

if ($send === 'ok'){
    header('location: ../index.php?msg=Message send');
}