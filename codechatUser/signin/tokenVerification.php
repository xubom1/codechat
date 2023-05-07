<?php
include ('../../database.php');

$db = getDatabase();

if (empty($_GET['token'])){
    header('location:/');
    exit;
}

$check = $db->prepare('SELECT owner, creation FROM token WHERE token = :token');
$check->execute(['token' => $_GET['token']]);
$token = $check->fetch(PDO::FETCH_ASSOC);

if (!$token) header('location: /login.php?your token is invalid !&err=true');

$expiration = strtotime($token['creation']) + 60 * 60 * 2; //add one hour
if ($expiration - time() < 0) header('location: /login.php?msg=your token is too old now !&err=true');

var_dump($token);

$verif = $db->prepare('UPDATE user SET verif = 1 WHERE id = :user');

if (!$verif->execute(['user' => $token['owner']])){
    header('location: /login.php?msg=failed to verify the account !&err=true');
    exit;
}

header('location: /login.php?msg= your account is now verified, your can sign in !');