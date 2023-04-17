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

                      <li class="breadcrumb-item active" aria-current="page">Address</li>
                      <li class="breadcrumb-item"><a href="password.php">Password</a></li>
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


                 <h6 class="my-3"> Address </h6>

                 <label for="codepostal" class="form-label">Postal code</label>
                 <input type="text" class="form-control" id="codepostal" name="postalCode" placeholder="your Postal code" value="<?php echo isset($_COOKIE['postalCode']) ? $_COOKIE['postalCode'] : ''; ?>" required>
                 <label for="ville" class="form-label my-2">City</label>
                 <input type="text" class="form-control" id="ville" name="city"placeholder="your city" value="<?php echo isset($_COOKIE['city']) ? $_COOKIE['city'] : ''; ?>" required>
                 <label for="adresse" class="form-label my-2">Address</label>
                 <input type="text" class="form-control" id="adresse" name="address"placeholder="your address" value="<?php echo isset($_COOKIE['address']) ? $_COOKIE['address'] : ''; ?>" required>

                 <input type="submit" value="Next" name="inscrip2" class="btn btn-secondary my-3" >
             </form>
         </main>
        <!--    END OF MAIN    -->
        <?= make_footer('..')?>
    </body>
</html>