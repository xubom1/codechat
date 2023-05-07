<?php
include('../pages/utils.php');
checkSessionAdminElseLogin('../');

//include database
include('../../database.php');
$db = getDatabase();


if (empty($_GET['user']) || empty($_GET['idPublication'])) {
    header('location: index.php?msg=user not found or publication&err=true');
    exit();
}
$user = htmlspecialchars($_GET['user']);
$idPubli = htmlspecialchars($_GET['idPublication']);

$cmd = $db->prepare('SELECT id FROM user WHERE pseudo = ?');
$cmd->execute([$user]);
$checkUser = $cmd->fetchAll(PDO::FETCH_ASSOC);

$cmd = $db->prepare('SELECT id FROM newsletter WHERE id = ?');
$cmd->execute([$idPubli]);
$checkPubli = $cmd->fetchAll(PDO::FETCH_ASSOC);

if (!$checkUser){
    header('location: index.php?msg=The user does not exist&err=true');
}

if (!$checkPubli){
    header('location: index.php?msg=The publication does not exist&err=true');
}

$banUser = $db->prepare('UPDATE user SET banned=1 WHERE pseudo = ?');
$SendCmd = $banUser->execute([$user]);

$deletePublication = $db->prepare('DELETE FROM publication WHERE id = ?');
$deletePublication->execute([$idPubli]);
header('location: index.php?msg=The publication deleted and user banned&err=false');