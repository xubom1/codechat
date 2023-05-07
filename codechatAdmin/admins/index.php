<?php

include("../pages/utils.php");
checkSessionAdminElseLogin('../.');

//get admins
include('../../database.php');
$db = getDatabase();

$command = $db->prepare('SELECT * FROM user WHERE admin = 1');
$command->execute() or die(print_r($db->errorInfo()));
$admins = $command->fetchAll();

//create page
include("../pages/template.php");

$content = "<h1 class='text-center'>Manage administrators</h1>";

function error()
{
    if (isset($_GET['msg']) && !empty($_GET['msg'])) {
        return htmlspecialchars($_GET['msg']);
    }
}

if (isset($_GET['msg'])) {
    $content .= "<div class='container mt-5 '>
        <p class='text-center " . ((isset($_GET['err']) && $_GET['err'] == 'true') ? " alert alert-danger" : " alert alert-success") . "'>
    " . error() . "
        </p>
    </div>";
}

$content .= "
    <table class='table table-responsive table-hover my-5'>
    <thead>
        <tr>
            <th scope='col' class='col-1' >#</th>
            <th scope='col' class='col' >username</th>
            <th scope='col' class='col' >password</th>
            <th scope='col' class='col' ></th>
        </tr>
    </thead>
        <tbody class='table-group-divider'>
";

foreach ($admins as $i => $admin){
    $class = "";
    $deleteAccountButtonClass = "";
    if ($admin['pseudo'] === $_SESSION['admin']){
        $class = "class='table-active'";
        $deleteAccountButtonClass = ' disabled ';
    }

    $content .= "
        <tr $class>
            <th>" . ($i + 1) . "</th>
            <td>" . $admin['pseudo'] . "</td>
            <td class='text-nowrap'>
                <div class='dropdown'>
                  <button class='btn btn-sm btn-secondary dropdown-toggle' type='button' data-bs-toggle='dropdown' aria-expanded='false'>
                    manage
                  </button>
                  <ul class='dropdown-menu'>
                    <li><a class='dropdown-item' data-bs-toggle='modal' data-bs-target='#" . $admin['pseudo'] . "ModalResetPassword'>reset password</a></li>
                    <li><hr class='dropdown-divider'></li>
                    <li class='dropdown-item-text text-break'>" . $admin['password'] . "</li>
                  </ul>
                </div>
            </td>
            <td>
                <button type='button' class='btn btn-danger btn-sm' data-bs-toggle='modal' data-bs-target='#" . $admin['pseudo'] . "Modal' $deleteAccountButtonClass>
                  delete account
                </button>
            </td>
            <td>
                <button type='button' class='btn btn-danger btn-sm' data-bs-toggle='modal' data-bs-target='#" . $admin['pseudo'] . "Modal-no' $deleteAccountButtonClass>
                  Not admin
                </button>
            </td>
        </tr>
        
        <!-- Modal delete account -->
        <div class='modal fade' id='" . $admin['pseudo'] . "Modal' aria-hidden='true'>
          <div class='modal-dialog'>
            <div class='modal-content'>
              <div class='modal-header'>
                <h1 class='modal-title fs-5' id='exampleModalLabel'>Are you sure you want to delete " . $admin['pseudo'] . " account ?</h1>
                <button type='button' class='btn-close' data-bs-dismiss='modal' aria-label='Close'></button>
              </div>
             
              <div class='modal-footer'>
                <form action='deleteAccount.php' method='post'>
                    <button type='button' class='btn btn-secondary' data-bs-dismiss='modal'>Cancel</button>
                    <input type='text' readonly name='admin' style='display: none' value='" . $admin['pseudo'] ."'>
                    <input class='btn btn-danger' type='submit' value='delete'>
                </form>
              </div>
            </div>
          </div>
        </div>
          
          
          <!-- Modal not admin account -->
        <div class='modal fade' id='" . $admin['pseudo'] . "Modal-no' aria-hidden='true'>
          <div class='modal-dialog'>
            <div class='modal-content'>
              <div class='modal-header'>
                <h1 class='modal-title fs-5' id='exampleModalLabel'>Are you sure you want to remove " . $admin['pseudo'] . " as an admin ?</h1>
                <button type='button' class='btn-close' data-bs-dismiss='modal' aria-label='Close'></button>
              </div>
             
              <div class='modal-footer'>
                <form action='removeAdmin.php' method='post'>
                    <button type='button' class='btn btn-secondary' data-bs-dismiss='modal'>Cancel</button>
                    <input type='text' readonly name='admin' style='display: none' value='" . $admin['pseudo'] ."'>
                    <input class='btn btn-danger' type='submit' value='Remove'>
                </form>
              </div>
            </div>
          </div>
        </div>
        
        
        </div>
        <!-- reset password account -->
        <div class='modal fade' id='" . $admin['pseudo'] . "ModalResetPassword' aria-hidden='true'>
            <div class='modal-dialog'>
                <div class='modal-content'>
                    <div class='modal-header'>
                        <h1 class='modal-title fs-5' id='exampleModalLabel'>Enter new password for " . $admin['pseudo'] . " account</h1>
                        <button type='button' class='btn-close' data-bs-dismiss='modal' aria-label='Close'></button>
                    </div>
                    <form action='resetPassword.php' method='post'>
                        <div class='modal-body'>
                            <input type='text' value='" . $admin['pseudo'] . "' name='admin' readonly style='display: none'>
                            <input type='password' name='password' class='form-control'>
                        </div>
                        <div class='modal-footer'>
                            <button type='button' class='btn btn-secondary' data-bs-dismiss='modal'>Cancel</button>
                            <input class='btn btn-primary' type='submit' value='reset password'>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    ";
}

$content .= "
        </tbody>
    </table>
    
    <button type='button' class='btn btn-primary' data-bs-toggle='modal' data-bs-target='#newAdminModal'>
        new admin
    </button>
    <div class='modal fade' id='newAdminModal' aria-labelledby='exampleModalLabel' aria-hidden='true'>
        <form action='createAdmin.php' method='post' class='modal-dialog'>
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
";



echo makePage('Admins', $content, "../");

