<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $fichierTemporaire = $_FILES['nouvelle_image']['tmp_name'];
    $fichierDestination = 'nouvelle_image.jpg';
    if (move_uploaded_file($fichierTemporaire, $fichierDestination)) {
        // Le fichier a été téléchargé avec succès
        $originalImage = imagecreatefromjpeg($fichierDestination);
        $originalWidth = imagesx($originalImage);
        $originalHeight = imagesy($originalImage);

        $partWidth = $originalWidth / 3;
        $partHeight = $originalHeight / 3;

        $parts = array();
        for ($i = 0; $i < 3; $i++) {
            for ($j = 0; $j < 3; $j++) {
                $part = imagecreatetruecolor($partWidth, $partHeight);
                imagecopy($part, $originalImage, 0, 0, $i * $partWidth, $j * $partHeight, $partWidth, $partHeight);
                $parts[] = $part;
            }
        }

        foreach ($parts as $index => $part) {
            imagejpeg($part, "image_test".($index+1).".jpg", 100);
        }

        // Rediriger vers la page contenant le puzzle
        header('Location: index.php');
        exit;
    } else {
        // Une erreur s'est produite lors du téléchargement du fichier
        echo "Une erreur s'est produite lors du téléchargement de l'image.";
    }
}
?>
