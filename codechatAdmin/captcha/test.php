<?php

include('../../database.php');
$db = getDatabase();

//get some users in the database
$cmd = $db->prepare('SELECT * FROM user WHERE admin=0 AND banned=0 ORDER BY creation ASC LIMIT 30');
$cmd->execute();
$users = $cmd->fetchAll();
$result_js = json_encode($users);


$content = '
    <br>
    <div class="input-group m-auto" style="width:500px; ">
      <input type="search" id="search" class="form-control rounded" placeholder="Search" aria-label="Search" aria-describedby="search-addon"/>
      
    </div>
';

$content .= "
    <h3 id='error' class='text-center mt-3'></h3>
    <br>
    <table class='table table-striped table-hover' id='usersTable'>
        <thead>
            <tr>
                <th scope='col'>Id</th>
                <th scope='col'>pseudo</th>
                <th scope='col'>mail</th>
                <th scope='col'>firstname</th>
                <th scope='col'>lastname</th>
                <th scope='col'></th>
            </tr>
        </thead>
        <tbody class='table-group-divider'>
";

$content .= '
    <script>
        let array = '.$result_js.';
        console.log(array);
        function showtable(curarray) {
            if (curarray == "") {
                document.getElementById("error").innerHTML = `<span class="text-danger ">Not Found!</span>`;
            }
            else {
                
                document.getElementById("error").innerHTML = "";
                
                for (let i = 0; i < curarray.length; i++) {
                   document.getElementById("usersTable").innerHTML += ` 
                      <tr > <td>${curarray[i].id}</td> <td>${curarray[i].pseudo}</td> 
                      <td>${curarray[i].mail}</td> <td>${curarray[i].firstName}</td> 
                      <td>${curarray[i].lastName}</td> </tr>`;
                }
            }
        }
            
        showtable(array)
        
        let newarray = [];
        
        document.getElementById("search").addEventListener("keyup", function () {
            let search = this.value.toLowerCase();
            newarray = array.filter(function (val) {
                if (val.id.includes(search) || val.pseudo.includes(search) || val.mail.includes(search) || val.firstName.includes(search) || val.lastName.includes(search)){
                    var newobj = { 0: val.id, 1: val.pseudo, 2: val.mail, 3: val.firstName, 4: val.lastName}
                }
                return newobj
            });
            console.log(newarray)
            showtable(newarray);
        });
    </script>
';

$content .= "
        </head>
    </table>
";


include("../pages/template.php");
echo makePage($content);