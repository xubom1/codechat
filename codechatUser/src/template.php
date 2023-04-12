<?php

function make_head($rootPath = '.', $add = ""): string
{
    ob_start();
    include ($rootPath . "/js/src/renderer3d/shaders.php");
    $shaders = ob_get_clean();

    return "
        <head>
            <title>Codechat</title>
            <meta charset='utf-8'>
            <meta name='viewport' content='width=device-width, initial-scale=1'>
            
            <!-- bootstrap -->
            <link rel='stylesheet' href='/bootstrap/bootstrap.css'>
            <script src='/bootstrap/node_modules/bootstrap/dist/js/bootstrap.bundle.min.js'></script>

            <!-- includes -->
            <link rel='stylesheet' href='/style/style.css'>
            <link rel='icon' href='/assets/logo.svg'>
            <script src='/js/user/darkMode.js'></script>
            <script src='/js/user/avatars.js'></script>
            $shaders
            <script src='/js/build/logo3D.bundle.js'></script>            
            $add
        </head>
    ";
}

function make_header($rootPath = '.', $searchBar = true): string
{
    $entry = '';
    if (gettype($searchBar) === "string"){
        $entry = $searchBar;
        $displaySearchBar = true;
    }
    else{
        $displaySearchBar = $searchBar;
    }

    return "
        <header class='container-fluid bg-primary p-0'>
            <nav class='navbar d-flex'>
                <div class='p-1 mx-2'>
                    <a class='navbar-brand d-flex' href='/'>
                        <canvas class='logo3D'></canvas>
                        <span class='text-light'>codechat</span>
                    </a>
                </div>
                " .
                ($displaySearchBar ? "<form class='input-group' id='searchBar' action='/search.php' method='get'>
                    <input name='entry' type='text' class='form-control' required value='" . $entry . "'>
                    <input type='submit' class='btn btn-outline-success' value='search'>
                </form>" : "") .
"
                <div class='mx-2 ms-5'>
                    <img src='/assets/burger.svg' alt='burger' class='animHover' width='40px' data-bs-toggle='collapse' data-bs-target='#collapsePanel'>
                </div>
            </nav>
            <div class='collapse bg-secondary' id='collapsePanel'>
                <div class='p-4'>

                    <!--<div class='my-2' onclick='location.href=\"/\"' title='set your account settings'>
                        <img src='/assets/settings.svg' alt='logout' width='25' class='mx-1 animHover'>
                        <label class='text-light'>settings</label>
                    </div>-->
                    
                    <div class='my-2' onclick='location.href=\"/\"'>
                        <img src='/assets/home.svg' alt='profile' width='25' class='mx-1 animHover'>
                        <label class='text-light'>Home</label>
                    </div>
                    
                    <div class='my-2' onclick='location.href=\"/profile.php\"'>
                        <img src='/assets/defaultAccount.svg' alt='profile' width='25' class='mx-1 animHover'>
                        <label class='text-light'>profile</label>
                    </div>

                    <div class='my-2' onclick='location.href=\"/src/logout.php\"'>
                        <img src='/assets/logout.svg' alt='logout' width='25' class='mx-1 animHover'>
                        <label class='text-light'>Log Out</label>
                    </div>
                </div>
            </div>
        </header>
    ";
}

function make_footer($rootPath = '.'): string
{
    return "
        <script></script>
        <footer class='container-fluid bg-secondary text-center  py-3 text-light'>
            <div class='row'>
                <div class='col align-self-end p-3'>
                    <p>&copy; 2023 codechat</p>
                </div>
                <div class='col text-center'>
                    <div>Nicolas GUILLOT</div>
                    <div>Rakulan SIVATHASAN</div>
                    <div>Marouf LAGUIDE</div>
                </div>
            </div>
        </footer>
    ";
}


