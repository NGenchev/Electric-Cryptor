<?php
  session_start();
  if(isset($_SESSION['logged']) && $_SESSION['logged'] == TRUE) header("Location: myPasswords.php");
  require_once('includes/database_config.php');

  if(isset($_POST['login']))
  {
     if(isset($_POST['captcha']) && $_POST['captcha'] == $_POST['captcha2'])
      {
      $user = $_POST['username'];
      $pass = encrypt($_POST['password']);
      $sql = "SELECT * FROM users WHERE (user_name = '$user' OR user_email = '$user') AND (user_password = '$pass') LIMIT 1";
      if($query = $dbh->prepare($sql))
      {
        $result = $query->execute();
        $count  = $query->rowCount();
        if($count === 1)
        {
            if(session_destroy()) session_start();
            $_SESSION['logged'] = TRUE;
            $data = $query->fetchAll();

            $_SESSION['avatar'] = $data[0]['user_avatar'];
            $_SESSION['name']   = $data[0]['user_name'];
            $_SESSION['uID']    = $data[0]['user_id'];
            $_SESSION['lastLogin'] = $data[0]['user_lastLogin'];
            $_SESSION['type']   = $data[0]['user_type'];

			$sql = "UPDATE users SET user_lastLogin = Now() WHERE user_id = '{$_SESSION['uID']}'";
			$result = $dbh->prepare($sql);
			$result->execute();

            $message_log = array(
              "login" => true,
			  "type"  => "success",
              "message" => "Успешно се вписахте в системата, след 5 секунди<BR>
               ще бъдете пренасочени към главната страница.
               <script type=\"text/javascript\">
				$('#messageBox').show(1500);
                function Redirect()
                {
                window.location=\"myPasswords.php\";
                } setTimeout('Redirect()', 5555);
              </script> "
            );
          }
      else
      {
          $message_log = array(
            "login" => false,
			"type"  => "error",
            "message" => "Неуспешен вход - потребителското име или паролата не са верни! <BR>"
          );
        }
      }
      else {
        $dbh=NULL;
      } // LOGIN CHECK
    }
    else
    {
      $message_log = array(
          "login" => false,
		  "type"  => "error",
          "message" => "Неуспешен вход - моля въведете сбора на числата коректно!"
        );
    } // captcha check
	unset($_POST);
  } //LOGIN SUBMIT

  if(isset($_POST['register']))
  {
    if(isset($_POST['captcha']) && $_POST['captcha'] == $_POST['captcha2'])
    {
		if(isset($_POST['agree']) && $_POST['agree'] == "true"){
      $user = $_POST['username'];
      $email = $_POST['email'];
      $err=0;
      if($user == NULL || $user == " " || strlen($user)<6)
      {
        $message_reg = array(
          "register" => false,
		  "type"  => "warning",
          "message" => "Въведете по-дълго име.."
        );
        $err++;
      }

      if($email == NULL || $email == " " || strlen($email)<3 || filter_var($email, FILTER_VALIDATE_EMAIL) === false)
      {
        $message_reg = array(
          "register" => false,
		  "type"  => "warning",
          "message" => "Въведете коректен емайл за потвърждение на акаунта!"
        );
        $err++;
      }

      if($err === 0)
      {
        $pass = encrypt($_POST['password']);
        $msPw = encrypt($_POST['masterPw']);
        $sql = "SELECT * FROM users WHERE user_name = '$user' OR user_email = '$email'";
        $query  = $dbh->prepare($sql);
        $result = $query->execute();
        $count  = $query->rowCount();
        if($count === 1)
        {
            $message_reg = array(
              "register" => false,
			  "type"  => "warning",
              "message" => "Вече съществува потребител с това име или емайл адрес."
            );
        }
        else
        {
          $hash = md5(time()-mt_rand(1000, 100000));
          $sql = "INSERT INTO users (`user_name`, `user_password`, `user_mPassword`, `user_email`, `user_hash`) VALUES ('$user', '$pass', '$msPw', '$email', '$hash')";
          $query  = $dbh->prepare($sql);
          $result = $query->execute();
          $count  = $query->rowCount();
          if($count === 1)
          {
              // EMAIL SEND

              $to      = $email; // Send email to our user
              $subject = 'Secured Password Manager | Потвърждение'; // Give the email a subject
              $message = '
               <BR> <BR>
              Благодарим Ви, за регистрацията!
              Вие успешно създадохте акаунт и с данните по-долу можете да се впишете, след като
              потвърдите емайла си! <BR><BR>

              ------------------------<BR>
              Потребителско име: <b>'.$user.'</b> <BR>
              Е-майл: <b>'.$email.'</b> <BR>
              Парола: <i>/паролата която сте въвели за вход при регистрацията/<i> <BR>
              ------------------------ <BR><BR>

              Моля кликнете, за да потвърдите акаунта си: <BR>
               <a href="http://www.electric-crew.top/email_confirm.php?email='.$email.'&hash='.$hash.'">http://www.electric-crew.top/email_confirm.php?email='.$email.'&hash='.$hash.'</a> <BR><BR><BR>


			  ============================================================================================ <BR>
			  Ako imate problem s kodirovkata i ne razchitate gorniqt text poglednete tozi: <BR>
			  ============================================================================================ <BR><BR>

			  Blagodarim Vi, za registratsiyata! <BR>
              Vie uspeshno sazdadohte akaunt i s dannite po-dolu mozhete da se vpishete, sled kato <BR>
              potvardite emayla si! <BR><BR>

              ------------------------ <BR>
              Potrebitelsko ime: <b>'.$user.'</b> <BR>
              E-mayl: <b>'.$email.'</b> <BR>
              Parola: <i>/parolata koyato ste vaveli za vhod pri registratsiyata/</i> <BR>
              ------------------------ <BR> <BR>

              Molya kliknete, za da potvardite akaunta si: <BR>
               <a href="http://www.electric-crew.top/email_confirm.php?email='.$email.'&hash='.$hash.'">http://www.electric-crew.top/email_confirm.php?email='.$email.'&hash='.$hash.'</a> <BR>
              '; // Our message above including the link

              $headers = 'From:noreply@electric-crew.top' . "\r\n"; // Set from headers
			  $headers .= "Content-Type: text/html; charset=UTF-8";

              if(mail($to, $subject, $message, $headers))
                $message_reg = array(
                  "register" => true,
				  "type"  => "success",
                  "message" => "Вашата регистрация е успешна, до 5 мин. трябва да получите емайл за потвърждение на акаунта. Ако не го получите, моля свържете се с <a href='mailto:admin@electric-crew.top'>администратор</a>"
                ); // Send our email
              // EMAIL SEND
          }
        }
      }
	  }
	  else
	  {
		  $message_reg = array(
              "register" => false,
			  "type"  => "warning",
              "message" => "Не можете да се регистрирате без да се съгласите с условията за конфиденциалност!"
            );
	  }
    }
    else
    {
      $message_reg = array(
          "login" => false,
		  "type"  => "warning",
          "message" => "Неуспешна регистрация - моля въведете сбора на числата коректно!"
        );
    } // captcha check
	unset($_POST);
  }
