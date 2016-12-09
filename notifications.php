<!doctype html>
<html>
<head>
	<meta charset="utf-8" />
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Secret Password Manager</title>
	<link rel="stylesheet" type="text/css" href="styles/style-1.css">
	<link rel="stylesheet" type="text/css" href="styles/font-awesome.min.css">
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
	<script src="js/toggle-side.js"></script>
</head>
<body>
	<div class="main">
    <div id="_side-panel" class="side-panel">
    	<div class="user-image"></div>
		<span class="user-name">Николай Генчев</span>
		<hr class="separator">
		<span class="menu-cat">Основно</span>
			<a href="index.php" class="menu-item"><i class="fa fa-home" aria-hidden="true"></i> &nbsp; Начало</a>
			<a class="menu-item"><i class="fa fa-user-circle-o" aria-hidden="true"></i> &nbsp; Моят профил</a>
			<a class="menu-item"><i class="fa fa-key" aria-hidden="true"></i> &nbsp; Моите пароли</a>
			<a class="menu-item"><i class="fa fa-sign-out" aria-hidden="true"></i> &nbsp; Изход</a>
		<hr class="separator">
		<span class="menu-cat">Администраторски панел</span>
			<a href="index.php" class="menu-item"><i class="fa fa-home" aria-hidden="true"></i> &nbsp; Начало</a>
			<a class="menu-item"><i class="fa fa-user-circle-o" aria-hidden="true"></i> &nbsp; Моят профил</a>
			<a class="menu-item"><i class="fa fa-key" aria-hidden="true"></i> &nbsp; Моите пароли</a>
			<a class="menu-item"><i class="fa fa-sign-out" aria-hidden="true"></i> &nbsp; Изход</a>
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
		  <h2>Преглед на парола за Facebook</h2>
		  <small>
		    ДОБАВЕНА НА: <coloured>ДАТА</coloured>
		    &bull;
		    ПОСЛЕДЕН ПРЕГЛЕД: <coloured>ДАТА</coloured>
		  </small>
		</div>
		<!-- Right Side -->
		  <div class="right-head">
		    <button class="button-1">РАБОТИ</button>
		    <button class="circular"><i class="fa fa-star" aria-hidden="true"></i></button>
		    <button class="circular"><i class="fa fa-pencil" aria-hidden="true"></i></button>
		    <button class="circular"><i class="fa fa-trash" aria-hidden="true"></i></button>
		  </div>
		  <div class="clear"></div>
		  <!-- Wrapper -->
		  <br>
		  <header>
		  <div class="wrapper">
		    <nav role="navigation">
		      <ul>
		        <li class="active"><a href="#" class="active">ОБОБЩЕНИЕ</a></li>
		        <li><a href="#">РЕДАКТИРАНЕ</a></li>
		        <li><a href="#">ИЗТРИВАНЕ</a></li>
		      </ul>
		    </nav>
		</div>
		</header>
		<br>
		</div>
		<!-- Table -->
		<div class="content2">
			<div class="info-msg">
		  <i class="fa fa-info-circle"></i>
		  Информативно.
		</div>

		<div class="success-msg">
		  <i class="fa fa-check"></i>
		  Успешно.
		</div>

		<div class="warning-msg">
		  <i class="fa fa-warning"></i>
		  Предупреждение.
		</div>

		<div class="error-msg">
		  <i class="fa fa-times-circle"></i>
		  Грешка.
		</div>
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
