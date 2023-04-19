<?php
include("../src/utils.php");
include("../../database.php");

checkSessionElseLogin();
$db = getDatabase();

//check that the form is filled
if (empty($_POST['content']) || empty($_POST['receiver'])) die(0);
if (strlen($_POST['content']) > 255) die(0);

$sendMsg = $db->prepare('INSERT INTO message(author, receiver, content) VALUES(:author, :receiver, :content)');
echo $sendMsg->execute([
    'author' => $_SESSION['user'],
    'receiver' => $_POST['receiver'],
    'content' => $_POST['content']
]);
