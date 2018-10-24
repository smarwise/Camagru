<!DOCTYPE html>
<html>
<head>
	<title>Sign Up</title>
	<link href='https://fonts.googleapis.com/css?family=Charmonman' rel='stylesheet'>
	<link rel="stylesheet"  href="login.css">
</head>
 <body>
<div id="myspace">
<form action="reset.php">
<div align="center">
  <h1>Camagru</h1>
  <label for="psw" class="minor" ><b>New Password</b></label>
  <input type="password" placeholder="Enter Password" name="passwd" required>
	<br /><br />
	<label for="psw" class="minor" ><b>Repeat Password</b></label>
  <input type="password" placeholder="Enter Password" name="passwd" required>
	<br /><br />
  <button type="submit">Reset Password</button>
  <button type="button">Cancel</button><br /><br />
 <span><a href="http://localhost:8080/Camagru/login.php">Login</a></span>
 </div>
</form>
</div>
</body>
</html>
<?PHP

if (isset($_GET['code']))
{
  $query = "SELECT id FROM users WHERE token = ? and verified = '0'";
  $stmt = $db->prepare( $query );
  $code = trim($_GET['code']);
  $stmt->bindParam(1, $code);
  $stmt->execute();
  $num = $stmt->rowCount();
  if ($num > 0)
  {
    $query = "UPDATE users set verified = '1' where token = :verification_code";
    $line = $db->prepare($query);
    $line->bindParam(':verification_code', $code);
    if ($line->execute())
      echo "Your email has been verified. You may now log in.";
    else
     {
				echo "Failed to verify email";
				exit;
		 }
  }
  else
   {
			echo "Verification token is invalid. Please try again.";
			exit;
	 }
}
?>