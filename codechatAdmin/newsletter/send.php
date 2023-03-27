<?php

$to = "nicolasguillot92@gmail.com";
$subject = "My subject";
$txt = "Hello world!";
$headers = "From: webmaster@example.com" . "\r\n" .
    "CC: somebodyelse@example.com";
var_dump(mail($to,$subject,$txt,$headers));

