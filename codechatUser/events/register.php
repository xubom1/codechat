<?php
include('../src/utils.php');
include('../../database.php');

checkSessionElseLogin();

if (empty($_POST['event_id'])) {
    die('Missing event ID');
}

$eventId = $_POST['event_id'];

$db = getDatabase();

// Vérifie si l'utilisateur est déjà inscrit à l'événement
$checkSign = $db->prepare('SELECT * FROM eventSign WHERE signer = :signer AND event = :event');
$checkSign->execute([
    'signer' => $_SESSION['user'],
    'event' => $eventId
]);

if ($checkSign->rowCount() > 0) {
    die('You are already registered to this event');
}

// Insère une nouvelle entrée dans la table eventSign pour enregistrer l'utilisateur à l'événement
$insertSign = $db->prepare('INSERT INTO eventSign(signer, event) VALUES(:signer, :event)');
$insertSign->execute([
    'signer' => $_SESSION['user'],
    'event' => $eventId
]);

echo 'You have been successfully registered to this event';
?>
