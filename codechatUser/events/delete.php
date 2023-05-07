<?php
include('../../database.php');
include('../../codechatAdmin/mailFunction.php')
$event_id = $_GET['id'];

$db = getDatabase();

$stmt = $db->prepare('SELECT * FROM eventSign WHERE event = :event_id');
$stmt->execute(array(':event_id' => $event_id));
$eventSigns = $stmt->fetchAll(PDO::FETCH_ASSOC);

$stmt = $db->prepare('DELETE FROM eventSign WHERE event = :event_id');
$stmt->execute(array(':event_id' => $event_id));


$stmt = $db->prepare('DELETE FROM events WHERE id = :id');
$stmt->execute(array(':id' => $event_id));
foreach ($eventSigns as $eventSign) {
    $user_id = $eventSign['signer'];
    $stmt = $db->prepare('SELECT * FROM user WHERE id = :user_id');
    $stmt->execute(array(':user_id' => $user_id));
    $user = $stmt->fetch(PDO::FETCH_ASSOC);
    
    $subject = 'Event deleted';
    $body = 'Dear '.$user['pseudo'].',<br><br>The event you signed up for has been deleted.<br><br>Best regards,<br>The Event Team';
    $bodyNoHtml = 'Dear '.$user['pseudo'].',The event you signed up for has been deleted.Best regards,The Event Team';
    
    sendMail('support@codechat.fr', 'Event Team', $user['mail'], $user['pseudo'], null, null, $subject, $body, $bodyNoHtml, '../../myEvent.php');
}

{
    $msg = 'your event has been deleted ';
    
    
header('Location: myEvent.php?msg=' . $msg);

exit();
}
?>