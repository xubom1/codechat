<?php
include('../pages/utils.php');
checkSessionAdminElseLogin();

include('../../database.php');
$db = getDatabase();

//include log function
include('../../Logs/LogFunction.php');

$user = htmlspecialchars($_GET['user']);


// Change username

if (isset($_POST['pseudo']) && !empty($_POST['pseudo']) && $_GET['type'] == 'pseudo'){
    $pseudo = htmlspecialchars($_POST['pseudo']);
    $check = $db->prepare('SELECT EXISTS(SELECT * FROM user WHERE pseudo=?)');
    $check->execute([$pseudo]);
    $checkExist = $check->fetchAll()[0][0];
    if (!$checkExist){
        $cmd = $db->prepare('UPDATE user SET pseudo=? WHERE pseudo=?');
        $cmd->execute([$pseudo, $user]);
        logAdmin('../../Logs/LogAdminChangeUser.txt', $_SESSION['admin'], $user, $_GET['type'], 'SUCC', $_POST['pseudo']);
        header('location: manageUser.php?user=' . $pseudo . '&msg=username changed successfuly&err=false');
        exit();
    } else {
        logAdmin('../../Logs/LogAdminChangeUser.txt', $_SESSION['admin'], $user, $_GET['type'], 'FAIL', 'already used');
        header('location: manageUser.php?user='. $user . '&msg=This username is already used !&err=true');
        exit();
    }
} else if (empty($_POST['pseudo']) && $_GET['type'] == 'pseudo'){
    logAdmin('../../Logs/LogAdminChangeUser.txt', $_SESSION['admin'], $user, $_GET['type'], 'FAIL', ' ');
    header('location: manageUser.php?user='. $user . '&msg=failed to change username !&err=true');
}

// Change email

if (isset($_POST['mail']) && !empty($_POST['mail'])){
    $mail = htmlspecialchars($_POST['mail']);
    if(!filter_var($mail, FILTER_VALIDATE_EMAIL)){
        header('location: manageUser.php?user='. $user . '&msg=wrong mail syntaxe !&err=true');
        exit();
    }
    $cmd = $db->prepare('UPDATE user SET mail=? WHERE pseudo=?');
    $cmd->execute([$mail, $user]);
    logAdmin('../../Logs/LogAdminChangeUser.txt', $_SESSION['admin'], $user, $_GET['type'], 'SUCC', $_POST['mail']);
    header('location: manageUser.php?user='. $user . '&msg=Mail changed successfuly&err=false');
    exit();
} else if (empty($_POST['mail']) && $_GET['type'] == 'mail'){
    logAdmin('../../Logs/LogAdminChangeUser.txt', $_SESSION['admin'], $user, $_GET['type'], 'FAIL', $_POST['mail']);
    header('location: manageUser.php?user='. $user . '&msg=failed to change mail !&err=true');
}

// Change firstName

if (isset($_POST['firstName']) && !empty($_POST['firstName'])){
    $firstName = htmlspecialchars($_POST['firstName']);
    $cmd = $db->prepare('UPDATE user SET firstName=? WHERE pseudo=?');
    $cmd->execute([$firstName, $user]);
    logAdmin('../../Logs/LogAdminChangeUser.txt', $_SESSION['admin'], $user, $_GET['type'], 'SUCC', $_POST['firstName']);
    header('location: manageUser.php?user='. $user . '&msg=First name changed successfuly&err=false');
    exit();
} else if (empty($_POST['firstName']) && $_GET['type'] == 'firstName'){
    logAdmin('../../Logs/LogAdminChangeUser.txt', $_SESSION['admin'], $user, $_GET['type'], 'FAIL', $_POST['firstName']);
    header('location: manageUser.php?user='. $user . '&msg=failed to change first name !&err=true');
}

// Change Last Name

if (isset($_POST['lastName']) && !empty($_POST['lastName'])){
    $lastName = htmlspecialchars($_POST['lastName']);
    $cmd = $db->prepare('UPDATE user SET lastName=? WHERE pseudo=?');
    $cmd->execute([$lastName, $user]);
    logAdmin('../../Logs/LogAdminChangeUser.txt', $_SESSION['admin'], $user, $_GET['type'], 'SUCC', $_POST['lastName']);
    header('location: manageUser.php?user='. $user . '&msg=Last name changed successfuly&err=false');
    exit();
} else if (empty($_POST['lastName']) && $_GET['type'] == 'lastName'){
    logAdmin('../../Logs/LogAdminChangeUser.txt', $_SESSION['admin'], $user, $_GET['type'], 'FAIL', $_POST['lastName']);
    header('location: manageUser.php?user='. $user . '&msg=failed to change last name !&err=true');
}

if (isset($_POST['postalCode']) && !empty($_POST['postalCode'])){
    $postalCode = htmlspecialchars($_POST['postalCode']);
    if (is_numeric($postalCode) == 1){
        $cmd = $db->prepare('UPDATE user SET postalCode=? WHERE pseudo=?');
        $cmd->execute([$postalCode, $user]);
        logAdmin('../../Logs/LogAdminChangeUser.txt', $_SESSION['admin'], $user, $_GET['type'], 'SUCC', $postalCode);
        header('location: manageUser.php?user='. $user . '&msg=postalcode changed successfuly&err=false');
    } else {
        logAdmin('../../Logs/LogAdminChangeUser.txt', $_SESSION['admin'], $user, $_GET['type'], 'FAIL', 'not numeric');
        header('location: manageUser.php?user='. $user . '&msg=failed to change postalcode bc is not numeric !&err=true');
    }
} else if (empty($_POST['postalCode']) && $_GET['type'] == 'postalCode'){
    logAdmin('../../Logs/LogAdminChangeUser.txt', $_SESSION['admin'], $user, $_GET['type'], 'FAIL', '');
    header('location: manageUser.php?user='. $user . '&msg=failed to change postal code !&err=true');
}

if (isset($_POST['city']) && !empty($_POST['city'])){
    $city = htmlspecialchars($_POST['city']);
    $cmd = $db->prepare('UPDATE user SET postalCode=? WHERE pseudo=?');
    $cmd->execute([$city, $user]);
    logAdmin('../../Logs/LogAdminChangeUser.txt', $_SESSION['admin'], $user, $_GET['type'], 'SUCC', $city);
    header('location: manageUser.php?user='. $user . '&msg= city changed successfuly&err=false');
} else if (empty($_POST['city']) && $_GET['type'] == 'city'){
    logAdmin('../../Logs/LogAdminChangeUser.txt', $_SESSION['admin'], $user, $_GET['type'], 'FAIL', '');
    header('location: manageUser.php?user='. $user . '&msg=failed to change city !&err=true');
}

if (isset($_POST['address']) && !empty($_POST['address'])){
    $address = htmlspecialchars($_POST['address']);
    $cmd = $db->prepare('UPDATE user SET addresse=? WHERE pseudo=?');
    $cmd->execute([$address, $user]);
    logAdmin('../../Logs/LogAdminChangeUser.txt', $_SESSION['admin'], $user, $_GET['type'], 'SUCC', $address);
    header('location: manageUser.php?user='. $user . '&msg= address changed successfuly&err=false');
} else if (empty($_POST['address']) && $_GET['type'] == 'address'){
    logAdmin('../../Logs/LogAdminChangeUser.txt', $_SESSION['admin'], $user, $_GET['type'], 'FAIL', '');
    header('location: manageUser.php?user='. $user . '&msg=failed to change address !&err=true');
}

if (isset($_POST['password']) && !empty($_POST['password'])){
    $password = htmlspecialchars($_POST['password']);
}