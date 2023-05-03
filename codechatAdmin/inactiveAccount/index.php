<?php
include('../pages/utils.php');
checkSessionAdminElseLogin('.');

function error()
{
    if (isset($_GET['msg']) && !empty($_GET['msg'])) {
        return htmlspecialchars($_GET['msg']);
    }
}

$content = '
        <h1 class="text-center">Inactive Account</h1>';

if (isset($_GET['msg']) && !empty($_GET['msg'])) {
    $content .= "<p class='text-center mt-4" . ((isset($_GET['err']) && $_GET['err'] == 'true') ? " alert alert-danger" : " alert alert-success") . "'> 
    " . error() . "
    </p>";
}

$content .= '
        <a href="automaticEmail/"><button class="btn btn-primary">Setting</button></a>
        <div class="my-5">
            <label>Since :</label>
            <input class="form-control my-1" type="date" id="dateSince">
            <label class="mt-4">Show member :</label>
            <input class="form-control my-1" type="number" placeholder="Default All" id="showNumber">
            <button class="btn btn-primary mt-4 col-12" onclick="getInactiveUser()">Search</button>
        </div>
        
        <p class="describe" id="description"></p>
        
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>id</th>
                    <th>pseudo</th>
                    <th>mail</th>
                    <th>Last Connexion</th>
                    <th class="col-2"></th>
                </tr>
            </thead>
            <tbody id="userRow">
                
            </tbody>
        </table>
        <script src="getUser.js"></script>
';

include("../pages/template.php");
echo makePage('Inactive account', $content);