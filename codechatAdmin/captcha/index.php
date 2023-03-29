<?php
include('../pages/utils.php');
checkSessionAdminElseLogin('.');

include('../../database.php');
$db = getDatabase();

//get some users in the database
$cmd = $db->prepare('SELECT * FROM user WHERE admin=0 AND banned=0 ORDER BY creation ASC LIMIT 10');
$cmd->execute();
$users = $cmd->fetchAll();

var_dump($users);

function error()
{
    if (isset($_GET['msg']) && !empty($_GET['msg'])) {
        return htmlspecialchars($_GET['msg']);
    }
}

$content = '
    <br>
    <div class="input-group m-auto" style="width:500px; ">
      <input type="search" id="search" class="form-control rounded" placeholder="Search" aria-label="Search" aria-describedby="search-addon"/>
      <h3 id="error" class="text-center mt-3"></h3>
    </div>
';

$content .= "
    <div class='container mt-5 '>
        <p class='text-center " . ((isset($_GET['err']) && $_GET['err'] == 'true') ? "text-danger" : " ") . "'> 
        " . error() . "
        </p>
    </div>
";

$content .= "
    
    <div class='modal fade' id='newAdminModal' aria-labelledby='exampleModalLabel' aria-hidden='true'>
        <form action='createAdmin.php' method='get' class='modal-dialog'>
            <div class='modal-content'>
                <div class='modal-header'>
                    <h1 class='modal-title fs-5' id='exampleModalLabel'>new account</h1>
                    <button type='button' class='btn-close' data-bs-dismiss='modal' aria-label='Close'></button>
                </div>
                <div class='modal-body'>
                    <label for='name' class='form-label'>username</label>
                    <input name='name' type='text' class='form-control'>
                    <label for='mail' class='form-label'>e-mail</label>
                    <input name='mail' type='mail' class='form-control'>
                    <label for='password' class='form-label'>password</label>
                    <input type='password' name='password' class='form-control'>
                </div>
                <div class='modal-footer'>
                    <button type='button' class='btn btn-secondary' data-bs-dismiss='modal'>Cancel</button>
                    <input class='btn btn-success' type='submit' value='create'>
                </div>
            </div>
        </form>
    </div>
    
    <table class='table table-striped table-hover'>
        <thead>
            <tr>
                <th scope='col'>#</th>
                <th scope='col'>pseudo</th>
                <th scope='col'>mail</th>
                <th scope='col'>first name</th>
                <th scope='col'>last name</th>
                <th scope='col'></th>
            </tr>
        </thead>
        <tbody class='table-group-divider'>
";

foreach ($users as $i => $user){
    $content .= sprintf("
    <tr>
        <th scope='row'>%d</th>
        <td>%s</td>
        <td>%s</td>
        <td>%s</td>
        <td>%s</td>
        <td class='d-flex justify-content-end'>
            <button class='btn btn-secondary btn-sm' onclick='location.href=\"manageUser.php?user=%s\"'>manage profile</button>
        </td>
    </tr>
    ", $i + 1, $user['pseudo'], $user['mail'], $user['firstName'], $user['lastName'], $user['pseudo']);
}

$content .= "
        </head>
    </table>
";

$content .= '
        
            <script>
                var array = ' .$users. '
                console.log(array)
        
        function showtable(curarray) {
            document.getElementById("mytable").innerHTML = `
            <tr class="bg-primary text-white fw-bold">
                        <td>#</td>
                        <td>pseudo</td>
                        <td>mail</td>
                        <td>first name</td>
                        <td>last name</td>
                    </tr> ` ;
        
            if (curarray == "") {
                document.getElementById("error").innerHTML = `<span class="text-danger ">Not Found!</span>`;
            }
            else {
        
                document.getElementById("error").innerHTML = "";
        
                for (var i = 0; i < curarray.length; i++) {
                    document.getElementById("mytable").innerHTML += ` 
                      <tr > <td>${curarray[i].id}</td> <td>${curarray[i].name}</td> 
                        <td>${curarray[i].country}</td> <td>${curarray[i].city}</td> </tr>`;
                }
            }
        }
        
        
        showtable(array);
        
        var newarray = [];
        
        document.getElementById("search").addEventListener("keyup", function () {
            var search = this.value.toLowerCase();
        
            newarray = array.filter(function (val) {
        
                    if (val.id.includes(search) || val.name.includes(search) || val.country.includes(search)
                        || val.city.includes(search)) {
                        var newobj = { id: val.id, name: val.name, country: val.country, city: val.city }
                    return newobj;
                }
                });
        
            showtable(newarray);

});
  
    </script>

</body>
';

include("../pages/template.php");
echo makePage($content);