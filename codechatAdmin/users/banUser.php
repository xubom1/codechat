<?php
include('../pages/utils.php');
checkSessionAdminElseLogin('.');

include('../../database.php');
$db = getDatabase();

//get some users in the database
$cmd = $db->prepare('SELECT * FROM user WHERE admin=0 AND banned=1 ORDER BY creation ASC');
$cmd->execute();
$users = $cmd->fetchAll();

$content = "
    <h1 class='text-center my-5'>Banned Users</h1>
    
    <div class='modal fade' id='newAdminModal' aria-labelledby='exampleModalLabel' aria-hidden='true'>
        <form action='createAdmin.php' method='get' class='modal-dialog'>
            <div class='modal-content'>
                <div class='modal-header'>
                    <h1 class='modal-title fs-5' id='exampleModalLabel'>new account</h1>
                    <button type='button' class='btn-close' data-bs-dismiss='modal' aria-label='Close'></button>
                </div>
                <div class='modal-body'>
                    <label for='name' class='form-label'>username</label>
                    <input name='name' type='text' class='form-control'>
                    <label for='mail' class='form-label'>e-mail</label>
                    <input name='mail' type='mail' class='form-control'>
                    <label for='password' class='form-label'>password</label>
                    <input type='password' name='password' class='form-control'>
                </div>
                <div class='modal-footer'>
                    <button type='button' class='btn btn-secondary' data-bs-dismiss='modal'>Cancel</button>
                    <input class='btn btn-success' type='submit' value='create'>
                </div>
            </div>
        </form>
    </div>
    
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
    $content .= "
    <tr>
        <th scope='row'>" . ($i + 1) ."</th>
        <td>". $user['pseudo'] ."</td>
        <td>". $user['mail'] ."</td>
        <td>". $user['firstName'] ."</td>
        <td>". $user['lastName'] ."</td>
        <td class='d-flex justify-content-end'>
            <div class='col-auto'><button class='btn btn-danger btn-sm' data-bs-toggle='modal' data-bs-target='#unBanAccount'>unban account</button></div>
        </td>
    </tr>

    <div class='modal' id='unBanAccount'>
      <div class='modal-dialog'>
        <div class='modal-content'>
          <div class='modal-header'>
            <h5 class='modal-title'> unban ". $user['pseudo'] ." account ?</h5>
            
            <button type='button' class='btn-close' data-bs-dismiss='modal' aria-label='Close'></button>
          </div>
          <div class='modal-footer'>
            <button type='button' class='btn btn-secondary' data-bs-dismiss='modal'>Cancel</button>
            <button type='button' class='btn btn-danger' onclick='location.href=\"unban.php?user=" . $user['pseudo'] . "\"'>unban</button>
          </div>
        </div>
      </div>
    </div>
    ";
}

$content .= "
        </head>
    </table>
";

include("../pages/template.php");
echo makePage('Banned', $content);
