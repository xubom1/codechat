<?php
include('../pages/utils.php');
checkSessionAdminElseLogin('.');

$content = "This is the captcha page";

include("../pages/template.php");
echo makePage('Captcha', $content);