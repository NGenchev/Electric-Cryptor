<?php
  session_start();
  if(!isset($_SESSION['logged']) && $_SESSION['logged'] == FALSE) header("Location: entrance.php");
  require_once('includes/database_config.php');
?>
<!doctype html>
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
		<a href="myAccount.php" class="menu-item active-link"><i class="fa fa-user-circle-o" aria-hidden="true"></i> &nbsp; Моят профил</a>
		<a href="myPasswords.php" class="menu-item"><i class="fa fa-key" aria-hidden="true"></i> &nbsp; Моите пароли</a>
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
  	<div id="topbar">
	  	<div id="toggle-btn" onclick="toggleNav()"></div>
  		<div id="searchbar">
  			<input type="text" id='searchId' name="search" placeholder="Търсене..." />
  			<input type="submit" name="search_button" value=" " />
  		</div>
  	</div>
  	<div class="clear"></div>
	<div class="content">
		<!-- Header -->
		<div class="wrap">
		  <h2>Профилът на <?= $_SESSION['name'] ?></h2>
		  <small>
		    ПОСЛЕДЕН ВХОД: <coloured><?= $_SESSION['lastLogin'] ?></coloured>
		  </small>
		</div>

		  <div class="clear"></div>
		  <!-- Wrapper -->
		  <br>
		  <header>
		  <div class="wrapper">
		    <nav role="navigation">
			  <ul>
		        <li><a href="myAccount.php">ПРЕГЛЕД</a></li>
				<li><a href="editAccount.php">РЕДАКТИРАЙ ПРОФИЛА</a></li>
				<li><a href="changePassword.php">ПРОМЕНИ ПАРОЛА</a></li>
				<li><a href="changeAvatar.php">СМЕНИ АВАТАР</a></li>
				<li class="active"><a class="active" href="deactivate.php">ИЗТРИЙ АКАУНТ</a></li>
		      </ul>
		    </nav>
		</div>
		</header>
		<br>
		</div>
		<!-- Registration -->
	<center>
		<div class="content2">
		<div class="container2-login">
			<div id='messageBox' style='width: 785px!important;' class="info-msg">
				 <i style='font-size: 19px' class="fa fa-info-circle"></i>&nbsp; <i> Изтриването на акаунта води до изтрване на ВСИЧКИ ваши съхранени пароли в нашата база от данни. Веднъж изтрити те не могат да се възстановят и могат само и единствено да се добавят отново след регистрация в сайта!!! </i>
			</div>
			<div class="login">
			  <h2 class="login-header">ИЗТРИВАНЕ НА АКАУНТА</h2>
			  <form method='POST' id='deactivate' name='deactivate' class="login-container">
					<p><input name='pass' type="password" placeholder="Парола"></p>
					<p><input name='pass1' type="password" placeholder="MASTER Парола"></p>
					<p><input name='pass2' type="password" placeholder="Потвърдете MASTER Парола"></p>
					<p><input type='checkbox' id='agreee' name='agree' /> Съгласен съм с акаунта ми да бъдат изтрити ВСИЧКИ пароли от акаунта ми!</p>
			    <p><input type="submit" onclick='sure();' name='deactivate' value="ИЗТРИЙ АКАУНТА"></p>
			  </form>
			  <script>
				function sure()
				{
					if($("#agreee").is(':checked') != true)
					{
						alert("За да изтриете акаунта си трябва да се съгласите заедно с него да бъдат изтрити всички ваши пароли и данни!");
						return false;
					}
				}
			  </script>
			  <?php 
				if(isset($_POST['deactivate']))
				{
					$nPass 	= encrypt($_POST['pass']);
					$mPass 	= encrypt($_POST['pass1']);
					$mPass2 = encrypt($_POST['pass2']);
					$userID = $_SESSION['uID'];
					
					if($mPass === $mPass2):
						$sql = "SELECT * FROM users WHERE `user_id` = '$userID' AND `user_password` = '$nPass' AND `user_mPassword` = '$mPass'";
						$res = $dbh->prepare($sql);
						$res->execute();
						$counter = $res->rowCount();
						if($counter == 1)
						{
							$sql = "DELETE FROM users WHERE user_id = '$userID'";
							$res = $dbh->prepare($sql);
							$res->execute();
							
							if($res->rowCount()==1)
							{
								echo "Вашият акаунт е деактивиран и повече няма да фигурира в нашата БД!";
								if(session_destroy())
									echo "<script> var timer = setTimeout(function() {
											window.location='myAccount.php'
										}, 2000);</script>";
							}
						}
						else
							echo "Проблем с изтриването на акаунт, моля свържете се с администратор! <BR>";
					endif;
				}
			  ?>
			</div>
		</div>
	</div>
	</center>
		<!-- Footer -->
		<footer>
		  All Rights Reserved <coloured>&copy;</coloured> Electric Crypter
		</footer>
	</div>
  </body>
</html>
