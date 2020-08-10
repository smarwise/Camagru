<!DOCTYPE html>
<html>
<head>
	<title>Sign Up</title>
	<link href='https://fonts.googleapis.com/css?family=Charmonman' rel='stylesheet'>
	<link rel="stylesheet"  href="stylesheets/login.css">
</head>
 <body>
<div id="myspace">
<form action="resetpwd.php" method="post">
<div align="center">
  <h1>Camagru</h1>
  <label for="email" class="minor"><b>Email</b></label>
  <input type="text" placeholder="Enter Email" name="email" required>
	<br /><br />
  <button type="submit">Reset Password</button>
  <button type="button">Cancel</button><br /><br />
 <span><a href="http://localhost:82/Camagru/login.php">Login</a></span>
 </div>
</form>
</div>
</body>
</html>

<?PHP
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
require_once("config/database.php");


$db->query("USE ".$dbname);
if (isset($_POST['email']))
	$email = $_POST['email'];
$query = $db->prepare("SELECT username,passwd  FROM users WHERE email = :email");
$query->bindParam(':email', $email);
$query->execute();
if ($query->rowcount() > 0)
{
  $verificationCode = md5(uniqid("something", true));
	$verificationLink = "http://localhost:82/Camagru/reset.php?code=" . $verificationCode;
	$htmlStr = "";
	$htmlStr .= "Hi " . $email . ",<br /><br />";
	$htmlStr .= "Please click the button below to reset your password and have access to the Camagru website.<br /><br /><br />";
	$htmlStr .= "<a href='{$verificationLink}' target='_blank' style='padding:1em; font-weight:bold; background-color:blue; color:#fff;'>RESET PASSWORD</a><br /><br /><br />";
	$htmlStr .= "Kind regards,<br />";
	$htmlStr .= "<a href='http://localhost:82/Camagru/' target='_blank'>Camagru</a><br />";
	$name = "Camagru";
	$email_sender = "no-reply@camagru.com";
	$subject = "Password Reset | Camagru";
	$recipient_email = $email;
	$headers  = "MIME-Version: 1.0\r\n";
	$headers .= "Content-type: text/html; charset=iso-8859-1\r\n";
	$headers .= "From: {$name} <{$email_sender}> \n";
  $body = $htmlStr;
  $query = "UPDATE users set token = :code where email = :email";
  $line = $db->prepare($query);
  $line->bindParam(':code', $verificationCode);
  $line->bindParam(':email', $email);
  $line->execute();
	if (mail($recipient_email, $subject, $body, $headers) )
   echo "<div id='successMessage'>An email was sent to <b>" . $email . "</b>, please open your email inbox and click the given link so you can reset your password.</div>";
  
  }
?>