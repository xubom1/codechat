<?php
include('../../pages/utils.php');
checkSessionAdminElseLogin('../..');


function error()
{
    if (isset($_GET['msg']) && !empty($_GET['msg'])) {
        return htmlspecialchars($_GET['msg']);
    }
}

$content = '
    <br>
    <div class="m-auto input-group" style="width: 500px">
        <input type="text" id="search" class="form-control" placeholder="Search">
        <button class="btn btn-success" onclick="searchUser()" id="searchBtn">Search</button>
        <button class="btn btn-primary" onclick="location.href=\'index.php\'">Reset</button>
    </div>
    <div class="d-flex flex-row m-2 d-flex justify-content-center">
        <div class="form-check m-2">
          <input class="form-check-input" type="checkbox" value="" name="pseudo" id="flexCheck1" onclick="validate()">
          <label class="form-check-label" for="flexCheckChecked">
            Pseudo
          </label>
        </div>
        <div class="form-check m-2">
          <input class="form-check-input" type="checkbox" value="" id="flexCheck2" onclick="validate()">
          <label class="form-check-label" for="flexCheckDefault">
            mail
          </label>
        </div>
        <div class="form-check m-2">
          <input class="form-check-input" type="checkbox" value="" id="flexCheck3" onclick="validate()">
          <label class="form-check-label" for="flexCheckChecked">
            first Name
          </label>
        </div>
        <div class="form-check m-2">
          <input class="form-check-input" type="checkbox" value="" id="flexCheck4" onclick="validate()">
          <label class="form-check-label" for="flexCheckChecked">
            last Name
          </label>
        </div>
    </div>
    
    <p class="describe" id="description"></p>
';

if (isset($_GET['err'])){
    $content .= "
    <div class='container mt-5 ' style=''>
        <p class='text-center" . ((isset($_GET['err']) && $_GET['err'] == 'true') ? " alert alert-danger mt-4" : " alert alert-success mt-4") . "'> 
        " . error() . "
        </p>
    </div>
";
}


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
        <tbody id='userRow' class='table-group-divider'>
";


// import table
include('../../../database.php');
$db = getDatabase();

//get some users in the database
$cmd = $db->prepare('SELECT * FROM user WHERE admin=0 AND banned=0 ORDER BY creation ASC LIMIT 10');
$cmd->execute();
$users = $cmd->fetchAll();

foreach ($users as $i => $user){
    $content .= sprintf("
    <tr>
        <th scope='row'>%d</th>
        <td>%s</td>
        <td>%s</td>
        <td>%s</td>
        <td>%s</td>
        <td class='d-flex justify-content-end'>
            <button class='btn btn-secondary btn-sm' onclick='location.href=\"../manageUser.php?user=%s\"'>manage profile</button>
        </td>
    </tr>
    ", $i + 1, $user['pseudo'], $user['mail'], $user['firstName'], $user['lastName'], $user['pseudo']);
}


$content .= "
            
        </tbody>
    </table>
    <script src='searchUser.js'></script>
";


include("../../pages/template.php");
echo makePage('User', $content, '../../');