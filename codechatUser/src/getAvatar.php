<?php
include("utils.php");
include("../../database.php");

checkSessionElseLogin();

//check that the user is given
if (empty($_POST['user'])) exit();

$users = explode("\n",$_POST['user']);

$db = getDatabase();

$response = [];
$getPaths = $db->prepare('SELECT avatarcomponent.path, avatarcomponent.type, avatarcomponent.id FROM avatarcomponent CROSS JOIN avatarownership ON avatarcomponent.id = avatarownership.component WHERE avatarownership.owner = :user');

//get all the images that compose the avatar of each user and return the path of the images
foreach ($users as $user){
    $getPaths->execute(['user' => $user]);
    $response[(int)$user] = $getPaths->fetchAll(PDO::FETCH_ASSOC);
}

//return json text of the response array
echo json_encode($response);

