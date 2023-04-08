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

function make_user_presentation($db, $id): string {
    $getUser = $db->prepare('SELECT pseudo FROM user WHERE id = :user ');
    $getUser->execute(['user' => $id]);
    $user = $getUser->fetch(PDO::FETCH_ASSOC);
    $pseudo = $user['pseudo'];

    return "
        <div class='d-flex flex-row align-items-center'>
            <div class='avatar' codechat-user='$id'></div>
            <a href='/user.php?user=$id' class='text-body'>$pseudo</a>
        </div>
    ";
}

function makePublication($id, $db, $rootpath = ".."): string
{
    //get publication
    $getPublication = $db->prepare("SELECT * FROM publication WHERE id=?");
    $getPublication->execute([(int)$id]);
    $publication = $getPublication->fetch(PDO::FETCH_ASSOC);

    //get like count
    $getLikeCount = $db->prepare("SELECT COUNT(*) FROM liked WHERE publication=?");
    $getLikeCount->execute([$id]);
    $likeCount = $getLikeCount->fetch()[0];

    //determine if user liked this publication
    $getLiked = $db->prepare("SELECT EXISTS( SELECT * FROM liked WHERE publication = :publication AND user = :user)");
    $getLiked->execute([
        'publication' => $id,
        'user' => $_SESSION['user']
    ]);
    $liked = $getLiked->fetch()[0];
    $likeImg = $liked ? "$rootpath/assets/unlike.png" : "$rootpath/assets/like.svg";
    $likeUser = $_SESSION['user'];

    //get creator
    $user = $publication['creator'];
    $pseudo = getUserPseudo($user, $db);

    //time since publication
    $interval = displayTimeInterval($publication["lastEdition"]);
    $id = $publication['id'];

    $content = $publication['content'];

    return "
        <article class='publication' id='$id'>
            <div class='publicationHeader d-flex align-items-center'>
                " . make_user_presentation($db, $user) . "
                <div class='mx-2'>
                    &bull; $interval
                </div>
            </div>
            <div class='publicationBody'>
                $content
            </div>
            <div class='publicationFooter'>
                <img src='$likeImg' alt='$liked' onclick='updateLike(this)' codechat-user='$likeUser'>
                <div class='likesCounter'>$likeCount</div>
            </div>
        </article>
    ";
}

function getColorTheme(){
    return $_COOKIE['codechat_theme'] ?? 'light';
}
