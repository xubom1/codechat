-+<?php
session_start();

if(!isset($_POST['username']) || !isset($_POST['password'])){
    header("location: ../login.php");
}

include('../../database.php');
$db = getDatabase();

$cmd = $db->prepare('SELECT password, id FROM user WHERE pseudo=?');
$cmd->execute([$_POST['username']]);
$res = $cmd->fetch();

if (!$res){
    header("location: ../login.php?msg=username is not correct !&err=true");
}

if (password_verify($_POST['password'], $res['password'])){
    //set session var
    $_SESSION['user'] = $res['id'];
    $_SESSION['pseudo'] = $_POST['username'];

    //update lastLogin in database
    $cmd = $db->prepare('UPDATE user SET lastLogin=NOW() WHERE id = ?');
    $cmd->execute([$_SESSION['user']]);

    //redirect user in index.php
    header("location: /");
}
header("location: ../login.php?msg=password is not correct !&err=true");

