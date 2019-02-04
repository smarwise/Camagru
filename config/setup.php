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
	$columns = "id int PRIMARY KEY AUTO_INCREMENT NOT NULL,
		`owner_email` varchar(255) NOT NULL,
		`file_name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
		`uploaded_on` datetime NOT NULL";
	$statement = "CREATE TABLE IF NOT EXISTS `$dbname`.`$table` ($columns)";
	$table = $db->exec($statement);
	$table = "photo_likes";
	$columns = "id int PRIMARY KEY AUTO_INCREMENT NOT NULL,
	`user` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
	`photo` int COLLATE utf8_unicode_ci NOT NULL";
	$statement = "CREATE TABLE IF NOT EXISTS `$dbname`.`$table` ($columns)";
	$table = $db->exec($statement);
	$table = "comments";
	$statement = "CREATE TABLE IF NOT EXISTS `$dbname`.`$table` (
		id int PRIMARY KEY AUTO_INCREMENT NOT NULL,
		name varchar(255) NOT NULL,
		comment varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
		photo_id int NOT NULL)";
	$table = $db->exec($statement);
	$db->query('ALTER TABLE comments CONVERT TO CHARACTER SET utf8mb4 COLLATE utf8mb4_bin');
?>