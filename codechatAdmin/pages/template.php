<?php

function makePage($title, $content, $rootPath = ".."){
    return
        "
<!DOCTYPE html>
<html lang='en' data-bs-theme='dark'>
    <head>
        <title>$title</title>
        <meta charset='utf-8'>
        <meta name='viewport' content='width=device-width, initial-scale=1'>
        <link rel='shortcut icon' href='$rootPath/assets/logo.svg'>
        <link rel='stylesheet' href='$rootPath/style/admin.css'>
        
        
        <link href='https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css' rel='stylesheet' integrity='sha384-GLhlTQ8iRABdZLl6O3oVMWSktQOp6b7In1Zl3/Jr59b6EGGoI1aFkw7cmDA6j6gD' crossorigin='anonymous'>
        <script src='https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js' integrity='sha384-w76AqPfDkMBDXo30jS1Sgez6pr3x5MlQ1ZAGC+nuZB+EYdgRZgiwxhTBTkF7CXvN' crossorigin='anonymous'></script>
                
    </head>
    <body>
        <header class='container-fluid bg-primary'>
            <nav class='navbar'>
                <div class='p-1 nav-item d-flex align-items-center'>
                    <a class='navbar-brand' href='$rootPath'>
                        <img src='$rootPath/assets/logo.svg' alt='logo' width='30'>
                        codechat
                    </a>
                </div>
                <div class='nav-item'>
                    <button onclick='location.href=\"$rootPath/logout.php\"' class='btn btn-danger mx-1'>logout</button>
                </div>
            </nav>
        </header>

        <main class='container my-4'>
            $content
        </main>

        <footer class='container-fluid bg-primary-subtle text-center p-2'>
            &copy; 2023 copyright : codechat
        </footer>
 
    </body>
</html>
    ";
}
