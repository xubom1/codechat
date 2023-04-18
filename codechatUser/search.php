<?php
include('src/utils.php');
include('src/template.php');
include('../database.php');

checkSessionElseLogin();
$db = getDatabase();

//entry count result
if (empty($_GET['entry'])){
    header('location: /');
}

$getUsersCount = $db->prepare("SELECT COUNT(*) FROM user WHERE pseudo LIKE CONCAT('%', :entry, '%') ");
$getPublicationsCount = $db->prepare("SELECT COUNT(*) FROM publication WHERE respondTo IS NULL AND content LIKE CONCAT('%', :entry, '%')");
$getCommentariesCount = $db->prepare("SELECT COUNT(*) FROM publication WHERE respondTo IS NOT NULL AND content LIKE CONCAT('%', :entry, '%')");
$input = ['entry' => $_GET['entry']];

$getUsersCount->execute($input);
$usersCount = $getUsersCount->fetch()[0];

$getPublicationsCount->execute($input);
$publicationsCount = $getPublicationsCount->fetch()[0];

$getCommentariesCount->execute($input);
$commentariesCount = $getCommentariesCount->fetch()[0];

//type searched (user, publication, ...)
$defaultType = $usersCount != 0 ? 0 : ($publicationsCount != 0 ? 1 : ($commentariesCount != 0 ? 2 : 0)); // get the first type not zero
$type = $_GET['type'] ?? $defaultType;

?>
<!DOCTYPE html>
    <html lang="en" data-bs-theme='<?=getColorTheme()?>'>
    <?= make_head(".", "
        <style>
            .row-cols-1 > a{
                text-decoration: none;
                transition: .3s;
            }
            .row-cols-1 > a:hover{
                background-color: #0003;
            }
        </style>
    ")?>
        <body>
        <?= make_header('.', $_GET['entry'] ?? '')?>
        <main class="container">
            <div class='mt-5 row'>
                <div class="col-2 p-3">
                    <div class="row row-cols-1">
                        <a href="/search.php?entry=<?=$_GET['entry']?>&type=0" class="d-flex justify-content-between align-items-center p-2 border rounded-top-2  ">
                            <div class="text-body">users</div><div class="bg-info rounded-pill px-2 py-1 text-dark"><?=$usersCount?></div>
                        </a>
                        <a href="/search.php?entry=<?=$_GET['entry']?>&type=1" class="d-flex justify-content-between align-items-center p-2 border-start border-end ">
                            <div class="text-body">publications</div><div class="bg-info rounded-pill px-2 py-1 text-dark"><?=$publicationsCount?></div>
                        </a>
                        <a href="/search.php?entry=<?=$_GET['entry']?>&type=2" class="d-flex justify-content-between align-items-center p-2 border rounded-bottom-2  ">
                            <div class="text-body">commentaries</div><div class="bg-info rounded-pill px-2 py-1 text-dark"><?=$commentariesCount?></div>
                        </a>
                    </div>
                </div>
                <div class="col-10 border-start border-end">
                    <?php
                    switch ($type){
                        case 0: default:
                            $getUsers = $db->prepare("SELECT id FROM user WHERE pseudo LIKE CONCAT('%', :entry, '%') LIMIT 100");
                            $getUsers->execute($input);
                            $users = $getUsers->fetchAll(PDO::FETCH_ASSOC);
                            foreach ($users as $user){
                                echo make_user_presentation($db, $user['id']);
                            }
                            if ($usersCount == 0) echo "<h4 class='text-center'>no user was found</h4>";
                            break;
                        case 1:
                            $getPublications = $db->prepare("SELECT id FROM publication WHERE respondTo IS NULL AND content LIKE CONCAT('%', :entry, '%') ORDER BY lastEdition DESC LIMIT 100");
                            $getPublications->execute($input);
                            $publications = $getPublications->fetchAll(PDO::FETCH_ASSOC);
                            foreach ($publications as $publication){
                                echo makePublication($publication['id'], $db);
                            }
                            if ($publicationsCount == 0) echo "<h4 class='text-center'>no publication was found</h4>";
                            break;
                        case 2:
                            $getCommentaries = $db->prepare("SELECT id FROM publication WHERE respondTo IS NOT NULL AND content LIKE CONCAT('%', :entry, '%') ORDER BY lastEdition DESC LIMIT 100");
                            $getCommentaries->execute($input);
                            $commentaries = $getCommentaries->fetchAll(PDO::FETCH_ASSOC);
                            foreach ($commentaries as $commentary){
                                echo makePublication($commentary['id'], $db);
                            }
                            if ($commentariesCount == 0) echo "<h4 class='text-center'>no commentary was found</h4>";
                            break;
                    }
                    ?>
                </div>
            </div>
            <script src='js/user/importPublications.js'></script>
        </main>
        <?= make_footer()?>
    </body>
</html>