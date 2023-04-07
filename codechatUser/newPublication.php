<?php
include("src/template.php");
include("src/utils.php");

checkSessionElseLogin();
?>
<!DOCTYPE html>
<html lang="en" data-bs-theme='<?=getColorTheme()?>'>
    <?= make_head()?>
    <body>
    <?= make_header()?>

    <!--    MAIN PAGE    -->

    <main class="container">
        <div class="p-3">
            <h2 class="border-bottom mb-5 py-2">Create a new publication</h2>
            <form action="src/newPublicationScript.php" method="post" class="">
                <label for="content">publication content</label>
                <textarea name="content" class="form-control my-3" rows="10"></textarea>
                <input type="submit" value="publish" class="btn btn-secondary my-3">
            </form>
        </div>
    </main>

    <!--    END OF MAIN    -->
    <?= make_footer()?>
    </body>
</html>