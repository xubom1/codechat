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
                <div>
                    <div id="user" onclick="location.href='profile.php' " class='d-flex align-items-center justify-content-center'>
                        <div class='avatar' codechat-user='<?=$_SESSION['user']?>'></div>
                        <div><?=$_SESSION['pseudo']?></div>

                    </div>
                    <button class='colorModeButton btn btn-outline-success m-2' onclick='switchColorMode()'><?=(($_COOKIE['codechat_theme'] ?? 'light') === 'dark' ? 'light' : 'dark')?> mode</button>
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