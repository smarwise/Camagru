<!DOCTYPE html>
<html>
<head>
	<title>Login</title>
	<link href='https://fonts.googleapis.com/css?family=Charmonman' rel='stylesheet'>
	<link rel="stylesheet"  href="login.css">
</head>
 <body>
 <div class="navbar">
		<a href="http://localhost:8080/Camagru/index.php">Home</a>
		<a href="http://localhost:8080/Camagru/login.php">Login</a>
	</div>
<div id="myspace">
<form action="login.php" method="post">
<div align="center">
  <h1>Camagru</h1>
  <label for="email" class="minor"><b>Username</b></label>
  <input type="text" placeholder="Enter Username" name="user" required>
	<br /><br />
  <label for="psw" class="minor" ><b>Password</b></label>
  <input type="password" placeholder="Enter Password" name="passwd" required>
	<br /><br />
  <button type="submit">Log In</button>
  <button type="button">Cancel</button><br /><br />
  <label>
        <input type="checkbox" checked="checked" name="remember"> Remember me
	  </label><br /><br />
 <span class="psw"><a href="http://localhost:8080/Camagru/resetpwd.php">Forgot password?</a></span>
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
function	userexists($user, $pwd)
{
	$host = "localhost";
	$dbname = "db_smarwise";
	$db = new PDO("mysql:host=$host", "root", "codecrazy");
	$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	$db->query("USE ".$dbname);
	$pswd = hash('whirlpool', $pwd);
	$one = "1";
	$query = $db->prepare("SELECT username,passwd  FROM users WHERE username = :name AND passwd = :passwd AND verified = :one");
	$query->bindParam(':name', $user);
	$query->bindParam(':passwd', $pswd);
	$query->bindParam(':one', $one);
	$query->execute();
	if ($query->rowcount() > 0)
		return (1);
	return (0);
}

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

if (isset($_POST['user']) && isset($_POST['passwd']))
{
	$user = $_POST['user'];
	$pwd = $_POST['passwd'];
}
if (isset($user) && isset($pwd))
{
	if (userexists($user, $pwd) == 1)
	{
		session_start();
		$query = "SELECT id FROM users where username = :user";
    	$line = $db->prepare($query);
		$line->bindParam(':user', $user);
		$id = $line->execute();
		$_SESSION["user_id"] = $id;
		$query = "SELECT * FROM users where username = :user";
    	$line = $db->prepare($query);
		$line->bindParam(':user', $user);
		$email = $line->execute();
		while ($row = $line->fetch(PDO::FETCH_ASSOC))
        {
            $email = $row;
        }
		$_SESSION['email'] = $email["email"];
  		$_SESSION["username"] = $user;
		$_SESSION["logged_in"] = true;
		header("Location:http://localhost:8080/Camagru/homepage.php?user=".$user);
	}
	else
		echo "Username and password do not match or Account is not yet verified";
}
?>