<?php
include('../src/utils.php');
include('../src/template.php');


?>
<!DOCTYPE html>
<html lang="en" data-bs-theme='<?=getColorTheme()?>'>
    <?= make_head('..')?>
    <body>
        <?= make_header('..')?>
         <!--    MAIN PAGE    -->
         <main class="container">
            <nav aria-label="breadcrumb" class="my-2">
                <ol class="breadcrumb p-2 d-flex justify-content-center">
                    <li class="breadcrumb-item"><a href="../login.php">Log-in</a></li>
                    <li class="breadcrumb-item"><a href="sign_in.php">Personal information</a></li>
                    <li class="breadcrumb-item"><a href="address.php">Address</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Password</li>
                </ol>
            </nav>
             <h1 class="text-center m-4"> Codechat Account Creation </h1>
             <?php
             if (!empty($_GET['msg'])){
                 $msg =  $_GET['msg'];
                 echo "
                    <div class='alert alert-danger' role='alert'>
                       $msg
                    </div>
                 ";
             }
             ?>
             <form class="col-6 m-auto" method="post" action="verification.php">
                 <h6 class="my-3"> Create your password </h6>

                 <label for="motdepasse" class="form-label">password</label>
                 <input type="password" class="form-control" id="motdepasse" name="password" placeholder="your password" value="<?php echo isset($_COOKIE['password']) ? $_COOKIE['password'] : ''; ?>" required>
                 <label for="motdepasse_confirm" class="form-label my-2">Confirm password</label>
                 <input type="password" class="form-control" id="motdepasse_confirm" name="confirmPassword" placeholder="confirm your password" value="<?php echo isset($_COOKIE['confirmPassword']) ? $_COOKIE['confirmPassword'] : ''; ?>" required>

                 <input type="submit" value="Sign in" name="inscrip3" class="btn btn-primary my-3">

             </form>
         </main>
        <?= make_footer('..')?>
    </body>
</html>