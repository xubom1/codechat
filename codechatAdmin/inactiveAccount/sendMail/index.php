<?php
include('../../pages/utils.php');
checkSessionAdminElseLogin('.');

$content = '
        <h3 class="text-center">Email detail</h3>
';

include("../../pages/template.php");
echo makePage('Send Mail', $content, '../..');