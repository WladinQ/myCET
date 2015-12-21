<?php

function change_profile_image($user_id, $file_temp, $file_extn) {
	$file_path = 'images/profile/' .substr(md5(time()), 0, 10) . '.' . $file_extn;
	move_uploaded_file($file_temp, $file_path);
	mysql_query("UPDATE `users` SET `profile` = '" . mysql_real_escape_string($file_path) . "' WHERE `user_id` = " . (int)$user_id);
}

/* zlé -- potrebuje refaktoring
function change_profile_image($user_id, $tmpPath, $fileExt) {
	$path = __DIR__ . '/images/profile/' . md5_file($tmpPath) . '.' . $fileExt;
	$userId = intval($user_id);

	return (
		move_uploaded_file($tmpPath, $path) &&
		mysql_query(<<< SQL
			UPDATE users
			SET profile = '{$path}'
			WHERE user_id = {$userId}
SQL
		)
	);
}
*/

/* dobré */
function mail_users($subject, $body) {
	$query = mysql_query("SELECT `email`, `username` FROM `users` WHERE `email_allow` = 1");
	while (($row = mysql_fetch_assoc($query)) !== false) {
		email($row['email'], $subject, "Dobrý den " . $row['username'] . ",\n\n" . $body);
	}
}

function has_access($user_id, $type) {
	$user_id = intval($user_id);
	$type = intval($type);
	
	return (mysql_result(mysql_query("SELECT COUNT(`user_id`) FROM `users` WHERE `user_id` = $user_id AND `type` = $type"), 0) == 1) ? true : false;
}

/* dobré */
function loggedIn() {
	return (
		isset($_SESSION['user_id']) &&
		!empty($_SESSION['user_id'])
	);
}

function recover($mode, $email) {
	$mode 		= sanitize($mode);
	$email		= sanitize($email);
	
	$user_data 	= user_data(user_id_from_email($email), 'user_id', 'username');
	
	if ($mode == 'username') {
		email($email, 'myČET -- zabudnutý nick', "Dobrý den " . $email . ",\n\nTvé uživatelské jméno je: " . $user_data['username'] . "\n\n myČET.cz");
	} else if ($mode == 'password') {
		$generated_password = substr(md5(rand(999, 999999)), 0, 8);
		change_password($user_data['user_id'], $generated_password);
		
		update_user($user_data['user_id'], array('password_recover' => '1'));
		
		email($email, 'myČET -- obnova hesla', "Dobrý den " . $user_data['username'] . ",\n\nTvé nové heslo je: " . $generated_password . "\n\n myČET.cz");
	}
}

function update_user($user_id, $update_data) {
	$update = array();
	array_walk($update_data, 'array_sanitize');

	foreach($update_data as $field=>$data) {
		$update[] = '`' . $field . '` = \'' . $data . '\'';
	}
	
	mysql_query("UPDATE `users` SET " . implode(', ', $update) . " WHERE `user_id` = $user_id");
}

function update_user_info() {
	trigger_error('Function ' . __FUNCTION__ . '() has not been implemented yet', E_USER_ERROR);
	// mysql_query("UPDATE");
}

function activate($email, $email_code) {
	$email		= mysql_real_escape_string($email);
	$email_code	= mysql_real_escape_string($email_code);
	
	if (mysql_result(mysql_query("SELECT COUNT(`user_id`) FROM `users` WHERE `email` = '$email' AND `email_code` = '$email_code' AND `active` = 0"), 0) == 1) {
		mysql_query("UPDATE `users` SET `active` = 1 WHERE `email` = '$email'");
		return true;
	} else {
		return false;
	}
}

/* dobré */ 
function change_password($user_id, $password) {
	$user_id = (int)$user_id;
	$password = md5($password);
	
	mysql_query("UPDATE `users` SET `password` = '$password', `password_recover` = 0 WHERE `user_id` = $user_id");
}

