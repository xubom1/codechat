<?php

include('../pages/utils.php');
include('../pages/template.php');
checkSessionAdminElseLogin('../.');

include("../../database.php");
$db = getDatabase();

$content = '<div class="mb-3">
              <label for="inputDate" class="form-label">Date</label>
              <input type="date" class="form-control" id="inputDate" name="date">
            </div>
            <div class="mb-3">
              <label for="inputTime" class="form-label">Date</label>
              <input type="time" class="form-control" id="inputTime" name="time">
            </div>
                
                ';


echo makePage('Newsletter', $content, '../');