<?php

function checkSessionElseLogin(): void
{
    session_start();
    if (!isset($_SESSION['user'])){
        header("location: login.php?msg=session is not valid, please identify&err=true");
    }
}

function checkNotSessionElseMainPage(): void
{
    session_start();
    if (isset($_SESSION['user'])){
        header("location: ../");
    }
}

function displayTimeInterval($date): string
{
    //get publication interval since creation
    date_default_timezone_set('Europe/Paris');
    $datePub = DateTime::createFromFormat('Y-m-d H:i:s', $date);
    $dateNow = DateTime::createFromFormat('Y-m-d H:i:s', date("Y-m-d H:i:s"));
    $interval = date_diff($dateNow, $datePub);

    $units = ['y' => 'year', 'm' => 'month', 'd' => 'day', 'h' => 'hour', 'i' => 'minute', 's' => 'second'];
    foreach ($units as $key => $output){
        if ($interval->$key != 0){
            return $interval->$key . ' ' . $output . ($interval->$key === 1 ? '' : 's') . ' ago';
        }
    }
    return "0 second ago";
}

function getUserPseudo($id, $db){
    $cmd = $db->prepare("SELECT pseudo FROM user WHERE id=?");
    $cmd->execute([$id]);
    return $cmd->fetch()['pseudo'];
}

function makePublication($id, $db, $rootpath = ".."): string
{

    //get publication
    $cmd = $db->prepare("SELECT * FROM publication WHERE id=?");
    $cmd->execute([$id]);
    $publication = $cmd->fetch();

    //get like count
    $cmd = $db->prepare("SELECT COUNT(*) FROM liked WHERE publication=?");
    $cmd->execute([$id]);
    $likeCount = $cmd->fetch()[0];

    $user = $publication['creator'];
    $pseudo = getUserPseudo($user, $db);


    $interval = displayTimeInterval($publication["lastEdition"]);
    $id = $publication['id'];

    return "
        <article class='publication' id='$id'>
            <div class='publicationHeader d-flex align-items-center'>
                <div class='avatar' codechat-user='$user'></div>
                <a href='#$id' class='text-body'>$pseudo</a>
                <div class='mx-2'>
                    &bull; $interval
                </div>
            </div>
            <div class='publicationBody'>
                $publication[1]
            </div>
            <div class='publicationFooter'>
                <img src='$rootpath/assets/like.svg'>
                <div>$likeCount</div>
            </div>
        </article>
    ";
}

function getColorTheme(){
    return $_COOKIE['codechat_theme'] ?? 'light';
}
