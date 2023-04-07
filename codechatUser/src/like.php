<?php
include("utils.php");
include("../../database.php");

checkSessionElseLogin();
$db = getDatabase();

//check that the user and the publication and the like button state is given
if (empty($_POST['user']) || empty($_POST['publication']) || !isset($_POST['like'])) exit();

$like = $db->prepare('INSERT INTO liked(user, publication) VALUES(:user, :publication)');
$unlike = $db->prepare('DELETE FROM liked where user = :user AND publication = :publication');

if ($_POST['like'] != 0) $commandToExecute = 'like';
else $commandToExecute = 'unlike';

$$commandToExecute->execute([
    'user' => $_POST['user'],
    'publication' => $_POST['publication']
]);

