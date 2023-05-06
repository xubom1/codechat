<?php
include('../pages/utils.php');
include('../pages/template.php');
checkSessionAdminElseLogin('../');

include("../../database.php");
$db = getDatabase();

if (!isset($_GET['id']) || empty($_GET['id'])){
    header('location: index.php?msg=Error can\'t deleted&err=true');
}

$cmd = $db->prepare('UPDATE newsletter SET deleted = 1 WHERE id = ?');
$cmd->execute([$_GET['id']]);
header('location: index.php?msg=The message has been deleted.&err=false');