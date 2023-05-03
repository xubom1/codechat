<?php
include('../../pages/utils.php');
checkSessionAdminElseLogin('.');

if (!isset($_POST['month']) && empty($_GET['month'])
    || !isset($_POST['day']) && empty($_GET['day'])
    || !isset($_POST['hour']) && empty($_GET['hour'])
    || !isset($_POST['minute']) && empty($_GET['minute'])
    || !isset($_POST['date']) && empty($_GET['date'])){
    header('location: index.php?msg=Please complete all the field correctly&err=true');
    exit;
}


if ($_POST['month'] < 0 or $_POST['month'] > 12) {
    header('location: index.php?msg=Month out of range&err=true');
    exit;
}

if ($_POST['day'] > 31 or $_POST['day'] < 0) {
    header('location: index.php?msg=Day out of range&err=true');
    exit;
}

if ($_POST['hour'] > 23 or $_POST['hour'] < 0) {
    header('location: index.php?msg=Hour out of range&err=true');
    exit;
}

if ($_POST['minute'] > 59 or $_POST['minute'] < 0) {
    header('location: index.php?msg=Minute out of range&err=true');
    exit;
}

$month = $_POST['month'];
$day = $_POST['day'];
$hour = $_POST['hour'];
$minute = $_POST['minute'];
$date = $_POST['date'];

date_default_timezone_set('Europe/Paris');

// include database
include('../../../database.php');
$db = getDatabase();

$cmd = $db->prepare('UPDATE send SET month = ?, day = ?, hour = ?, minute = ?, date = ?, lastSendDate = ?, lastSendTime = ?, lastUpdate = ? WHERE id = 1');
$cmd->execute([$month, $day, $hour, $minute, $date, date('Y-m-d'), date('H:i'), date('Y-m-d H:i:s')]);

header('location: index.php?msg=C\'est bon ça à été mis à jour.');