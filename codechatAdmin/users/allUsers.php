<?php
include('../pages/utils.php');
checkSessionAdminElseLogin('.');

include('../../database.php');
$db = getDatabase();

//get some users in the database
$cmd = $db->prepare('SELECT * FROM user WHERE admin=0 AND banned=0 ORDER BY creation ASC');
$cmd->execute();
$users = $cmd->fetchAll();

function error()
{
    if (isset($_GET['msg']) && !empty($_GET['msg'])) {
        return htmlspecialchars($_GET['msg']);
    }
}

$content = '
    <br>
    <div class="input-group m-auto" style="width:500px; ">
      <input type="search" id="search" class="form-control rounded" placeholder="Search" aria-label="Search" aria-describedby="search-addon"/>
    </div>
';

$content .= "
    <div class='container mt-5 '>
        <p class='text-center " . ((isset($_GET['err']) && $_GET['err'] == 'true') ? "text-danger" : " ") . "'> 
        " . error() . "
        </p>
    </div>
";

$content .= "
    <table class='table table-striped table-hover'>
        <thead>
            <tr>
                <th scope='col'>#</th>
                <th scope='col'>pseudo</th>
                <th scope='col'>mail</th>
                <th scope='col'>first name</th>
                <th scope='col'>last name</th>
                <th scope='col'></th>
            </tr>
        </thead>
        <tbody class='table-group-divider'>
";

foreach ($users as $i => $user){
    $content .= sprintf("
    <tr>
        <th scope='row'>%d</th>
        <td>%s</td>
        <td>%s</td>
        <td>%s</td>
        <td>%s</td>
        <td class='d-flex justify-content-end'>
            <button class='btn btn-secondary btn-sm' onclick='location.href=\"manageUser.php?user=%s\"'>manage profile</button>
        </td>
    </tr>
    ", $i + 1, $user['pseudo'], $user['mail'], $user['firstName'], $user['lastName'], $user['pseudo']);
}

$content .= "
        </head>
    </table>
";


include("../pages/template.php");
echo makePage($content);
