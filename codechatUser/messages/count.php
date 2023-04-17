<?php
include("../src/utils.php");
include("../../database.php");

checkSessionElseLogin();
$db = getDatabase();

$count = $db->prepare('SELECT COUNT(content) AS count FROM message WHERE :user IN (author, receiver)');
$count->execute(['user' => $_SESSION['user']]);
echo $count->fetch()[0];
