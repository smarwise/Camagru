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
	$login = $_POST["user"];
	$passwd = $_POST["passwd"];
	$accounts = array();
	$accounts = unserialize(file_get_contents("private/passwd"));
	if (account_exists($accounts, $login, $passwd) === 1)
	{
		// echo "OK\n";
		return (1);
		// exit;
	}
	else
	{
		return (0);
		// echo "ERROR\n";
		// exit;
	}
}

if (auth() == 1)
	header("Location:http://localhost:8080/Camagru/homepage.php");
else
	echo "Error";
?>