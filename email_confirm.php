<?php 
if(isset($_GET['email']))
	if(isset($_GET['hash']))
		if(!filter_var($_GET['email'], FILTER_VALIDATE_EMAIL === false))
			if(mb_strlen($_GET['hash'])===32)
				define("___ERROR___", 0);
			else
				define("___ERROR___", 1);
		else
			define("___ERROR___", 2);
	else
		define("___ERROR___", 3);
else
	define("___ERROR___", 4);

if(___ERROR___ === 0)
{
	require_once('includes/database_config.php');

	$email = $_GET['email'];
	$hash  = $_GET['hash'];

	$sql = "SELECT * FROM users WHERE user_email = '$email' AND user_hash = '$hash' LIMIT 1";
	$query = $dbh->prepare($sql);
	$query->execute();
	$count = $query->rowCount();
	if($count === 1)
	{
		$sql = "UPDATE users SET user_activated = '1', user_hash = '' WHERE user_email = '$email' AND user_hash = '$hash'";
		$res = $dbh->prepare($sql);
		$res->execute();
		$count = $res->rowCount();
		if($count === 1)
		{
			header('Location: myAccount.php');
		}
		else
		{
			echo $sql;
		}
	}
}
else
	echo ___ERROR___;