?><!doctype html>
<html>
<head>
	<meta charset="utf-8" />
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Secured Password Manager</title>
	<link rel="stylesheet" type="text/css" href="styles/style-1.css">
	<link rel="stylesheet" type="text/css" href="styles/font-awesome.min.css">
	<script src='js/jquery.js'></script>
	<script src="js/toggle-side.js"></script><script src="js/search.js"></script>
	<script>
	</script>
</head>
<body>
	<div class="main">
    <div id="_side-panel" class="side-panel">
    	<div class="user-image" style="background: url('<?= $_SESSION['avatar'] ?? "imgs/avatar.png" ?>') no-repeat; background-size: contain; background-position: 50% 50%;"></div>
		<span class="user-name"><?= $_SESSION['name'] ?></span>
		<hr class="separator">
		<span class="menu-cat">Потребителски панел</span>
		<a href="index.php" class="menu-item"><i class="fa fa-home" aria-hidden="true"></i> &nbsp; Начало</a>

	<?php if(isset($_SESSION['logged']) && $_SESSION['logged'] === true) { ?>
		<a href="myAccount.php" class="menu-item"><i class="fa fa-user-circle-o" aria-hidden="true"></i> &nbsp; Моят профил</a>
		<a href="myPasswords.php" class="menu-item"><i class="fa fa-key" aria-hidden="true"></i> &nbsp; Моите пароли</a>
		<a href="logout.php" class="menu-item"><i class="fa fa-sign-out" aria-hidden="true"></i> &nbsp; Изход</a>
	<?php } else { ?>
		<a href="entrance.php" class="menu-item active-link"><i class="fa fa-user-circle-o" aria-hidden="true"></i> &nbsp; Влез в системата</a>
	<?php } ?>

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
		  <h2>Вход в системата</h2>
		</div>
		  <div class="clear"></div>
		  <!-- Wrapper -->
		  <br>
		  <header>
		  <div class="wrapper">
		    <nav role="navigation">
		      <ul>
		        <li class="active"><a href="" class="active">РЕГИСТРАЦИЯ / ВХОД В СИСТЕМАТА</a></li>
		        <li><a href="forgotPassword.php">ЗАБРАВЕНА ПАРОЛА</a></li>
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
				<div id='messageBox' style='width: 65% !important;' class="<?php echo $message_log['type'] ?? $message_reg['type']; ?>-msg">
				  <?php
				  if(isset($message_log['type']) || isset($message_reg['type'])){
					  $type = $message_log['type'] ?? $message_reg['type'];
					  if($type == "success") echo '<i class="fa fa-check"></i>&nbsp;';
						elseif($type == "warning") echo '<i class="fa fa-warning"></i>&nbsp;';
							elseif($type == "error") echo '<i class="fa fa-times-circle"></i>&nbsp;';
				  }
				  echo $message_log['message'] ?? $message_reg['message'];
				  ?>
				</div>
			<!-- LOGIN -->
			<div class="login">
			  <h2 class="login-header">Вход в системата</h2>
			  <form autocomplete="off" method='POST' class="login-container">
					<p><input type="text" name="username" placeholder="Потребителско Име или Имейл"></p>
					<p><input type="password" name="password" placeholder="Парола за вход"></p>
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
			    <p><input type="submit" name="login" value="ВХОД В СИСТЕМАТА"></p>
			  </form>
			</div>

			<!-- Register -->
			<div class="login">
			  <h2 class="login-header">Регистрация</h2>

			  <form method='POST' class="login-container">
					<p><input type="text" name='username' placeholder="Потребителско Име"></p>
			    <p><input type="email" name='email' placeholder="Имейл"></p>
					<p><input name="password" type="password" placeholder="Парола"></p>
					<p><input name="masterPw" type="password" placeholder="MASTER Парола"></p>
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
					<input type='checkbox' name='agree' style='display: inline-block;' value='true'/> Съгласен съм с <a href='terms-of-use.php'>условията за ползване на сайта</a>!
			    <p><input type="submit" name='register' value="РЕГИСТРАЦИЯ"></p>
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
