<!doctype html>
<html>
<head>
	<meta charset="utf-8" />
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Security Password Manager</title>
	<link rel="stylesheet" type="text/css" href="styles/style-1.css">
	<link rel="stylesheet" type="text/css" href="styles/font-awesome.min.css">
	<script src='http://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.min.js'></script>
	<script src="js/toggle-side.js"></script>
</head>
<body>
	<div class="main">
    <div id="_side-panel" class="side-panel">
    	<div class="user-image" style="background: url('<?= $_SESSION['avatar'] ?? "imgs/avatar.png" ?>') no-repeat; background-size: contain; background-position: 50% 50%;"></div>
		<span class="user-name"><?= $_SESSION['name'] ?></span>
		<hr class="separator">
		<span class="menu-cat">Потребителски панел</span>
		<a href="index.php" class="menu-item active-link"><i class="fa fa-home" aria-hidden="true"></i> &nbsp; Начало</a>
		
	<?php if(isset($_SESSION['logged']) && $_SESSION['logged'] === true) : ?>
		<a href="myAccount.php" class="menu-item"><i class="fa fa-user-circle-o" aria-hidden="true"></i> &nbsp; Моят профил</a>
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
		  <!-- Wrapper -->
		  
		  <br>
		  <header>
		  <div class="wrapper">
		    <nav role="navigation">
		      <ul>
		        <li class="active"><a class="active" href="#">ОБЩИ УСЛОВИЯ ЗА ПОЛЗВАНЕ</a></li>
		      </ul>
		    </nav>
		</div>
		</header>
		<br>
		</div>
		<!-- Registration -->
	<center>
	<div class="content2" style="color: #354052">
		<div class="container2-login">
				<p style="text-align: justify;">Този уеб сайт е официалният сайт на Security Password Manager (SPM-Electric Crew) по смисъла на чл. 10, ал. 3 от Закона за електронното управление. Сайтът и неговото съдържание се публикуват за Ваше удобство и са предназначени изключително за лична и некомерсиална употреба.&nbsp;&nbsp;</p>
				<p style="text-align: justify;">При използване на този сайт, моля да имате предвид следното:</p>
				<h3 style="text-align: justify;"><strong>Авторски права</strong></h3>
				<p style="text-align: justify;">Софтуерът, осигуряващ функционирането на тази интернет страница, нейният дизайн, включително цялата разположена в сайта информация, доколкото не съставляват обществена информация, са обект на авторско право. Никаква част от обектите на закрила не може да се възпроизвежда, да се превежда, променя или използва по какъвто и да е начин без предварителното съгласие на екипа на Electric-Crew.</p>
				<h3 style="text-align: justify;">Изявление за защита на личните данни</h3>
				<p style="text-align: justify;">Лични данни се събират чрез тази интернет страница и обработват от Electric-Crew единствено за нуждите на предоставянето на електронни административни услуги, при строго спазване на изискванията на Закона за електронното управление и Закона за защита на личните данни.</p>
				<p style="text-align: justify;">В случай, че решите да използвате някои от специализираните ни модули и услуги, необходимо е да предоставите желаните от нас лични данни, за да извършим услугата, която сте заявили, но личните Ви данни продължават да бъдат защитени. Подчертаваме, че събираме данни, които са необходими за извършване на желаната услуга, като в този процес използваме изключително онези данни, които сме получили директно от Вас. Приоритетна цел на Electric-Crew е да гарантира на своите потребители разумно ниво на безопасност на личните данни.</p>
				<h3 style="text-align: justify;">Съгласие с правилата и условията за ползване на сайта</h3>
				<p style="text-align: justify;">Посещавайки интернет страниците на Electric-Crew, ние приемаме, че сте съгласни с нашите правила и условия за ползване на сайта. Ако не сте съгласни с тях, моля не използвайте този сайт и предоставените в него услуги и модули. Ние сме създали тези правила и ръководни принципи единствено с цел да Ви защитаваме и да Ви осигурим безопасни, приятни и полезни минути, посещавайки този сайт.</p>
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
