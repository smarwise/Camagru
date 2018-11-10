<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
require_once("config/database.php");
require_once("navbar.php");
session_start();
if (!isset($_SESSION["logged_in"]))
{
    header("Location:http://localhost:8080/Camagru/login.php");
}
?>
<html>
<head>
	<title>Edit</title>
	<link rel="stylesheet"  href="edit.css">
</head>
<div class="header">
   <h1> CAMAGRU </h1>
</div>
<div style="position:relative;">
<video id="video" width="500" height="350" muted="muted" autoplay></video>
<img src="#" alt="" id="img-overlay" style="position:absolute; left: 0;width: 500;height: 350;">
<select id="stickers">
<option id="overlay" value="stickers/none.png">normal</option>
<option id="overlay" value="stickers/cutecat.png">cutecat</option>
<option id="overlay" value="stickers/dogears.png">dogears</option>
<option id="overlay" value="stickers/hellokitty.png">hellokitty</option>
<option id="overlay" value="stickers/lovehearts.png">lovehearts</option>
<option id="overlay" value="stickers/sadness.png">sadness</option>
</select>
<button id="snap">Snap Photo</button>
<button id="clear">Clear</button>
<canvas id="canvas" width="500" height="350"></canvas>
</div>
<div class="bottom">
    <div id="photos"></div>
<form method="post" action="editpage.php" id="myform">
      <input type="hidden" name="hidden1" id="hidden1" />
      <input type="hidden" name="hidden2" id="hidden2" />
    <button id="save">Save</button>
</form>
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
    var save = document.getElementById('save');
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
        sticker = e.target.value;
        imgoverlay.src = sticker;
         e.preventDefault();
    });
     function takePicture()
     {
         context.drawImage(video, 0, 0, 500, 350);
         var imgurl = canvas.toDataURL('image/png');
         const image = document.createElement('img');
         image.setAttribute('src', imgurl);
         console.log(sticker);
         photos.appendChild(image);
         document.getElementById("hidden1").value = imgurl.split(',')[1];
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
require_once("config/setup.php");

$db->query("USE ".$dbname);
if (isset($_POST['hidden2']) && isset($_POST['hidden1']))
{
    $sticker = $_POST['hidden2'];
    $url = $_POST['hidden1'];
    $path = 'uploads/';
    $path .= $url;
    $path .= '.png';
    $filename = substr($url, 0, 10);
    $filename .= '.png';
    if ($sticker != 'none')
    {
        file_put_contents('uploads/'.$filename, base64_decode($_POST['hidden1']));
        $baseimg = imagecreatefrompng('uploads/'.$filename);
        // echo $sticker;
        $stickeroverlay = imagecreatefrompng($sticker);
        imagecopy($baseimg, $stickeroverlay, 0, 0, 0, 0, 500, 350);
        imagepng($baseimg, 'uploads/'.$filename);
        $email = $_SESSION['email'];
        $query = "INSERT into photos (file_name, uploaded_on, owner_email) VALUES (:name, NOW(), :email)";
        $stmt = $db->prepare( $query );
        $stmt->bindParam(':name', $filename);
        $stmt->bindParam(':email', $email);
        $insert = $stmt->execute();
    }
    else
    {
        file_put_contents('uploads/'.$filename, base64_decode($_POST['hidden1']));
        $email = $_SESSION['email'];
        $query = "INSERT into photos (file_name, uploaded_on, owner_email) VALUES (:name, NOW(), :email)";
        $stmt = $db->prepare( $query );
        $stmt->bindParam(':name', $filename);
        $stmt->bindParam(':email', $email);
        $insert = $stmt->execute();
    }
    
 }
?>