<?php
include('../pages/utils.php');
checkSessionAdminElseLogin('../');

//include database
include('../../database.php');
$db = getDatabase();


echo $_GET['id'];