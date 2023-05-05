<?php
include('../src/utils.php');
include('../../database.php');

checkSessionElseLogin();
if (empty(trim($_POST['name'])) 
    || empty($_POST['starting_date'])
    || empty($_POST['ending_date'])
    || empty(trim($_POST['location']))
    || empty(trim($_POST['description']))
)
{
    $msg = 'you must fill in all the fields';
    header('location: createEvents.php?msg=' . $msg);
    exit();
}

    $starting_date = $_POST['starting_date'];
    $ending_date = $_POST['ending_date'];
    
    $starting_timestamp = strtotime($starting_date);
    $ending_timestamp = strtotime($ending_date);
    
    if ($starting_timestamp > $ending_timestamp) {
       
        $msg = 'The start date must be before or equal to the end date.';
        header('Location: createEvents.php?msg=' . $msg);
        exit();
    }
    
    $db = getDatabase();
$newEvents = $db->prepare('INSERT INTO events(name, starting_date, ending_date, location, description, creator) VALUES(:name, :starting_date, :ending_date, :location, :description, :creator)');
$newEvents->execute([
    'name' => $_POST['name'],
    'starting_date' => $_POST['starting_date'],
    'ending_date' => $_POST['ending_date'],
    'location' => $_POST['location'],
    'description' => $_POST['description'],
    'creator' => $_SESSION['user']
]);
header('location: /');
?>