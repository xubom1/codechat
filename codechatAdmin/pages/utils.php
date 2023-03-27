<?php

function doesAdminNameExists($name, $database){
    $exist = $database->prepare("SELECT EXISTS(SELECT * FROM user WHERE pseudo=:name AND admin = 1)");
    $exist->execute([
        "name" => $name
    ]) or die(print_r("db errors :" . $database->errorInfo()));

    return $exist->fetchAll()[0][0];
}

function checkSessionElseLogin($rootpath = '..'){
    session_start();
    if (!isset($_SESSION['admin'])){
        header("location: $rootpath/admin/login.php?msg=session is not valid, please identify&err=true");
    }
}

function checkNotSessionElseMainPage(){
    session_start();
    if (isset($_SESSION['admin'])){
        header("location: ../?");
    }
}
