<?php
include('../pages/utils.php');
checkSessionAdminElseLogin('.');

$content = "This page is for manage all avatar items !";

include("../pages/template.php");
echo makePage($content);