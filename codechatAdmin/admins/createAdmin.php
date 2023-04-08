<?php
include('../pages/utils.php');
checkSessionAdminElseLogin();

if (!isset($_GET['name']) || !isset($_GET['password'])){
    header("location: ./");
}

include('../../database.php');
$db = getDatabase();

$cmd = $db->prepare('SELECT EXISTS(SELECT * from user WHERE pseudo=? AND admin)');
$cmd->execute([$_SESSION['admin']]);

if ($cmd->fetchAll()[0][0]){
    header('location: ./?msg=user already exists !');
}

$cmd = $db->prepare('INSERT INTO user (pseudo, mail, password, admin) VALUES(?, ?, ?, ?)');

$cmd->execute([
    $_GET['name'],
    $_GET['mail'],
    password_hash($_GET['password'], PASSWORD_BCRYPT),
    1
]);

header('location: ./');

