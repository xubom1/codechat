<?php
include('../src/utils.php');
include('../../database.php');

checkSessionElseLogin();
if (empty(trim($_POST['name'])) 
    || empty($_POST['starting_date'])
    || empty($_POST['ending_date'])
    || empty(trim($_POST['location']))
    || empty(trim($_POST['description']))
    || empty(trim($_POST['max_signups']))
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
    
    if (!empty($_POST['max_signups']) && $_POST['max_signups'] <= 0)
    {
       
        $msg = 'The maximum number of signups must be greater than zero';
        header('Location: createEvents.php?msg=' . $msg);
        exit();
    }

    $db = getDatabase();
$newEvents = $db->prepare('INSERT INTO events(name, starting_date, ending_date, location, description, creator, max_signups) VALUES(:name, :starting_date, :ending_date, :location, :description, :creator, :max_signups)');
$newEvents->execute([
    'name' => $_POST['name'],
    'starting_date' => $_POST['starting_date'],
    'ending_date' => $_POST['ending_date'],
    'location' => $_POST['location'],
    'description' => $_POST['description'],
    'creator' => $_SESSION['user'],
    'max_signups'  => $_POST['max_signups']
]);
header('location: /');
?>