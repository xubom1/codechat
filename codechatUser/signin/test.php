<?php
include('../../codechatAdmin/mailFunction.php');
sendMail('support@codechat.fr', 'codechat', 'nicolasguillot92@gmail.com', 'nicolas', NULL, NULL, 'codechat account verification', 'coucou', 'error', '/login.php');
echo 'ok';