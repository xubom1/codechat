<?php
include('../src/utils.php');
include('../../database.php');


checkSessionElseLogin();

if (empty($_POST['event_id'])) {
    die('Missing event ID');
}

$eventId = $_POST['event_id'];

$db = getDatabase();

// Vérifie si l'utilisateur est inscrit à l'événement
$checkSign = $db->prepare('SELECT * FROM eventSign WHERE signer = :signer AND event = :event');
$checkSign->execute([
    'signer' => $_SESSION['user'],
    'event' => $eventId
]);

if ($checkSign->rowCount() == 0) {
    die('You are not registered to this event');
}

// Supprime l'entrée de la table eventSign pour retirer l'utilisateur de l'événement
$deleteSign = $db->prepare('DELETE FROM eventSign WHERE signer = :signer AND event = :event');
$deleteSign->execute([
    'signer' => $_SESSION['user'],
    'event' => $eventId
]);

echo 'You have been successfully unregistered from this event';
?>
