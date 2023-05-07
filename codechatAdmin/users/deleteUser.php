<?php
include('../pages/utils.php');
checkSessionAdminElseLogin();

include('../../database.php');
$db = getDatabase();

$user = $_GET['user'];

if (isset($user) && !empty($user)){
    $cmd = $db->prepare('DELETE FROM user WHERE pseudo = ?');
    $cmd->execute([$user]);
    header('location: searchUsers/index.php?msg=the user has been successfully deleted&err=false');
}