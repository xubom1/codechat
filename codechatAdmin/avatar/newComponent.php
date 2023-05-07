<?php
include('../pages/utils.php');
checkSessionAdminElseLogin('..');

$alert = "";

if (!empty($_GET['msg'])){
    $alert = "
        <div class='alert alert-info' role='alert'>
            " . $_GET['msg'] . "
        </div>
    ";
}

if (!empty($_GET['err'])){
    $alert = "
        <div class='alert alert-danger' role='alert'>
            " . $_GET['err'] . "
        </div>
    ";
}

$content = "
    <div class='container'>
        <h3 class='text-center mb-5'>new avatar component page</h3>
        $alert
        <form action='newComponentScript.php' method='post' enctype='multipart/form-data' class='d-flex flex-column'>
            <label for='name' class='form-label'>name of the component (ex: blue glasses)</label>
            <input type='text' name='name' class='form-control mb-3' required>
            
            <label for='image' class='form-label'>component</label>
            <input type='file' accept='.png, .jpg, .jpeg' name='image' id='avatarComponentInput' class='form-control mb-3' required>
            
            <label for='type' class='form-label'>type of the component (work also as a z-index in the result)</label>
            <input type='number' min='0' name='type' class='form-control' required>
            
            <input type='submit' class='btn btn-outline-primary mt-4 align-self-end' value='create'>
        </form>
    </div>
";

include("../pages/template.php");
echo makePage('Avatar', $content);