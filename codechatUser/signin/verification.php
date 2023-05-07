<?php
include('../../database.php');
include('../../codechatAdmin/mailFunction.php');

$db = getDatabase();

session_start();
if( isset($_POST['inscrip1'])){
    if( empty(trim($_POST['pseudo']))
    || empty(trim($_POST['mail']))
    || empty(trim($_POST['lastName']))
    || empty(trim($_POST['firstName']))
)
{
header('location: sign_in.php?msg=you must fill in all the fields ');
exit();
}
   
if(!filter_var($_POST['mail'], FILTER_VALIDATE_EMAIL))
{
	header('location: sign_in.php?msg=Invalid mail.');
	exit();
}else{
    setcookie('mail', $_POST['mail']);
    setcookie('pseudo', $_POST['pseudo']);
    setcookie('firstName', $_POST['firstName']);
    setcookie('lastName', $_POST['lastName']);
    header('location: address.php');
    exit;
}
}
/*******************VERIFICATION DEUXIÈME PAGE******************************************************************************************************* */  
if( isset($_POST['inscrip2'])){
    if( empty(trim($_POST['postalCode']))
    || empty(trim($_POST['city']))
    || empty(trim($_POST['address']))
    
)
{
header('location: Address.php?msg=you must fill in all the fields ');
exit();
} 

$string = $_POST['postalCode'];

if(strlen($string) != 5)
{$msg = 'you must have only 5 digits ';
    header('location: Address.php?msg=' . $msg);
    exit();}


else{
    setcookie('postalCode', $_POST['postalCode']);
    setcookie('city', $_POST['city']);
    setcookie('address', $_POST['address']);
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
        header('location: password.php?msg=you must fill in all the fields ');
        exit();
    }
    setcookie('password', $_POST['password']);
    setcookie('confirmPassword', $_POST['confirmPassword']);
    if ($_POST['password'] !== $_POST['confirmPassword']) {
        header ('location: password.php?msg=the password must be the same.');
        exit();
    }

/************************************************************************************************************************** */

    $q = 'SELECT pseudo FROM user WHERE pseudo = :pseudo';
    $req = $db-> prepare($q);
    $req->execute([
        'pseudo' =>  $_COOKIE['pseudo']
    ]);

    $response = $req->fetch();
    if($response){
        header ('location: sign_in.php?msg=The nickname is already in use');
        exit();
    }
    $q = 'SELECT mail  FROM user WHERE mail = :mail';
    $req = $db-> prepare($q);
    $req->execute([
        'mail' =>  $_COOKIE ['mail']
    ]);
    $response = $req->fetch();
    if($response){
        header ('location: sign_in.php?msg=The email address is already in use !');
        exit();
    }

    //create user
    $q = 'INSERT INTO user (pseudo, mail, lastName, firstName, postalCode, city, address, password) VALUES(:pseudo, :mail, :lastName, :firstName, :postalCode, :city, :address,  :password)';
    $req = $db-> prepare($q);
    try {
        $reponse = $req ->execute([
            'pseudo'=>  htmlspecialchars($_COOKIE ['pseudo']),
            'mail'=>  htmlspecialchars($_COOKIE ['mail']),
            'lastName'=>  htmlspecialchars($_COOKIE ['lastName']),
            'firstName'=>  htmlspecialchars($_COOKIE ['firstName']),
            'postalCode'=>  htmlspecialchars($_COOKIE ['postalCode']),
            'city'=>  htmlspecialchars($_COOKIE ['city']),
            'address'=>  htmlspecialchars($_COOKIE ['address']),
            'password' => password_hash( $_POST['password'], PASSWORD_DEFAULT)
        ]);
    }
    catch(Exception $e){
        header('location: sign_in.php?msg=oops! An error occurred while creating the user.');
    }

    if(!$reponse) header('location: sign_in.php?msg=oops! An error occurred.');


    //generate a token of 32 characters
    $possibleChars = "123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ$/!:,?";
    $token = '';
    for ($i = 0; $i < 32; $i++) {
        $token .= $possibleChars[rand(0,strlen($possibleChars) - 1)];
    }

    //save the token in the database
     {
        $getUser = $db->prepare('SELECT id FROM user WHERE pseudo = :pseudo');
        $getUser->execute(['pseudo' => $_COOKIE['pseudo']]);
        $userId = $getUser->fetch(PDO::FETCH_ASSOC)['id'];

        $deleteOld = $db->prepare('DELETE FROM token WHERE owner = :user ');
        $deleteOld->execute(['user' => $userId]);

        $insert = $db->prepare('INSERT INTO token(token, owner) VALUES (:token, :user)');
        $insert->execute([
            'token' => $token,
            'user' => $userId
        ]);
    }
//    catch(Exception $e){
//        header('location: sign_in.php?msg=oops! An error occurred while generating the token !');
//    }

    $mail = "
        <h2>Hello " . $_COOKIE ['pseudo'] . " !</h2>
        <p>Your codechat account is almost here ! please click on the link below to finalise it.</p>
        <a href='https://codechat.fr/signin/tokenVerification.php?token=$token'>codechat.fr/signin/tokenVerification.php</a>
    ";

    sendMail('support@codechat.fr', 'codechat', $_COOKIE['mail'], $_COOKIE['pseudo'],
        NULL, NULL, 'codechat account verification', $mail, $mail, '/login.php');

    //delete the cookies
    setcookie('pseudo', '', time());
    setcookie('mail', '', time());
    setcookie('lastName', '', time());
    setcookie('firstName', '', time());
    setcookie('postalCode', '', time());
    setcookie('city', '', time());
    setcookie('address', '', time());
    setcookie('password', '', time());
    setcookie('confirmPassword', '', time());

    header('location: ../login.php?msg=your account was created successfully, check your mail to verify your account !');

}