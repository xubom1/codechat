<?php
include("src/utils.php");
include("../../database.php");

checkSessionElseLogin();

if (empty($_POST['name'])
|| empty($_POST['starting_date'])
|| empty($_POST['ending_date'])
|| empty($_POST['location'])
|| empty($_POST['description'])

)
{
    $msg = 'you must fill in all the fields ';
    header('location: events.php:?msg=' . $msg);
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