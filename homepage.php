<?PHP
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
require_once("config/database.php");
require_once("config/setup.php");
require_once("navbar.php");
session_start();

if (!empty($_GET['user']))
	$user = $_GET['user'];
?>
<!DOCTYPE html>
<head>
	<title>Camagru</title>
	<link rel="stylesheet"  href="stylesheets/index.css">
</head>
<body>
	  <br />
	</body>
</html>