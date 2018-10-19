
<html>
<head>
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
	</body>
</html>
<?php
require 'auth.php';


if($_SESSION['logged'] == true){ 
	echo ($_SESSION["username"]);
}
?>