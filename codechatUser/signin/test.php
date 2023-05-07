<?php
include('../../codechatAdmin/mailFunction.php');
sendMail('support@codechat.fr', 'codechat', 'nicolasguillot92@gmail.com', 'nicolas',
    NULL, NULL, 'codechat', 'coucou', 'coucou', '/login.php');
echo 'ok';