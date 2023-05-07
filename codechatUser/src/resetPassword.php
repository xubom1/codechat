<?php
include("utils.php");
include('../../database.php');
include('../../codechatAdmin/mailFunction.php');


if (empty($_POST['username'])){
    header('location: ../getNewPassword.php?msg=Complete pseudo field&err=true');
}

function randomPassword() {
    $alphabet = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ1234567890';
    $pass = array();
    $alphaLength = strlen($alphabet) - 1;
    for ($i = 0; $i < 8; $i++) {
        $n = rand(0, $alphaLength);
        $pass[] = $alphabet[$n];
    }
    return implode($pass);
}


$db = getDatabase();
$cmd = $db->prepare('SELECT id, pseudo, mail FROM user WHERE pseudo = ?');
$cmd->execute([$_POST['username']]);
$test = $cmd->fetchAll(PDO::FETCH_ASSOC)[0];

if ($test){
    $newPassword = randomPassword();
    $haspPassword = password_hash($newPassword, PASSWORD_DEFAULT);
    $cmd = $db->prepare('UPDATE user SET password = ? WHERE id = ?');
    $cmd->execute([$haspPassword, $test['id']]);
    $sub = 'Reset a password';
    $cont = 'Hello '. $test['pseudo'] . ', Connect with this password : ' . $newPassword .' Please change the password quickly';
    sendMail('support codechat', 'support', $test['mail'], $test['pseudo'], NULL, NULL, $sub, $cont, $cont, 'getNewPassword.php');
    header('getNewPassword.php?msg=New password has been send.&err=false');
}