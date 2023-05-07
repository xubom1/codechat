<?php
include('../src/utils.php');
include('../src/template.php');

error_reporting(E_ERROR | E_PARSE);

if (empty($_GET['token'])) header('location: /login.php?msg=error in the captcha !');

?>
<!DOCTYPE html>
<html lang="en" data-bs-theme='<?=getColorTheme()?>'>
<head>
<?= make_head('..')?>
    
    <style>
        .my-container {
            text-align: center;
        }
        .my-board-container {
            width: 340px;
            height: 340px;
            background-color: rgb(59, 94, 103);
            border: 10px solid #fefefe;
            margin:  auto;
        }
        .my-board {
            display: flex;
            flex-wrap: wrap;
           
            align-items: center;
            height: 100%;
        }
        .my-board-item {
            width: 112px;
            height: 112px;
            border: 2px solid  #fefefe;
            margin: 1px;
            padding: 0;
        }
        .my-board-item img {
            width: 100px;
            height: 100%;
            
        }
    </style>
</head>
<body>
<?= make_header('', false)?>
<main class="container">
  <?php
$dir = "uploads/";
$files = array_diff(scandir($dir), array('.', '..'));
$randomFile = $dir . $files[array_rand($files)];

// Charger l'image
$originalImage = imagecreatefromjpeg($randomFile);
$originalWidth = imagesx($originalImage);
$originalHeight = imagesy($originalImage);

$partWidth = $originalWidth / 3;
$partHeight = $originalHeight / 3;

$parts = array();
for ($i = 0; $i < 3; $i++) {
    for ($j = 0; $j < 3; $j++) {
        $part = imagecreatetruecolor($partWidth, $partHeight);
        imagecopy($part, $originalImage, 0, 0, $i * $partWidth, $j * $partHeight, $partWidth, $partHeight);
        $parts[] = $part;
    }
}

foreach ($parts as $index => $part) {
  imagejpeg($part, "puzzle_piece/image_test".($index+1).".jpg", 100);
}
?>

  <div class="container my-container">
    <h1 class="my-5">CAPTCHA</h1>
    <div id="board" class="my-board-container">
      <div class="my-board row">
        <?php
        $imageSources = [
          'puzzle_piece/image_test1.jpg', 
          'puzzle_piece/image_test2.jpg', 
          'puzzle_piece/image_test3.jpg', 
          'puzzle_piece/image_test4.jpg', 
          'puzzle_piece/image_test5.jpg', 
          'puzzle_piece/image_test6.jpg', 
          'puzzle_piece/image_test7.jpg', 
          'puzzle_piece/image_test8.jpg', 
          'puzzle_piece/image_test9.jpg'
        ];
        shuffle($imageSources);
        foreach ($imageSources as $index => $src) {
          echo "<div class='my-board-item'><img id='part".($index+1)."' src='".$src."' class='w-100'></div>";
        }
        ?>
      </div>
    </div>
   
  </div>

<script>
  var lastClickedImage = null;

  function swapImages(img) {
    if (lastClickedImage) {
      var tempSrc = lastClickedImage.src;
      lastClickedImage.src = img.src;
      img.src = tempSrc;
      lastClickedImage = null;
      checkOrder();
    } else {
      lastClickedImage = img;
    }
  }

  

  var images = document.querySelectorAll('#board img');
  for (var i = 0; i < images.length; i++) {
    images[i].onclick = function() {
      swapImages(this);
    };
  }
  function checkOrder() {
    var imageIds = ['part1', 'part4', 'part7', 'part2', 'part5', 'part8', 'part3', 'part6', 'part9'];
    var inOrder = true;
    for (var i = 0; i < imageIds.length; i++) {
      if (document.getElementById(imageIds[i]).src.endsWith('image_test'+(i+1)+'.jpg') === false) {
        inOrder = false;
        break;
      }
    }
    if (inOrder) {
      alert('Captcha parfait !');
      document.location.href="/signin/tokenVerification.php?token=" . <?=$_GET['token']?>;
    }
  }
</script>
</main>

<?= make_footer('..')?>
</body>


</html>
