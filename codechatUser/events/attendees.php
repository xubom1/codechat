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
                    <li class="breadcrumb-item"><a href="myEvent.php">Edit my event</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Event attendees</li>
                </ol>
            </nav>
            
<?php
if (!empty($_GET['id'])) {
    $eventId = $_GET['id'];
    $db = getDatabase();

   
    $getEvent = $db->query("SELECT * FROM events WHERE id = $eventId");
    $event = $getEvent->fetch(PDO::FETCH_ASSOC);

    
    $getAttendees = $db->query("SELECT * FROM user WHERE id IN (SELECT signer FROM eventSign WHERE event = $eventId)");
    
    if ($getAttendees->rowCount() == 0) {
        echo '<p>No attendees yet.</p>';
    } else{ while ($attendee = $getAttendees->fetch()) 
        echo '<li>' . $attendee['pseudo'] . '</li>';
    }
    echo '</ul>';
}
    ?>
    </main>

    <!--    END OF MAIN    -->
    <?= make_footer()?>
    </body>
    </html>