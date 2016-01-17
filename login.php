<?php

include 'core/init.php';
logged_in_redirect();

if (strtoupper($_SERVER['REQUEST_METHOD']) === 'POST' && !empty($_POST)) {
	// reference operator avoids notices, but this is a bad practice
	$username = & $_POST['username'];
	$password = & $_POST['password'];

	if (empty($username) || empty($password)
	 || is_array($username) || is_array($password)) {
		$errors[] = 'Musíte zadat uživatelské jméno a heslo.<br><br>';
	} elseif (!user_exists($username)) {
		$errors[] = 'Nemůžeme najít vámi zadané jméno. Už jste se zaregistrovali?<br><br>';
	} elseif (!user_active($username)) {
		$errors[] = 'Vy jste ješte neaktivovali svůj účet. Přejděte prosím do schránky Vámi zadané e-mailové adresy.<br><br>';
	} else {
	
		if (strlen($password) > 32) {
			$errors[] = 'Heslo je příliš dlouhé.';
		}
	
		if (!$login = login($username, $password)) {
			$errors[] = 'Tato kombinace uživatelského jména a hesla je nesprávna.<br><br>';
		} else {
			$_SESSION['user_id'] = $login;
			header('Location: index.php');
			exit();
		}
	}
} else {
	$errors[] = 'K příhlášení použijte prosím náš přihlašovací formulář.<br><br>';
}

include 'includes/overall/header.php';

$latteParam["errors"] = output_errors($errors);

// render to output
$latte->render('templates/login.latte', $latteParam);

include 'register.php';

include 'includes/overall/footer.php';

?>