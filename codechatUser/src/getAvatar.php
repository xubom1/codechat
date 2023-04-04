<?php
include("utils.php");
include("../../database.php");

checkSessionElseLogin();

//check that the user is given
if (empty($_POST['user'])) exit();

$db = getDatabase();

$cmd = $db->prepare('SELECT component FROM avatarownership WHERE owner = :user');

$cmd->execute( ['user' => $_POST['user']]);
$components = $cmd->fetchAll(PDO::FETCH_ASSOC);
$images = [];

//if there is some components in the database
if (count($components)){
    $getPath = $db->prepare('SELECT path, type, id FROM avatarcomponent WHERE id = :id');
    foreach ($components as $component){
        $getPath->execute(['id' => $component['component']]);
        $images[] = $getPath->fetch(PDO::FETCH_ASSOC);
    }
    echo json_encode($images);
}
else { //else use the default avatar
    echo json_encode([]);
}
