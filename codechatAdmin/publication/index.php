<?php
include('../pages/utils.php');
checkSessionAdminElseLogin('.');

$content = "This page is for manage all publication !";

include("../pages/template.php");
echo makePage('Publication', $content);