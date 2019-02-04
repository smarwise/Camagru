<html>
<head>
	<title>Camagru</title>
	<link rel="stylesheet"  href="landingpage.css">
	<link rel="stylesheet"  href="login.css">
	<link href='https://fonts.googleapis.com/css?family=Charmonman' rel='stylesheet'>
</head>
<body>
		<div id="myspace">
		<form action="signup.php" method="post">
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
</body>
</html>


<?php

require_once("config/database.php");
require_once("config/setup.php");

$db->query("USE ".$dbname);
if ($_POST['email'] && $_POST['user'] && $_POST['passwd'] && $_POST['passwd2'])
{
	if ($_POST['passwd'] != $_POST['passwd2'])
	{
		header("Location: index.php");
		echo "<script type='text/javascript'>alert('Password does not match');</script>";
		exit;
	}
	$user = $_POST['user'];
	$email = trim($_POST['email']);
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
		echo "<script type='text/javascript'>alert('Password must be at least 8 characters long');</script>";
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
	$verificationCode = md5(uniqid("something", true));
	$verificationLink = "http://localhost:8080/Camagru/login.php?code=" . $verificationCode;
	$htmlStr = "";
	$htmlStr .= "Hi " . $email . ",<br /><br />";
	$htmlStr .= "Please click the button below to verify your subscription and have access to the Camagru website.<br /><br /><br />";
	$htmlStr .= "<a href='{$verificationLink}' target='_blank' style='padding:1em; font-weight:bold; background-color:blue; color:#fff;'>VERIFY EMAIL</a><br /><br /><br />";
	$htmlStr .= "Kind regards,<br />";
	$htmlStr .= "<a href='http://localhost:8080/Camagru/' target='_blank'>Camagru</a><br />";
	$name = "Camagru";
	$email_sender = "no-reply@camagru.com";
	$subject = "Verification Link | Camagru | Registration";
	$recipient_email = $email;
	$headers  = "MIME-Version: 1.0\r\n";
	$headers .= "Content-type: text/html; charset=iso-8859-1\r\n";
	$headers .= "From: {$name} <{$email_sender}> \n";
	$body = $htmlStr;
	if (mail($recipient_email, $subject, $body, $headers) )
		echo "<div id='successMessage'>A verification email was sent to <b>" . $email . "</b>, please open your email inbox and click the given link so you can login.</div>";
	$table = "users";
	$sql = "INSERT INTO users (email, username, passwd, notifications, token) VALUES (:email, :username, :passwd, :noti, :token)";
	$coolpwd = hash('whirlpool', $password);
	$noti = "off";
	$stmt= $db->prepare($sql);
	$stmt->bindParam(':email', $email);
	$stmt->bindParam(':username', $user);
	$stmt->bindParam(':passwd', $coolpwd);
	$stmt->bindParam(':noti', $noti);
	$stmt->bindParam(':token', $verificationCode);
	$stmt->execute();
}
?>