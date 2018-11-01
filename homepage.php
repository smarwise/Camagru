<?PHP
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
require_once("config/database.php");
require_once("config/setup.php");
session_start();

$user = $_GET['user'];
echo $user;
?>
<!DOCTYPE html>
<head>
	<title>Camagru</title>
	<link rel="stylesheet"  href="landingpage.css">
</head>
<body>
	<div class="navbar">
		<a href="http://localhost:8080/Camagru/homepage.php">Home</a>
		<a href="http://localhost:8080/Camagru/settings.php?user=?".$user>Settings</a>
		<a href="#">Gallery</a>
		<a float="right" href="#">Sign Out</a>
	  </div>
	  <br />
	</body>
</html>