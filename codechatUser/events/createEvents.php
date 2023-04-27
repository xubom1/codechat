<?php
include('../src/utils.php');
include('../src/template.php');

checkSessionElseLogin(false);
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
                    
                    <li class="breadcrumb-item active" aria-current="page">Create an event</li>
                    <li class="breadcrumb-item"><a href="takePartEvent.php">Assist to an event</a></li>
                    <li class="breadcrumb-item"><a href="myEvent.php">Edit my event</a></li>
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

            <form action="chekCreateEvent.php" method="post" class="">
            <div class="form-group">
                <label for="name">Name of the event:</label>
                <input type="text" class="form-control" id="name" name="name" required>
            </div>
            <div class="form-group">
                <label for="starting_date">Starting date:</label>
                <input type="datetime-local" class="form-control" id="starting_date" name="starting_date" required>
            </div>
            <div class="form-group">
                <label for="ending_date">Ending date:</label>
                <input type="datetime-local" class="form-control" id="ending_date" name="ending_date" required>
            </div>
            <div class="form-group">
                <label for="location">Location:</label>
                <input type="text" class="form-control" id="location" name="location" required>
            </div>
            <div class="form-group">
                <label for="description">Description:</label>
                <textarea class="form-control" rows="10" id="description" name="description"></textarea>
            </div>
            <br>
            <button type="submit" class="btn btn-primary">Create</button>
            </form>

            </div>
    </main>

    <!--    END OF MAIN    -->
    <?= make_footer()?>
    </body>
</html>