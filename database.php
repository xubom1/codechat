<?php

function getDatabase(){
    try{
        $db = new PDO(
            'mysql:host=localhost;dbname=codechat;charset=utf8',
            'root',
            'esgi',
            [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]
        );
    }
    catch (Exception $e){
        die("failed to connect to the database !\n error : " . $e->getMessage());
    }
    return $db;
}