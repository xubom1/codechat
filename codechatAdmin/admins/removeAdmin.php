<?php

include("../pages/utils.php");
checkSessionAdminElseLogin('../.');


if (!isset($_POST['admin'])){
    header('location: searchUsers/index.php?msg=Admin cannot find&err=true');
    exit;
}

$admin = htmlspecialchars($_POST['admin']);

include('../../database.php');
$db = getDatabase();

$cmd = $db->prepare('SELECT id FROM user WHERE pseudo = ?');
$cmd->execute([$admin]);
$ok = $cmd->fetchAll(PDO::FETCH_ASSOC);

if ($ok){
    $cmd = $db->prepare('UPDATE user SET admin = 0 WHERE pseudo = ?');
    $cmd->execute([$admin]);
    header('location: index.php?msg='. $admin .' is not admin');
    exit;
} else {
    header('location: index.php?msg=Problem&err=true');
}