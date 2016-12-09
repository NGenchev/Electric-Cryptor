<?php
  session_start();
  if(!isset($_SESSION['logged']) && $_SESSION['logged'] == FALSE) header("Location: entrance.php");
  require_once('includes/database_config.php');

  if(isset($_GET['pwID']) && (int)$_GET['pwID']>=1)
  {
    $id = (int)$_GET['pwID'];
    $uID = $_SESSION['uID'];
    $sql = "SELECT * FROM passwords WHERE pw_uID = '$uID' AND pw_id = '$id'";
    $res = $dbh->prepare($sql);
    $res->execute();
    $count = $res->rowCount();
    if($count == 0)
      die("<script>alert('Това не е ваша парола...');location.replace('myPasswords.php');</script>");
    else
    {
      $res = $res->fetch(PDO::FETCH_OBJ);
      $site = $res->pw_site;
      $user = $res->pw_user;
    }
  }
  
  if(isset($_POST['edit'])):
	$uID        = $_SESSION['uID'];
	$masterPw   = $_POST['u_MasterPW'];
	$masterPw   = encrypt($masterPw);
	$sql = "SELECT * FROM users WHERE user_id = '$uID' AND user_mPassword = '$masterPw'";
	$masterValid = FALSE;
	if($dbh->prepare($sql)->execute())
	  $masterValid = TRUE;
	else
	  $masterValid = FALSE;
	$id         = $_POST['pwd_ID'];
	$siteName   = $_POST['pw_url'];
	$username   = $_POST['pw_username'];
	if($username != NULL) 
		$username = encrypt_uPwds($username);
	else
		$username = encrypt_uPwds($_POST['txtnm']);
	$password   = $_POST['pw_password'];
	$password2  = $_POST['pw_password2'];
	if($password === $password2 && $masterValid === TRUE) {
	  $password = encrypt_uPwds($password);
	  $sql = "UPDATE passwords SET `pw_site`='$siteName', `pw_user`='$username', `pw_content`='$password' WHERE `pw_id`='$id'";
	  if($dbh->prepare($sql)->execute())
		$message = array(
			"type" => "success",
			"message" => "Успешно променихте парола!"
		);
	  else
		$message = array(
			"type" => "error",
			"message" => "Проблем с БД!"
		);
	} // if passwords match
	else
	  $message = array(
			"type" => "warning",
			"message" => "Некоректни данни (MASTER парола или несъвпадание на паролите)!"
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
  	<div id="topbar">
	  	<div id="toggle-btn" onclick="toggleNav()"></div>
  		<div id="searchbar">
  			<input type="text" name="search" placeholder="Търсене..." />
  			<input type="submit" name="search_button" value=" " />
  		</div>
  	</div>
  	<div class="clear"></div>
	<div class="content">

		  <div class="clear"></div>
		  <!-- Wrapper -->
		  <br>
		  <header>
		  <div class="wrapper">
		    <nav role="navigation">
		      <ul>
		        <li class="active"><a href="#" class="active">Промяна на парола</a></li>
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
			  <h2 class="login-header">ПРОМЕНИ ПАРОЛА</h2>

			  <form method='POST' class="login-container">
				 <input type='hidden' name='pwd_ID' value='<?= (int)$_GET['pwID'] ?>' />
				 <input type='hidden' name='txtnm' value='<?= decrypt_uPwds($user) ?>' />
					<p><input type="text" name='pw_url' value='<?= $site ?>' placeholder="http://facebook.com"></p>
					<p><input type="text" name='pw_username' value='' placeholder="Ново потребителско име(остави празно, ако не искаш да го сменяш)"></p>
					<p><input type="password" name='pw_password' placeholder="Парола"></p>
					<p><input type="password" name='pw_password2' placeholder="Потвърди новата парола"></p>
					
					<p><span style='font: 8.5pt "Verdana'>(*въведи за промяна или изтриване на парола)</span></p>
					<p><input type="password" name='u_MasterPW' placeholder="MASTER Парола"></p>
			    <p><input type="submit" name='edit' value="ПРОМЕНИ"></p>
			  </form>
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
