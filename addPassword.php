<?php
  session_start();
  require_once('includes/database_config.php');
  if(!isset($_SESSION['logged']) && $_SESSION['logged'] !== true) header('Location: entrance.php');

  $uID = $_SESSION['uID'];
  $res = $dbh->prepare("SELECT * FROM users WHERE user_id = '$uID'");
  $res->execute();
  $res = $res->fetchAll();
  $active = $res[0]['user_activated'];
  if($active != TRUE)
    echo "<script>alert('Моля първо потвърдете емайла си, за да добавяте пароли!');location.replace('myPassword.php');</script>";

  if(isset($_POST['add']) && $active == TRUE):
	$siteName = $_POST['url'];
	$username = encrypt_uPwds($_POST['username']);
	$password = encrypt_uPwds($_POST['password']);
	$uID      = $_SESSION['uID'];
	$sql = "INSERT INTO passwords (`pw_uID`, `pw_site`, `pw_user`, `pw_content`) VALUES ('$uID', '$siteName', '$username', '$password')";

	if($dbh->prepare($sql)->execute())
		 $message = array(
			"type" => "success",
			"message" => "Успешно добавихте парола!"
		);
	else
	   $message = array(
			"type" => "error",
			"message" => "Проблем с БД!!"
		);
  endif;
?>
<!doctype html>
<html>
<head>
	<meta charset="utf-8" />
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Secured Password Manager</title>
	<link rel="stylesheet" type="text/css" href="styles/style-1.css">
	<link rel="stylesheet" type="text/css" href="styles/font-awesome.min.css">
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
	<script src="js/toggle-side.js"></script>
	<script src="js/search.js"></script>
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
		  <h2>Добавяне на нова парола</h2>
		</div>
		  <div class="clear"></div>
		  <!-- Wrapper -->
		  <br>
		  <header>
		  <div class="wrapper">
		    <nav role="navigation">
		      <ul>
		        <li><a href="myPasswords.php">ПРЕГЛЕД НА ПАРОЛИТЕ</a></li>
				<li class="active"><a href="addPassword.php" class="active">ДОБАВЯНЕ НА ПАРОЛА	</a></li>
		      </ul>
		    </nav>
		</div>
		</header>
		<br>
		</div>
		<!-- Table -->
		<div class="content2">
			<div class="container2-login">
				<div id='messageBox' style='width: 380px!important;' class="<?= $message['type'] ?>-msg">
				  <?php 
				  if(isset($message['type'])){
					  $type = $message['type'];
					  if($type == "success") echo '<i class="fa fa-check"></i>&nbsp;';
						elseif($type == "warning") echo '<i class="fa fa-warning"></i>&nbsp;';
							elseif($type == "error") echo '<i class="fa fa-times-circle"></i>&nbsp;';
				  }
				  echo $message['message']; 
				  ?>
				</div>
				<center>
				<div class="login">
					<h2 class="login-header">ДОБАВЯНЕ НА ПАРОЛА</h2>
					<form method='post' class="login-container">
						<p><input type="text" name='url' placeholder="Сайт"></p>
						<p><input type="text" name='username' placeholder="Потребителско Име"></p>
						<p><input type="password" name='password' placeholder="Парола"></p>
						<p><input type="submit" name='add' value="ДОБАВИ ПАРОЛА"></p>
					</form>
				</div>
			</center>
			</div>
		</div>
	</div>
		<!-- Footer -->
		<footer>
		  Всички права са запазени &copy; 2016-2017 Design &amp; Code By Electric Crew
		</footer>
	</div>

</div>
    </body>
</html>