function register_user($register_data) {
	array_walk($register_data, 'array_sanitize');
	$register_data['password'] = md5($register_data['password']);
	
	$fields = '`' . implode('`, `', array_keys($register_data)) . '`';
	$data = '\'' . implode('\', \'', $register_data) . '\'';

	mysql_query("INSERT INTO `users` ($fields) VALUES ($data)");
	email($register_data['email'], 'Aktivace účtu na myČET', "Dobrý den " . $register_data['username'] . ",\n\n Pro aktivaci účtu, kliknete zde:\n\n http://mycet.php5.sk/activate.php?email=" . $register_data['email'] . "&email_code=" . $register_data['email_code'] . "\n\n myČET.cz");
}

/* dobré */
function user_count() {
	// cache
	static $count;

	if(!isset($count))
		$count = mysql_result(
			mysql_query("SELECT COUNT(`user_id`) FROM `users` WHERE `active` = 1"), // mysql result-set
			0 // first result
		);
	
	return $count;

}

/* 
	nie je dobré
	čo má vrátiť funkcia v prípade, že jej dodáš iba prvý parameter?

	mimochodom, na túto funkciu by mohla delegovať zodpovednosť getUser()
*/
function user_data($user_id) {
	$data = array();
	$user_id = (int) $user_id;
	
	if (func_num_args() > 1) {
		$fields = '`' . join('`,`', array_slice(func_get_args(), 1)) . '`';
	} else {
		$fields = ' * ';
	}
	
	$data = mysql_fetch_assoc(mysql_query("SELECT {$fields} FROM `users` WHERE `user_id` = {$user_id}"));
	return $data;

}

/* dobré */
function getUser($user_id, $field) {
	return user_data($user_id, $field)[$field];
}

/**
 * Returns the id of currently authenticated user.
 *
 * @return int
 */
function getAuthenticatedUser() {
	return
		loggedIn()
			? intval($_SESSION['user_id'])
			: 0;
}

/* dobré */
function logged_in() {
	return loggedIn();
}

/* dobré */
function user_exists($username) {
	$username = sanitize($username);
	 return (mysql_result(mysql_query("SELECT COUNT('user_id') FROM `users` WHERE `username` = '$username'"), 0) == 1);
}

/* dobré */
function email_exists($email) {
	$email = sanitize($email);
	return (mysql_result(mysql_query("SELECT COUNT('user_id') FROM `users` WHERE `email` = '$email'"), 0) == 1);
}

/* dobré */
function user_active($username) {
	$username = sanitize($username);
	return (mysql_result(mysql_query("SELECT COUNT('user_id') FROM `users` WHERE `username` = '$username' AND `active` = 1"), 0) == 1);
}

/* dobré */
function user_id_from_username($username) {
	$username = sanitize($username);
	return mysql_result(mysql_query("SELECT `user_id` FROM `users` WHERE `username` = '$username'"), 0, 'user_id');
}

function user_id_from_email($email) {
	$email = sanitize($email);
	return mysql_result(mysql_query("SELECT `user_id` FROM `users` WHERE `email` = '$email'"), 0, 'user_id');
}

/* dobré */
function login($username, $password) {

	$loginQuery = sprintf("SELECT COUNT(`user_id`) FROM `users` WHERE `username` = '%s' AND `password` = '%s'", sanitize($username), md5($password));

	if(mysql_result(mysql_query($loginQuery), 0) + 0 === 1) {
		return user_id_from_username($username);
	}

	return FALSE;
}

function checkAge($date) {
   try {
   	$date = new DateTime($date);

   	if($date->diff(new DateTime)->y < 14) {
   		throw new Exception;
   	}

   	return $date;

   } catch(Exception $exc) {
   	return false;
   }
}

///
/// Exceptions
///

/**
 * Exception thrown if user isn't correctly authenticated to do some action.
 */
class AuthenticationException extends \RuntimeException
{

}

/**
 * Exception thrown when user hasn't permissions to do something.
 */
class AuthorizationException extends \RuntimeException
{

}
