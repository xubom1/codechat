<?php
include('../src/utils.php');
include('../src/template.php');

include('../../database.php');

checkSessionElseLogin(false);
?>
<!DOCTYPE html>
<html lang="en" data-bs-theme='<?=getColorTheme()?>'>
<?= make_head('..')?>
    <body>
    <?= make_header('', false)?>

     <!--    MAIN PAGE    -->

     <main class="container">

     <nav aria-label="breadcrumb" class="my-2">
                <ol class="breadcrumb p-2 d-flex justify-content-center">
                    <li class="breadcrumb-item"><a href="createEvents.php">Create an event</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Assist to event</li>
                    <li class="breadcrumb-item"><a href="myEvent.php">Edit my event</a></li>
                   
                </ol>
            </nav>
            <div class="events">
    <h2>Liste des événements</h2>
    
    <ul>
        <?php
        
 
        $db = getDatabase();
        $getId = $db->query('SELECT id FROM user');
        $id = $getId->fetch(PDO::FETCH_ASSOC)['id'];
      
        $getEvents = $db->query("SELECT id, name, starting_date, ending_date, location, description FROM events WHERE creator != '" .$_SESSION['user']. "'");
        
        while ($event = $getEvents->fetch()) {
            
            echo '<li>';
            echo '<h3>' . $event['name'] . '</h3>';
            echo '<p><strong>Date : </strong> du ' . $event['starting_date'] . ' au ' . $event['ending_date'] . '</p>';
            echo '<p><strong>Lieu : </strong>' . $event['location'] . '</p>';
            echo '<p><strong>Description : </strong>' . $event['description'] . '</p>';
            echo '<button class="btn-register" data-event-id="' . $event['id'] . '">S\'inscrire</button>';
            echo '<span>&nbsp;</span>';
            echo '<button class="btn-unregister" data-event-id="' . $event['id'] . '">Se désinscrire</button>';
            echo '</li>';
        }
        
        ?>
    </ul>
</div>
<script>
// Récupère tous les boutons "S'inscrire"
var btnRegisters = document.querySelectorAll('.btn-register');
for (var i = 0; i < btnRegisters.length; i++) {
    // Ajoute un gestionnaire d'événements "click" à chaque bouton
    btnRegisters[i].addEventListener('click', function() {
        // Récupère l'ID de l'événement à partir de l'attribut "data-event-id"
        var eventId = this.getAttribute('data-event-id');

        // Envoie une requête AJAX pour ajouter l'utilisateur à l'événement
        var xhr = new XMLHttpRequest();
        xhr.open('POST', 'register.php', true);
        xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
        xhr.onload = function() {
            // Affiche un message de confirmation
            alert(xhr.responseText);
        };
        xhr.send('event_id=' + eventId);
    });
}

// Récupère tous les boutons "Se désinscrire"
var btnUnregisters = document.querySelectorAll('.btn-unregister');
for (var i = 0; i < btnUnregisters.length; i++) {
    // Ajoute un gestionnaire d'événements "click" à chaque bouton
    btnUnregisters[i].addEventListener('click', function() {
        // Récupère l'ID de l'événement à partir de l'attribut "data-event-id"
        var eventId = this.getAttribute('data-event-id');

        // Envoie une requête AJAX pour supprimer l'utilisateur de l'événement
        var xhr = new XMLHttpRequest();
        xhr.open('POST', 'unregister.php', true);
        xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
        xhr.onload = function() {
            // Affiche un message de confirmation
            alert(xhr.responseText);
        };
        xhr.send('event_id=' + eventId);
    });
}
</script>
</main>

<!--    END OF MAIN    -->
<?= make_footer()?>
</body>
</html>