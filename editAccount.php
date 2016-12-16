<?php
  session_start();
  if(!isset($_SESSION['logged']) && $_SESSION['logged'] == FALSE) header("Location: entrance.php");
  require_once('includes/database_config.php');

	if(isset($_POST['save']))
	{
		extract($_POST);
		$real_name = htmlspecialchars(strip_tags(addslashes($real_name)));
		$city = htmlspecialchars(strip_tags(addslashes($city)));
		$description = htmlspecialchars(strip_tags(addslashes($description)));
		$sql = "UPDATE users SET user_realName = '{$real_name}', user_city = '{$city}', user_description = '{$description}' WHERE user_id = '{$_SESSION['uID']}'";
		$res = $dbh->prepare($sql);
		$res->execute();
		if($res->rowCount() == 1)
		{
			$message = array(
			  "register" => true,
			  "type"  => "success",
			  "message" => "Успешно редактирахте профила си."
			); // Send our email
		}
		else
		{
			$message = array(
			  "register" => true,
			  "type"  => "error",
			  "message" => "Не сте променили нищо!"
			); // Send our email
		}
	}
	
	{
		$sql = "SELECT * FROM users WHERE user_id = '{$_SESSION['uID']}'";
		$prep = $dbh->prepare($sql);
		$prep->execute();
		$rows = $prep->fetchAll();
		$row = $rows[0];
	}
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
				<li class="active"><a class="active" href="editAccount.php">РЕДАКТИРАЙ ПРОФИЛА</a></li>
				<li><a href="changePassword.php">ПРОМЕНИ ПАРОЛА</a></li>
				<li><a href="changeAvatar.php">СМЕНИ АВАТАР</a></li>
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
			<div id='messageBox' style='width: 65% !important;' class="<?php echo $message['type']; ?>-msg">
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
			  <h2 class="login-header">РЕДАКТИРАНЕ НА ПРОФИЛА</h2>

			  <form method= 'post' class="login-container">
					<p><input name='real_name' type="text" value='<?= $row['user_realName'] ?>' placeholder="Три Имена"></p>
					<p><input name='city' type="text" value='<?= $row['user_city'] ?>' placeholder="Град"></p>
					<p><textarea name='description' placeholder="Описание/допълнителна информация..."><?= $row['user_description'] ?></textarea></p>
			    <p><input type="submit" name='save' value="ЗАПИШИ ПРОМЕНИТЕ"></p>
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
