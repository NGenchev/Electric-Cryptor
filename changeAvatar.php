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
	<script src='http://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.min.js'></script>
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
		<a href="myAccount.php" class="menu-item  active-link"><i class="fa fa-user-circle-o" aria-hidden="true"></i> &nbsp; Моят профил</a>
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
  			<input type="text" name="search" placeholder="Търсене..." />
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
				<li class="active"><a href="changeAvatar.php" class="active">СМЕНИ АВАТАР</a></li>
				<li><a href="deactivate.php">ИЗТРИЙ АКАУНТ</a></li>
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
			<div class="login">
			  <h2 class="login-header">Смени Аватара</h2>

			  <form method='post' class="login-container">
				<img src='<?= $_SESSION['avatar']; ?>' width='150' height='150' alt='Empty avatar'/>
				<p><input type="url" name='urlAvatar' placeholder="Линк"></p>
			    <p><input type="submit" value="СМЕНИ АВАТАРА" name='changeAvatar'></p>
			  </form>
			  <?php
				if(isset($_POST['changeAvatar']))
				{
				  $url = $_POST['urlAvatar'];
				  
				  if(filter_var($url, FILTER_VALIDATE_URL) == true) 
				  {
					  $uID = $_SESSION['uID'];
					  $sql = "UPDATE users SET `user_avatar` = '$url' WHERE user_id = '$uID'";
					  $res = $dbh->prepare($sql);
					  $res->execute();
					  $count = $res->rowCount();
					  if($count == 1)
					  {
						echo "Успешно сменихте аватара си!";
						$_SESSION['avatar'] = $url;
					  }
					  else
						echo "Проблем със смяната на аватара...";
				  }
				  else
					echo "Не се прави на хакер, няма да ти се получи! ;)";
				 
				}
			  ?>
			</div>
		</div>
		</div>
	</center>
		<!-- Footer -->
		<footer>
		  Всички права са запазени &copy; 2016-2017 Design &amp; Code By Electric Crew
		</footer>
	</div>
    </body>
</html>
