<?php
include('../pages/utils.php');
checkSessionElseLogin();

include('../../database.php');
$db = getDatabase();

$cmd = $db->prepare('SELECT * FROM user WHERE admin=1');
$cmd->execute();
$admins = $cmd->fetchAll();

if (!isset($_POST['admin']) || !isset($_POST['password'])) header('location: ./');

foreach ($admins as $admin){
    if ($admin['pseudo'] === $_POST['admin']){
        $cmd = $db->prepare('UPDATE user SET password=? WHERE pseudo=? AND admin=?');
        $cmd->execute([
            password_hash(htmlspecialchars($_POST['password']), PASSWORD_BCRYPT),
            $_POST['admin'],
            1
        ]);
    }
}
header('location: ./');
