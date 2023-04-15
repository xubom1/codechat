<?php

include("src/template.php");
include("src/utils.php");
include("../database.php");

checkSessionElseLogin();

if (empty($_GET['id'])){
    header('location: /');
}

$db = getDatabase();

//get comments
$getComments = $db->prepare('SELECT id FROM publication WHERE respondTo = :publication ORDER BY lastEdition DESC LIMIT 100');
$getComments->execute(['publication' => $_GET['id']]);
$comments = $getComments->fetchAll(PDO::FETCH_ASSOC);


?>
<!DOCTYPE html>
<html lang="en" data-bs-theme='<?=getColorTheme()?>'>
    <?= make_head()?>
    <body>
        <?= make_header()?>
        <!--    MAIN PAGE    -->
        <main class="container mt-3">
            <div class="col-8 m-auto ">
                <?=makePublication($_GET['id'],$db);?>
            </div>
            <div class="col-6 m-auto border-start border-end p-2">
                <div class="border-bottom pb-2">
                    <?= make_user_presentation($db, $_SESSION['user']);?>
                    <form class="d-flex flex-column" action="/src/createComment.php" method="post">
                        <textarea placeholder="write your comment here..." class="form-control my-2" name="content"></textarea>
                        <input type="hidden" name="publication" value="<?=$_GET['id']?>">
                        <input type="submit" class="btn btn-secondary my-1 align-self-end" value="publish">
                    </form>

                </div>
                <?php


                if (!count($comments)) echo '<h6 class="text-center my-2">there is no comments under this publication</h6>';
                foreach ($comments as $comment){
                    echo makePublication($comment['id'], $db);
                }
                ?>
            </div>

        </main>
        <!--    END OF MAIN    -->
        <?= make_footer()?>
        <script src='js/user/importPublications.js'></script>
    </body>
</html>
