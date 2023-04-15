<?php
include('../src/utils.php');
include('../src/template.php');

checkSessionElseLogin(false);
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
                    
                    <li class="breadcrumb-item active" aria-current="page">Create an event</li>
                    <li class="breadcrumb-item"><a href="signevents.php">Assist to an event</a></li>
                    
                </ol>
            </nav>
        <div class="p-3">
            <h2 class="border-bottom mb-5 py-2">Create a new event</h2>

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

            <form action="newEventscript.php" method="post" class="">
            <label for="name">Name of the event :</label>
        <input type="text" id="name" name="name" required><br><br>
        <label for="starting_date">Starting date :</label>
        <input type="datetime-local" id="starting_date" name="starting_date" required> <br><br>
         <label for="date_fin">Ending date :</label>
        <input type="datetime-local" id="ending_date" name="ending_date" required> <br><br>
        <label for="date_fin">Location :</label>
        <input type="text" id="location" name="location" required><br><br>
        <label for="description">Description :</label>
        <textarea class="form-control my-3" rows="10" id="description" name="description"></textarea>
        
        <input type="submit" value="created" name="events" class="btn btn-secondary my-3">
            </form>
            </div>
    </main>

    <!--    END OF MAIN    -->
    <?= make_footer()?>
    </body>
</html>