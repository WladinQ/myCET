<?php

/* rozhodne nie je dobré */
function email($to, $subject, $body) {
	/* trigger_error(__FUNCTION__ . '(): namiesto diakritiky sa posielajú otázniky', E_USER_NOTICE); */
	return mail($to, $subject, $body, 'From: myČET <oznameni@mycet.cz>');
}

/* toto rozhodne nie je dobré */
function logged_in_redirect() {
	if (logged_in()) {
		trigger_error(__FUNCTION__ . '(): HTTP hlavička Location akceptuje iba komletnú URL adresu (http://doména/názov-súboru)', E_USER_NOTICE);
		header('Location: index.php');
		exit();
	}
}

/* toto rozhodne nie je dobré */
function protect_page() {
	if (!logged_in()) {
		trigger_error(__FUNCTION__ . '(): HTTP hlavička Location akceptuje iba komletnú URL adresu (http://doména/názov-súboru)', E_USER_NOTICE);
		// spätne nekompatibilné
		header('Location: protected.php', true, 303); // presmerovať na KOMPLETNÚ URL!!!
		exit();
	}
}

function admin_protect() {
	global $user_data;

	if (!has_access($user_data['user_id'], 1)) {
		trigger_error(__FUNCTION__ . '(): HTTP hlavička Location akceptuje iba komletnú URL adresu (http://doména/názov-súboru)', E_USER_NOTICE);
		header('Location: index.php');
		exit();
	}
}

function moderator_protect() {
	global $user_data;

	if (!has_access($user_data['user_id'], 2)) {
		trigger_error(__FUNCTION__ . '(): HTTP hlavička Location akceptuje iba komletnú URL adresu (http://doména/názov-súboru)', E_USER_NOTICE);
		header('Location: index.php');
		exit();
	}
}

function array_sanitize(& $item) {
	$item = sanitize($item);
}

function sanitize($data) { // wtf? nesmie sa používať na všeobecné escapovanie!
	return htmlspecialchars($data);
}

/**
 * Output HTML-formatted errors.
 * 
 * @param array errors
 * @param bool whether to output instead of return
 * @return string
 */
function output_errors(array $errors, $output = false) {
	$html = implode($errors);

	if($output)
		printf($html);
	else
		return $html;
}
