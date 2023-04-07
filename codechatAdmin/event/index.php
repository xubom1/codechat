<?php
include('../pages/utils.php');
checkSessionAdminElseLogin('.');

$content = "This page is for manage all event !";

include("../pages/template.php");
echo makePage($content);