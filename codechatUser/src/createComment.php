<?php
include("template.php");
include("utils.php");
include("../../database.php");

checkSessionElseLogin();

$db = getDatabase();

if (empty($_POST['content']) || empty($_POST['publication'])){
    header('location: /');
}

$createComment = $db->prepare('INSERT INTO publication(content, respondTo, creator) VALUES(:content, :publication, :author)');
$createComment->execute([
    'content' => htmlspecialchars($_POST['content']),
    'publication' => $_POST['publication'],
    'author' => $_SESSION['user']
]);

header("location: /publication.php?id=" . $_POST['publication']);

