<?php

include('../pages/utils.php');
checkSessionAdminElseLogin('../');

include('../../database.php');

if(isset($_GET['name'])){
    $name = $_GET['name'];
    $db = getDatabase();
    $sql = 'SELECT * FROM publication WHERE content LIKE ? OR creator LIKE ?';

    $stmt = $db->prepare($sql);
    $success = $stmt->execute(['%'.$name.'%', '%'.$name.'%']);

    if($success){
        $publication = $stmt->fetchAll(PDO::FETCH_ASSOC);



        foreach ($publication as $i =>$public) {
            echo sprintf("
            <tr>
                <td>%s</td>
                <td>%s</td>
                <td class='d-flex justify-content-end'>
                    <button class='btn btn-secondary btn-sm' onclick='location.href=\"managePublication.php?publication=". $public['id'] ."\"'>manage</button>
                </td>
            </tr>
        ", $public['creator'], $public['content']);
        }
    }

}