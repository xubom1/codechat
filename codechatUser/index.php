<?php
    include("src/template.php");
    include("src/utils.php");
    include("../database.php");

    checkSessionElseLogin();
?>
<!DOCTYPE html>
<html lang="en" data-bs-theme='<?=getColorTheme()?>'>
    <?= make_head()?>
    <body>
        <?= make_header()?>

        <!--    MAIN PAGE    -->

        <main class="row justify-content-center">
            <div id="leftPanel" class="mainPagePanel col-2">
                <div id="user" onclick="location.href='profile.php'">
                    <img src="assets/defaultAccount.svg" alt="avatar" width="60px">
                    <a><?=$_SESSION['pseudo']?></a>
                </div>
                <button class="btn btn-secondary">new publication</button>
            </div>

            <div id="scrollerContainer" class="col-6">
                <div id="scroller"></div>
            </div>

            <div id="rightPanel" class="mainPagePanel col-2">
            </div>           
        </main>

        <!--    END OF MAIN    -->
        <?= make_footer()?>
        <script src='js/user/importPublications.js'></script>
    </body>
</html>