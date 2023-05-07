<?php
include('../pages/utils.php');
checkSessionAdminElseLogin('../');

//include database
include('../../database.php');
$db = getDatabase();

if (empty($_GET['idPublication'])) {
    header('location: index.php?msg=user not found or publication&err=true');
    exit();
}

$idPubli = htmlspecialchars($_GET['idPublication']);

$cmd = $db->prepare('SELECT id FROM newsletter WHERE id = ?');
$cmd->execute([$idPubli]);
$checkPubli = $cmd->fetchAll(PDO::FETCH_ASSOC);

if (!$checkPubli){
    header('location: index.php?msg=The publication does not exist&err=true');
}

$deletePublication = $db->prepare('DELETE FROM publication WHERE id = ?');
$deletePublication->execute([$idPubli]);
header('location: index.php?msg=The publication deleted&err=false');