<!DOCTYPE html>
<html>
<head>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-KK94CHFLLe+nY2dmCWGMq91rCGa5gtU4mk92HdvYe+M/SXH301p5ILy+dN9+nJOZ" crossorigin="anonymous">
    <title>Change the picture</title>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ENjdO4Dr2bkBIFxQpeoTz1HIcje39Wm4jDKdf19U8gI4ddQ3GYNS7NTKfAdVQSZe" crossorigin="anonymous"></script>
</head>
<body>
    
<main class="justify-content-center row container m-auto">
            <h3 class=" text-center">change the picture</h3>
    
            <form class="col-12 mt-4" method="post" action="add_image.php" enctype="multipart/form-data">
        <label for="nouvelle_image">New picture:</label><br>
        <input type="file" name="image" accept="image/jpeg, image/png"><br><br>
        <input type="submit" value="change the picture "class="btn btn-primary my-2">
    </form>
</main>
</body>
</html>
