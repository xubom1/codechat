<?php
include('../pages/utils.php');
include('../pages/template.php');
checkSessionAdminElseLogin('../');

include("../../database.php");
$db = getDatabase();

if (!isset($_GET['id']) || empty($_GET['id'])){
    header('location: index.php?msg=Error can\'t deleted&err=true');
}

$id = htmlspecialchars($_GET['id']);

$cmd = $db->prepare('SELECT * FROM newsletter WHERE id = ?');
$cmd->execute([$_GET['id']]);
$getNews = $cmd->fetchAll(PDO::FETCH_ASSOC)[0];

$content = '<h3 class="text-center">Modify newsletter id '. $id .'</h3>
<form class="justify-content-center mt-3" action="applyChange.php" method="post">
    <input class="form-control" name="id" value="'. $id .'" disabled>
    <label class="mt-2">Title</label>
    <input class="form-control mt-1" name="title" value="'. $getNews['title'] .'">
    <label class="mt-2">Content</label>
    <textarea class="form-control mt-1" name="content" style="min-height: 300px; max-height: 300px;">'. $getNews['content'] .'</textarea>
    <label class="mt-2">Date</label>
    <input class="form-control mt-1" name="date" type="date" id="inputDate">
    <label class="mt-2">Time</label>
    <input class="form-control mt-1" name="time" type="time" value="'. $getNews['title'] .'">
    <button type="submit" class="btn btn-primary mt-3">Apply Change</button>
    <a href="index.php"><button type="button" class="btn btn-danger mt-3">Cancel</button><a>
</form>
<script src="default.js"></script>
';

echo makePage('Newsletter', $content, '../');