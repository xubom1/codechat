<?php

// Check if is correct
function randomPassword() {
    $alphabet = "abcdefghijklmnopqrstuwxyzABCDEFGHIJKLMNOPQRSTUWXYZ0123456789";
    for ($i = 0; $i < 8; $i++) {
        $n = rand(0, count($alphabet)-1);
        $pass[$i] = $alphabet[$n];
    }
    return $pass;
}

include ('/var/www/html/codechat/codechatAdmin/mailFunction.php');

if (isset($_POST['submit'])){
    if (!isset($_POST['username']) || empty($_POST['username'])){
        header('location: getNewPassword.php?msg=complete pseudo&err=true');
    }

    include ('../database.php');
    $db = getDatabase();
    $cmd = $db->prepare('SELECT id, pseudo, mail FROM user WHERE pseudo = ?');
    $cmd->execute([$_POST['username']]);
    $test = $cmd->fetch();

    if ($test){
        $newPassword = randomPassword();
        $cmd = $db->prepare('UPDATE user SET password = ? WHERE id = ?');
        $cmd->execute([password_hash($newPassword, PASSWORD_DEFAULT)]);
        $sub = 'Reset a password';
        $cont = 'Hello '. $test['pseudo'] . ', Connect with this password : ' . $newPassword .' Please change the password quickly';
        sendMail('support codechat', 'support', $test['mail'], $test['pseudo'], NULL, NULL, $sub, $cont, $cont, 'getNewPassword.php');
        header('getNewPassword.php?msg=New password has been send.&err=false');
    } else {
        header('location: getNewPassword.php');
    }
}

// -------------------

include('src/utils.php');
include('src/template.php');

checkNotSessionElseMainPage();

$msg = 'Found your password !';
if (isset($_GET['msg'])) {
    $msg = $_GET['msg'];
}
$msgClass = '';
if (isset($_GET['err']) && $_GET['err'] == 'true') {
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
    <form class="col-6 mt-4" method="post" action="">
        <label for="username" class="form-label">username</label>
        <input type="text" class="form-control" name="username">

        <input type="submit" value="Log In" class="btn btn-primary my-2" >
        <div class="dropdown-divider"></div>
        <a href="login.php">Go back</a>

    </form>
</main>
<!--    END OF MAIN    -->
<?= make_footer()?>
</body>
</html>