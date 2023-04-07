<?php
include('src/utils.php');
include('src/template.php');


?>
<!DOCTYPE html>
<html lang="en" data-bs-theme='<?=getColorTheme()?>'>
    <?= make_head()?>
    <body>
        <?= make_header()?>
         <!--    MAIN PAGE    -->
         <main class="justify-content-start ">
   
         <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="login.php">Log-in</a></li>
            <li class="breadcrumb-item"><a href="sign_in.php">Personal information</a></li>
            <li class="breadcrumb-item"><a href="address.php">Address</a></li>
            <li class="breadcrumb-item active" aria-current="page">Password</li>
        </ol>
    </nav>
</main>
<h1> INSCRIPTION </h1>
      <p> Password </p>
<main class="justify-content-center row container m-auto">
    <form class="col-6 mt-4" method="post" action="verification.php">
        <label for="motdepasse" class="form-label">Password</label>
        <input type="password" class="form-control" id="motdepasse" name="password" placeholder="your password" value="<?php echo isset($_COOKIE['password']) ? $_COOKIE['password'] : ''; ?>" required>

        <label for="motdepasse_confirm" class="form-label">Confirm password</label>
        <input type="password" class="form-control" id="motdepasse_confirm" name="confirmPassword" placeholder="confirm your password" value="<?php echo isset($_COOKIE['confirmPassword']) ? $_COOKIE['confirmPassword'] : ''; ?>" required>

        <input type="submit" value="Sign in" name="inscrip3" class="btn btn-outline-primary my-2" >
                
    </form>
</main>



</main>


        <!--    END OF MAIN    -->
        <?= make_footer()?>
    </body>
</html>