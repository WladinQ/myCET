<?php
	include 'core/init.php';
	protect_page();
	include 'includes/overall/header.php';

		$my_id = AUTHENTIZATED_USER_ID;
		$latteParam["notices"] = mysql_num_rows(mysql_query("SELECT * FROM friend_requests WHERE user_to='$my_id'"));		
		$latteParam["my_like_post"] = mysql_num_rows(mysql_query("SELECT * FROM like_post WHERE id_users_post='$my_id'"));		
		$latteParam["celkovo"] = $notices + $my_like_post;
		$latteParam["typ"] = false;

		$requests = array();
		$likes = array();

		if(isset($_GET['zadosti-o-pratelstvi'])) { 
			$latteParam["typ"] = "zadosti";
				$my_id  = AUTHENTIZATED_USER_ID;
				$chceck_notices = mysql_query("SELECT user_to FROM friend_requests WHERE user_to='$my_id'");
				$chceck = mysql_num_rows($chceck_notices);
					
				if ($chceck == 0){
				} else if ($chceck != 0){
					$my_id  = AUTHENTIZATED_USER_ID;
					$notices = mysql_query("SELECT * FROM friend_requests WHERE user_to='$my_id'");
					while($data 	= mysql_fetch_assoc($notices)){
						$user_from	= $data['user_from'];
						$user_to		= $data['user_to'];
						$date 			= $data['date'];
						$date 			= strtotime($date);
						$data["date2"] 		= date ('d.m.Y', $date);
						$time 			= $data['time'];
							
						$data["users"]			= getuser($user_to, 'username');
						$data["users2"]		= getuser($user_from, 'username');
						$data["photo"]			= getuser($user_from, 'profile');
						
						$likes[] = $data;
					}
				}
	 } else if(isset($_GET['libi-se-mi-to'])) {
	 		$latteParam["typ"] = "libi";
				$my_id  = AUTHENTIZATED_USER_ID;
				$chceck_notices_like = mysql_query("SELECT id_users_post FROM like_post WHERE id_users_post='$my_id'");
				$chceck_like = mysql_num_rows($chceck_notices_like);
					
				if ($chceck_like == 0){
				} else if ($chceck_like != 0){
					$my_id  = AUTHENTIZATED_USER_ID;
					$notices_like = mysql_query("SELECT * FROM like_post WHERE id_users_post='$my_id'");
					while($data_like = mysql_fetch_assoc($notices_like)){
						$post					= $data_like['id_post'];
						$my_post			= $data_like['id_users_post'];
						$kto_post_like		= $data_like['id_users_like'];
						$date 					= $data_like['date'];
						$date 					= strtotime($date);
						$date2 				= date ('d.m.Y', $date);
						$time 					= $data_like['time'];
							
						$data_like["my_username"]			= getuser($my_post, 'username');
						$data_like["username"]		= getuser($kto_post_like, 'username');
						
						$likes[] = $data_like;
					}
				}
		} 

		$latteParam["requests"] = $requests;
		$latteParam["likes"] = $likes; 

// render to output
$latte->render('templates/oznameni.latte', $latteParam);

include 'includes/overall/footer.php'; ?>