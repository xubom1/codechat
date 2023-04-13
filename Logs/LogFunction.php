<?php


function logAdmin ($path, $admin, $userPseudo, $type, $SorN, $description){
    $logFunction = fopen($path, "a+");
    $txt = date('y/m/d - h:m:s') . '-' . $admin . '-' . $userPseudo . '-' . $type . '-' . $SorN . '-' . $description . "\n";
    fwrite($logFunction, $txt);
    fclose($logFunction);
}

function logAdminPublication (){

}