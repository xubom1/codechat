<?php

use Dompdf\Dompdf;
require_once '../../lib/dompdf/autoload.inc.php';

include('../../database.php');
$db = getDatabase();

$user = htmlspecialchars($_GET['user']);

$cmd = $db->prepare('SELECT * FROM user WHERE pseudo = ?');
$cmd->execute([$user]);
$infoArray = $cmd->fetch();

$cmdFollow = $db->prepare('SELECT followed FROM follow WHERE follower = ?');
$cmdFollow->execute([$user]);
$followArray = $cmdFollow->fetchAll();


$content = '
    <h1>Profil : '. $user . '</h1>
    <p> Le mail :'. $infoArray[1] .'</p>
    <p> Le nom :'. $infoArray[2] .'</p>
    <p> Le prenom :'. $infoArray[3] .'</p>
    <p> Le mail :'. $infoArray[4] .'</p>
    <p> Le mail :'. $infoArray[5] .'</p>
    <p> Liste des follow :
';

foreach ($followArray as $value){
    $content .= '<br>'.$value[0].' ';
}

$content .= '</p>';

$dompdf = new Dompdf();
$dompdf->setPaper('A4', 'portrait');
$dompdf->loadHtml($content);
$dompdf->render();
$filename = $user . '_account_detail';
$dompdf->stream($filename);

echo $content;

header('location: manageUser.php?user='.$user);