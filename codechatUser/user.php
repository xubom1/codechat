<?php

include("src/template.php");
include("src/utils.php");
include("../database.php");

checkSessionElseLogin();

if (empty($_GET['user'])){
    header('location: /');
}

//if the user wants to see its own page
if ($_GET['user'] == $_SESSION['user']){
    header('location: /profile.php');
}

$db = getDatabase();

$getUser = $db->prepare('SELECT * FROM user WHERE id = :user');
$getUser->execute(['user' => $_GET['user']]);
$user = $getUser->fetch(PDO::FETCH_ASSOC);

//get number of followers
$getFollowersCount = $db->prepare('SELECT COUNT(*) FROM follow WHERE followed = :user');
$getFollowersCount->execute(['user' => $_GET['user']]);
$followersCount = $getFollowersCount->fetch()[0];

//get number of followed users
$getFollowedCount = $db->prepare('SELECT COUNT(*) FROM follow WHERE follower = :user');
$getFollowedCount->execute(['user' => $_GET['user']]);
$followedCount = $getFollowedCount->fetch()[0];

//get publications
$getPublications  = $db->prepare('SELECT id FROM publication WHERE creator = :user limit 10');
$getPublications->execute(['user' => $_GET['user']]);
$publications = $getPublications->fetchAll();

?>
<!DOCTYPE html>
<html lang="en" data-bs-theme='<?=getColorTheme()?>'>
    <?= make_head()?>
    <body>
        <?= make_header()?>
        <!--    MAIN PAGE    -->
        <main class="container mt-3">
            <div class="d-flex align-items-center">
                <?=make_user_presentation($db, $user['id']);?>
                <div class="p-2">&bull; user created in <? echo date('M Y',strtotime($user['creation']));?></div>
                <div class="px-1">&bull; <?=$followersCount?> followers</div>
                <div> &bull; <?=$followedCount;?> followed</div>
            </div>
            <div>
                <?php
                foreach ($publications as $publication){
                    makePublication($publication['id'], $db, '.');
                }
                ?>
            </div>
        </main>
        <!--    END OF MAIN    -->
        <?= make_footer()?>
        <script src='js/user/importPublications.js'></script>
    </body>
</html>
