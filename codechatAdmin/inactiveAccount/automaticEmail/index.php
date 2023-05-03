<?php
include('../../pages/utils.php');
checkSessionAdminElseLogin('.');

include('../../../database.php');
$db = getDatabase();

$cmd = $db->prepare('SELECT month, day, hour, minute, date FROM send WHERE id = ?');
$cmd->execute([1]);
$get = $cmd->fetchAll(PDO::FETCH_ASSOC);

function error()
{
    if (isset($_GET['msg']) && !empty($_GET['msg'])) {
        return htmlspecialchars($_GET['msg']);
    }
}

$content = "

    <h3 class='text-center'>Send frequency</h3>";

if (isset($_GET['msg']) && !empty($_GET['msg'])) {
    $content .= "<p class='text-center mt-4" . ((isset($_GET['err']) && $_GET['err'] == 'true') ? " alert alert-danger" : " alert alert-success") . "'> 
    " . error() . "
    </p>";
}

$content .= "<table class='table my-5'>
        <tr>
            <th>Frequency (month)</th>
            <th>Frequency (day)</th>
            <th>Frequency (hour)</th>
            <th>Frequency (minute)</th>
            <th>Last login less</th>
        </tr>
        <tr>";

foreach ($get as $time){
    $content .= "<td>". $time['month'] ."</td>
            <td>". $time['day'] ."</td>
            <td>". $time['hour'] ."</td>
            <td>". $time['minute'] ."</td>
            <td>". $time['date'] ."</td>";

}

$content .= "</tr>
    </table>
    
    <button class='btn btn-primary col-12' data-bs-toggle='modal' data-bs-target='#changeFrequency'>Change</button>


    <!-- Change Frequency -->
    <div class='modal fade' id='changeFrequency'>
        <div class='modal-dialog'>
            <div class='modal-content'>
                <div class='modal-header'>
                        <h1 class='modal-title fs-5'>Change settings</h1>
                    <button type='button' class='btn-close' data-bs-dismiss='modal' aria-label='Close'></button>
                </div>
                <div class='modal-body'>
                    <p>Minimum 1 minute between each email</p>
                    <form action='changeParameter.php' method='post'>
                        <label class='mt-2'>Frequency</label>
                        <input class='mt-1 form-control' type='number' min='00' max='12' placeholder='month' name='month'>
                        <input class='mt-1 form-control' type='number' min='00' max='31' placeholder='day' name='day'>
                        <input class='mt-1 form-control' type='number' min='00' max='23' placeholder='hour' name='hour'>
                        <input class='mt-1 form-control' type='number' min='00' max='59' placeholder='minute' name='minute'>
                        <label class='mt-2'>Last login</label>
                        <input class='mt-1 form-control col-12' type='date' name='date'>
                </div>
                <div class='modal-footer'>
                    <button type='submit' class='btn btn-primary'>Change</button>
                </div>
                    </form>
            </div>
        </div>
    </div>
";

include("../../pages/template.php");
echo makePage('Inactive account', $content, '../..');