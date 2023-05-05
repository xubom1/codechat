<?php
include("utils.php");
include("../../database.php");

checkSessionElseLogin();

$db = getDatabase();

if (isset($_GET['pseudo'])){
    try{
        $pseudo = $db->prepare('UPDATE user SET pseudo=:value WHERE id=:user');
        $pseudo->execute([
            'value' => htmlspecialchars($_GET['pseudo']),
            'user' => $_SESSION['user']
        ]);

        $_SESSION['pseudo'] = htmlspecialchars($_GET['pseudo']);
    }
    catch(Exception $e){}
}

if (isset($_GET['mail'])){
    try{
        $pseudo = $db->prepare('UPDATE user SET mail=:value WHERE id=:user');
        $pseudo->execute([
            'value' => htmlspecialchars($_GET['mail']),
            'user' => $_SESSION['user']
        ]);
    }
    catch(Exception $e){}
}

if (isset($_GET['lastName'])){
    try{
        $pseudo = $db->prepare('UPDATE user SET lastName=:value WHERE id=:user');
        $pseudo->execute([
            'value' => htmlspecialchars($_GET['lastName']),
            'user' => $_SESSION['user']
        ]);
    }
    catch(Exception $e){}
}

if (isset($_GET['firstName'])){
    try{
        $pseudo = $db->prepare('UPDATE user SET firstName=:value WHERE id=:user');
        $pseudo->execute([
            'value' => htmlspecialchars($_GET['firstName']),
            'user' => $_SESSION['user']
        ]);
    }
    catch(Exception $e){}

}

if (isset($_GET['postalCode'])){
    try {
        $pseudo = $db->prepare('UPDATE user SET postalCode=:value WHERE id=:user');
        $pseudo->execute([
            'value' => htmlspecialchars($_GET['postalCode']),
            'user' => $_SESSION['user']
        ]);
    }
    catch(Exception $e){}

}

if (isset($_GET['city'])){
    try {
        $pseudo = $db->prepare('UPDATE user SET city=:value WHERE id=:user');
        $pseudo->execute([
            'value' => htmlspecialchars($_GET['city']),
            'user' => $_SESSION['user']
        ]);
    }
    catch(Exception $e){}

}

if (isset($_GET['address'])){
    try {
        $pseudo = $db->prepare('UPDATE user SET address=:value WHERE id=:user');
        $pseudo->execute([
            'value' => htmlspecialchars($_GET['address']),
            'user' => $_SESSION['user']
        ]);
    }
    catch(Exception $e){}
}

if (isset($_GET['wantNews'])){
    try {
        $pseudo = $db->prepare('UPDATE user SET wantNews=!wantNews WHERE id=:user');
        $pseudo->execute([
            'user' => $_SESSION['user']
        ]);
    }
    catch(Exception $e){}
}

header('location: /profile.php');