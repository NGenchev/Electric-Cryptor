<?php
  session_start();
  require_once('../includes/database_config.php');
  if($_SESSION['type'] != 1 || $_SESSION['logged'] !== TRUE || !isset($_SESSION)) header('Location: ../index.php');
?>
<!doctype html>
<html>
<head>
	<meta charset="utf-8" />
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Security Password Manager</title>
	<link rel="stylesheet" type="text/css" href="../styles/style-1.css">
	<link rel="stylesheet" type="text/css" href="../styles/font-awesome.min.css">
	<script src='../js/jquery.min.js'></script>
	<script src="../js/toggle-side.js"></script>
	<script src="../js/search.js"></script>
</head>
<body>
	<div class="main">
    <div id="_side-panel" class="side-panel">
    	<div class="user-image" style="background: url('<?= $_SESSION['avatar'] ?? "../imgs/avatar.png" ?>') no-repeat; background-size: contain; background-position: 50% 50%;"></div>
		<span class="user-name"><?= $_SESSION['name'] ?></span>
		<hr class="separator">
		<span class="menu-cat">Потребителски панел</span>
		<a href="../index.php" class="menu-item"><i class="fa fa-home" aria-hidden="true"></i> &nbsp; Начало</a>
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
		        <li class="active"><a href="administrators.php" class="active">ПРЕГЛЕД НА АДМИНИСТРАТОРИТЕ</a></li>
				<li><a href="addAdministrator.php">ДОБАВИ АДМИНИСТРАТОР</a></li>
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
			<table>
			     <thead>
			       <tr style="font-weight: normal;">
			         <th>ID</th>
					 <th>Потребителско име</th>
					 <th>Общо пароли</th>
					 <th>Последно влизане</th>
					 <th>Премахни от поста</th>
			       </tr>
			     <thead>
			     <tbody>
					<?php 
						$sql = "SELECT * FROM users WHERE user_type = '1' ORDER BY user_id ASC";
						$res = $dbh->prepare($sql);
						$res->execute();
						$rows = $res->fetchAll(PDO::FETCH_OBJ);
						foreach($rows as $row)
						{
							$sql = "select * from passwords where pw_uID = '{$row->user_id}'";
							$res = $dbh->prepare($sql);
							$res->execute();
							$count = $res->rowCount();
							
							echo '
							<tr>
								<td>'. $row->user_id .'</td>
									<td>'. $row->user_name .'</td>
									<td>'. $count .'</td>
									<td>'. $row->user_lastLogin .'</td>
									<td>
									<button onclick="removeAdmin('. $row->user_id .');" class="edit" style="width: 25%"><i class="fa fa-times"></i></button>
								</td>
						   </tr>';
						}
					?>
			     </tbody>
			   <table/>
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
