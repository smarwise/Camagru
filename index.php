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
		<a href="http://localhost:8080/Camagru/login.php">Login</a>
	  </div>
		<div id="myspace">
		<form action="index.php" method="post">
		<div class="input-wrapper" align="center">
			<h1>Camagru</h1>
			<label for="email" class="minor"><b>Email</b></label>
			<input type="text" placeholder="Enter Email" name="email" required>
			<br /><br />
			<label for="username" class="minor"><b>Username</b></label>
			<input type="text" placeholder="Enter Username" name="user" required>
			<br /><br />
			<label for="psw" class="minor" ><b>Password</b></label>
			<input type="password" placeholder="Enter Password" name="passwd" required>
			<br /><br />
			<label for="psw" class="minor" ><b>Repeat Password</b></label>
			<input type="password" placeholder="Enter Password" name="passwd2" required>
			<br /><br />
			<button type="submit">Create Account</button>
			<button type="button">Cancel</button><br /><br />
		<span>Already a user?  <a href="http://localhost:8080/Camagru/login.php">Login</a></span>
		</div>
		</form>
		</div>
	  <br />
	</body>
</html>
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
	if (!filter_var($email, FILTER_VALIDATE_EMAIL))
	{
		echo "<script type='text/javascript'>alert('Please use a valid email addresss');</script>";
		exit ;
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
	if (strlen($password) < 8)
	{
		echo "<script type='text/javascript'>alert('Password must be at least characters long');</script>";
	 	exit;
	}
	if (!preg_match("#[0-9]+#", $password))
	{
		echo "<script type='text/javascript'>alert('Password must include at least one number');</script>";
		exit;
    }

	if (!preg_match("#[a-zA-Z]+#", $password))
	{
        echo "<script type='text/javascript'>alert('Password must include at least one letter');</script>";
		exit;
	}     
	$table = "users";
	$sql = "INSERT INTO users (email, username, passwd) VALUES (:email, :username, :passwd)";
    $stmt= $db->prepare($sql);
    $stmt->bindParam(':email', $email);
    $stmt->bindParam(':username', $user);
    $stmt->bindParam(':passwd', $password);
	if ($stmt->execute())
		header("Location: login.php");
}
?>