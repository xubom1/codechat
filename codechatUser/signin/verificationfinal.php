<?php
include('../../database.php');
session_start();

$db = getDatabase();
$pseudo = $_SESSION['pseudo'];
$mail = $_SESSION['mail'];
$password = $_SESSION['password'];
$lastName = $_SESSION['lastName'];
$firstName = $_SESSION['firstName'];
$postalCode = $_SESSION['postalCode'];
$city = $_SESSION['city'];
$address = $_SESSION['address'];


$q = 'SELECT pseudo FROM user WHERE pseudo = :pseudo';
$req = $db->prepare($q);
$req->execute(['pseudo' => $pseudo]);
$response = $req->fetch(); 
if($response){
    $msg = 'The nickname is already in use';
    header ('location: sign_in.php?msg='. $msg);
    exit();
}

$q = 'SELECT mail FROM user WHERE mail = :mail';
$req = $db->prepare($q);
$req->execute(['mail' => $mail]);
$response = $req->fetch(); 
if($response){
    $msg = 'The email address is already in use';
    header ('location: sign_in.php?msg='.$msg);
    exit();
}

$q = 'INSERT INTO user (pseudo, mail, lastName, firstName, postalCode, city, address, password) VALUES (:pseudo, :mail, :lastName, :firstName, :postalCode, :city, :address, :password)';
$req = $db->prepare($q);
$reponse = $req->execute([
    'pseudo' => htmlspecialchars($pseudo),
    'mail' =>  htmlspecialchars($mail),
    'lastName' => htmlspecialchars($lastName),
    'firstName' => htmlspecialchars($firstName),
    'postalCode' =>  htmlspecialchars($postalCode),
    'city' => htmlspecialchars($city),
    'address' =>  htmlspecialchars($address),
    'password' =>  htmlspecialchars(password_hash($password, PASSWORD_DEFAULT))
]);

if($reponse ==0){
    $msg = 'Erreur lors de l\'inscription en base de données.';
    header('location: sign_in.php?msg=' .$msg);
    exit();
} else {
    $msg = 'successfully created account!!';
    header('location: ../login.php?msg=' .$msg);
    exit;
}


?>