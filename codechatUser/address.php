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
     
      <li class="breadcrumb-item active" aria-current="page">Address</li>
      <li class="breadcrumb-item"><a href="password.php">Password</a></li>
  </ol>
</nav>
</main>
<h1> INSCRIPTION </h1>
      <p> Address </p>
<main class="justify-content-center row container m-auto">
    <form class="col-6 mt-4" method="post" action="verification.php">
                 <label for="codepostal" class="form-label">Postal code</label>
				<input type="text" class="form-control" id="codepostal" name="postalCode" placeholder="your Postal code" value="<?php echo isset($_COOKIE['postalCode']) ? $_COOKIE['postalCode'] : ''; ?>" required>
                <label for="ville" class="form-label">City</label>
				<input type="text" class="form-control" id="ville" name="city"placeholder="your city" value="<?php echo isset($_COOKIE['city']) ? $_COOKIE['city'] : ''; ?>" required>
                <label for="adresse" class="form-label">Address</label>
				<input type="text" class="form-control" id="adresse" name="address"placeholder="your address" value="<?php echo isset($_COOKIE['address']) ? $_COOKIE['address'] : ''; ?>" required>

                <input type="submit" value="Next" name="inscrip2" class="btn btn-outline-primary my-2" >


</form>



</main>



        <!--    END OF MAIN    -->
        <?= make_footer()?>
    </body>
</html>