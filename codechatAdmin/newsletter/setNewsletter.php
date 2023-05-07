<?php

include('../pages/utils.php');
include('../pages/template.php');
checkSessionAdminElseLogin('../');

include("../../database.php");
$db = getDatabase();


if (!isset($_POST['title']) || empty($_POST['title'])
    && !isset($_POST['content']) || empty($_POST['content'])
    && !isset($_POST['date']) || empty($_POST['time'])){
    header('location: index.php?msg=complete all the fields to schedule a newsletter&err=true');
    exit;
}

date_default_timezone_set('Europe/Paris');

if ($_POST['date'] < date('Y-m-d')){
    header('location: index.php?msg=date cannot be less than today&err=true');
    exit;
}

if ($_POST['date'] == date('Y-m-d')){
    if ($_POST['time'] <= date('H:i')){
        header('location: index.php?msg=Send time must be greater than today&err=true');
        exit;
    }
}

$title = $_POST['title'];
$content = $_POST['content'];

$timeToSend = $_POST['date'] . ' ' . $_POST['time'];

$cmd = $db->prepare('INSERT INTO newsletter (title, content, creationDateTime, sendDateTime, createBy, sendTo) VALUES (?, ?, ?, ?, ?, ?)');
$cmd->execute([$_POST['title'], $_POST['content'], date('Y-m-d H:i:s'), $timeToSend, $_SESSION['admin'], $_POST['sendTo']]);
header('location: index.php?msg=The message has been programmed.&err=false');