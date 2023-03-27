<?php
include('pages/utils.php');
checkSessionElseLogin();

include('../database.php');
$db = getDatabase();

$user = $_GET['user'];

if (isset($user) && !empty($user)){
    $cmd = $db->prepare('DELETE FROM user WHERE pseudo = ?');
    $cmd->execute([$user]);
    header('location: manageUser.php');
}