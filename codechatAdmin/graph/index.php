<?php
include('../pages/utils.php');
checkSessionAdminElseLogin('.');

$content = '
        <div class="container mx-auto">
            <h1>Last Connexion</h1>
        </div>
';

include("../pages/template.php");
echo makePage('stats', $content);