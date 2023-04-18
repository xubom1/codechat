<?php
include('../../database.php');
// Récupère l'identifiant de l'événement à supprimer à partir de la variable $_GET['id']
$event_id = $_GET['id'];

// Connexion à la base de données
$db = getDatabase();

// Suppression de l'événement de la base de données
$stmt = $db->prepare('DELETE FROM events WHERE id = :id');
$stmt->execute(array(':id' => $event_id));

// Redirection vers la page d'affichage des événements de l'utilisateur
header('Location: myEvent.php');

exit();
?>