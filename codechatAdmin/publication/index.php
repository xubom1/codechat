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

$content = '
    <div class="m-auto input-group" style="width: 500px">
        <input type="text" id="search" class="form-control" placeholder="Search">
        <button class="btn btn-success" onclick="searchPublication()" id="searchBtn">Search</button>
        <button class="btn btn-primary" onclick="location.href=\'index.php\'">Reset</button>
    </div>
    <p class="describe" id="description"></p>
';

$content .= "
    
    <table class='table table-responsive table-hover my-5'>
    <thead>
        <tr>
            <th scope='col' class='col-2' >username</th>
            <th scope='col' class='col-8' >Publication</th>
            <th scope='col' class='col' >Manage</th>
        </tr>
    </thead>
    <tbody id='publicationRow'>
";

foreach ($getAll as $i =>$publication) {
    $cmdUser = $db->prepare('SELECT pseudo FROM user WHERE id=?');
    $getPseudo = $cmdUser->execute([$publication['creator']]);
    $user = $cmdUser->fetch();
    $content .= "
        <tr>
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
    <script src="getPublication.js"></script>
';

include("../pages/template.php");
echo makePage('Publication', $content, '../');