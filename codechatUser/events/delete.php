<?php
include('../../database.php');

$event_id = $_GET['id'];

$db = getDatabase();
$stmt = $db->prepare('DELETE FROM events WHERE id = :id');
$stmt->execute(array(':id' => $event_id));
{
    $msg = 'your event has been deleted ';
    
    
header('Location: myEvent.php?msg=' . $msg);

exit();
}
?>