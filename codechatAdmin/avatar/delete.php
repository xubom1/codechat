<?php
include('../pages/utils.php');
checkSessionAdminElseLogin('..');

include('../../database.php');
$db = getDatabase();

if (empty($_GET['component'])) header('location: ./');

try{
    $getComponent = $db->prepare('SELECT path FROM avatarcomponent WHERE id = :component');
    $deleteOwnerships = $db->prepare('DELETE FROM avatarownership WHERE component = :component');
    $deleteComponent = $db->prepare('DELETE FROM avatarcomponent WHERE id = :component');

    $v = ['component' => $_GET['component']];

    $getComponent->execute($v);
    $component = $getComponent->fetch(PDO::FETCH_ASSOC);
    $deleteOwnerships->execute($v);
    $deleteComponent->execute($v);

    //delete file and link to the file in the user folder
    unlink('../../codechatUser/' . $component['path']);
    unlink('components/' . pathinfo($component['path'], PATHINFO_FILENAME) . '.' . pathinfo($component['path'], PATHINFO_EXTENSION));
}
catch (Exception $e){
    header('location: ./');
}

header('location: ./');



