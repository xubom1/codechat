<?php
include('../../database.php');
// Vérifie que le formulaire a été soumis
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Récupère les données soumises par le formulaire
    $event_id = $_POST['event_id'];
    $name = $_POST['name'];
    $starting_date = $_POST['starting_date'];
    $ending_date = $_POST['ending_date'];
    $location = $_POST['location'];
    $description = $_POST['description'];

    // Connexion à la base de données
    $db = getDatabase();

    // Met à jour l'événement dans la base de données
    $stmt = $db->prepare('UPDATE events SET name = :name, starting_date = :starting_date, ending_date = :ending_date, location = :location, description = :description WHERE id = :event_id');
    $stmt->execute(array(':name' => $name, ':starting_date' => $starting_date, ':ending_date' => $ending_date, ':location' => $location, ':description' => $description, ':event_id' => $event_id));

    // Redirige l'utilisateur vers la page d'affichage de l'événement mis à jour
    header('Location: myEvent.php?id=' . $event_id);
    exit();
} else {
    // Le formulaire n'a pas été soumis, affiche un message d'erreur
    echo "Le formulaire n'a pas été soumis.";
}
?>
