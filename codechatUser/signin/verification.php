<?php
include('../../database.php');

$db = getDatabase();

session_start();
if( isset($_POST['inscrip1'])){
    if( empty(trim($_POST['pseudo']))
    || empty(trim($_POST['mail']))
    || empty(trim($_POST['lastName']))
    || empty(trim($_POST['firstName']))
)
{
$msg = 'you must fill in all the fields ';
header('location: sign_in.php?msg=' . $msg);
exit();
}
   
if(!filter_var($_POST['mail'], FILTER_VALIDATE_EMAIL))
{
	$msg = 'Invalid mail.';
	header('location: sign_in.php?msg=' . $msg);
	exit();
}else{
    $_SESSION ['mail'] = $_POST['mail'];
    $_SESSION ['pseudo'] = $_POST ['pseudo'];
    $_SESSION ['firstName'] = $_POST['firstName'];
    $_SESSION['lastName'] =  $_POST['lastName'];
    header('location: address.php');
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
header('location: Address.php?msg=' . $msg);
exit();
} 
 if($_POST['postalCode']>5)
 {
    $msg = 'you must fill in all the fields ';
    header('location: address.php?msg=' . $msg);
    exit();
    }


else{
    $_SESSION['postalCode'] = $_POST['postalCode'];
    $_SESSION ['city'] = $_POST ['city'];
    $_SESSION ['address'] = $_POST['address'];
    header('location: password.php');
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
        header('location: password.php?msg=' . $msg);
        exit();
        } if (isset($_POST['password']) != isset($_POST['confirmPassword'])) {
            $msg = 'the password must be the same.';
            header ('location: password.php?msg='.$msg);
            exit();
        }
        else{
            $_SESSION ['password'] = $_POST['password'];
            header('location: ../captchaPuzzle/index.php');
        exit;
    }
}

/******************************************************************************* */

     ?>