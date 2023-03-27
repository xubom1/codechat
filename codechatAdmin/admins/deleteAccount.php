<?php
include("../pages/utils.php");
checkSessionElseLogin();

if (!isset($_POST['admin'])) header("location: ./");

if ($_SESSION['admin'] === $_POST['admin']){
    header("location: ./");
}

include('../../database.php');
$db = getDatabase();

$cmd = $db->prepare('DELETE FROM user WHERE pseudo=? AND admin=?');
$cmd->execute([
    $_POST['admin'],
    1
]);
header('location: ./');








