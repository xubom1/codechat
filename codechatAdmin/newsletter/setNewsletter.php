<?php

include('../pages/utils.php');
include('../pages/template.php');
checkSessionAdminElseLogin('../');

include("../../database.php");
$db = getDatabase();

