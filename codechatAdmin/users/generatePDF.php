<?php

if (!isset($_GET['user']) || empty($_GET['user'])){
    header('location: searchUsers/index.php?msg=Error&err=true');
}

function YesOrNot($var) {
    if ($var){
        return 'Yes';
    } else {
        return 'No';
    }
}


function getPDF($pathlogo = 'logo.php'){
    $user = htmlspecialchars($_GET['user']);

    include('../../database.php');
    $db = getDatabase();

    // user
    $cmd = $db->prepare('SELECT * FROM user WHERE pseudo = ?');
    $cmd->execute([$_GET['user']]);
    $getInfo = $cmd->fetchAll(PDO::FETCH_ASSOC)[0];

    // publication
    $cmd = $db->prepare('SELECT * FROM publication WHERE creator = ?');
    $cmd->execute([$_GET['user']]);
    $getPubli = $cmd->fetchAll(PDO::FETCH_ASSOC);

    $content = '<!doctype html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <title>Invoice</title>

        <style type="text/css">
            * {
                font-family: Verdana, Arial, sans-serif;
            }
            table{
                font-size: x-small;
            }
            tfoot tr td{
                font-weight: bold;
                font-size: x-small;
            }

            .gray {
                background-color: lightgray
            }
            
            .page_break { page-break-before: always; }
        </style>
    </head>
    <body>
    <h1 align="center">CODECHAT</h1>
    <table>
        <tr>
            <td align="center">GDPR law</td>
        </tr>
        <tr>
            <td>The General Data Protection Regulation (GDPR) is the toughest privacy and security law in the world. Though it was drafted and passed by the European Union (EU), it imposes obligations onto organizations anywhere, so long as they target or collect data related to people in the EU. The regulation was put into effect on May 25, 2018. The GDPR will levy harsh fines against those who violate its privacy and security standards, with penalties reaching into the tens of millions of euros.

With the GDPR, Europe is signaling its firm stance on data privacy and security at a time when more people are entrusting their personal data with cloud services and breaches are a daily occurrence. The regulation itself is large, far-reaching, and fairly light on specifics, making GDPR compliance a daunting prospect, particularly for small and medium-sized enterprises (SMEs).

We created this website to serve as a resource for SME owners and managers to address specific challenges they may face. While it is not a substitute for legal advice, it may help you to understand where to focus your GDPR compliance efforts. We also offer tips on privacy tools and how to mitigate risks. As the GDPR continues to be interpreted, we’ll keep you up to date on evolving best practices.

If you’ve found this page — “what is the GDPR?” — chances are you’re looking for a crash course. Maybe you haven’t even found the document itself yet (tip: here’s the full regulation https://gdpr.eu/tag/gdpr/). Maybe you don’t have time to read the whole thing. This page is for you. In this article, we try to demystify the GDPR and, we hope, make it less overwhelming for SMEs concerned about GDPR compliance.</td>
        </tr>
    </table>
    
    <div class="page_break"></div>

    <table width="100%">
        <tr>
            <td valign="top"><img style="height: 150px; width: 150px;" src="'. $pathlogo .'"/></td>
            <td align="right">
                <h3>Codechat</h3>
                <pre>
                Codechat since 2023
                support@codechat.com
                Paris
            </pre>
            </td>
        </tr>

    </table>

    <table width="100%">
        <tr>
            <td><strong>Download by: </strong>'. $_SESSION['admin'] .'</td>
            <td><strong>History of: </strong>'. $user .'</td>
            <td><strong>Date: </strong>'. date('d-m-Y') .'</td>
            <td><strong>Time: </strong>'. date('H:i:s') .'</td>
        </tr>

    </table>

    <br/>
    
    <h3 align="center">Profil</h3>
    <table width="100%">
        <thead style="background-color: lightgray;">
        <tr>
            <th>Type</th>
            <th>Information</th>
        </tr>
        </thead>
        <tbody>
            <tr>
                <td align="center">Pseudo</td>
                <td align="center">'. $getInfo['pseudo'] .'</td>
            </tr>
            <tr>
                <td align="center">Nom</td>
                <td align="center">'. $getInfo['lastName'] .'</td>
            </tr>
            <tr>
                <td align="center">Prenom</td>
                <td align="center">'. $getInfo['firstName'] .'</td>
            </tr>
            <tr>
                <td align="center">Mail</td>
                <td align="center">'. $getInfo['mail'] .'</td>
            </tr>
            <tr>
                <td align="center">Last Login</td>
                <td align="center">'. $getInfo['lastLogin'] .'</td>
            </tr>
            <tr>
                <td align="center">Incription Date</td>
                <td align="center">'. $getInfo['creation'] .'</td>
            </tr>
            <tr>
                <td align="center">Banned</td>
                <td align="center">'. YesOrNot($getInfo['banned']) .'</td>
            </tr>
            <tr>
                <td align="center">Admin</td>
                <td align="center">'. YesOrNot($getInfo['admin']) .'</td>
            </tr>
            <tr>
                <td align="center">Want Newsletter</td>
                <td align="center">'. YesOrNot($getInfo['wantNews']) .'</td>
            </tr>
            <tr>
                <td align="center">ID</td>
                <td align="center">'. $getInfo['id'] .'</td>
            </tr>
        </tbody>
    </table>
    
    <h3 align="center">Publication</h3>';

    foreach ($getPubli as $publication){
        $content .= '<table width="100%">
        <tbody>
        <tr>
            <td style="background-color: lightgray;">Id</td>
            <td>'. $publication['id'] .'</td>
        </tr>
        <tr>
            <td style="background-color: lightgray;">Création</td>
            <td>'. $publication['lastEdition'] .'</td>
        </tr>
        <tr>
            <td style="background-color: lightgray;">Content</td>
            <td>'. $publication['content'] .'</td>
        </tr>
        </tbody>
    </table>';
    }


    $content .= '
    </body>
    </html>';

    return $content;
}