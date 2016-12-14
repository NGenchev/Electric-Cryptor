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

if(___ERROR___ === 0 || isset($_POST['change']))
{
	require_once('includes/database_config.php');
	if(isset($_POST['change']))
	{
		extract($_POST);
		$first_pass = encrypt($first_pass);
		$sec_pass 	= encrypt($sec_pass);
		if($first_pass === $sec_pass)
		{
			$pass = $first_pass;
			$sql = "UPDATE users SET user_password = '$pass', user_hash = '' WHERE user_email = '$email' AND user_hash = '$hash'";
			$res = $dbh->prepare($sql);
			if($res->execute())
				header('Location: myAccount.php');
		}
		else
		echo "Passwords doesn`t match.";
	}
	else
	{
		$email = $_GET['email'];
		$hash  = $_GET['hash'];

		$sql = "SELECT * FROM users WHERE user_email = '$email' AND user_hash = '$hash' LIMIT 1";
		$query = $dbh->prepare($sql);
		$query->execute();
		$count = $query->rowCount();
		if($count === 1)
		{?><!doctype html>
<html>
<head>
	<meta charset="utf-8" />
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Secured Password Manager</title>
	<link rel="stylesheet" type="text/css" href="styles/style-1.css">
	<link rel="stylesheet" type="text/css" href="styles/font-awesome.min.css">
	<script src='js/jquery.js'></script>
	<script src="js/toggle-side.js"></script><script src="js/search.js"></script>
</head>
<body>
	<div class="main">
    <div id="_side-panel" class="side-panel">
    	<div class="user-image" style="background: url('<?= $_SESSION['avatar'] ?? "imgs/avatar.png" ?>') no-repeat; background-size: contain; background-position: 50% 50%;"></div>
		<span class="user-name"><?= $_SESSION['name'] ?></span>
		<hr class="separator">
		<span class="menu-cat">Потребителски панел</span>
		<a href="index.php" class="menu-item"><i class="fa fa-home" aria-hidden="true"></i> &nbsp; Начало</a>
		
	<?php if(isset($_SESSION['logged']) && $_SESSION['logged'] === true) : ?>
		<a href="myAccount.php" class="menu-item"><i class="fa fa-user-circle-o" aria-hidden="true"></i> &nbsp; Моят профил</a>
		<a href="myPasswords.php" class="menu-item active-link"><i class="fa fa-key" aria-hidden="true"></i> &nbsp; Моите пароли</a>
		<a href="logout.php" class="menu-item"><i class="fa fa-sign-out" aria-hidden="true"></i> &nbsp; Изход</a>
	<?php else : ?>
		<a href="entrance.php" class="menu-item"><i class="fa fa-user-circle-o" aria-hidden="true"></i> &nbsp; Влез в системата</a>
	<?php endif; ?>
		
	<?php if ($_SESSION['type'] === 1) : ?>
		<hr class="separator">
		<span class="menu-cat">Администраторски панел</span>
		<a href="admin/administrators.php" class="menu-item"><i class="fa fa-code" aria-hidden="true"></i> &nbsp; Администратор</a>
		<a href="admin/users.php" class="menu-item"><i class="fa fa-users" aria-hidden="true"></i> &nbsp; Потребители</a>
		<a href="admin/passwords.php" class="menu-item"><i class="fa fa-shield" aria-hidden="true"></i> &nbsp; Пароли</a>
	<?php endif; ?>
	</div>
<div style="">
  	<div id="topbar">
	  	<div id="toggle-btn" onclick="toggleNav()"></div>
  		<div id="searchbar">
  			<input type="text" name="search" placeholder="Търсене..." />
  			<input type="submit" name="search_button" value=" " />
  		</div>
  	</div>
  	<div class="clear"></div>
	<div class="content">
		<!-- Header -->
		<div class="wrap">
		  <h2>Преглед на парола за Facebook</h2>
		  <small>
		    ДОБАВЕНА НА: <coloured>ДАТА</coloured>
		    &bull;
		    ПОСЛЕДЕН ПРЕГЛЕД: <coloured>ДАТА</coloured>
		  </small>
		</div>

		  <div class="clear"></div>
		  <!-- Wrapper -->
		  <br>
		  <header>
		  <div class="wrapper">
		    <nav role="navigation">
		      <ul>
		        <li><a href="#">РЕГИСТРАЦИЯ / ВХОД В СИСТЕМАТА</a></li>
		        <li class="active"><a href="#" class="active">ЗАБРАВЕНА ПАРОЛА</a></li>
		      </ul>
		    </nav>
		</div>
		</header>
		<br>
		</div>
		<!-- Registration -->
	<center>
		<div class="content2">
			<div class="login">
			  <h2 class="login-header">Забравена Парола</h2>

			  <form class="login-container" method='POST'>
				<input type='hidden' value='<?= $email ?>' name='email' />
				<input type='hidden' value='<?= $hash ?>' name='hash' />
				<p><input name='first_pass' type="password" placeholder="Парола"></p>
			    <p><input name='sec_pass' type="password" placeholder="Парола"></p>
			    <p><input name='change' type="submit" value="ИЗПРАТИ"></p>
			  </form>
			</div>
	</div>
</center>
	</div>
		<!-- Footer -->
		<footer>
		  Всички права са запазени &copy; 2016-2017 Design &amp; Code By Electric Crew
		</footer>
	</div>

</div>
    </body>
</html>
<?php
		}
	}
}
else
	echo ___ERROR___;