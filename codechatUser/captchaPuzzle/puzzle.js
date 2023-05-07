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
    document.getElementById('captcha-result').innerHTML = 'Captcha correct !';
  } else {
    document.getElementById('captcha-result').innerHTML = 'Captcha incorrect.';
  }
}

document.getElementById('check-captcha-button').addEventListener('click', checkOrder);
