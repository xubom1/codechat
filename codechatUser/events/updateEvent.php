<?php
include('../../database.php');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    
    $event_id = $_POST['event_id'];
    $name = $_POST['name'];
    $starting_date = $_POST['starting_date'];
    $ending_date = $_POST['ending_date'];
    $location = $_POST['location'];
    $description = $_POST['description'];

    
    $db = getDatabase();

    $stmt = $db->prepare('UPDATE events SET name = :name, starting_date = :starting_date, ending_date = :ending_date, location = :location, description = :description WHERE id = :event_id');
    $stmt->execute(array(':name' => $name, ':starting_date' => $starting_date, ':ending_date' => $ending_date, ':location' => $location, ':description' => $description, ':event_id' => $event_id));

    {
        $msg = 'your event has been modified  ';
        
        
    header('Location: myEvent.php?msg=' . $msg );
    exit();
} 
}
?>
