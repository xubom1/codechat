<?php
    try{
        $db = new PDO(
            'mysql:host=localhost:8889;dbname=codechat',
            'root',
            'root',
            [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION ]);    
    }
    catch (Exception $e){
        die("failed to connect to the database !\n error : " . $e->getMessage());
    }
?>