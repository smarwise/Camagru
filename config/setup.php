<?php


require_once("database.php");
$db = new PDO("mysql:host=$host", 'root', 'codecrazy');
$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
$db->query("USE ".$dbname);

	$table = "users";
	$statement = "CREATE TABLE IF NOT EXISTS `$dbname`.`$table` (
		id int PRIMARY KEY AUTO_INCREMENT NOT NULL,
		email varchar(255) NOT NULL, 
		username varchar(255) NOT NULL,
		passwd varchar(255) NOT NULL,
		token text NOT NULL,
		notifications varchar(255) NOT NULL,
		verified int DEFAULT '0' NOT NULL)";
	$table = $db->exec($statement);
	$table = "photos";
	$columns = "id int PRIMARY KEY AUTO_INCREMENT NOT NULL, picture varchar(255) NOT NULL";
	$statement = "CREATE TABLE IF NOT EXISTS `$dbname`.`$table` ($columns)";
	$table = $db->exec($statement);
?>