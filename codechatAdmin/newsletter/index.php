<?php
include('../pages/utils.php');
include('../pages/template.php');
checkSessionAdminElseLogin('../');

include("../../database.php");
$db = getDatabase();

function error()
{
    if (isset($_GET['msg']) && !empty($_GET['msg'])) {
        return htmlspecialchars($_GET['msg']);
    }
}

$content = '
    <h1 class="text-center">Newsletter Management</h1>';

if (isset($_GET['msg']) && !empty($_GET['msg'])) {
    $content .= "<p class='text-center mt-4" . ((isset($_GET['err']) && $_GET['err'] == 'true') ? " alert alert-danger" : " alert alert-success") . "'> 
    " . error() . "
    </p>";
    }

$content .= '
    <div class="container d-flex align-items-start mt-4">
      <div class="nav flex-column nav-pills me-3" id="v-pills-tab" role="tablist" aria-orientation="vertical">
        <button class="nav-link active" id="v-pills-home-tab" data-bs-toggle="pill" data-bs-target="#v-pills-create">Create</button>
        <button class="nav-link" id="v-pills-messages-tab" data-bs-toggle="pill" data-bs-target="#v-pills-program">Programmer</button>
        <button class="nav-link" id="v-pills-profile-tab" data-bs-toggle="pill" data-bs-target="#v-pills-history">History</button>
      </div>
      <div class="tab-content" id="v-pills-tabContent">
      
        <!-- Create Newsletter -->
        <div class="tab-pane fade show active" id="v-pills-create">
        
            <form class="row g-3 needs-validation" action="sendNow.php" method="POST">
                
                <select class="form-select" aria-label="Default select example" name="sendTo">
                  <option selected>Send to</option>
                  <option value="all">All</option>
                  <option value="administrator">Administrator only</option>
                </select>
                
                <div class="mb-3">
                  <label for="InputTitle" class="form-label">Title</label>
                  <input type="text" class="form-control" id="InputTitle" placeholder="Title" name="title">
                </div>
                <div class="mb-3">
                  <label for="inputContent" class="form-label">Example textarea</label>
                  <textarea class="form-control" id="inputContent" rows="3" name="content"></textarea>
                </div>
                
                <button type="submit" class="btn btn-primary">Send</button>
                
            </form>
            
        </div>
        
        <!-- programmed newsletter -->
        <div class="tab-pane fade" id="v-pills-program">
            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#prgmNews">Program newsletter</button>
            <div class="modal fade" id="prgmNews" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
              <div class="modal-dialog">
                <div class="modal-content">
                  <div class="modal-header">
                    <h1 class="modal-title fs-5" id="exampleModalLabel">Create newsletter</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                  </div>
                  <div class="modal-body">
                    <form action="setNewsletter.php" method="post">
                        <label>Title</label>
                        <input class="form-control mt-1">
                        <label class="mt-2">Content</label>
                        <textarea class="form-control mt-1" style="max-height: 250px; min-height: 250px"></textarea>
                        <label class="mt-2">Date</label>
                        <input class="form-control mt-1" type="date">
                        <label class="mt-2">Time</label>
                        <input class="form-control mt-1" type="time">
                    </form>
                  </div>
                  <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary">Programme</button>
                  </div>
                </div>
              </div>
            </div>
            <table class="table table-striped">
              <thead>
                <tr>
                  <th scope="col">Title</th>
                  <th scope="col">Content</th>
                  <th scope="col">Send Date / Time</th>
                  <th scope="col">Made By</th>
                  <th scope="col">To</th>
                  <th scope="col">Modify</th>
                  <th scope="col">Delete</th>
                </tr>
              </thead>
              <tbody>';

date_default_timezone_set('Europe/Paris');

$cmdProgrammed = $db->prepare('SELECT * FROM newsletter WHERE sendDateTime > ?');
$cmdProgrammed->execute([date('Y-m-d H:m:s')]);
$getAllProgram = $cmdProgrammed->fetchAll(PDO::FETCH_ASSOC);

if ($getAllProgram){
    foreach ($getAllProgram as $prog){
        $content .= '
            <tr>
                <td>'. $prog['title'] .'</td>
                <td>'. $prog['content'] .'</td>
                <td>'. $prog['sendDateTime'] .'</td>
                <td>'. $prog['createBy'] .'</td>
                <td>'. $prog['sendTo'] .'</td>
                
                <td><img src="../assets/edit.svg" alt="edit" class="editButton p-0" height="20" title="edit"></td>
                <td><img src="../assets/delete2.svg" alt="edit" class="editButton p-0" height="20" title="edit"></td>
            </tr>
        ';
    }
}


$content .= '</tbody>
            </table>
        </div>
        
        <!-- View all newsletter -->
        <div class="tab-pane fade" id="v-pills-history">
            <table class="table table-striped">
              <thead>
                <tr>
                  <th scope="col">Id</th>
                  <th scope="col">Title</th>
                  <th scope="col">Content</th>
                  <th scope="col">Send Date / Time</th>
                  <th scope="col">Made By</th>
                  <th scope="col">To</th>
                </tr>
              </thead>
              <tbody>';

$cmdHistory = $db->prepare('SELECT * FROM newsletter WHERE sent = ?');
$cmdHistory->execute([1]);
$getAllHistory = $cmdHistory->fetchAll(PDO::FETCH_ASSOC);

if ($getAllHistory){
    foreach ($getAllHistory as $history){
        $content .= '
            <tr>
                <td>'. $history['id'] .'</td>
                <td>'. $history['title'] .'</td>
                <td>'. $history['content'] .'</td>
                <td>'. $history['sendDateTime'] .'</td>
                <td>'. $history['createBy'] .'</td>
                <td>'. $history['sendTo'] .'</td>
            </tr>
        ';
    }
}

$content .= '
              </tbody>
            </table>
            </div>
          </div>
          <script src="default.js"></script>
      </div>
        ';


echo makePage('Newsletter', $content, '../');