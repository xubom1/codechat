<?php
include('../../codechatAdmin/mailFunction.php');
sendMail('check@codechat.fr', 'codechat', 'nicolasguillot92@gmail.com', 'nicolas', NULL, NULL, 'TEST', '<h1>coucou ca fonctionne</H1>', 'coucou', NULL);
echo 'mail sent ?';