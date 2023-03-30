<?php
include('src/utils.php');
include('src/template.php');



if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $pseudo = isset($_POST['pseudo']) ? $_POST['pseudo'] : '';
     $lastName = isset($_POST['lastName']) ? $_POST['lastName'] : '';
    $firstName = isset($_POST['firstName']) ? $_POST['firstName'] : '';
    $mail = isset($_POST['mail']) ? $_POST['mail'] : '';
    setcookie('pseudo', $pseudo, time() + (86400 * 30), ); // Durée de vie de 30 jours
    setcookie('lastName', $lastName, time() + (86400 * 30), );
    setcookie('firstName', $firstName, time() + (86400 * 30), );
    setcookie('mail', $mail, time() + (86400 * 30), );
}

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
      <li class="breadcrumb-item active" aria-current="page">Personal information</li>
      <li class="breadcrumb-item"><a href="address.php">Address</a></li>
      <li class="breadcrumb-item"><a href="password.php">Password</a></li>
  </ol>
</nav>
</main>
<h1> INSCRIPTION </h1>
      <p> Personal information </p>
<main class="justify-content-center row container m-auto">

    <form class="col-6 mt-4" method="post" action="verification.php">
     
                <label for="username" class="form-label">Pseudo</label>
                <input type="text" class="form-control" id="pseudo" name="pseudo" placeholder="your pseudo" value="<?php echo isset($_COOKIE['pseudo']) ? $_COOKIE['pseudo'] : ''; ?>" required>

              
                <label for="nom" class="form-label">Lastname</label>
				<input type="text" class="form-control" id="nom" name="lastName"placeholder="your Lastname" value="<?php echo isset($_COOKIE['lastName']) ? $_COOKIE['lastName'] : ''; ?>" required>
                <label for="prenom" class="form-label">Firstname</label>
				<input type="text"class="form-control" id="prenom" name="firstName" placeholder="your Firstname" value="<?php echo isset($_COOKIE['firstName']) ? $_COOKIE['firstName'] : ''; ?>" required>
                <label for="email" class="form-label">Mail</label>
				<input type="email" class="form-control" id="email" name="mail" placeholder="your mail" value="<?php echo isset($_COOKIE['mail']) ? $_COOKIE['mail'] : ''; ?>" required>
                
                <input type="submit" value="Next" name="inscrip1" class="btn btn-outline-primary my-2" >


</form>

</main>

        <!--    END OF MAIN    -->
        <?= make_footer()?>
    </body>
</html>

