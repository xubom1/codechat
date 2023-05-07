<?php
include('../src/utils.php');
include('../src/template.php');

session_start();


//if ($_SERVER['REQUEST_METHOD'] == 'POST') {
//    $pseudo = isset($_POST['pseudo']) ? $_POST['pseudo'] : '';
//     $lastName = isset($_POST['lastName']) ? $_POST['lastName'] : '';
//    $firstName = isset($_POST['firstName']) ? $_POST['firstName'] : '';
//    $mail = isset($_POST['mail']) ? $_POST['mail'] : '';
//    setcookie('pseudo', $pseudo, time() + (86400 * 30)); // Durée de vie de 30 jours
//    setcookie('lastName', $lastName, time() + (86400 * 30));
//    setcookie('firstName', $firstName, time() + (86400 * 30));
//    setcookie('mail', $mail, time() + (86400 * 30));
//}

?>
<!DOCTYPE html>
<html lang="en" data-bs-theme='<?=getColorTheme()?>'>
    <?= make_head('..')?>
    <body>
    <?= make_header('', false)?>
         <!--    MAIN PAGE    -->
         <main class="container">

            <nav aria-label="breadcrumb" class="my-2">
                <ol class="breadcrumb p-2 d-flex justify-content-center">
                    <li class="breadcrumb-item"><a href="../login.php">Log-in</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Personal information</li>
                    <li class="breadcrumb-item"><a href="address.php">Address</a></li>
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
                 <h6 class="my-3"> Personal information </h6>

                 <label for="username" class="form-label">Pseudo</label>
                 <input type="text" class="form-control" id="pseudo" name="pseudo" placeholder="your pseudo" value="<?php echo htmlspecialchars($_COOKIE['pseudo'] ?? ''); ?>" required>
                 <label for="nom" class="form-label my-2">Lastname</label>
                 <input type="text" class="form-control" id="nom" name="lastName" placeholder="your Lastname" value="<?php echo htmlspecialchars($_COOKIE['lastName'] ?? ''); ?>" required>
                 <label for="prenom" class="form-label my-2">Firstname</label>
                 <input type="text" class="form-control" id="prenom" name="firstName" placeholder="your Firstname" value="<?php echo htmlspecialchars($_COOKIE['firstName'] ?? ''); ?>" required>
                 <label for="email" class="form-label my-2">Mail</label>
                 <input type="email" class="form-control" id="email" name="mail" placeholder="your mail" value="<?php echo htmlspecialchars($_COOKIE['mail'] ?? ''); ?>" required>

                 <input type="submit" value="Next" name="inscrip1" class="btn btn-secondary my-3" >


             </form>
        </main>


        <!--    END OF MAIN    -->
        <?= make_footer('..')?>
    </body>
</html>

