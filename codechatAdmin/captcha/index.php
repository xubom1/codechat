<?php
include('../pages/utils.php');
checkSessionAdminElseLogin('.');

$content = "
        <p>Hello</p>
";

include("../pages/template.php");
echo makePage($content);