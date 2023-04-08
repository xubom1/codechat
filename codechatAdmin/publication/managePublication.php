<?php
include('../pages/utils.php');
checkSessionAdminElseLogin('../');

//include database
include('../../database.php');
$db = getDatabase();

$publication = htmlspecialchars($_GET['publication']);
if (empty($publication)){
    header('location: index.php');
    exit;
}

$cmd = $db->prepare('SELECT * FROM publication WHERE id = ?');
$get = $cmd->execute([$publication]);
$getAll = $cmd->fetchAll()[0];

$cmdUser = $db->prepare('SELECT pseudo FROM user WHERE id=?');
$getPseudo = $cmdUser->execute([$getAll['creator']]);
$user = $cmdUser->fetch();


$content = '
    <table class="table table-hover">
      <tbody>
        <tr>
          <th scope="row">id</th>
          <td>'. $getAll['id'] .'</td>
        </tr>
        <tr>
          <th scope="row">Creator</th>
          <td>'. $user[0] .'</td>
        </tr>
        <tr>
          <th scope="row">last Edition</th>
          <td>'. $getAll['lastEdition'] .'</td>
        </tr>
        <tr>
          <th scope="row">Content</th>
          <td>'. $getAll['content'] .'</td>
        </tr>
      </tbody>
    </table>
';

$content .= "
    <div class='row my-5'>
        <div class='col-auto'><button class='btn btn-danger' data-bs-toggle='modal' data-bs-target='#banAccount'>ban ". $user[0] ."</button></div>
        <div class='col-auto'><button class='btn btn-danger' data-bs-toggle='modal' data-bs-target='#deletePublication'>delete publication</button></div>
        <div class='col-auto'><button class='btn btn-primary' data-bs-toggle='modal' data-bs-target='#goBack'>Go Back</button></div>
    </div>
    
    <!--ban account -->
    <div class='modal' id='deletePublication'>
      <div class='modal-dialog'>
        <div class='modal-content'>
          <div class='modal-header'>
            <h5 class='modal-title'>Are you sure you want to delete this publication ?</h5>
            
            <button type='button' class='btn-close' data-bs-dismiss='modal' aria-label='Close'></button>
          </div>
          <div class='modal-body'>
            <strong>this modification is definitive !</strong>
          </div>
          <div class='modal-footer'>
            <button type='button' class='btn btn-secondary' data-bs-dismiss='modal'>Cancel</button>
            <button type='button' class='btn btn-danger' onclick='location.href=\"deletePublication.php?id=" . $getAll['id'] . "\"'>delete</button>
          </div>
        </div>
      </div>
    </div>
    
     <!--ban account -->
    <div class='modal' id='banAccount'>
      <div class='modal-dialog'>
        <div class='modal-content'>
          <div class='modal-header'>
            <h5 class='modal-title'> ban $user[0] account ?</h5>
            
            <button type='button' class='btn-close' data-bs-dismiss='modal' aria-label='Close'></button>
          </div>
          <div class='modal-footer'>
            <button type='button' class='btn btn-secondary' data-bs-dismiss='modal'>Cancel</button>
            <button type='button' class='btn btn-danger' onclick='location.href=\"banUserPublication.php?user=" . $user[0] . "\"'>ban</button>
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
            <button type='button' class='btn btn-primary' onclick='location.href=\"generatePdf.php?user=" . $user['pseudo'] . "\"'>Download</button>
          </div>
        </div>
      </div>
    </div>";




include("../pages/template.php");
echo makePage('Publication of ' . $user[0], $content, '../');