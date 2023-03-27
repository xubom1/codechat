<?php
include("../pages/utils.php");
checkSessionElseLogin();

if (empty($_POST['id']) || empty($_POST['password'])){
    header("location: index.php?msg&you can't create empty admin");
}

//open database
include('../../database.php');
$db = getDatabase();

//
if (!doesAdminNameExists($_POST['id'], $db)){
    $insertion = $db->prepare('INSERT INTO user(pseudo, password) VALUES(:name, :password)');

    $insertion->execute([
        "name" => $_POST['id'],
        "password" => password_hash(htmlspecialchars( $_POST['password']), PASSWORD_BCRYPT)
    ]) or die(print_r($db->errorInfo()));
}

