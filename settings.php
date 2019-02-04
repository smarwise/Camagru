<head>
	<title>Settings</title>
	<link rel="stylesheet"  href="settings.css">
</head>
<form action="settings.php" method="post">
  <h1>Settings</h1>
  <label for="email" class="minor"><b>Old Username</b></label>
  <input type="text" placeholder="Enter Username" name="olduser" required>
	<br /><br />
  <label for="email" class="minor"><b>New Username</b></label>
  <input type="text" placeholder="Enter Username" name="newuser" required>
	<br /><br />
  <label for="email" class="minor"><b>Repeat Username</b></label>
  <input type="text" placeholder="Enter Username" name="newuser2" required>
	<br /><br />
  <button type="submit">change username</button>
 </div>
</form>
<form action="settings.php" method="post">
<div>
  <h1>Password</h1>
  <label for="psw" class="minor" ><b>Old Password</b></label>
  <input type="password" placeholder="Enter Password" name="oldpasswd" required>
	<br /><br />
  <label for="psw" class="minor" ><b>New Password</b></label>
  <input type="password" placeholder="Enter Password" name="passwd" required>
	<br /><br />
	<label for="psw" class="minor" ><b>Repeat Password</b></label>
  <input type="password" placeholder="Enter Password" name="passwd2" required>
	<br /><br />
  <button type="submit">reset password</button>
 </div>
</form>
<form action="settings.php" method="post">
<div>
<h1>Email</h1>
		<label for="email" class="minor"><b>Old Email</b></label>
		<input type="text" placeholder="Enter Email" name="oldemail" required>
	<br /><br />
  <label for="email" class="minor"><b>New Email</b></label>
		<input type="text" placeholder="Enter Email" name="email1" required>
	<br /><br />
  <label for="email" class="minor"><b>Email</b></label>
		<input type="text" placeholder="Enter Email" name="email2" required>
	<br /><br />
  <button type="submit">change email</button>
 </div>
</form>
<form action="settings.php" method="post">
  <input type="radio" name="on" value="On">Notifications On<br>
  <input type="radio" name="on" value="Off">Notifications Off<br>
  <input type="submit" value="Submit">
</form>
<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
require_once("config/database.php");
require_once("navbar.php");
session_start();
$db->query("USE ".$dbname);

if (!isset($_SESSION["logged_in"]))
{
    header("Location: login.php");
}
if (isset($_POST['newuser']) && isset($_POST['newuser2']))
{
    if ($_POST['newuser'] == $_POST['newuser2'])
    {
        $user = $_POST['olduser'];
        $newuser = $_POST['newuser'];
        $query = "SELECT id FROM users WHERE username = ?";
        $stmt = $db->prepare( $query );
        $stmt->bindParam(1, $user);
        $stmt->execute();
        $num = $stmt->rowCount();
        if ($num > 0)
        {
          $query = "UPDATE users set username = :user where username = :old";
          $line = $db->prepare($query);
          $line->bindParam(':user', $newuser);
          $line->bindParam(':old', $user);
          if ($line->execute())
            echo "Username has been successfully changed.";
        }
        else
           echo "You entered a wrong username.";
    }
    else
    {
        echo "<script type='text/javascript'>alert('Passwords do not match');</script>";
		exit;
    }
}
else
{

}
if (isset($_POST['passwd']) && isset($_POST['passwd2']))
{
  if ($_POST['passwd'] && $_POST['passwd2'])
  {
     if ($_POST['passwd'] != $_POST['passwd2'])
     {
      echo "<script type='text/javascript'>alert('Password does not match');</script>";
      exit;
      }
    $password = $_POST['oldpasswd'];
    $newpwd = $_POST['passwd'];
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
    $query = "SELECT id FROM users WHERE passwd = ?";
    $pwd = hash('whirlpool', $password);
    $stmt = $db->prepare( $query );
    $stmt->bindParam(1, $pwd);
    $stmt->execute();
    $num = $stmt->rowCount();
    if ($num > 0)
    {
      $newpwd = hash('whirlpool', $newpwd);
      $query = "UPDATE users set passwd = :pwd where passwd = :old";
      $line = $db->prepare($query);
      $line->bindParam(':pwd', $newpwd);
      $line->bindParam(':old', $pwd);
      if ($line->execute())
          echo "Password successfully changed.";
    }
    else
      echo "You entered a wrong old password";
  }
}
else
{}
if (isset($_POST['email1']) && isset($_POST['email2']))
{
  $email = trim($_POST['email1']);
	if (!filter_var($email, FILTER_VALIDATE_EMAIL))
	{
		echo "<script type='text/javascript'>alert('Please use a valid email addresss');</script>";
		exit ;
  }
  $oldemail = $_POST['oldemail'];
	$query = $db->prepare("SELECT * FROM users WHERE email = :name");
	$query->bindParam(':name', $email);
	$query->execute();
	if ($query->rowcount() > 0)
	{
		echo "<script type='text/javascript'>alert('Email already has an account');</script>";
	 	exit;
  }
  $query = $db->prepare("SELECT * FROM users WHERE email = :name");
	$query->bindParam(':name', $oldemail);
	$query->execute();
	if ($query->rowcount() > 0)
	{
    $query = "UPDATE users set email = :newemail where email = :old";
    $line = $db->prepare($query);
    $line->bindParam(':newemail', $email);
    $line->bindParam(':old', $oldemail);
    if ($line->execute())
       echo "Email successfully changed.";
  }
  else
  {
    echo "<script type='text/javascript'>alert('Email already has an account');</script>";
    exit;
  }
}

if (isset($_POST['on']))
{
  if (isset($_POST['on']) && $_POST['on'] == 'On')
  {
    $user = $_SESSION['username'];
    $query = "UPDATE users set notifications = :on where username = :user";
    $line = $db->prepare($query);
    $on = "on";
    $line->bindParam(':on', $on);
    $line->bindParam(':user', $user);
    if ($line->execute())
      echo "Notifications successfully turned on.";
  }
  else if (isset($_POST['on']) && $_POST['on'] == 'Off')
  {
    $user = $_SESSION['username'];
    $query = "UPDATE users set notifications = :off where username = :user";
    $line = $db->prepare($query);
    $off = "off";
    $line->bindParam(':off', $off);
    $line->bindParam(':user', $user);
    if ($line->execute())
      echo "Notifications successfully turned off.";
  }
}
?>
