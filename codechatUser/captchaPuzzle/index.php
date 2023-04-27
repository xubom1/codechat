<?php
include('../src/utils.php');
include('../src/template.php');

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
  


  <div class="container my-container">
    <h1 class="my-5">CAPTCHA</h1>
    <div id="board" class="my-board-container">
      <div class="my-board row">
        <?php
        $imageSources = [
          'image_test1.jpg', 
          'image_test2.jpg', 
          'image_test3.jpg', 
          'image_test4.jpg', 
          'image_test5.jpg', 
          'image_test6.jpg', 
          'image_test7.jpg', 
          'image_test8.jpg', 
          'image_test9.jpg'
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
      document.location.href="../signin/verificationfinal.php";
     
     
    }
  }
</script>
</main>

<?= make_footer('..')?>
</body>


</html>
