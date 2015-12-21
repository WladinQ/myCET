<html>
<head>
	<!--?php
		require_once('version.php');
		if(detect_mobile_device() == FALSE)
		{
		  // Presmerovani na mobilni verzi
		  header('Location: http://mycet.php5.sk');
		  exit;
		};
	?-->
	<link rel="stylesheet" href="css/style-mobile.css">
	<header>
		<img src="../images/logo.png">
	</header>
</head>
<body>
	<div id="login">
		<?php
			// prihlasenie
		?>
		<input tabindex=1 type="text" name="username" placeholder="Uživatelské jméno">
		<input tabindex=2 type="password" name="password" placeholder="Heslo">
		<input type="submit" name="submit" value="Přihlásit se">
  	
		<a href="">Zapomenuté heslo?</a>&nbsp;&nbsp;&nbsp;&nbsp;&middot;&nbsp;&nbsp;&nbsp;&nbsp;<a href="">Potřebujete poradit?</a>
	</div>
	<div id="register">
		<a href="">Zaregistrovat se</a>
	</div>
	<div id="footer">
		<div class="oznam">
			Mobilní verze stránky se pořád připravuje.
		</div>
		myČET 2015
	</div>
</body>
</html>