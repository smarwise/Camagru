<?PHP
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
require_once("config/database.php");
require_once("config/setup.php");
require_once("navbar.php");
session_start();

$user = $_GET['user'];
echo $user;
?>
<!DOCTYPE html>
<head>
	<title>Camagru</title>
	<link rel="stylesheet"  href="stylesheets/landingpage.css">
</head>
<body>
	  <br />
	</body>
</html>