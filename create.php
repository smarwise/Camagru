<?php

function		account_exists($accounts, $login, $email)
{
	$i = 0;
	/*while ($accounts[$i] != NULL)
	{
		if ($accounts[$i]["email"] == $email)
			return(2);
		$i++;
	}*/
	// $i = 0;
	while ($accounts[$i] != NULL)
	{
		if ($accounts[$i]["user"] == $login)
			return(1);
		$i++;
	}
	return(0);
}

function validemail($email)
{
	$reg = "/[a-zA-Z0-9_-.+]+@[a-zA-Z0-9-]+.[a-zA-Z]+/";
	if (preg_match($reg, $email) == NULL)
		return (0);
	else
		return (1);
}

//[a-zA-Z0-9.-_]{1,}@[a-zA-Z.-]{2,}[.]{1}[a-zA-Z]{2,}
function makeaccount()
{
	$accounts = array();

	if ($_POST['email'] && $_POST['user'] && $_POST['passwd'] && $_POST['passwd2'])
	{
		// if (validemail($_POST["email"]) == 0)
			// return ("valid");
		$user = $_POST['user'];
		if ($_POST['passwd'] != $_POST['passwd2'])
		{
			return "passwd";
		}
		if (!file_exists("private/"))
			mkdir("private/");
		if (!file_exists("private/passwd")) 
			file_put_contents("private/passwd", null);
		$accounts = unserialize(file_get_contents("private/passwd"));
		if (account_exists($accounts, $_POST["user"], $_POST["email"]) == 1)
		{
			return "user";
			exit;
		}
		else if (account_exists($accounts, $_POST["user"], $_POST["email"]) == 2)
		{
			return "email";
			exit;
		}
		else
		{
			$data[] = [ 'email' => $_POST['email'], 'user' => $_POST['user'], 'passwd' => hash('whirlpool', $_POST['passwd'])];
			file_put_contents("private/passwd", serialize($data), FILE_APPEND | LOCK_EX);
			return "OK";
		}
	}
	else
		return "ERROR";
}

if (makeaccount() == "user")
	echo "Username is already taken.";
else if (makeaccount() == "passwd")
	echo "Passwords do not match";
else if (makeaccount() == "email")
	echo "Email already has an account";
else if (makeaccount() == "valid")
	echo "Email is not valid";
else
{
	echo "Account successfully created";
	header("Location:http://localhost:8080/Camagru/login.php");
 }
?>

<html>
	<body>
	<?php if (isset($user)) { ?>
		<h1> Login: <?php echo "$user" ?></h1>
		<?php } ?>
	</body>
	</html>