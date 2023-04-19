<?php
include('pages/utils.php');
checkSessionAdminElseLogin('.');

$content = "<h1 class='text-center my-5'>hello " . $_SESSION['admin'] . "</h1>";

$content = '
    <div class="d-flex justify-content-center">
        <div class="card m-4" style="width: 18rem;">
          <div class="card-body">
             <h5 class="card-title">Manage Users</h5>
             <p class="card-text">Here is all users in codechat database.</p>
             <a href="users/searchUsers/" class="btn btn-primary">Start manage</a>
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
             <a href="newsletter/" class="btn btn-primary">Start manage</a>
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
             <h5 class="card-title">Manage administrator</h5>
             <p class="card-text">Here is all administrateur, that you can manage, create or delete.</p>
             <a href="admins/" class="btn btn-primary">Start manage</a>
          </div>
        </div>
        
        <div class="card m-4" style="width: 18rem;">
          <div class="card-body">
             <h5 class="card-title">statistical</h5>
             <p class="card-text">Here you can see login or registration numbers by hour.</p>
             <a href="graph/" class="btn btn-primary">Start manage</a>
          </div>
        </div>
    </div>
    
    <div class="d-flex justify-content-center">
        <div class="card m-4" style="width: 18rem;">
          <div class="card-body">
             <h5 class="card-title">Event</h5>
             <p class="card-text">Here manage all event create in codechat.</p>
             <a href="event/" class="btn btn-primary">Start manage</a>
          </div>
        </div>
        <div class="card m-4" style="width: 18rem;">
          <div class="card-body">
             <h5 class="card-title">Publication</h5>
             <p class="card-text">See all the publication. And manage all the publication.</p>
             <a href="publication/" class="btn btn-primary">Start manage</a>
          </div>
        </div>
        <div class="card m-4" style="width: 18rem;">
          <div class="card-body">
             <h5 class="card-title">Avatar</h5>
             <p class="card-text">Add or delete avatar items or update avatar items.</p>
             <a href="avatar/" class="btn btn-primary">Start manage</a>
          </div>
        </div>
    </div>
    
    <div class="d-flex justify-content-center">
        <div class="card m-4" style="width: 18rem;">
          <div class="card-body">
             <h5 class="card-title">Inactive account</h5>
             <p class="card-text">Here you will see all accounts that have been inactive for a while.</p>
             <a href="event/" class="btn btn-primary">Start manage</a>
          </div>
        </div>
        <div class="card m-4" style="width: 18rem;">
          <div class="card-body">
             <h5 class="card-title">Report</h5>
             <p class="card-text">Here you will find all reports and complaints made by users.</p>
             <a href="publication/" class="btn btn-primary">Start manage</a>
          </div>
        </div>
        <div class="card m-4" style="width: 18rem;">
          <div class="card-body">
             <h5 class="card-title">Message</h5>
             <p class="card-text">Here you will find messages sent to you by users or administrators.</p>
             <a href="avatar/" class="btn btn-primary">Start manage</a>
          </div>
        </div>
    </div>
';


include("pages/template.php");
echo makePage('Home', $content, '.');
