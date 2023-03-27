<?php
include('../../database.php');
include('utils.php');

checkSessionElseLogin();

$db = getDatabase();

$publicationOffset = 0;
if (isset($_POST['publicationsCount'])){
    $publicationOffset = $_POST['publicationsCount'];
}
$publicationsCountWanted = 1;
if (isset($_POST['countWanted'])){
    $publicationsCountWanted = $_POST['countWanted'];
}

$cmd = $db->prepare('(SELECT publication.id FROM publication, follow WHERE publication.creator = follow.followed AND follow.follower = :user ORDER BY publication.lastEdition DESC) LIMIT :offset, :count');

$cmd->bindValue(":user", $_SESSION['user']);
$cmd->bindValue(":offset", $publicationOffset, PDO::PARAM_INT);
$cmd->bindValue(":count", $publicationsCountWanted, PDO::PARAM_INT);
$cmd->execute();

$publications = $cmd->fetchAll(PDO::FETCH_ASSOC);

if (empty($publications)){
    echo "";
    exit();
}

foreach ($publications as $publication){
    echo makePublication($publication['id'], $db, '..');
}





