<?php
	include 'core/init.php';
	
	$value = $_POST['value'];
	
	
	$query = mysql_query("SELECT username, user_id, profile FROM users WHERE username LIKE '$value%'");
	while($run = mysql_fetch_array($query)){
		$users[] = $run;
	}
	
	$latteParam["users"] = $users;
	
	// render to output
	$latte->render('templates/vyhledavac.latte', $latteParam);	
?>