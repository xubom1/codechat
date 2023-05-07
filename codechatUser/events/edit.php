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
                    <li class="breadcrumb-item"><a href="createEvents.php">create an event</a></li>
                    <li class="breadcrumb-item"><a href="takePartEvent.php">Assist to an event</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Edit my event</li>
                   
                </ol>
            </nav>
     <div class="p-3">
            <h2 class="border-bottom mb-5 py-2">Edit your Event</h2>
     
<?php
    // Récupère l'ID de l'événement à partir de la variable $_GET['id']
    $eventId = $_GET['id'];

    // Récupère les informations de l'événement à partir de la base de données
    $db = getDatabase();
    $stmt = $db->prepare('SELECT name, starting_date, ending_date, location, description FROM events WHERE id = ?');
    $stmt->execute([$eventId]);
    $event = $stmt->fetch(PDO::FETCH_ASSOC);
?>

<!-- Affiche le formulaire de modification avec les informations de l'événement pré-remplies -->
<form action="updateEvent.php" method="post" class="">

    <input type="hidden" name="event_id" value="<?php echo $eventId; ?>">

    <div class="form-group">
    <label for="name">Name of the event :</label>
    <input type="text" class="form-control" name="name" id="name" value="<?php echo $event['name']; ?>"required><br>
    <div>
    
    <div class="form-group">
    <label for="starting_date">Starting date :</label>
    <input type="datetime-local"  class="form-control" name="starting_date" id="starting_date" value="<?php echo $event['starting_date']; ?>"required><br>
    <div>

    <div class="form-group">
    <label for="ending_date">Ending date :</label>
    <input type="datetime-local"class="form-control" name="ending_date" id="ending_date" value="<?php echo $event['ending_date']; ?>"required><br>
    <div>

    <div class="form-group">
    <label for="location">Location  :</label>
    <input type="text" class="form-control" name="location" id="location" value="<?php echo $event['location']; ?>"required><br>
    <div>

    <div class="form-group">
    <label for="description">Description :</label>
    <textarea  class="form-control"name="description" id="description"><?php echo $event['description']; ?></textarea><br><br>
    <div>

    <input type="submit" value="Edit" name="events" class="btn btn-secondary my-3">
</form>
 
</div>

</main>