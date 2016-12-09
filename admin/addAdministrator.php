<?php
  session_start();
  require_once('../includes/database_config.php');
  if($_SESSION['type'] != 1 || $_SESSION['logged'] !== TRUE || !isset($_SESSION)) header('Location: ../index.php');
  
  if(isset($_POST['add']))
  {
	$user = $_POST['username'];  
	$sql = "UPDATE users SET user_type = '1' WHERE user_name = '$user'";
	$res = $dbh->prepare($sql);
	$res->execute();
	$count = $res->rowCount();
	if($count == 1)
	{
		$message = array(
		  "type" => "success",
		  "message" => "Успешно добавихте администратор!"
		);
	}
	else
	{
		$message = array(
		  "type" => "error",
		  "message" => "Такъв потребител не съществува или вече е администратор!!"
		);
	}
  }
?>
<!doctype html>
<html>
<head>
	<meta charset="utf-8" />
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Secret Password Manager</title>
	<link rel="stylesheet" type="text/css" href="../styles/style-1.css">
	<link rel="stylesheet" type="text/css" href="../styles/font-awesome.min.css">
	<script src='../js/jquery.min.js'></script>
	<script src="../js/search.js"></script>
	<script src="../js/toggle-side.js"></script>
</head>
<body>
	<div class="main">
    <div id="_side-panel" class="side-panel">
    	<div class="user-image" style="background: url('<?= $_SESSION['avatar'] ?? "../imgs/avatar.png" ?>') no-repeat; background-size: contain; background-position: 50% 50%;"></div>
		<span class="user-name"><?= $_SESSION['name'] ?></span>
		<hr class="separator">
		<span class="menu-cat">Потребителски панел</span>
		<a href="../index.php" class="menu-item "><i class="fa fa-home" aria-hidden="true"></i> &nbsp; Начало</a>
		<a class="menu-item" href="../myAccount.php"><i class="fa fa-user-circle-o" aria-hidden="true"></i> &nbsp; Моят профил</a>
		<a class="menu-item" href="../myPasswords.php"><i class="fa fa-key" aria-hidden="true"></i> &nbsp; Моите пароли</a>
		<a class="menu-item" href="../logout.php"><i class="fa fa-sign-out" aria-hidden="true"></i> &nbsp; Изход</a>
		<hr class="separator">
		<span class="menu-cat">Администраторски панел</span>
		<a href="administrators.php" class="menu-item active-link"><i class="fa fa-code" aria-hidden="true"></i> &nbsp; Администратори</a>
		<a href="users.php" class="menu-item"><i class="fa fa-users" aria-hidden="true"></i> &nbsp; Потребители</a>
		<a href="passwords.php" class="menu-item"><i class="fa fa-shield" aria-hidden="true"></i> &nbsp; Пароли</a>
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
		        <li><a href="administrators.php">ПРЕГЛЕД НА АДМИНИСТРАТОРИТЕ</a></li>
				<li class="active"><a href="addAdministrator.php" class="active">ДОБАВИ АДМИНИСТРАТОР</a></li>
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
			<div class="login">
			  <h2 class="login-header">ДОБАВИ АДМИНИСТРАТОР</h2>

			  <form method='POST' class="login-container">
					<p><input type="text" name='username' placeholder="Потребителско Име"></p>
					<p><input type="submit" name='add' value="ДОБАВИ АДМИНИСТРАТОР"></p>
			  </form>
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
