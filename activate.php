<?php
include 'core/init.php';
logged_in_redirect();
include 'includes/overall/header.php';

if (isset($_GET['success']) === true && empty($_GET['success']) === true) {
	$latteParam["status"] = true;
	
} else if (isset($_GET['email'], $_GET['email_code']) === true) {
	
	$email		= trim($_GET['email']);
	$email_code = trim($_GET['email_code']);
	
	if (email_exists($email) === false) {
		$errors[] = 'Oops, something went wrong, and we couldn\'t find that email address!';
	} else if (activate($email, $email_code) === false) {
		$errors[] = 'We had problems activating your account';
	}
	
	if (empty($errors) === false) {
		$latteParam["status"] = $false;
		$latteParam["error"] = output_errors($errors);
	} else {
		header('Location: activate.php?success');
		exit();
	}
	
} else {
	header('Location: index.php');
	exit();
}

// render to output
$latte->render('templates/activate.latte', $latteParam);

include 'includes/overall/footer.php';
?>