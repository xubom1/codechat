<?php
include('../pages/utils.php');
checkSessionAdminElseLogin('../.');

include('../../database.php');
$db = getDatabase();


if ($_POST['sendTo'] === 'Send to'){
    header('location: index.php?msg=Thanks to put the destination.');
    exit;
}

if (!isset($_POST['title']) || empty($_POST['title']) ||
    !isset($_POST['content']) || empty($_POST['content']) ||
    !isset($_POST['date']) || empty($_POST['date']) ||
    !isset($_POST['time']) || empty($_POST['time']))
{
    header('location: index.php?msg=Please complete all field');
    exit;
}

date_default_timezone_set('Europe/Paris');
$sendDateTime = $_POST['date'].' '.$_POST['time'].':00';

if ($_POST['date'] < date('Y-m-d')){
    header('location: index.php?msg=date invalide.');
    exit;
}

if ($_POST['date'] == date('Y-m-d') && $_POST['time'] < date('H:m')){
    header('location: index.php?msg=time invalide');
    exit;
}


$cmd = $db->prepare('INSERT INTO newsletter (title, content, creationDateTime, sendDateTime, createBy, sendTo) VALUES (?, ?, ?, ?, ?, ?)');
$cmd->execute([$_POST['title'], $_POST['content'], date('Y-m-d H:m:s'), $sendDateTime, $_SESSION['admin'], $_POST['sendTo']]);
header('location: index.php?msg=Newsletter is send');