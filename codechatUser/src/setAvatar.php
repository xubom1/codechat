<?php
include("utils.php");
include("../../database.php");

checkSessionElseLogin();

$db = getDatabase();

if (empty($_POST['component'])) exit();

//get the type of the component to delete the old component
$getType = $db->prepare('SELECT type FROM avatarcomponent WHERE id = :id');

$getType->execute(['id' => $_POST['component']]);
$component = $getType->fetch(PDO::FETCH_ASSOC);

//delete the old ownership with the same type
$query = 'DELETE avatarownership FROM avatarownership CROSS JOIN avatarcomponent ON avatarownership.component = avatarcomponent.id WHERE avatarownership.owner = :user AND avatarcomponent.type = :type';
$deleteOld = $db->prepare($query);
$deleteOld->execute([
    'user' => $_SESSION['user'],
    'type' => $component['type']
]);

//add the new ownership
$createNew = $db->prepare('INSERT INTO avatarownership(owner, component) VALUES(:user, :component)');
$createNew->execute([
    'user' => $_SESSION['user'],
    'component' => $_POST['component']
]);