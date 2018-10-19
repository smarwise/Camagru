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
		<form action="create.php" method="post">
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
?>