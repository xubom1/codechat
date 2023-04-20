<?php
include('../pages/utils.php');
include('../pages/template.php');
checkSessionAdminElseLogin('../.');

include("../../database.php");
$db = getDatabase();

$content = '
    <h1 class="center mx-auto">Newsletter Management</h1>
    <div class="d-flex align-items-start mt-4">
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
                  <option value="new">New</option>
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
                
                <div class="mb-3">
                  <label for="inputDate" class="form-label">Date</label>
                  <input type="date" class="form-control" id="inputDate" name="date">
                </div>
                <div class="mb-3">
                  <label for="inputTime" class="form-label">Date</label>
                  <input type="time" class="form-control" id="inputTime" name="time">
                </div>
                
                <button type="submit" class="btn btn-primary">Send</button>
                
            </form>
            
        </div>
        
        <!-- View all programmed newsletter -->
        <div class="tab-pane fade" id="v-pills-program">
            <table class="table table-striped">
              <thead>
                <tr>
                  <th scope="col">Title</th>
                  <th scope="col">Content</th>
                  <th scope="col">Send Date</th>
                  <th scope="col">Send Time</th>
                  <th scope="col">Made By</th>
                  <th scope="col">Modify</th>
                  <th scope="col">Delete</th>
                </tr>
              </thead>
              <tbody>';

date_default_timezone_set('Europe/Paris');
$cmdProgrammed = $db->prepare('SELECT * FROM newsletter WHERE sendDate > ? OR sendTime > ?');
$cmdProgrammed->execute([date('Y-m-d'), date('H:m:s')]);
$getAllProgram = $cmdProgrammed->fetchAll(PDO::FETCH_ASSOC);

if ($getAllProgram){
    foreach ($getAllProgram as $prog){
        $content .= '
            <tr>
                <td>'. $prog['title'] .'</td>
                <td>'. $prog['content'] .'</td>
                <td>'. $prog['sendDate'] .'</td>
                <td>'. $prog['sendTime'] .'</td>
                <td>'. $prog['createBy'] .'</td>
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
                  <th scope="col">#</th>
                  <th scope="col">Title</th>
                  <th scope="col">Send it</th>
                  <th scope="col">By</th>
                  <th scope="col">To</th>
                  <th scope="col">Detail</th>
                </tr>
              </thead>
              <tbody>';

$content .= '
              </tbody>
            </table>
            </div>
          </div>
          <script src="default.js"></script>
      </div>
        ';

// get newsletter history

$getHistory = $db->prepare('SELECT * FROM newsletter');
$getHistory->execute([]);
$history = $getHistory->fetchAll(PDO::FETCH_ASSOC);


$content .= '
                
';

echo makePage('Newsletter', $content, '../');