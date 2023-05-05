<?php
include("utils.php");
include("../../database.php");

checkSessionElseLogin();

if (empty($_GET['id'])){
    header('location: /');
}

$db = getDatabase();

$getAuthor = $db->prepare('SELECT creator FROM publication WHERE id=:publication');
$getAuthor->execute(['publication' => $_GET['id']]);

if ($getAuthor->fetch(PDO::FETCH_ASSOC)['creator'] === $_SESSION['user']){
    $del = $db->prepare('DELETE FROM publication WHERE id=:publication');
    $del->execute(['publication' => $_GET['id']]);
}

header('location: /');