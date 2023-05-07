<?php

if (isset($_GET['user']) && empty($_GET['user'])){
    header('location: searchUsers/index.php?msg=Error can\'t download.&err=true');
}

error_reporting(E_ALL); ini_set('display_errors', '1');

include('../pages/utils.php');
checkSessionAdminElseLogin();

include('generatePDF.php');

$user = $_GET['user'];

require '../lib/vendor/autoload.php';

use Dompdf\Dompdf;

$dompdf = new Dompdf;


$dompdf->loadHtml(getPDF('logo.png'));
$dompdf->setPaper('A4', 'portrait');
$dompdf->render();
$dompdf->stream($user . ' History', [
    'Attachment' => false
]);