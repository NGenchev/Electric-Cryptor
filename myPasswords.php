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
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
	<script src="js/toggle-side.js"></script>
	<script src="js/search.js"></script>
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
		<!-- Header -->
		<div class="wrap">
		  <h2>Моите Пароли</h2>
		</div>
		  <div class="clear"></div>
		  <!-- Wrapper -->
		  <br>
		  <header>
		  <div class="wrapper">
		    <nav role="navigation">
		      <ul>
		        <li class="active"><a href="#" class="active">ПРЕГЛЕД НА ПАРОЛИТЕ</a></li>
				<li><a href="addPassword.php">ДОБАВЯНЕ НА ПАРОЛА</a></li>
		      </ul>
		    </nav>
		</div>
		</header>
		<br>
		</div>
		<!-- Table -->
		<div class="content2">
		<script type='text/javascript'>
		  function showPass(id)
		  {
			var master = prompt("Въведете MASTER парола:");
			var userID = <?= $_SESSION['uID'] ?>;
			var pwID   = id;
			  if (master != null) {
			  $(function(){
				$.ajax({
					type: "POST",
					url: "response_Pass.php",
					data: {master, userID, pwID},
					success: function(data){
						data = JSON.parse(data);
						if(data.valid==true) prompt('Вашата парола е:', data.password);
						else alert("Грешна master парола!");
					}
				});
				return false;
			 });
			}
		  }

		  function showUser(id)
		  {
			var master = prompt("Въведете MASTER парола:");
			var userID = <?= $_SESSION['uID'] ?>;
			var pwID   = id;
			  if (master != null) {
			  $(function(){
				$.ajax({
					type: "POST",
					url: "response_User.php",
					data: {master, userID, pwID},
					success: function(data){
						data = JSON.parse(data);
						if(data.valid==true) prompt('Вашият никнейм е:', data.user);
						else alert("Грешна master парола!");
						}
					});
					return false;
				 });
			}
		  }

		  function deletePass(id)
		  {
			var master = prompt("Въведете MASTER парола:");
			var userID = <?= $_SESSION['uID'] ?>;
			var pwID   = id;
			  if (master != null) {
			  $(function(){
				$.ajax({
					type: "POST",
					url: "delete_response.php",
					data: {master, userID, pwID},
					success: function(data){
						data = JSON.parse(data);
						if(data.valid==true) 
							{
								alert("Успешно изтрихте паролата!");
								$('#pass_'+id).hide(500);
							}
						else alert("Грешна master парола!");
					}
				}); return false;
			  });
			 }
		  }
		</script>
			<?php
                $uID = $_SESSION['uID'];
                $sql = "SELECT * FROM passwords WHERE pw_uID = '$uID' ORDER BY pw_lastUpdate ASC";
                $res = $dbh->prepare($sql);
                $res->execute();
                $count = $res->rowCount();
                if($count > 0)
                {
                  echo "<table>
				 <thead>
				   <tr style=\"font-weight: normal;\">
					 <th>САЙТ</th>
					 <th>ПОТРЕБИТЕЛСКО ИМЕ</th>
					 <th>ПАРОЛА</th>
					 <th>ПОСЛЕДНА ПРОМЯНА</th>
					 <th>ДЕЙСТВИЯ</th>
				   </tr>
				 <thead>
				 <tbody>";
                  $rows = $res->fetchAll();
                  foreach($rows as $row)
                  {
                    $id = $row['pw_id'];
                    $site = $row['pw_site'];
                    if(filter_var($site, FILTER_VALIDATE_URL)){
                    $site_parsedURL = (explode('.', (parse_url($site))['host']))[0];
                    $site_parsedURL = mb_strlen($site_parsedURL) > 10 ? mb_substr($site_parsedURL, 0, 9)."..." : $site_parsedURL;}

                    $site = filter_var($site, FILTER_VALIDATE_URL) ? "<a target='_blank' href='$site' class='site_link'>". $site_parsedURL ."</a>" : $site;
                    $user = $row['pw_user'];
                    $pass[$id] = $row['pw_content'];
                    $lUp = $row['pw_lastUpdate'];
                    $month = date('m', strtotime($lUp));

                    if($month==1)
                      $month = "Яну.";
                    elseif($month==2)
                      $month = "Февр.";
                    elseif($month==3)
                      $month = "Март";
                    elseif($month==4)
                      $month = "Апр.";
                    elseif($month==5)
                      $month = "Май";
                    elseif($month==6)
                      $month = "Юни";
                    elseif($month==7)
                      $month = "Юли";
                    elseif($month==8)
                      $month = "Авг.";
                    elseif($month==9)
                      $month = "Септ.";
                    elseif($month==10)
                      $month = "Окт.";
                    elseif($month==11)
                      $month = "Ноем.";
                    elseif($month==12)
                      $month = "Дек.";
                    else $month = "Ян.";

                    $lUp = date("d $month Y H:i:s\ч.", strtotime($lUp));
                    echo "
                    <tr id='pass_{$id}'>
                      <td>$site</td>
                      <td>
                      <button class='edit' onclick='showUser($id);' id='$id'>ПОКАЖИ</button>
                      </td>
                      <td>
                      <button class='edit' onclick='showPass($id);' id='$id'>ПОКАЖИ</button>
                      </td>
                      <td>$lUp</td>
                      <td>
                        <a href='editPassword.php?pwID=$id'><button class=\"edit\" style=\"width: 25%\"><i class=\"fa fa-edit\"></i></button></a>
						<button onclick='deletePass($id);' class=\"edit\" style=\"width: 25%\"><i class=\"fa fa-times\"></i></button>
                      </td>
                    </tr>
                    ";
                  }
                }
                else {
                  echo '
					<div id="messageBox" style="width: 65%!important;" class="info-msg">
						<i class="fa fa-warning"></i>&nbsp;
						Нямате добавени пароли...
					</div>
				  ';
                }
              ?>
		     </tbody>
		   <table/>
		</div>
	</div>
		<!-- Footer -->
		<footer>
		  Всички права са запазени &copy; 2016-2017 Design &amp; Code By Electric Crew
		</footer>
	</div>

</div>
    </body>
</html>
