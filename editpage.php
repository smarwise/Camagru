<?php
// ini_set('display_errors', 1);
// ini_set('display_startup_errors', 1);
// error_reporting(E_ALL);
require_once("config/database.php");
require_once("navbar.php");
session_start();
$db->query("USE ".$dbname);
if (!isset($_SESSION["logged_in"]))
{
    header("Location: login.php");
}
$start = 0;
$limit = 3;
$query = $db->prepare("SELECT * FROM photos ORDER BY uploaded_on DESC limit {$start},{$limit}");
$query->execute();
$num = $query->rowCount();
$i = 0;
if ($num > 0)
{
    while($line = $query->fetch(PDO::FETCH_ASSOC))
    {
       $oldimages[] = $line;
    }
}
// echo '<pre>' . print_r($oldimages, true) . '</pre>';
?>
<html>
<head>
	<title>Edit</title>
	<link rel="stylesheet"  href="edit.css">
</head>
<div class="header">
   <h1> CAMAGRU </h1>
</div>
<div >
<a href="#" id="hearts"><img src="stickers/hearts.png" width="50px" height="50px"></a>
<a href="#" id="birds"><img src="stickers/birds.png" width="50px" height="50px"></a>
<a href="#" id="nice"><img src="stickers/nice.png" width="50px" height="50px"></a>
<a href="#" id="flowers"><img src="stickers/flowers.png" width="50px" height="50px"></a>
<a href="#" id="bubbles"><img src="stickers/bubbles.png" width="50px" height="50px"></a>
<a href="#" id="sticker1">sticker1</a>
<a href="#" id="sticker2">sticker2</a>
</div>
<div style="position:relative;">
<video id="video" width="500" height="350" muted="muted" autoplay></video>
<img src="#" alt="" id="img-overlay" style="position:absolute; left: 0;width: 500;height: 350;">
<img src="#" alt="" id="img-overlay2" style="position:absolute; left: 0;width: 500;height: 350;">
<button id="snap">Snap Photo</button>
<div id="old-photos">
<?php if (!empty($oldimages)):?>
<?php  foreach ($oldimages as $photo): ?>
<img width="150px" height="100px" src="<?php echo 'uploads/'.$photo["file_name"]; ?>" alt="" />
<?php endforeach; ?>
<?php endif; ?>
</div>
<canvas id="canvas" width="500" height="350"></canvas>
</div>
<div class="bottom">
    <div id="photos"></div>
<form method="post" action="editpage.php" id="myform">
      <input type="hidden" name="hidden1" id="hidden1" />
      <input type="hidden" name="hidden2" id="hidden2" />
      <input type="hidden" name="hidden3" id="hidden3" />
    <button id="save">Save</button>
</form>
</div>
<div>
Else
<form action="editpage.php" method="post" enctype="multipart/form-data">
    Select Image File to Upload:
    <input type="file" name="file">
    <input type="submit" name="submit" value="Upload">
