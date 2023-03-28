<?php
include('pages/utils.php');
checkSessionElseLogin();

$content = "<h1 class='text-center my-5'>hello " . $_SESSION['admin'] . "</h1>";

$content = '
    <div class="d-flex justify-content-center">
        <div class="card m-4" style="width: 18rem;">
          <div class="card-body">
             <h5 class="card-title">Manage Users</h5>
             <p class="card-text">Here is all users in codechat database.</p>
             <a href="users/allUsers.php" class="btn btn-primary">Start manage</a>
          </div>
        </div>
        
        <div class="card m-4" style="width: 18rem;">
          <div class="card-body">
             <h5 class="card-title">Manage Banned Users</h5>
             <p class="card-text">Here is all banned users in codechat database.</p>
             <a href="users/banUser.php" class="btn btn-primary">Start manage</a>
          </div>
        </div>
        
        <div class="card m-4" style="width: 18rem;">
          <div class="card-body">
             <h5 class="card-title">Newsletter</h5>
             <p class="card-text">Here ypu can create newsletter. And send it automaticly.</p>
             <a href="newsletter/newsletter.php" class="btn btn-primary">Start manage</a>
          </div>
        </div>
    </div>
    
    <div class="d-flex justify-content-center">
        <div class="card m-4" style="width: 18rem;">
          <div class="card-body">
             <h5 class="card-title">Captcha</h5>
             <p class="card-text">Here change captcha picture. Add and delete captcha.</p>
             <a href="captcha/" class="btn btn-primary">Start manage</a>
          </div>
        </div>
        
        <div class="card m-4" style="width: 18rem;">
          <div class="card-body">
             <h5 class="card-title">Manage administrateur</h5>
             <p class="card-text">Here is all administrateur, that you can manage, create or delete.</p>
             <a href="admins/index.php" class="btn btn-primary">Start manage</a>
          </div>
        </div>
        
        <div class="card m-4" style="width: 18rem;">
          <div class="card-body">
             <h5 class="card-title">statistical</h5>
             <p class="card-text">Here you can see login or registration numbers by hour.</p>
             <a href="graph/graph.php" class="btn btn-primary">Start manage</a>
          </div>
        </div>
    </div>
';


include("pages/template.php");
echo makePage($content);
