 <?php
 include("pages/utils.php");
 checkNotSessionElseMainPage();

 include('../database.php');
$db = getDatabase();

 //check

if (isset($_POST["id"]) && !empty($_POST["id"]) && isset($_POST["password"]) && !empty($_POST["password"])){
    $success= false;

    if (doesAdminNameExists($_POST['id'], $db)){
        $command = $db->prepare('SELECT password FROM user WHERE pseudo=:name');
        $command->execute([
            'name' => $_POST["id"]
        ]) or die(print_r($db->errorInfo()));

        if (password_verify($_POST['password'], $command->fetch()['password'])){
            $_SESSION['admin'] = $_POST["id"];
            header("location: index.php");
        }
        else{
            header("location: login.php?msg=password is not correct !&err=true");
        }
    }
    else{
        header("location: login.php?msg=identifier is not correct !&err=true");
    }
}
else{
    header("location: login.php?msg=please fill the form to identify&err=true");
}