</form>
</div>
<script>
var video = document.getElementById('video');
var over = 0;
if(navigator.mediaDevices && navigator.mediaDevices.getUserMedia)
{
    var canvas = document.getElementById('canvas');
    var context = canvas.getContext('2d');
    var video = document.getElementById('video');
    var photo = document.getElementById('snap');
    var images = document.getElementById('photos');
    var filter = document.getElementById('filters');
    var stickers = document.getElementById('stickers');
    var imgoverlay = document.getElementById('img-overlay');
    var imgoverlay2 = document.getElementById('img-overlay2');
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
    var sticker1 = "none";
    document.getElementById('sticker1').addEventListener("click", function(e)
    {
        over = 0;
        e.preventDefault();
    });
    document.getElementById('sticker2').addEventListener("click", function(e)
    {
        over = 1;
        e.preventDefault();
    });
    document.getElementById('nice').addEventListener('click', function(e)
    {
        if (over == 0)
        {
            sticker = "stickers/nice.png";
            imgoverlay.src = "stickers/nice.png";
        }
        else
        {
            sticker1 = "stickers/nice.png";
            imgoverlay2.src = "stickers/nice.png";
        }
        e.preventDefault();
    });
    document.getElementById('birds').addEventListener('click', function(e)
    {
        if (over == 0)
        {
            sticker = "stickers/birds.png";
            imgoverlay.src = "stickers/birds.png";
        }
        else
        {
            sticker1 = "stickers/birds.png";
            imgoverlay2.src = "stickers/birds.png";
        }
        e.preventDefault();
    });
    document.getElementById('flowers').addEventListener('click', function(e)
    {
        if (over == 0)
        {
            sticker = "stickers/flowers.png";
            imgoverlay.src = "stickers/flowers.png";
        }
        else
         {
            sticker1 = "stickers/flowers.png";
             imgoverlay2.src = "stickers/flowers.png";
         }
        e.preventDefault();
    });
    document.getElementById('hearts').addEventListener('click', function(e)
    {
        if (over == 0)
        {
            sticker = "stickers/hearts.png";
            imgoverlay.src = "stickers/hearts.png";
        }
        else
         {
            sticker1 = "stickers/hearts.png";
             imgoverlay2.src = "stickers/hearts.png";
         }
        e.preventDefault();
    });
    document.getElementById('bubbles').addEventListener('click', function(e)
    {
        if (over == 0)
        {
            sticker = "stickers/bubbles.png";
            imgoverlay.src = "stickers/bubbles.png";
        }
        else
        {
            sticker1 = "stickers/bubbles.png";
            imgoverlay2.src = "stickers/bubbles.png";
        }
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
         if (over > 0)
            document.getElementById("hidden3").value = sticker1;
    }
}
</script>
</html>
<?php
// ini_set('display_errors', 1);
// ini_set('display_startup_errors', 1);
// error_reporting(E_ALL);
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
    $filename = md5(uniqid("something", true));
    $filename .= '.png';
    if ($sticker != 'none')
    {
        file_put_contents('uploads/'.$filename, base64_decode($_POST['hidden1']));
        if (exif_imagetype('uploads/'.$filename) == IMAGETYPE_PNG)
            $baseimg = imagecreatefrompng('uploads/'.$filename);
        else
            die();
        $stickeroverlay = imagecreatefrompng($sticker);
        imagecopy($baseimg, $stickeroverlay, 0, 0, 0, 0, 500, 350);
        if (isset($_POST['hidden3']))
        {
            $sticker1 = trim($_POST['hidden3']);
            if ($sticker1 != "")
            {
                $stickeroverlay1 = imagecreatefrompng($sticker1);
                imagecopy($baseimg, $stickeroverlay1, 0, 0, 0, 0, 500, 350);
            }
        }
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
 else
 {
 }
?>
<?php

$statusMsg = '';
$db->query("USE ".$dbname);
$targetDir = "uploads/";
if (isset($_FILES["file"]["name"]))
{
    $fileName = basename($_FILES["file"]["name"]);
    $targetFilePath = $targetDir . $fileName;
    $fileType = pathinfo($targetFilePath, PATHINFO_EXTENSION);
}
if (isset($_POST["submit"]) && !empty($_FILES["file"]["name"]))
{
    $allowTypes = array('jpg','png','jpeg','gif','pdf');
    if (in_array($fileType, $allowTypes))
    {
        if (move_uploaded_file($_FILES["file"]["tmp_name"], $targetFilePath))
        {
            $email = $_SESSION['email'];
            $query = "INSERT into photos (file_name, uploaded_on, owner_email) VALUES (:name, NOW(), :email)";
            $stmt = $db->prepare( $query );
            $stmt->bindParam(':name', $fileName);
            $stmt->bindParam(':email', $email);
            $insert = $stmt->execute();
            if ($insert)
            {
                $statusMsg = "The file ".$fileName. " has been uploaded successfully.";
            }
            else
            {
                $statusMsg = "File upload failed, please try again.";
            } 
        }
        else
        {
            $statusMsg = "Sorry, there was an error uploading your file.";
        }
    }
    else
    {
        $statusMsg = 'Sorry, only JPG, JPEG, PNG, GIF, & PDF files are allowed to upload.';
    }
}
else
{
    $statusMsg = 'Please select a file to upload.';
}
echo $statusMsg;
?>