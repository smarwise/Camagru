<!DOCTYPE html>
<html>
<head>
	<title>Sign Up</title>
	<link href='https://fonts.googleapis.com/css?family=Charmonman' rel='stylesheet'>
	<link rel="stylesheet"  href="login.css">
</head>
 <body>
<div id="myspace">
<form action="create.php" method="post">
<div align="center">
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
 <span><a href="http://localhost:8080/Camagru/login.php">Login</a></span>
 </div>
</form>
</div>
</body>
</html>