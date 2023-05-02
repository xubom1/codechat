<?php
include('../pages/utils.php');
include('../pages/template.php');
checkSessionAdminElseLogin('../.');

include("../../database.php");
$db = getDatabase();

$content = '
    <h1 class="text-center">Newsletter Management</h1>
    <div class="container d-flex align-items-start mt-4">
      <div class="nav flex-column nav-pills me-3" id="v-pills-tab" role="tablist" aria-orientation="vertical">
        <button class="nav-link active" id="v-pills-home-tab" data-bs-toggle="pill" data-bs-target="#v-pills-create">Create</button>
        <button class="nav-link" id="v-pills-messages-tab" data-bs-toggle="pill" data-bs-target="#v-pills-program">Programmer</button>
        <button class="nav-link" id="v-pills-profile-tab" data-bs-toggle="pill" data-bs-target="#v-pills-history">History</button>
      </div>
      <div class="tab-content" id="v-pills-tabContent">
      
        <!-- Create Newsletter -->
        <div class="tab-pane fade show active" id="v-pills-create">
        
            <form class="row g-3 needs-validation" action="check.php" method="POST">
                
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
            <button class="btn btn-primary">Create</button>
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