<?php

session_start();

//error_reporting(E_ALL ^ E_DEPRECATED);

require __DIR__ . '/database/connect.php';
require __DIR__ . '/functions/general.php';
require __DIR__ . '/functions/users.php';

// na toto ˇ sa používa basename()
$current_file = explode('/', $_SERVER['SCRIPT_NAME']);
$current_file = end($current_file);

if (logged_in() === true) {
	define('AUTHENTIZATED_USER_ID', $_SESSION['user_id']);

	$user_data = user_data(AUTHENTIZATED_USER_ID, 'user_id', 'username', 'profile', 'status', 'password', 'password_recover', 'email', 'okres', 'bday', 'sex', 'email_allow', 'type');
	if (user_active($user_data['username']) === false) {
		session_destroy();
		header('Location: index.php');
		exit();
	}
	/*if (basename($_SERVER['SCRIPT_NAME']) !== 'change-password.php' && $user_data['password_recover'] == 1) {
		header('Location: change-password.php?force');
		exit();
	}*/
}

if(!defined('AUTHENTIZATED_USER_ID'))
	define('AUTHENTIZATED_USER_ID', false);

$errors = array();


require __DIR__ . '/latte.php';
$latte = new Latte\Engine;

$latte->setTempDirectory(__DIR__ . '/../temp');


?>