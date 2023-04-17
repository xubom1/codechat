<?php
include('../pages/utils.php');
include('../pages/template.php');
checkSessionAdminElseLogin('../');

if (!isset($_GET['user'])){
    header('location: ./');
    exit;
}

include('../../database.php');
$db = getDatabase();

$cmd = $db->prepare('SELECT * FROM user WHERE pseudo=? AND banned=0');
$cmd->execute([htmlspecialchars($_GET['user'])]);
$user = $cmd->fetchAll()[0];

if($user == 0)
    header('location: searchUsers/index.php?msg=unkown error&err=true');

$pseudo = htmlspecialchars($_GET['user']);

function createRow($text, $bddName, $user, $type){
    return "
        
        <tr class='row justify-content-md-center'>
            <th class='col-3'>$text</th>
            <td class='col'>" . $user[$bddName] . "</td>
            <td class='col-auto'><button class='btn btn-secondary btn-sm' data-bs-toggle='modal' data-bs-target='#$bddName-modal'>change</button></td>
        </tr>
        
        <!--change value -->
        <div class='modal' id='$bddName-modal'>
          <div class='modal-dialog'>
            <div class='modal-content'>
              <div class='modal-header'>
                <h5 class='modal-title'>change ". htmlspecialchars($_GET['user']) ."'s $text</h5>
                          
                <button type='button' class='btn-close' data-bs-dismiss='modal' aria-label='Close'></button>
              </div>
              <form action='change.php?user=". htmlspecialchars($_GET['user']) ."&type=$bddName' method='post'>
                  <div class='modal-body'>
                     <label for='name' class='form-label'>New $text</label>
                     <input name='$bddName' type='$type' class='form-control'>
                  </div>
                  <div class='modal-footer'>
                    <button type='button' class='btn btn-secondary' data-bs-dismiss='modal'>Cancel</button>
                    <button type='submit' class='btn btn-danger'>change</button>
                  </div>
              </form>
            </div>
          </div>
        </div>
    ";
}

function error()
{
    if (isset($_GET['msg']) && !empty($_GET['msg'])) {
        return htmlspecialchars($_GET['msg']);
    }
}

$content = "
    
    <h2 class='text-cente r my-4 text-decoration-underline'><em>$pseudo</em> account manager</h2>
    
    <div class='container mt-5 '>
        <p class='text-center " . ((isset($_GET['err']) && $_GET['err'] == 'true') ? "text-danger" : " ") . "'> 
        " . error() . "
        </p>
    </div>
    
    <div class='container border-top my-5'>
        <table class='table table-striped table-hover'>
            ". createRow('pseudo', 'pseudo' ,$user, "text") ."
            ". createRow('mail', 'mail' ,$user, "email") ."
            ". createRow('first name', 'firstName' ,$user, "text") ."
            ". createRow('last name', 'lastName' ,$user, "text") ."
            ". createRow('postal code', 'postalCode' ,$user, "integer") ."
            ". createRow('city', 'city' ,$user, "text") ."
            ". createRow('address', 'address' ,$user, "text") ."
            ". createRow('password', 'password' ,$user, "password") ."
        </table>
        
        <div class='row my-5'>
            <div class='col-auto'><button class='btn btn-danger' data-bs-toggle='modal' data-bs-target='#banAccount'>ban account</button></div>
            <div class='col-auto'><button class='btn btn-danger' data-bs-toggle='modal' data-bs-target='#deleteAccount'>delete account</button></div>
            <div class='col-auto'><button class='btn btn-primary' data-bs-toggle='modal' data-bs-target='#printAccount'>Download</button></div>
        </div>
    </div>
    
    <!--delete account -->
    <div class='modal' id='deleteAccount'>
      <div class='modal-dialog'>
        <div class='modal-content'>
          <div class='modal-header'>
            <h5 class='modal-title'>Are you sure you want to delete $pseudo account ?</h5>
            
            <button type='button' class='btn-close' data-bs-dismiss='modal' aria-label='Close'></button>
          </div>
          <div class='modal-body'>
            <strong>this modification is definitive !</strong>
          </div>
          <div class='modal-footer'>
            <button type='button' class='btn btn-secondary' data-bs-dismiss='modal'>Cancel</button>
            <button type='button' class='btn btn-danger' onclick='location.href=\"deleteUser.php?user=" . htmlspecialchars($_GET['user']) . "\"'>delete</button>
          </div>
        </div>
      </div>
    </div>
    
     <!--ban account -->
    <div class='modal' id='banAccount'>
      <div class='modal-dialog'>
        <div class='modal-content'>
          <div class='modal-header'>
            <h5 class='modal-title'> ban $pseudo account ?</h5>
            
            <button type='button' class='btn-close' data-bs-dismiss='modal' aria-label='Close'></button>
          </div>
          <div class='modal-footer'>
            <button type='button' class='btn btn-secondary' data-bs-dismiss='modal'>Cancel</button>
            <button type='button' class='btn btn-danger' onclick='location.href=\"ban.php?user=" . htmlspecialchars($_GET['user']) . "\"'>ban</button>
          </div>
        </div>
      </div>
    </div>
    
    <!--download user -->
    <div class='modal' id='printAccount'>
      <div class='modal-dialog'>
        <div class='modal-content'>
          <div class='modal-header'>
            <h5 class='modal-title'> download $pseudo information ?</h5>
            <button type='button' class='btn-close' data-bs-dismiss='modal' aria-label='Close'></button>
          </div>
            <p class='modal-body'>By clicking on download you will download all the information concerning $pseudo.</p>
          <div class='modal-footer'>
            <button type='button' class='btn btn-secondary' data-bs-dismiss='modal'>Cancel</button>
            <button type='button' class='btn btn-primary' onclick='location.href=\"generatePdf.php?user=" . htmlspecialchars($_GET['user']) . "\"'>Download</button>
          </div>
        </div>
      </div>
    </div>
    
";

echo makePage('Manage '. $pseudo , $content, "..");
