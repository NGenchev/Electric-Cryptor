<?php
  session_start();
  require_once('../includes/database_config.php');
  if($_SESSION['type'] != 1 || $_SESSION['logged'] !== TRUE || !isset($_SESSION)) header('Location: ../index.php');  
	// Users information
	$Passwords = array(
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

	$sql = "SELECT * FROM passwords";
	$res = $dbh->prepare($sql);
	$res->execute();
	$rows = $res->fetchAll();

	$Passwords['total']['count'] = $res->rowCount();
	if($Passwords['total']['count']!=0)
	{	
		foreach($rows as $row)
		{
			// Day
			  $dateOfCreate = date("d-m-Y", strtotime($row['pw_Created']));
			  $nowDate = date("d-m-Y");
			  if($dateOfCreate == $nowDate) $Passwords['day']['count']++;
			// Week
			  
			// Month
			  $dateOfCreate = date("m-Y", strtotime($row['pw_Created']));
			  $nowDate = date("m-Y");
			  if($dateOfCreate == $nowDate) {
				  $Passwords['month']['count']++;
					if((date("d")-date("d", strtotime($row['pw_Created']))) <= 7 ) $Passwords['week']['count']++;
			  }
			  // Year
			  $dateOfCreate = date("Y", strtotime($row['pw_Created']));
			  $nowDate = date("Y");
			  if($dateOfCreate == $nowDate) $Passwords['year']['count']++;
		}

		$Passwords['day']['pcnts']    = round($Passwords['day']['count']    / $Passwords['total']['count'] * 100, 2);
		$Passwords['week']['pcnts']   = round($Passwords['week']['count']   / $Passwords['total']['count'] * 100, 2);
		$Passwords['month']['pcnts']  = round($Passwords['month']['count']  / $Passwords['total']['count'] * 100, 2);
		$Passwords['year']['pcnts']   = round($Passwords['year']['count']   / $Passwords['total']['count'] * 100, 2);
		$Passwords['total']['pcnts']  = round($Passwords['total']['count']  / $Passwords['total']['count'] * 100, 2);
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
		  ['Днес (<?= $Passwords['day']['count'] ?>)',  <?= $Passwords['day']['pcnts'] ?>],
		  ['Тази Седмица (<?= $Passwords['week']['count'] ?>)', <?= $Passwords['week']['pcnts'] ?>],
		  ['Този Месец (<?= $Passwords['month']['count'] ?>)', <?= $Passwords['month']['pcnts'] ?>],
		  ['Тази Година (<?= $Passwords['year']['count'] ?>)', <?= $Passwords['year']['pcnts'] ?>],
		  ['Общо (<?= $Passwords['total']['count'] ?>)', <?= $Passwords['total']['pcnts'] ?>]
		]);

		var options = {
		  title: 'Период (брой пароли) / паролите в проценти',
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
    	<div class="user-image" style="background: url('<?= $_SESSION['avatar'] ?? "../../imgs/avatar.png" ?>') no-repeat; background-size: contain; background-position: 50% 50%;"></div>
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
			<a href="users.php" class="menu-item"><i class="fa fa-users" aria-hidden="true"></i> &nbsp; Потребители</a>
			<a href="passwords.php" class="menu-item active-link"><i class="fa fa-shield" aria-hidden="true"></i> &nbsp; Пароли</a>
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
				<h2 class="title">Брой на  добавени пароли</h2>
				<div id="chart_div1" class="chart"></div>
				<br>
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
					}, 1000);
				});
				});
			</script>
    </body>
</html>
