<?php
include('../pages/utils.php');
checkSessionAdminElseLogin('.');

$content = '
    <div class="row">
        <div class="card mb-3 m-2" style="max-width: 540px;">
          <div class="row g-0">
            <div class="col-md-4">
                <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d2624.835044518637!2d2.327088015984315!3d48.86272507928779!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x47e66e0cf6c3dc47%3A0x53ef54179c24c7a2!2s123%20Rue%20de%20la%20Paix%2C%2075008%20Paris%2C%20France!5e0!3m2!1sen!2sus!4v1618526196879!5m2!1sen!2sus" width="100%" height="200" style="border:0;" allowfullscreen="" loading="lazy"></iframe>
              <!--<img src="..." class="img-fluid rounded-start" alt="...">-->
            </div>
            <div class="col-md-8">
              <div class="card-body">
                <h5 class="card-title">Card title</h5>
                <p class="card-text">This is a wider card with supporting text below as a natural lead-in to additional content. This content is a little bit longer.</p>
                <p class="card-text"><small class="text-body-secondary">Last updated 3 mins ago</small></p>
              </div>
            </div>
          </div>
        </div>
        <div class="card mb-3 m-2" style="max-width: 540px;">
          <div class="row g-0">
            <div class="col-md-4">
                <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d2624.835044518637!2d2.327088015984315!3d48.86272507928779!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x47e66e0cf6c3dc47%3A0x53ef54179c24c7a2!2s123%20Rue%20de%20la%20Paix%2C%2075008%20Paris%2C%20France!5e0!3m2!1sen!2sus!4v1618526196879!5m2!1sen!2sus" width="100%" height="200" style="border:0;" allowfullscreen="" loading="lazy"></iframe>
              <!--<img src="..." class="img-fluid rounded-start" alt="...">-->
            </div>
            <div class="col-md-8">
              <div class="card-body">
                <h5 class="card-title">Card title</h5>
                <p class="card-text">This is a wider card with supporting text below as a natural lead-in to additional content. This content is a little bit longer.</p>
                <p class="card-text"><small class="text-body-secondary">Last updated 3 mins ago</small></p>
              </div>
            </div>
          </div>
        </div>
    </div>
    <div class="card text-center">
      <div class="card-header">
        Featured
      </div>
      <div class="card-body">
        <h5 class="card-title">Special title treatment</h5>
        <p class="card-text">With supporting text below as a natural lead-in to additional content.</p>
        <a href="#" class="btn btn-primary">Go somewhere</a>
      </div>
      <div class="card-footer text-body-secondary">
        2 days ago
      </div>
    </div>
';


include("../pages/template.php");
echo makePage('Event', $content);