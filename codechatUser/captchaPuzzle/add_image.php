<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $fichierTemporaire = $_FILES['image']['tmp_name'];
    $filename = basename($_FILES['image']['name']);

    if (!file_exists('uploads')){
        mkdir('uploads'); // création du dossier
    }

    $fichierDestination = 'uploads/' . $filename;
    if (move_uploaded_file($fichierTemporaire, $fichierDestination))
   
        header('Location: index.php');
        exit;
    } else {
        // Une erreur s'est produite lors du téléchargement du fichier
        echo "Une erreur s'est produite lors du téléchargement de l'image.";
    }

?>