<?php
include('../pages/utils.php');
include('../pages/template.php');
checkSessionAdminElseLogin('../.');

$content = "
    <div class=''>
        <form action='send.php' method='POST'>
            <label for='subject' class='form-label'>subject</label>
            <input type='text' name='subject' class='form-control'>
            
            <label for='text' class='form-label'>subject</label>
            <textarea name='text' class='form-control' style='min-height: 200px'></textarea>
            
            <input type='submit' value='send' class='btn btn-primary my-4'>
        </form>
    </div>
";
echo makePage('Newsletter', $content, '../');