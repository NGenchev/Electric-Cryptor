<?php 
  session_start();
  if(!isset($_SESSION['logged']) && $_SESSION['logged'] == FALSE) header("Location: entrance.php");
  require_once('includes/database_config.php');

  $uID = $_SESSION['uID']; 
  $res = $dbh->prepare("SELECT * FROM users WHERE user_id = '$uID'");
  $res->execute();
  $res = $res->fetchAll();
  $active = $res[0]['user_activated'];
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
<div style="">
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
		  <h2>Профилът на <?= $_SESSION['name']; ?></h2>
		  <small>
		    ПОСЛЕДЕН ВХОД: <coloured><?= $_SESSION['lastLogin']; ?></coloured>
		  </small>
		</div>

		  <div class="clear"></div>
		  <!-- Wrapper -->
		  <br>
		  <header>
		  <div class="wrapper">
		    <nav role="navigation">
			  <ul>
		        <li class="active"><a class="active" href="myAccount.php">ПРЕГЛЕД</a></li>
				<li><a href="editAccount.php">РЕДАКТИРАЙ ПРОФИЛА</a></li>
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
			<table>
	     <thead>
	       <tr>
	         <th colspan="2">Допълнителна информация<a href="editAccount.php" class="edit"><i class="fa fa-pencil" aria-hidden="true"></i> Редактирай </a></th>
	       </tr>
	     <thead>
		 <?php 
			$sql = "SELECT * FROM users WHERE user_id = '{$_SESSION['uID']}'";
			$prep = $dbh->prepare($sql);
			$prep->execute();
			$rows = $prep->fetchAll();
			$row = $rows[0];
			
			$sql = "SELECT * FROM passwords WHERE pw_uID = '{$_SESSION['uID']}'";
			$prep = $dbh->prepare($sql);
			$prep->execute();
			$count = $prep->rowCount();
		 ?>
	     <tbody>
	       <tr>
	         <td><strong>Цяло име: </strong></td>
	         <td><?= $row['user_realName'] ?></td>
	       </tr>
	          <tr>
	         <td><strong>Град/село: </strong></td>
	         <td><?= $row['user_city'] ?></td>
	       </tr>
	          <tr>
	         <td><strong>Брой запазени пароли: </strong></td>
	         <td><?= $count ?></td>
	       </tr>
	          <tr>
	         <td><strong>Статус на акаунта: </strong></td>
	         <td><?= $row['user_activated'] ? "ПОТВЪРДЕН" : "НЕПОТВЪРДЕН"; ?></td>
	       </tr>
	         <tr>
	        <td><strong>Допълнително описание: </strong></td>
	        <td> <?= $row['user_description']; ?> </td>
	      </tr>
	      <tr>
	     <td><strong>Тип на акаунта: </strong></td>
	     <td style='text-transform: capitalize;'><?= $row['user_type'] == 1 ? "Администратор" : "Потребител" ?></td>
	   </tr>
	     <tr>
	    <td><strong>Последно влизане в акаунта: </strong></td>
	    <td><?= $_SESSION['lastLogin'] ?></td>
	  </tr>
	     </tbody>
	   <table/>
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
