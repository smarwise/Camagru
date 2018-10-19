<?php

require_once("database.php");
require_once("setup.php");

$db = new PDO("mysql:host=$host", 'root', 'codecrazy');
$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
$db->query("USE ".$dbname);
if ($_POST['email'] && $_POST['user'] && $_POST['passwd'] && $_POST['passwd2'])
{
	if ($_POST['passwd'] != $_POST['passwd2'])
	{
		header("Location:http://localhost:8080/Camagru/index.php");
		echo "<script type='text/javascript'>alert('Password does not match');</script>";
		exit;
	}
	$user = $_POST['user'];
	$email = $_POST['email'];
	$reg = "/[a-zA-Z0-9_-.+]+@[a-zA-Z0-9-]+.[a-zA-Z]+/";
	if (preg_match($reg, $email) == NULL)
	{
		echo "<script type='text/javascript'>alert('Please use a valid email adress');</script>";
		exit;
	}
	$query = $db->prepare("SELECT * FROM users WHERE email = :name");
	$query->bindParam(':name', $email);
	$query->execute();
	if ($query->rowcount() > 0)
	{
		echo "<script type='text/javascript'>alert('Email already has an account');</script>";
	 	exit;
	}
	$query = $db->prepare("SELECT * FROM users WHERE username = :name");
	$query->bindParam(':name', $user);
	$query->execute();
	if ($query->rowcount() > 0)
	{
		echo "<script type='text/javascript'>alert('Username is already taken');</script>";
	 	exit;
	}
	$password = $_POST['passwd'];
	$table = "users";

	$sql = "INSERT INTO users (email, username, passwd) VALUES (:email, :username, :passwd)";
    $stmt= $db->prepare($sql);
    $stmt->bindParam(':email', $email);
    $stmt->bindParam(':username', $user);
    $stmt->bindParam(':passwd', $password);
	$stmt->execute();
}
?>