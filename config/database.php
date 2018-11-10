<?PHP

$host = "localhost";
$username = "root";
$password = "codecrazy";
$table = "users";
$dbname = "db_smarwise";
$db = null;

try{
	$db = new PDO("mysql:host=$host", $username, $password);
	$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	$sql = "CREATE DATABASE IF NOT EXISTS db_smarwise DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci";
	$db->exec($sql);
	
}
catch (PDOException $e) {
	print "Error!: " . $e->getMessage() . "";
	die();
}
?>