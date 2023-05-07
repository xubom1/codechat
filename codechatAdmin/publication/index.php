<?php
include('../pages/utils.php');
checkSessionAdminElseLogin('../');

//include database
include('../../database.php');
$db = getDatabase();

if (!empty($_GET['msg'])){
    $content = '
        <div class="alert alert-warning" role="alert">
            '. $_GET['msg'] .'
        </div>
    ';
}


$cmd = $db->prepare('SELECT * FROM publication LIMIT 10');
$get = $cmd->execute([]);
$getAll = $cmd->fetchAll();


$content .= "
    <table class='table table-responsive table-hover my-5'>
    <thead>
        <tr>
            <th scope='col' class='col-1' >#</th>
            <th scope='col' class='col-2' >username</th>
            <th scope='col' class='col-8' >Publication</th>
            <th scope='col' class='col' ></th>
        </tr>
    </thead>
    <tbody>
";

foreach ($getAll as $i =>$publication) {
    $cmdUser = $db->prepare('SELECT pseudo FROM user WHERE id=?');
    $getPseudo = $cmdUser->execute([$publication['creator']]);
    $user = $cmdUser->fetch();
    $content .= "
        <tr>
            <th>". $i + 1 ."</th>
            <td>" . $user[0] . "</td>
            <td>" . $publication['content'] . "</td>
            <td class='d-flex justify-content-end'>
                <button class='btn btn-secondary btn-sm' onclick='location.href=\"managePublication.php?publication=". $publication['id'] ."\"'>manage</button>
            </td>
        </tr>
    ";
}

$content .= '
    </tbody>
    </table>
';

include("../pages/template.php");
echo makePage('Publication', $content, '../');