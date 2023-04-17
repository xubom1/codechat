<?php

include('src/utils.php');
include('src/template.php');

checkNotSessionElseMainPage();

$msg = 'Please log in !';
if (isset($_GET['msg'])){
    $msg = $_GET['msg'];
}
$msgClass = '';
if (isset($_GET['err']) && $_GET['err'] == 'true'){
    $msgClass = ' text-danger ';
}

?>
<!DOCTYPE html>
<html lang="en" data-bs-theme='<?=getColorTheme()?>'>
    <?= make_head()?>
    <body>
        <?= make_header('', false)?>
        <main class="justify-content-center row container m-auto">
            <h3 class="<?=$msgClass?> text-center"><?=$msg?></h3>
            <form class="col-6 mt-4" method="post" action="./src/check.php">
                <label for="username" class="form-label">username</label>
                <input type="text" class="form-control" name="username">

                <label for="password" class="form-label">password</label>
                <input type="password" class="form-control" name="password">

                <input type="submit" value="Log In" class="btn btn-primary my-2" >
                <div class="dropdown-divider"></div>
                <span>New around here?</span> <a href='signin/sign_in.php'>Sign Up</a><br>
                <a href="#">Forgot password ?</a>

            </form>
        </main>
        <!--    END OF MAIN    -->
        <?= make_footer()?>
    </body>
</html>