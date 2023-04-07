<?php
include('../database.php');

$db = getDatabase();

session_start();
if( isset($_POST['inscrip1'])){
    if( empty($_POST['pseudo'])
    || empty($_POST['mail'])
    || empty($_POST['lastName'])
    || empty($_POST['firstName'])
)
{
$msg = 'you must fill in all the fields ';
header('location: sign_in.php?message=' . $msg);
exit();
}
   
if(!filter_var($_POST['mail'], FILTER_VALIDATE_EMAIL))
{
	$msg = 'Invalid mail.';
	header('location: sign_in.php?message=' . $msg);
	exit();
}else{
    $_SESSION ['mail'] = $_POST['mail'];
    $_SESSION ['pseudo'] = $_POST ['pseudo'];
    $_SESSION ['firstName'] = $_POST['firstName'];
    $_SESSION['lastName'] =  $_POST['lastName'];
    header('location:address.php');
    exit;
}
}
/*******************VERIFICATION DEUXIÈME PAGE******************************************************************************************************* */  
if( isset($_POST['inscrip2'])){
    if( empty($_POST['postalCode'])
    || empty($_POST['city'])
    || empty($_POST['address'])
    
)
{
$msg = 'you must fill in all the fields ';
header('location: Address.php?message=' . $msg);
exit();
} 
 

else{
    $_SESSION['postalCode'] = $_POST['postalCode'];
    $_SESSION ['city'] = $_POST ['city'];
    $_SESSION ['address'] = $_POST['address'];
    header('location:password.php');
    exit;
}
}
/*********************************VERIFICATION MOT DE PASSE***************************************************************************************** */  
if( isset($_POST['inscrip3'])){
    if( empty($_POST['password'])
    || empty($_POST['confirmPassword'])
    )
    {
        $msg = 'you must fill in all the fields ';
        header('location: password.php?message=' . $msg);
        exit();
        } if (isset($_POST['password']) !== isset($_POST['confirmPassword'])) {
            $msg = 'the password must be the same.';
            header ('location:password.php?message='.$msg);
            exit();
        }
        else{
            $_SESSION ['password'] = $_POST['password'];
         
          
        

/************************************************************************************************************************** */

    $q = 'SELECT pseudo FROM user WHERE pseudo = :pseudo';
    $req = $db-> prepare($q);
    $req->execute([
        'pseudo' =>  $_SESSION ['pseudo']
    ]);

    $response = $req->fetch(); 
    if($response){
        $msg = 'The nickname is already in use';
        header ('location: sign_in.php?message='. $msg);
        exit();
    }
    $q = 'SELECT mail  FROM user WHERE mail = :mail';
    $req = $db-> prepare($q);
    $req->execute([
        'mail' =>  $_SESSION ['mail']
    ]);
    $response = $req->fetch(); 
    if($response != false){
        $msg = 'The email address is already in use';
        header ('location: sign_in.php?message='.$msg);
        exit();
    }
    $q = 'INSERT INTO user (pseudo,mail,lastName,firstName,postalCode,city,address, password) VALUES(:pseudo, :mail, :lastName, :firstName, :postalCode, :city, :address,  :password)';
    $req = $db-> prepare($q);

    $reponse = $req ->execute([
        'pseudo'=>  $_SESSION ['pseudo'],
        'mail'=>  $_SESSION ['mail'],
        'lastName'=>  $_SESSION ['lastName'],
        'firstName'=>  $_SESSION ['firstName'],
        'postalCode'=>  $_SESSION ['postalCode'],
        'city'=>  $_SESSION ['city'],
        'address'=>  $_SESSION ['address'],
        'password' => password_hash( $_SESSION['password'], PASSWORD_DEFAULT)
    ]);

    if($reponse ==0){
        $msg = 'Erreur lors de l\'inscription en base de données.';
        header('location:sign_in.php?message=' .$msg);
        exit();
    } else {
        $msg = 'compte créé avec succès!!';
        header('location: login.php?message=' .$msg);
        exit;
    }
}
}
?>
