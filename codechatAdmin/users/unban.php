<?php
include('../pages/utils.php');
checkSessionAdminElseLogin('.');

include ('../../database.php');
$db = getDatabase();

$user = htmlspecialchars($_GET['user']);

if (isset($_GET['user']) && empty($_GET['user'])){
    header('location: banUser.php?msg=user not found&err=true');
    exit;
}

$cmdCheck = $db->prepare('SELECT EXISTS(SELECT * FROM user WHERE pseudo = ? AND banned = 1)');
$cmdCheck->execute([$user]);
$users = $cmdCheck->fetch();

if ($users > 0){
    $cmd = $db->prepare('UPDATE user SET banned=0 WHERE pseudo = ?');
    $cmd->execute([$user]);
    header('location: allUsers.php?msg=user banned&err=false');
}