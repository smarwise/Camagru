<?PHP

$host = "localhost";
$username = "root";
$password = "123456";
$table = "users";
$dbname = "db_smarwise";
$db = null;

try{
	$db = new PDO("mysql:host=$host", $username, $password);
	$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	$db->exec("set names utf8");
	$sql = "CREATE DATABASE IF NOT EXISTS db_smarwise DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci";
	$db->exec($sql);
}
catch (PDOException $e) {
	print "Error!: " . $e->getMessage() . "";
	die();
}
?>