<?php
include('../pages/utils.php');
checkSessionAdminElseLogin('..');

include('../../database.php');

$db = getDatabase();

$content = "
    <div class='container'>
        <h3 class='text-center mb-5'>avatars administrators page</h3>
        <a href='newComponent.php' class='btn btn-primary'>Add a new component</a>
        
        <div>";

$getAllComponents = $db->query('SELECT type, path, name, id FROM avatarcomponent ORDER BY type');
$components = $getAllComponents->fetchAll(PDO::FETCH_ASSOC);

$currentType = -1;
foreach ($components as $component){
    $type = $component['type'];
    $id = $component['id'];
    //add divs tags at the right correct spot
    if ($type != $currentType){
        if ($currentType != -1){
            $content .= "</div>";
        }
        $content .= "<h4 class='text-center'>components type $type : </h4><div class='border rounded-2 p-2 my-2 d-flex justify-content-evenly type flex-wrap'>";
        $currentType = $type;
    }

    $path = pathinfo($component['path'], PATHINFO_FILENAME) . '.' . pathinfo($component['path'], PATHINFO_EXTENSION);
    $content .= "
        <div class='border rounded p-2 compo'>
            <img src='./components/$path' width='45'>
            <a class='btn btn-danger' href='delete.php?component=$id'>delete</a>
        </div>";
}

$content .= "
        </div>
    </div>
";

include("../pages/template.php");
echo makePage('Avatar', $content);