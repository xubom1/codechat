<?php
include('../pages/utils.php');
checkSessionAdminElseLogin('../');

//include database
include('../../database.php');
$db = getDatabase();

$user = htmlspecialchars($_GET['user']);

if (!empty($user)) {
    $banUser = $db->prepare('UPDATE user SET banned=1 WHERE pseudo = ?');
    $SendCmd = $banUser->execute([$user]);
} else {
    header('location: index.php?msg=error when we banned, we don\'t found the user ! ');
}
