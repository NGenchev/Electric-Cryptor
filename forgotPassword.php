<?php
  session_start();
  if(isset($_SESSION['logged']) && $_SESSION['logged'] == TRUE) header("Location: myPasswords.php");
  require_once('includes/database_config.php');

  if(isset($_POST['forgot']))
  {
    $email  = $_POST['email'];
    $user   = $_POST['username'];
    $sql = "SELECT * FROM users WHERE user_name = '$user' AND user_email = '$email' AND user_hash = ''";
    $res = $dbh->prepare($sql);
    $res->execute();
    $count = $res->rowCount();
    if($count == 1)
    {
        $hash = md5(time()-mt_rand(1000, 100000));

        $sql = "UPDATE users SET user_hash = '$hash' WHERE user_email = '$email' AND user_name = '$user'";
        $res = $dbh->prepare($sql)->execute();

        $to   = $email; // Send email to our user
              $subject = 'Security PM | Потвърждение за забравена парола'; // Give the email a subject 
              $message = '
               
              Направихте заявка за забравена парола, ако наистина сте си забравили паролата,
              влезте в този лник и изберете нова парола
               
              ------------------------
              Моля кликнете, за да потвърдите,че сте си забравили акаунта:
              http://www.electric-crew.top/forgotPassword_Step2.php?email='.$email.'&hash='.$hash.'
              ------------------------
               
              Ако не сте пускали заявка за забравена парола кликнете тук:
              http://www.electric-crew.top/forgotPassword_Wrong.php?email='.$email.'&hash='.$hash.'
               и сменете вашата парола след това!
			   
			   
			  ============================================================================================
			  Ako imate problem s kodirovkata i ne razchitate gorniqt text poglednete tozi: 
			  ============================================================================================
			  
			  Napravihte zayavka za zabravena parola, ako naistina ste si zabravili parolata,
              vlezte v tozi lnik i izberete nova parola
               
              ------------------------
              Molya kliknete, za da potvardite,che ste si zabravili akaunta:
              http://www.electric-crew.top/forgotPassword_Step2.php?email='.$email.'&hash='.$hash.'
              ------------------------
               
              Ako ne ste puskali zayavka za zabravena parola kliknete tuk:
              http://www.electric-crew.top/forgotPassword_Wrong.php?email='.$email.'&hash='.$hash.'
               i smenete vashata parola sled tova!
			   
              '; // Our message above including the link
                                   
              $headers = 'From:noreply@electric-crew.top' . "\r\n"; // Set from headers
              
              if(mail($to, $subject, $message, $headers))
                $message = array(
                  "type" => "success",
                  "message" => "Получихте емайл за допълнителна информация, за възстановяването на паролата..."
                ); // Send our email

              // EMAIL SEND
    }
	else
		$message = array(
                  "type" => "error",
                  "message" => "Въведени са невалидни данни!"
                ); // Send our email
 } 
?>
<!doctype html>
<html>
<head>
	<meta charset="utf-8" />
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Security Password Manager</title>
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
		  <header>
		  <div class="wrapper">
		    <nav role="navigation">
		      <ul>
		        <li><a href="entrance.php">РЕГИСТРАЦИЯ / ВХОД В СИСТЕМАТА</a></li>
		        <li class="active"><a href="" class="active">ЗАБРАВЕНА ПАРОЛА</a></li>
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
			  <h2 class="login-header">Забравена Парола</h2>
				
			  <form method='POST' class="login-container">
				<p><input name="username" type="text" placeholder="Потребителско Име"></p>
			    <p><input name="email" type="email" placeholder="Имейл"></p>
				<p style="width: 96.5%;"> 
					<?php 
					  $x = mt_rand(1, 10); 
					  $y = mt_rand(1, 10);
					  $z = $x + $y; 
					  echo "<input type='hidden' name='captcha2' value = {$z} />"
					 ?>
					<label style="width: 20%;position: relative; display: inline-block; text-align: center" for="captcha"><?= "{$x} + {$y} = " ?></label>
					<input type="text" maxlength=2 max = 20 min = 2 style="display: inline-block;width: 72%; display: relative;" name="captcha" placeholder="Captcha">
				</p>
			    <p><input type="submit" value="ИЗПРАТИ" name="forgot" /></p>
			  </form>
			</div>
		</div>
	</center>
		<!-- Footer -->
		<footer>
		  All Rights Reserved &copy; Electric Crypter
		</footer>
	</div>
    </body>
</html>
