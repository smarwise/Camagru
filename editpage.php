<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
require_once("config/database.php");
?>
<html>
<head>
	<title>Edit</title>
	<link rel="stylesheet"  href="edit.css">
</head>
<div class="header">
   <h1> CAMAGRU </h1>
</div>
<div class="top" style="position:relative;">
<video id="video" width="640" height="480" muted="muted" autoplay></video>
<img src="" alt="" id="img-overlay" style="position:absolute; left: 0;width: 640;height: 480;">
<select id="stickers">
<option id="overlay" value="stickers/none.png">normal</option>
<option id="overlay" value="stickers/cutecat.png">cutecat</option>
<option id="overlay" value="stickers/bear.png">bear</option>
<option id="overlay" value="stickers/dogears.png">dogears</option>
<option id="overlay" value="stickers/hellokitty.png">hellokitty</option>
<option id="overlay" value="stickers/lovehearts.png">lovehearts</option>
<option id="overlay" value="stickers/sadness.png">sadness</option>
</select>
<button id="snap">Snap Photo</button>
<button id="clear">Clear</button>
<form name="myform" action="editpage.php" method="post" id="myform">
      <input type="submit" name="submit" value="Test!" />
      <input type="hidden" name="hidden1" id="hidden1" />
      <input type="hidden" name="hidden2" id="hidden2" />
   </form>
<canvas id="canvas" width="640" height="480"></canvas>
</div>
<div class="bottom">
    <div id="photos" id="images"></div>
<div>
<script>
var video = document.getElementById('video');
if(navigator.mediaDevices && navigator.mediaDevices.getUserMedia)
{
    var canvas = document.getElementById('canvas');
    var context = canvas.getContext('2d');
    var video = document.getElementById('video');
    var photo = document.getElementById('snap');
    var images = document.getElementById('photos');
    var filter = document.getElementById('filters');
    var clear = document.getElementById('clear');
    var stickers = document.getElementById('stickers');
    var imgoverlay = document.getElementById('img-overlay');
    navigator.mediaDevices.getUserMedia({ video: true }).then(function(stream) 
    {
        video.src = window.URL.createObjectURL(stream);
        video.play();
    }); 
    photo.addEventListener("click", function(e) {
    takePicture();
     e.preventDefault();
    });
    var sticker = "none";
    clear.addEventListener('click', function(e)
    {
        images.innerHTML = '';
        e.preventDefault();
    });
    stickers.addEventListener('change', function(e)
    {
        var sticker = e.target.value;
        imgoverlay.src = sticker;
         e.preventDefault();
    });
     function takePicture()
     {
        // var overlay = new Image();
        //  overlay.src = sticker;
        //  overlay.onload = function()
        //  {
        //     contex.drawImage(overlay, 0, 0, 640, 480);
        //  }
         context.drawImage(video, 0, 0, 640, 480);
         var imgurl = canvas.toDataURL('image/png');
         const image = document.createElement('img');
         image.setAttribute('src', imgurl);
         console.log(imgurl);
         photos.appendChild(image);
         document.getElementById("hidden1").value = imgurl;
         document.getElementById("hidden2").value = sticker;
    }
}
</script>
</html>
<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);

error_reporting(E_ALL);
require_once("config/database.php");

if (isset($_POST['hidden2']))
{
    echo "You submitted {$_POST['hidden2']}";
    die;
 }
?>