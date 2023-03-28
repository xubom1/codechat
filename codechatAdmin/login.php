<?php
include('pages/utils.php');
checkNotSessionElseMainPage();

include('pages/template.php');


$msg =   $_GET['msg'] ?? 'please identify to continue';
$class = isset($_GET['err']) && $_GET['err'] ? 'text-danger' : '';
$msg =  "<p class='text-center $class'>$msg</p>";


$content = "
<div class='container mt-5 '>
    <h1 class='text-center text-decoration-underline mb-5'>Hello admin !</h1>
    <p class='text-center " . ((isset($_GET['err']) && $_GET['err'] == 'true') ? "text-danger" : " ") . "'>
    " .  ($_GET['msg'] ?? "please identify") . "
    </p>
</div>
    
<div class='my-1 p-3 row justify-content-center'>
    <form action='check.php' method='post' class='col-5'>
        <div class='mb-3'>
            <label for='id' class='form-label'>identifier</label>
            <input type='text' name='id'  class='form-control' placeholder='myId'>
        </div>

        <div class='mb-3'>
            <label for='password' class='form-label'>password</label>
            <input type='password' name='password' class='form-control' placeholder=''>
        </div>

        <div class='mt-4'>
            <input type='submit' value='login' class='btn btn-primary'>
        </div>
    </form>
</div>";

echo makePage($content, '.');


