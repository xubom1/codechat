<?php
include('../../pages/utils.php');
checkSessionAdminElseLogin('.');

if (!isset($_GET['id']) || empty($_GET['id'])){
    header('location: ../index.php?msg=error&err=true');
}

include('../../../database.php');
$db = getDatabase();

$get = $db->prepare('SELECT pseudo, mail, lastLogin FROM user WHERE id = ?');
$get->execute([$_GET['id']]);
$getUser = $get->fetchAll(PDO::FETCH_ASSOC)[0];

$content = '
        <h3 class="text-center">Email detail</h3>
        <form method="post" action="sendMail.php">
            <label class="mt-2">Pseudo :</label>
            <input class="form-control mt-1" value="'. $getUser['pseudo'] .'" name="pseudo" readonly>
            <label class="mt-2">Mail :</label>
            <input class="form-control mt-1" type="email" value="'. $getUser['mail'] .'" name="mail" readonly>
            <label class="mt-2">Title :</label>
            <input class="form-control mt-1" value="Inactive account" name="title">
            <label class="mt-2">Message :</label>
            <input class="form-control mt-1" type="textarea" name="content" value="Hello '. $getUser['pseudo'] .', Your account will be deleted if you do not log in. Here is the access link: codechat.fr . ">
            <button type="submit" class="btn btn-primary col-12 mt-3">Send mail</button>
        </form>
';

include("../../pages/template.php");
echo makePage('Send Mail', $content, '../..');