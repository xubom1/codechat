<?php

include('../pages/utils.php');
checkSessionAdminElseLogin('../');

if (!isset($_GET['user'])){
    header('location: searchUsers/index.php?msg=Problem');
    exit;
}

$user = htmlspecialchars($_GET['user']);

include('../../database.php');
$db = getDatabase();

$cmd = $db->prepare('SELECT id FROM user WHERE pseudo = ?');
$cmd->execute([$user]);
$ok = $cmd->fetchAll(PDO::FETCH_ASSOC);

if ($ok){
    $cmd = $db->prepare('UPDATE user SET admin = 1 WHERE pseudo = ?');
    $cmd->execute([$user]);
    header('location: ../admins/index.php?msg='. $user .' is admin');
    exit;
} else {
    header('location: searchUsers/index.php?msg=Problem');
}