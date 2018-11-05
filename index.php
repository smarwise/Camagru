<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
require_once("config/database.php");
require_once("config/setup.php");
?>
<html>
<head>
	<title>Camagru</title>
	<link rel="stylesheet"  href="landingpage.css">
	<link rel="stylesheet"  href="login.css">
	<link href='https://fonts.googleapis.com/css?family=Charmonman' rel='stylesheet'>
</head>
<body>
	<div class="navbar">
		<a href="http://localhost:8080/Camagru/index.php">Home</a>
		<a href="http://localhost:8080/Camagru/gallery.php">Gallery</a>
		<a href="http://localhost:8080/Camagru/login.php">Login</a>
		<a href="http://localhost:8080/Camagru/signup.php">SignUp</a>
		<a href="http://localhost:8080/Camagru/homepage.php">Home</a>
		</div>
	  <br />
	</body>
</html>
