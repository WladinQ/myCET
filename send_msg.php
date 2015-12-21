<?php
	include 'core/init.php';
	protect_page();
	include 'includes/overall/header.php';
?>
<div id="">	
	<?php
		$latteParam["user"] = false;
		$latteParam["check_con"] = false;
		$users = array();
		if(isset($_GET['user']) && !empty($_GET['user'])){
			$latteParam["user"] = true;

				if(isset($_POST['message']) && !empty($_POST['message'])){
					$my_id 			= AUTHENTIZATED_USER_ID;
					$user 			= $_GET['user'];
					$random_number 	= rand();
					$message 		= $_POST['message'];
					
					$check_con = mysql_query("SELECT `hash` FROM `message_group` WHERE (`user_one`='$my_id' AND `user_two`='$user') OR (`user_one`='$user' AND `user_two`='$my_id')");
					
					if(mysql_num_rows($check_con) == 1){
						$latteParam["check_con"] = true;
					} else {
					mysql_query("INSERT INTO message_group VALUES('', '$my_id', '$user', '$random_number')");
					mysql_query("INSERT INTO messages VALUES('', '$random_number', '$my_id', '$user', '$message', now(), now())");
					}
				}
			$latteParam["sendname"] = getuser($_GET['user'], 'username');
		} else {
			$user_list = mysql_query("SELECT `user_id`, `username` FROM `users`");
			while($run_user = mysql_fetch_array($user_list)){
				$users[] = $run_user;
			}
		}

		$latteParam["users"] = $users;
	?>
</div>
<?php 

// render to output
$latte->render('templates/send_msg.latte', $latteParam);

include 'includes/overall/footer.php'; ?>