<?PHP

function	account_exists($accounts, $login, $password)
{
	 
	$i = 0;
	while ($accounts[$i] != NULL)
	{
		if ($accounts[$i]["user"] === $login && $accounts[$i]['passwd'] === hash('whirlpool', $password))
			return(1);
		$i++;
	}
	return(0);
}

function	auth()
{
	$login = $_POST["login"];
	$passwd = $_POST["passwd"];
	$accounts = array();
	$accounts = unserialize(file_get_contents("private/passwd"));
	if (account_exists($accounts, $login, $passwd) === 1)
	{
		 echo "OK\n";
		return (1);
	}
	else
	{
		return (0);
	}
}

if (auth() == 1)
{
	session_start();
   	$_SESSION["username"] = $_GET["user"];
	$_SESSION["logged"] = true;
	header("Location:http://localhost:8080/Camagru/homepage.php");
}
else
	echo "Error";
?>