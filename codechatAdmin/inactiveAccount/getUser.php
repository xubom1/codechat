<?php

include('../../database.php');
$db = getDatabase();

$date = htmlspecialchars($_GET['date']);

if (isset($_GET['date']) AND isset($_GET['number']) AND !empty($_GET['date']) AND !empty($_GET['number'])){
    $number = intval(htmlspecialchars($_GET['number']));

    $cmd = $db->prepare('SELECT id, pseudo, mail, lastLogin FROM user WHERE lastLogin < ? LIMIT '.$number);
    $cmd->execute([$date]);
    $users = $cmd->fetchAll(PDO::FETCH_ASSOC);

    if ($users) {
        foreach ($users as $user) {
            echo sprintf("
            <tr>
                <td>" . $user['id'] . "</td>
                <td>" . $user['pseudo'] . "</td>
                <td>" . $user['mail'] . "</td>
                <td>" . $user['lastLogin'] . "</td>
                <td>
                    <a href='sendMail/index.php?id=" . $user['id'] ."'><button class='btn btn-primary btn-sm'>Send Mail</button></a>
                </td>
            </tr>
            ");
        }
    }
} else {
    $cmd = $db->prepare('SELECT id, pseudo, mail, lastLogin FROM user WHERE lastLogin < ?');
    $cmd->execute([$date]);
    $users = $cmd->fetchAll(PDO::FETCH_ASSOC);

    if ($users) {
        foreach ($users as $user) {
            echo sprintf("
            <tr>
                <td>" . $user['id'] . "</td>
                <td>" . $user['pseudo'] . "</td>
                <td>" . $user['mail'] . "</td>
                <td>" . $user['lastLogin'] . "</td>
                <td>
                    <a href='sendMail/index.php?id=" . $user['id'] ."'><button class='btn btn-primary btn-sm'>Send Mail</button></a>
                </td>
            </tr>
            ");
        }
    }
}