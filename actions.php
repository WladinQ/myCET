<?php
	include 'core/init.php';
	protect_page();
	include 'includes/overall/header.php';

	$action = $_GET['action'];
	$username = $_GET['username'];
	$user = $_GET['user_id'];
	$my_id = AUTHENTIZATED_USER_ID;
	
	if($action == 'send'){
		mysql_query("INSERT INTO frnd_req VALUES('', '$my_id', '$user')");
	}
	
	if($action == 'cancel'){
		mysql_query("DELETE FROM `frnd_req` WHERE `od`='$my_id' AND `pre`='$user'");
	}
	
	if($action == 'accept'){
		mysql_query("DELETE FROM `frnd_req` WHERE `od`='$user' AND `pre`='$my_id'");
		mysql_query("INSERT INTO frnds VALUES('', '$user', '$my_id')");
	}
	
	if($action == 'unfrnd'){
		mysql_query("DELETE FROM frnds WHERE (user_one='$my_id' AND user_two='$user') OR (user_one='$user' AND user_two='$my_id')");
	}
	
	header('Refresh:0);
?>

<?php include 'includes/overall/footer.php'; ?>