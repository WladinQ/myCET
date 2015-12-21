<?php
include 'core/init.php';
protect_page();

$errors = array();

if (empty($_POST) === false) {
	$required_fields = array('current_password', 'password', 'password_again');
	foreach($_POST as $key=>$value) {
		if (empty($value) && in_array($key, $required_fields) === true) {
			$errors[] = 'Pole označené hvězdičkou jsou povinná.';
			break 1;
		}
	}
	
	if (md5($_POST['current_password']) === $user_data['password']) {
		if (trim($_POST['password']) !== trim($_POST['password_again'])) {
			$errors[] = 'Vaše nové heslá se neshodují!';
		} else if (strlen($_POST['password']) < 6) {
			$errors[] = 'Vaše heslo musí mít alespoň 6 znaků!';
		}
	} else {
		$errors[] = 'Vaše aktuální heslo je nesprávné!';
	}
}

include 'includes/overall/header.php';

$latteParam["success"] = false;
$latteParam["force"] = false;
$latteParam["errors"] = false;

if (isset($_GET['success']) === true && empty($_GET['success']) === true) {
	$latteParam["success"] = true;
} else {

	if (isset($_GET['force']) === true && empty($_GET['force']) === true) {
		$latteParam["force"] = true;
	}
	
	if (empty($_POST) === false && empty($errors) === true) {
		change_password(AUTHENTIZATED_USER_ID, $_POST['password']);
		header('Location: change-password.php?success');
	} else if (empty($errors) === false) {
		$latteParam["errors"] = output_errors($errors);
	}
}

// render to output
$latte->render('templates/zmena-hesla.latte', $latteParam);


include 'includes/overall/footer.php';
?>