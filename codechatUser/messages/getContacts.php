<?php
include("../src/utils.php");
include("../../database.php");

checkSessionElseLogin();
$db = getDatabase();

//get each user that the user talked with
$getContact = $db->prepare('SELECT u.id AS user, MAX(m.creation) AS date FROM user AS u INNER JOIN message AS m ON u.id IN (m.author, m.receiver) AND :user IN (m.author, m.receiver) WHERE u.id != :user GROUP BY u.id ORDER BY date DESC');
$getContact->execute([ 'user' => $_SESSION['user']]);
$contacts = $getContact->fetchAll(PDO::FETCH_ASSOC);

//get current messages count
$count = $db->prepare('SELECT COUNT(content) AS count FROM message WHERE :user IN (author, receiver)');
$count->execute(['user' => $_SESSION['user']]);
$messageCount = $count->fetch()[0];

//display new messages system
$newMessageCount = 0;
if (!empty($_POST['previousMessageCount'])){
    $newMessageCount = $messageCount - $_POST['previousMessageCount'];
}

$getNewMessages = $db->prepare('SELECT author FROM message ORDER BY creation DESC LIMIT :count');
$getNewMessages->bindValue('count', $newMessageCount, PDO::PARAM_INT);
$getNewMessages->execute();
$news = $getNewMessages->fetchAll(PDO::FETCH_ASSOC);

$newMsgCountPerUser = [];

foreach ($news as $msg){
    $newMsgCountPerUser[$msg['author']] = ($newMsgCountPerUser[$msg['author']] ?? 0) + 1;
}

foreach ($contacts as $contact){
    $user = $contact['user'];

    $new = "";

    if (isset($newMsgCountPerUser[$user])){
        $new = "<div class='rounded-pill bg-info px-2 text-black me-1'>$newMsgCountPerUser[$user]</div>";
    }

    echo "
        <a class='contact py-1 d-flex justify-content-between align-items-center border-bottom' href='?user=$user'>
            <div class='d-flex align-items-center'>
                <div class='avatar' codechat-user='$user' size='30'></div>
                <div class='text-body text-decoration-none'>".getUserPseudo($user, $db)."</div>
            </div>
            
            
            <div class='d-flex'>
                <div class='pe-2 text-body mt-1'>". displayTimeInterval($contact['date'], true) ."</div>
                $new
            </div>
        </a>
        ";
}

if (!count($contacts)){
    echo "<div class='my-2'>you talked to nobody for now</div>";
}