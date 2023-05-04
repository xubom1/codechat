<?php
include('../pages/utils.php');
checkSessionAdminElseLogin('../');

include('../../database.php');
$db = getDatabase();


if ($_POST['sendTo'] === 'Send to'){
    header('location: index.php?msg=Thanks to put the destination.');
    exit;
}

if (!isset($_POST['title']) || empty($_POST['title']) ||
    !isset($_POST['content']) || empty($_POST['content']))
{
    header('location: index.php?msg=Please complete all field');
    exit;
}

$title = $_POST['title'];
$content = $_POST['content'];

$cmd = $db->prepare('INSERT INTO newsletter (title, content, creationDateTime, createBy, sendTo) VALUES (?, ?, ?, ?, ?)');
$cmd->execute([$_POST['title'], $_POST['content'], date('Y-m-d H:m:s'), $_SESSION['admin'], $_POST['sendTo']]);
header('location: index.php?msg=Message has been send&err=false');