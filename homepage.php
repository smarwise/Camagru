<?PHP
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
require_once("config/database.php");
require_once("config/setup.php");
session_start();
?>
<!DOCTYPE html>
<!-- <head>
	<title>Camagru</title>
	<link rel="stylesheet"  href="landingpage.css">
</head>
<body>
	<div class="navbar">
		<a href="http://localhost:8080/Camagru/homepage.php">Home</a>
		<a href="#">Gallery</a>
		<a float="right" href="#">Sign Out</a>
	  </div>
	  <br />
	</body>-->
<video id="video" width="800" height="800" autoplay></video>
<button id="snap">Snap Photo</button>
<canvas id="canvas" width="800" height="800"></canvas>
<script>
var video = document.getElementById('video');

if(navigator.mediaDevices && navigator.mediaDevices.getUserMedia) {
    navigator.mediaDevices.getUserMedia({ video: true }).then(function(stream) {
        video.src = window.URL.createObjectURL(stream);
        video.play();
    });
}
var canvas = document.getElementById('canvas');
var context = canvas.getContext('2d');
var video = document.getElementById('video');

document.getElementById("snap").addEventListener("click", function() {
	context.drawImage(video, 0, 0, 800, 800);
});
</script>
</html>