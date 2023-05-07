<?php
include('../../database.php');

$event_id = $_GET['id'];

$db = getDatabase();
$stmt = $db->prepare('DELETE FROM events WHERE id = :id');
$stmt->execute(array(':id' => $event_id));
header('Location: myEvent.php');

exit();
?>