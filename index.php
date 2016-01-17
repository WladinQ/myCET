<?php

include 'core/init.php';

include 'includes/overall/header.php';


if(loggedin()){ 

	if(isset($_POST['message']) && !empty($_POST['message'])){
		$odKoho = AUTHENTIZATED_USER_ID;
		$preKoho = $user_id;
		$message = $_POST['message'];
		
		mysql_query("INSERT INTO post VALUES('', '$odKoho', '$preKoho', '$message', now(), now())");
	}

	if(isset($_POST['comment']) && !empty($_POST['comment'])){
		$postId = $_POST['idcommentpost'];
		$odKoho = AUTHENTIZATED_USER_ID;
		$comment = $_POST['comment'];
		
		mysql_query("INSERT INTO comment VALUES('', '$postId', '$odKoho', '$comment', now(), now())");
	}

	$my_id = AUTHENTIZATED_USER_ID;
	$post_query = mysql_query("SELECT id, odKoho, preKoho, message, date, time_post FROM post WHERE preKoho = 0 ORDER BY date DESC, time_post DESC");
	$numrows = mysql_num_rows($post_query);
	
	$posts = array();
	if ($numrows == 0){

	} else {
		
		while($run_post = mysql_fetch_array($post_query)){
			$post_id 		= $run_post['id'];
			$post_odKoho 	= $run_post['odKoho'];
			$post_preKoho 	= $run_post['preKoho'];
			$post_message 	= $run_post['message'];
			$post_date		= $run_post['date'];
			$post_date 		= strtotime($post_date);
			$post_date2 	= date ('d.m.Y', $post_date);
			$post_time 		= $run_post['time_post'];
					
			$run_post['username'] = getuser($post_odKoho, 'username');

			$my_id = AUTHENTIZATED_USER_ID;
						    
			$chceck_like_num = mysql_num_rows(mysql_query("SELECT id_post FROM like_post WHERE id_post = $post_id"));
						    
			$chceck = mysql_query("SELECT * FROM like_post");
			$chceck_like_post = mysql_query("SELECT id_post FROM like_post WHERE id_post = $post_id");
			$chceck_like = mysql_num_rows($chceck_like_post);
						    
			if ($chceck_like == 0){
				$run_post["like"] = "like";
			} if ($chceck_like != 0){
				$run_post["like"] = "like ($chceck_like_num)";
			}

			$posts[] = $run_post;
		}
		$latteParam["posts"] = $posts;
	}
	$latteParam["numrows"] = $numrows;

// render to output
$latte->render('templates/index.latte', $latteParam);

} else {
	include 'register.php';
} 

include 'includes/overall/footer.php';
