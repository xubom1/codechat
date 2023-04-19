<?php
include("utils.php");
include("../../database.php");

checkSessionElseLogin();
$db = getDatabase();

//check
if (empty($_POST['user']) || !isset($_POST['follow'])) exit();

$follow = $db->prepare('INSERT INTO follow(follower, followed) VALUES(:sessionUser, :user)');
$unfollow = $db->prepare('DELETE FROM follow where follower = :sessionUser AND followed = :user');

if ($_POST['follow'] != 0)
    $commandToExecute = 'unfollow';
else $commandToExecute = 'follow';

$$commandToExecute->execute([
    'sessionUser' => $_SESSION['user'],
    'user' => $_POST['user']
]);