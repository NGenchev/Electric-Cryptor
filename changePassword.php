<?php
  session_start();
  if(!isset($_SESSION['logged']) && $_SESSION['logged'] == FALSE) header("Location: entrance.php");
  require_once('includes/database_config.php');

  $uID = $_SESSION['uID']; 
  $res = $dbh->prepare("SELECT * FROM users WHERE user_id = '$uID'");
  $res->execute();
  $res = $res->fetchAll();
  $active = $res[0]['user_activated'];
  
  if(isset($_POST['changeNow']))
  {
    $pass     = encrypt($_POST['nowPass']);
    $newPass  = encrypt($_POST['newPass2']);
    $confPass = encrypt($_POST['newPassConf']);
    $us_ID    = $_SESSION['uID'];
    $query = "SELECT * FROM users WHERE user_id = '$us_ID' AND user_password = '$pass'";
    $res = $dbh->prepare($query);
    $res->execute();
    $count = $res->rowCount();
    if($count == 1)
    {
      if($newPass == $confPass)
      {
        $query = "UPDATE users SET `user_password` = '$newPass' WHERE user_id = '$us_ID'";
        $res = $dbh->prepare($query);
        $res->execute();
        $count = $res->rowCount();
        if($count == 1)
        {
          $message_cN = array(
              'changed' => true,
			  'type' => "success",
              'message' => "Успешно сменихте паролата си за вход!"
          );
        } // if success db update query
        else
        {
          $message_cN = array(
              'changed' => false,
			  'type' => "error",
              'message' => "Проблем с БД!"
          );
        } // if not success db update query
      } // if confirm pass equals new pass;
      else
      {
        $message_cN = array(
            'changed' => false,
			'type' => "warning",
            'message' => "Въведохте две различни нови пароли! <BR> $newPass <BR> $confPass <BR> "
        );
      } // if not confirm pass equals new pass;
    }  // if  enter right password
    else
    {
      $message_cN = array(
          'changed' => false,
		  'type' => "error",
          'message' => "Въведохте грешна СЕГАШНА парола!"
      );
    } // if not enter right password
  }
  
  
  //// CHANGE MASTER PASSWORD
  
  if(isset($_POST['changeMaster']))
  {
    $pass     = encrypt($_POST['nowMPass']);
    $newPass  = encrypt($_POST['newMPass2']);
    $confPass = encrypt($_POST['newMPassConf']);
    $us_ID    = $_SESSION['uID'] ?? 1;
    $query = "SELECT * FROM users WHERE user_id = '$us_ID' AND user_mPassword = '$pass'";
    $res = $dbh->prepare($query);
    $res->execute();
    $count = $res->rowCount();
    if($count == 1)
    {
      if($newPass == $confPass)
      {
        $query = "UPDATE users SET `user_mPassword` = '$newPass' WHERE user_id = '$us_ID'";
        $res = $dbh->prepare($query);
        $res->execute();
        $count = $res->rowCount();
        if($count == 1)
        {
          $message_cN = array(
              'changed' => true,
			  'type' => "success",
              'message' => "Успешно сменихте MASTER паролата си!"
          );
        } // if success db update query
        else
        {
          $message_cN = array(
              'changed' => false,
			  'type' => "error",
              'message' => "Проблем с БД!"
          );
        } // if not success db update query
      } // if confirm pass equals new pass;
      else
      {
        $message_cN = array(
            'changed' => false,
			'type' => "warning",
            'message' => "Въведохте две различни нови пароли!"
        );
      } // if not confirm pass equals new pass;
    }  // if  enter right password
    else
    {
      $message_cN = array(
          'changed' => false,
		  'type' => "error",
          'message' => "Въведохте грешна СЕГАШНАТА си MASTER парола!"
      );
    } // if not enter right password
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
    	<div class="user-image" style="background: url('<?= $_SESSION['avatar'] ?? "images/avatar.png" ?>') no-repeat; background-size: contain; background-position: 50% 50%;"></div>
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
		    ПОСЛЕДЕН ВХОД: <coloured> <?= $_SESSION['lastLogin'] ?></coloured>
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
				<li class="active"><a class="active" href="changePassword.php">ПРОМЕНИ ПАРОЛА</a></li>
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
			<div id='messageBox' style='width: 785px!important;' class="<?php echo $message_cN['type']; ?>-msg">
		  <?php 
		  if(isset($message_cN['type'])){
			  $type = $message_cN['type'];
			  if($type == "success") echo '<i class="fa fa-check"></i>&nbsp;';
				elseif($type == "warning") echo '<i class="fa fa-warning"></i>&nbsp;';
					elseif($type == "error") echo '<i class="fa fa-times-circle"></i>&nbsp;';
		  }
		  echo $message_cN['message']; 
		  ?>
		</div>
      <div class="login">
        <h2 class="login-header">Смени паролата за вход</h2>

        <form method='POST' class="login-container">
          <p><input type="password" name='nowPass' placeholder="Сегашна парола"></p>
          <p><input type="password" name='newPass2' placeholder="Нова парола"></p>
          <p><input type="password" name='newPassConf' placeholder="Потвърдете новата парола"></p>
          <p><input type="submit" name='changeNow' value="СМЕНИ ПАРОЛАТА"></p>
        </form>
      </div>
      <!-- LOGIN -->
      <div class="login">
        <h2 class="login-header">Смени MASTER Паролата</h2>

        <form method='POST' class="login-container">
          <p><input type="password" name='nowMPass' placeholder="Сегашна MASTER парола"></p>
          <p><input type="password" name='newMPass2' placeholder="Нова MASTER парола"></p>
          <p><input type="password" name='newMPassConf' placeholder="Потвърдете новата MASTER парола"></p>
          <p><input type="submit" name='changeMaster' value="СМЕНИ MASTER ПАРОЛАТА"></p>
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
