<!DOCTYPE html>
<html>
<head>
	<title>Login</title>
	<link href='https://fonts.googleapis.com/css?family=Charmonman' rel='stylesheet'>
	<link rel="stylesheet"  href="login.css">
</head>
 <body>
<div id="myspace">
<form action="index.php">
<div align="center">
  <h1>Camagru</h1>
  <label for="email" class="minor"><b>Email</b></label>
  <input type="text" placeholder="Enter Email" name="login" required>
	<br /><br />
  <label for="psw" class="minor" ><b>Password</b></label>
  <input type="password" placeholder="Enter Password" name="passwd" required>
	<br /><br />
  <button type="submit">Log In</button>
  <button type="button">Cancel</button><br /><br />
  <label>
        <input type="checkbox" checked="checked" name="remember"> Remember me
	  </label><br /><br />
 <span class="psw"><a href="#">Forgot password?</a></span>
 </div>
</form>
</div>
</body>
</html>