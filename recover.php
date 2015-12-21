<?php
include 'core/init.php';
logged_in_redirect();
include 'includes/overall/header.php';

$latteParam["success"] = false;
$latteParam["error"] = [];
if (isset($_GET['success']) === true && empty($_GET['success']) === true) {
	$latteParam["success"] = true;
} else {
	$mode_allowed = array('username', 'password');
	if (isset($_GET['mode']) === true && in_array($_GET['mode'], $mode_allowed) === true) {
		if (isset($_POST['email']) === true && empty($_POST['email']) === false) {
			if (email_exists($_POST['email']) === true) {
				recover($_GET['mode'], $_POST['email']);
				header('Location: recover.php?success');
				exit();
			} else {
				$latteParam["success"] = false;;
				$latteParam["error"]["emailNotExists"] = TRUE;
			}
		}
	} else {
		header('Location: index.php');
		exit();
	}
}

// render to output
$latte->render('templates/recover.latte', $latteParam);

include 'includes/overall/footer.php'; ?>