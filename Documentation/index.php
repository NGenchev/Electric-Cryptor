<!doctype html>
<head lang="bg">
	<meta charset="utf-8">
	<title>Security Password Manager - Документация</title>
	<!-- Framework CSS -->
	<link rel="stylesheet" href="assets/blueprint-css/screen.css" type="text/css" media="screen, projection">
	<link rel="stylesheet" href="assets/blueprint-css/print.css" type="text/css" media="print">
	<!--[if lt IE 8]><link rel="stylesheet" href="assets/blueprint-css/ie.css" type="text/css" media="screen, projection"><![endif]-->
	<link rel="stylesheet" href="assets/blueprint-css/plugins/fancy-type/screen.css" type="text/css" media="screen, projection">
	<style type="text/css" media="screen">
	body a { text-decoration: none; }
		p, table, hr, .box { margin-bottom:25px; }
		.box p { margin-bottom:10px; }
	</style>
</head>


<body>
	<div class="container">
		
		<h1 class="center">&ldquo;Security Password Manager&rdquo;</h1>
		
		<div class="borderTop">
			<div class="span-6 colborder info prepend-1">
				<p class="prepend-top">
					<strong>
					Създадено: 9, Декември 2016г.<br>
					От: Electric-Crew<br>
					Имейл: <a href="mailto:webmaster@electric-crew.top">webmaster@electric-crew.top</a>
					</strong>
				</p>
			</div><!-- end div .span-6 -->		
	
			<div class="span-12 last">
				<p class="prepend-top append-0">Добре дошли в нашият наръчник за използване на Security Password Manager. Ако имате
                    някакви въпроси, които са извън този помощен файл, задайте ги на имейл <a href="mailto:webmaster@electric-crew.top">webmaster@electric-crew.top</a>. Благодарим Ви!</p>
			</div>
		</div><!-- end div .borderTop -->
		
		<hr>
		
		<h2 id="toc" class="alt">Навигация</h2>
		<ol class="alpha">
			<li><a href="#howtostart">Как да си създам акаунт?</a></li>
		</ol>
		<hr>
		
		<p>
			<strong>Security Password Manager</strong>  е уеб приложение за сигурно съхранение на вашите
			пароли.
			
			Потребителят може да добавя своите пароли, да ги променя, да ги изтрива, както и да си променя главните пароли.

			Като допълнителна информация, те могат да си добавят аватар(снимка на профила), опция за изтриване на акаунта си,
            
		</p>
		
		<h3><strong>Характеристики и технологии:</strong></h3>
		<ol>
			<li>PHP7</li>
			<li>HTML5</li>
			<li>CSS3</li>
			<li>jQuery </li>
			<li>PDO с Prepared Statements</li>
			<li>Font Awesome</li>
			<li>Лесен дизайн за употреба</li>
			<li>Потребителите могат да добавят пароли</li>
			<li>Потребителите могат да редактират своите пароли</li>
			<li>Потребителите могат да изтриват своите пароли</li>
			<li>Потребителите могат да качват собствена снимка</li>
			<li>Потребителите могат да си въведат трите имена</li>
			<li>Потребителите могат да си въведат градът, в който живеят</li>
			<li>Потребителите могат да си въведат описание за самите тях</li>
			<li>Потребителите могат да сменят главните си пароли </li>
			<li>Потребителите могат да си върнат парола при загубване</li>
			<li>Активиране на потребителски акаунт чрез имейл</li>
			<li>Тройна криптировка на личните данни</li>
			<li>Доработен метод на Шифъра на Цезър</li>
			<li>XSS защита</li>
			<li>Потребителски типове: Администратор/Потребител</li>
			<li>Статистики на сайта за тип Администратори</li>
		</ol>
		<hr />
		
		<h3 id="howtostart"><strong>A) Как да си създам акаунт? </strong> - <a href="#toc">нагоре</a></h3>
		<p>
			Искате да си създадете акаунт, за да си запазите паролите сигурни?
			Първото нещо, което трябва да направите е да:
			<ul>
				<li>1.) Отидете на връзката на която пише "Влез в системата"</li>
                    <img src="assets/images/screen_1.png">
				<li>2.) След това си изберете потребителско име и да въведете валиден имейл адрес</li>
                    <img src="assets/images/screen_2.png">
                <li>3.) Задайте си две пароли.Нека обясним всяка за какво служи.Полето "<strong>Парола</strong>" служи за
                    вход в нашата система. Полето "<strong>MASTER Парола</strong>" служи като ключ за отключване на вашите
                    добавен пароли в нашата система.<br><strong>Бъдете внимателни с тези две полета!</strong>
                </li>
                <li>4.) Време е да натиснем бутонът "Регистрация" и да се съгласим с условията за ползване, след като сме ги
                прочели!</li>
                <img src="assets/images/screen_3.png">
                <li>5.) Поздравления! Успяхте да се регистрирате в нашата система.Нека не бързаме, естествено.Спомняте ли си
                имейлът, който въведохте по-горе във формата? Сега е момента да си влезете в него, за да видите, че имате едно ново писмо.</li>
                <img src="assets/images/screen_4.png">
                <li>6.) Влезте в това писмо и го прочетете за повече информация.В него трябва да има един дълъг линк, който би трябвало
                да изглежда по следният начин:</li>
                <img src="assets/images/screen_5.png">
                 <li>7.) След като сте наясно за какво служи този линк, моля последвайте го.</li>
                <li><strong>Поздравления! Вие си създадохте вашият акаунт!</strоng></li>
			</ul>
			
		</p>
	
		<hr>

		<h3 id="credits"><strong>Източници</strong> - <a href="#toc">нагоре</a></h3>
		
		<p>Ние сме използвали ресурси от следните източници:</p>
		
		<ul>
			<li>jQuery - http://jquery.com/</li>
			<li>Font Awesome - http://fortawesome.github.io/Font-Awesome/</li>
			<li>Шрифтове - https://www.google.com/fonts</li>
            <li>Blueprint CSS(за документацията) - http://www.blueprintcss.org/</li>
		</ul>

	<hr>
		
		
		<p class="append-bottom alt large"><strong>Electric-Crew</strong></p>
		<p><a href="#toc">Към Навигацията</a></p>
		
		<hr class="space">
	</div><!-- end div .container -->
</body>
</html>