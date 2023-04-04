<!DOCTYPE html>
<html>
    <head>
        <title>Loading...</title>
        <link rel='icon' href='../assets/logo.svg'>
        <link rel='stylesheet' href='../bootstrap/bootstrap.css'>
        <script src='../bootstrap/node_modules/bootstrap/dist/js/bootstrap.bundle.min.js'></script>

        <style>
            html, body{
                margin: 0;
                background-color: black;
            }
            canvas{
                width: 100%;
                height: 99vh;
            }
        </style>

    </head>
    <body>
        <canvas></canvas>
        <?php include('../js/src/renderer3d/shaders.php') ?>
        <script src="../js/build/loadingPage.bundle.js"></script>
    </body>
</html>