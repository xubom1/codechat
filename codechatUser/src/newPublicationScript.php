<?php
include("utils.php");
include("../../database.php");

checkSessionElseLogin();

//check that the user is given
if (empty($_POST['content'])) exit();

//check content max-size
if(strlen($_POST['content']) > 10000) die('content is too long !');

//send
$db = getDatabase();
$newPublication = $db->prepare('INSERT INTO publication(content, creator) VALUES(:content, :creator)');
$newPublication->execute([
    'content' => $_POST['content'],
    'creator' => $_SESSION['user']
]);

header('location: /');