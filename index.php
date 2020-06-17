<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
require_once("config/database.php");
require_once("config/setup.php");
require_once("login_navbar.php");
?>
<html>
<head>
	<title>Camagru</title>
	<link rel="stylesheet"  href="stylesheets/index.css">
	<link href='https://fonts.googleapis.com/css?family=Charmonman' rel='stylesheet'>
</head>
<body>
	  <div class="form_style">
		<form action="signup.php" method="post">
		<div class="input-wrapper">
			<h1>Camagru</h1>
			<label for="email"><b>Email</b></label>
			<input type="text" placeholder="Enter Email" name="email" required>
			<label for="username"><b>Username</b></label>
			<input type="text" placeholder="Enter Username" name="user" required>
			<label for="psw"><b>Password</b></label>
			<input type="password" placeholder="Enter Password" name="passwd" required>
			<label for="psw"><b>Repeat Password</b></label>
			<input type="password" placeholder="Enter Password" name="passwd2" required>
			<button type="submit">Create Account</button>
			<button type="button">Cancel</button>
		<span>Already a user?  <a href="http://localhost:81/Camagru/login.php">Login</a></span>
		</div>
        </form>
	</div>
	</body>
</html>
