<!DOCTYPE html>
<html>
<head>
	<title>Sign Up</title>
	<link href='https://fonts.googleapis.com/css?family=Charmonman' rel='stylesheet'>
	<link rel="stylesheet"  href="login.css">
</head>
 <body>
<div id="myspace">
<form action="reset.php" method="post">
<div align="center">
  <h1>Camagru</h1>
  <label for="psw" class="minor" ><b>New Password</b></label>
  <input type="password" placeholder="Enter Password" name="passwd" required>
	<br /><br />
	<label for="psw" class="minor" ><b>Repeat Password</b></label>
  <input type="password" placeholder="Enter Password" name="passwd2" required>
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
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
require_once("config/database.php");
$db->query("USE ".$dbname);
session_start();
if (isset($_GET['code']))
{
  $query = "SELECT id FROM users WHERE token = ?";
  $stmt = $db->prepare( $query );
  $code = trim($_GET['code']);
  $_SESSION["code"] = $code;
  $stmt->bindParam(1, $code);
  $stmt->execute();
  $num = $stmt->rowCount();
  if ($num > 0)
    echo "You may now reset your password";
    else
    {
		echo "Failed to verify your ownership of this account";
		exit;
	 }
}

if (isset($_POST['passwd']) && isset($_POST['passwd2']))
{
  if ($_POST['passwd'] && $_POST['passwd2'])
  {
      if (isset($_SESSION['code']))
        $token = $_SESSION['code'];
      echo "$token";
      if ($_POST['passwd'] != $_POST['passwd2'])
     {
      echo "<script type='text/javascript'>alert('Password does not match');</script>";
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
      $pwd = hash('whirlpool', $password);
      $query = "UPDATE users set passwd = :pwd where token = :code";
      $line = $db->prepare($query);
      $line->bindParam(':pwd', $pwd);
      $line->bindParam(':code', $token);
      if ($line->execute())
          echo "Password has been successfully changed. You may now log in";
  }
}
?>