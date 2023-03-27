<?php
include('../pages/utils.php');
checkSessionElseLogin();


include ('../../database.php');
$db = getDatabase();

if (isset($_GET['user']) && empty($_GET['user'])){
    header('location: ../allUsers.php?msg=user not found&err=true');
    exit;
}

$user = $_GET['user'];

$cmdCheck = $db->prepare('SELECT EXISTS(SELECT * FROM user WHERE pseudo = ?)');
$cmdCheck->execute([$user]);
$users = $cmdCheck->fetch();

if ($users > 0){
    $cmd = $db->prepare('UPDATE user SET banned=1 WHERE pseudo = ?');
    $cmd->execute([$user]);
    header('location: ../allUsers.php?msg=user banned&err=false');
}

//$cmd = $db->prepare('UPDATE user SET banned=1 WHERE pseudo = ?');
//$cmd->execute([$user]);