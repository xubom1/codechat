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
                    <li class="breadcrumb-item"><a href="takePartEvent.php">Assist to an event</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Edit my event</li>
                   
                </ol>
            </nav>
            <div class="events">
    <h2>Mes événements</h2>
    
    <ul>
    <?php
        $db = getDatabase();
        $getId = $db->query('SELECT id FROM user');
        $id = $getId->fetch(PDO::FETCH_ASSOC)['id'];
      
        $getEvents = $db->query("SELECT id, name, starting_date, ending_date, location, description FROM events WHERE creator = '" .$_SESSION['user']. "'");
        
        if ($getEvents->rowCount() == 0) {
            echo '<p>Vous n\'avez créé aucun événement pour le moment.</p>';
          } else {
            while ($event = $getEvents->fetch()) {
              echo '<li>';
              echo '<h3>' . $event['name'] . '</h3>';
              echo '<p><strong>Date : </strong> du ' . $event['starting_date'] . ' au ' . $event['ending_date'] . '</p>';
              echo '<p><strong>Location : </strong>' . $event['location'] . '</p>';
              echo '<p><strong>Description : </strong>' . $event['description'] . '</p>';
              echo '<button class="btn-edit">';
              echo '<a href="delete.php?id=' . $event['id'] . '">delete</a>';
              echo '</button>';
              echo '<span>&nbsp;</span>';
              echo '<button class="btn-edit">';
                echo '<a href="edit.php?id=' . $event['id'] . '">edit</a>';
                echo '</button>';

              echo '</li>';
            }
          }
        ?>
</ul>
</div>

</main>

<!--    END OF MAIN    -->
<?= make_footer()?>
</body>
</html>
