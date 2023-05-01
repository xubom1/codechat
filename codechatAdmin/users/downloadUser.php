<?php

if (isset($_GET['user']) && empty($_GET['user'])){
    header('location: searchUsers/index.php?msg=Error can\'t download.&err=true');
}

include('../pages/utils.php');
checkSessionAdminElseLogin();

include('../../database.php');
$db = getDatabase();

$user = $_GET['user'];

require '../lib/vendor/autoload.php';

use Dompdf\Dompdf;

$dompdf = new Dompdf;

$dompdf -> loadHtml('Hello world');

$dompdf -> render();

$dompdf -> stream();