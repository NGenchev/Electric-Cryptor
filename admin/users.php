<?php
  session_start();
  require_once('../includes/database_config.php');
  if($_SESSION['type'] != 1 || $_SESSION['logged'] !== TRUE || !isset($_SESSION)) header('Location: ../index.php');
	// Users information
	$Users = array(
		"total" =>
				array(
					"count" => 0,
					"pcnts" => 0
				),
		"day"   =>
				array(
					"count" => 0,
					"pcnts" => 0
				),
		"week"   =>
				array(
				"count" => 0,
				"pcnts" => 0
				),
		"month" =>
				array(
					"count" => 0,
					"pcnts" => 0
				),
		"year"  =>
			   array(
					"count" => 0,
					"pcnts" => 0
				)
	);

	$sql = "SELECT * FROM users";
	$res = $dbh->prepare($sql);
	$res->execute();
	$rows = $res->fetchAll();

	$Users['total']['count'] = $res->rowCount();
	if($Users['total']['count']!=0)
	{
		foreach($rows as $row)
		{
			// Day
			  $dateOfCreate = date("d-m-Y", strtotime($row['user_Created']));
			  $nowDate = date("d-m-Y");
			  if($dateOfCreate == $nowDate) $Users['day']['count']++;
			// Month & Week
			  $dateOfCreate = date("m-Y", strtotime($row['user_Created']));
			  $nowDate = date("m-Y");
			  if($dateOfCreate == $nowDate) 
			  {
				$Users['month']['count']++;
				if((date("d")-date("d", strtotime($row['user_Created']))) <= 7 )
				   $Users['week']['count']++;
			  }
			// Year
			  $dateOfCreate = date("Y", strtotime($row['user_Created']));
			  $nowDate = date("Y");
			  if($dateOfCreate == $nowDate) $Users['year']['count']++;
		}

		$Users['day']['pcnts']    = round($Users['day']['count']    / $Users['total']['count'] * 100, 2);
		$Users['week']['pcnts']   = round($Users['week']['count']   / $Users['total']['count'] * 100, 2);
		$Users['month']['pcnts']  = round($Users['month']['count']  / $Users['total']['count'] * 100, 2);
		$Users['year']['pcnts']   = round($Users['year']['count']   / $Users['total']['count'] * 100, 2);
		$Users['total']['pcnts']  = round($Users['total']['count']  / $Users['total']['count'] * 100, 2);
	}
?>
<!doctype html>
<html>
<head>
	<meta charset="utf-8" />
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Security Password Manager</title>
	<link rel="stylesheet" type="text/css" href="../styles/style-1.css">
	<link rel="stylesheet" type="text/css" href="../styles/font-awesome.min.css">
	<link rel="stylesheet" type="text/css" href="../styles/chart.css">
		<style>
		.chart {
		  width: 100%;
		  min-height: 450px;
		}
		</style>
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
	<script src="../js/toggle-side.js"></script>
	<script src="../js/search.js"></script>
	<script src="https://www.google.com/jsapi"></script>
	<script type='text/javascript'>
	  google.load("visualization", "1", {packages:["corechart"]});
	  google.setOnLoadCallback(drawChart1);
	  function drawChart1() {
		var data = google.visualization.arrayToDataTable([
		  ['Период (брой)', 'в проценти'],
		  ['Днес (<?= $Users['day']['count'] ?>)',  <?= $Users['day']['pcnts'] ?>],
		  ['Тази Седмица (<?= $Users['week']['count'] ?>)', <?= $Users['week']['pcnts'] ?>],
		  ['Този Месец (<?= $Users['month']['count'] ?>)', <?= $Users['month']['pcnts'] ?>],
		  ['Тази Година (<?= $Users['year']['count'] ?>)', <?= $Users['year']['pcnts'] ?>],
		  ['Общо (<?= $Users['total']['count'] ?>)', <?= $Users['total']['pcnts'] ?>]
		]);

		var options = {
		  title: 'Период (брой посещения) / посещенията в проценти',
	   };

	  var chart = new google.visualization.ColumnChart(document.getElementById('chart_div1'));
		chart.draw(data, options);
	  }
	  $(window).resize(function(){
		drawChart1();
	  });
	</script>
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
			<a href="administrators.php" class="menu-item"><i class="fa fa-code" aria-hidden="true"></i> &nbsp; Администратори</a>
			<a href="users.php" class="menu-item active-link"><i class="fa fa-users" aria-hidden="true"></i> &nbsp; Потребители</a>
			<a href="passwords.php" class="menu-item"><i class="fa fa-shield" aria-hidden="true"></i> &nbsp; Пароли</a>
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
				<h2>Security Password Manager - Администраторски панел</h2>
			</div>
		  <div class="clear"></div>
		  <!-- Wrapper -->
		  <br>
		<br>
		</div>
		<!-- Table -->
		<div class="content2">
			<div class="article">
				<h2 class="title">Брой на регистрирани потребители</h2>
					
				<div id="chart_div1" class="chart"></div>
				<br>
				<h2 class="title">Брой на регистрирани пароли на всеки потребител</h2>
				<br>
				<table>
				     <thead>
				       <tr style="font-weight: normal;">
				         <th>ID НА ПОТРЕБИТЕЛ</th>
						 <th>ПОТРЕБИТЕЛСКО ИМЕ</th>
						 <th>БРОЙ НА ПАРОЛИ</th>
						 <th>ПОСЛЕДЕН ВХОД</th>
						 <th>ДЕЙСТВИЯ</th>
				       </tr>
				     <thead>
				     <tbody>
					   <?php
						$sql = "SELECT * FROM users ORDER BY user_lastLogin DESC";
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
									<td><a href="#"><button onclick="alert(\'Функция за ПРЕМИУМ акаунт.. Скоро!\');" style="width: 50%;" class="edit"><i class="fa fa-check-circle" aria-hidden="true"></i></button></a>
								</td>
						   </tr>';
						}
					?>
				     </tbody>
				   <table/>
			</div>
			</div>

		<!-- Footer -->
		<footer>
		  All Rights Reserved &copy; Electric Crypter
		</footer>
	</div>

			<script type="text/javascript">
			$(function() {
				$("#bars li .bar").each( function( key, bar ) {
					var percentage = $(this).data('percentage');

					$(this).animate({
						'height' : percentage + '%'
					}, 2500);
				});
				});
			</script>
    </body>
</html>
