<?php
include('../../pages/utils.php');
checkSessionAdminElseLogin('.');


function error()
{
    if (isset($_GET['msg']) && !empty($_GET['msg'])) {
        return htmlspecialchars($_GET['msg']);
    }
}

$content = '
    <br>
    <div class="container-fluid m-auto form-check-inline d-flex justify-content-center" style="width: 500px">
        <input type="search" id="search" class="form-control rounded" placeholder="Search" aria-label="Search" aria-describedby="search-addon"/>
        <button class="btn btn-success" onclick="searchUser()">Cliquez</button>
    </div>
    <div class="d-flex flex-row m-2 d-flex justify-content-center">
        <div class="form-check m-2">
          <input class="form-check-input btnSearch" type="checkbox" id="flexCheckDefault" onclick="formClick()" checked>
          <label class="form-check-label" for="flexCheckDefault">
            All
          </label>
        </div>
        <div class="form-check m-2">
          <input class="form-check-input" type="checkbox" value="test" name="pseudo" id="flexCheck1" disabled>
          <label class="form-check-label" for="flexCheckChecked">
            Pseudo
          </label>
        </div>
        <div class="form-check m-2">
          <input class="form-check-input" type="checkbox" value="" id="flexCheck2" disabled>
          <label class="form-check-label" for="flexCheckDefault">
            mail
          </label>
        </div>
        <div class="form-check m-2">
          <input class="form-check-input" type="checkbox" value="" id="flexCheck3" disabled>
          <label class="form-check-label" for="flexCheckChecked">
            first Name
          </label>
        </div>
        <div class="form-check m-2">
          <input class="form-check-input" type="checkbox" value="" id="flexCheck4" disabled>
          <label class="form-check-label" for="flexCheckChecked">
            last Name
          </label>
        </div>
    </div>
    
    <p class="describe" id="description"></p>
';

$content .= "
    <div class='container mt-5 ' style='width: 150px'>
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
        <tbody id='userRow' class='table-group-divider'>
";


$content .= "
        </head>
    </table>
    <script src='searchUser.js'></script>
";


include("../../pages/template.php");
echo makePage($content, '../../');
