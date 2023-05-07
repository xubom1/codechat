<?php
include ('../../database.php');

if (empty($_FILES)) header('location: newComponent.php?err=there is no file attached !');
if (empty($_POST['name'])) header('location: newComponent.php?err=name of the component is not given !');
if (empty($_POST['type'])) header('location: newComponent.php?err=type of the component is not given !');

if ($_FILES['image']['size'] > 500000){
    header('location: newComponent.php?err=file is too big !');
}

$target_dir = "components/";
$target_name = basename($_FILES["image"]["name"]);
$target_file = $target_dir . $target_name;

if (file_exists($target_file)) header('location: newComponent.php?err=file already exists !');

$fileType= strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
if ($fileType != "jpg" && $fileType != "png" && $fileType != "jpeg")
    header('location: newComponent.php?err=file has to be a png, jpg or jpeg format !');

if (move_uploaded_file($_FILES["image"]["tmp_name"], $target_file)) {
    //create a symlink of the image in the user pat of the server
    if (!symlink(realpath($target_file), realpath('../../codechatUser/assets/avatars') . '/' . $target_name))
        header('location: newComponent.php?err=failed to create the link !');

    $db = getDatabase();
    $addComponent = $db->prepare('INSERT INTO avatarcomponent(name, path, type) VALUES(:name, :path, :type)');
    if (!$addComponent->execute([
        'name' => htmlspecialchars($_POST['name']),
        'path' => 'assets/avatars/' . $target_name,
        'type' => $_POST['type']
    ])) header('location: newComponent.php?err=failed to modify the database !');

    header('location: ./?msg=component has been created successfully !');
}
else {
    header('location: newComponent.php?msg=an error occurred !');
}





