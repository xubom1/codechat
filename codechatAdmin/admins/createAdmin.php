<?php
include('../pages/utils.php');
checkSessionAdminElseLogin();

if (!isset($_POST['name']) || !isset($_POST['password'])){
    header("location: index.php?msg=Complete all the field&err=true");
}

include('../../database.php');
$db = getDatabase();

$cmd = $db->prepare('SELECT id from user WHERE pseudo=?');
$cmd->execute([$_POST['name']]);
$test = $cmd->fetchAll(PDO::FETCH_ASSOC);

if ($test){
    header('location: index.php?msg=user already exists !&err=true');
    exit;
}

$cmd = $db->prepare('INSERT INTO user (pseudo, mail, password, admin) VALUES(?, ?, ?, ?)');

$cmd->execute([
    $_POST['name'],
    $_POST['mail'],
    password_hash($_GET['password'], PASSWORD_BCRYPT),
    1
]);

header('location: ./');

