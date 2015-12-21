<?php
	include __DIR__ . '/core/init.php';
	
	$postId = $_POST['post_input_id'];
	$odKoho = AUTHENTIZATED_USER_ID;
	$comment = $_POST['comment'];
	
	mysql_query("INSERT INTO comment VALUES('', '$postId', '$odKoho', '$comment', now(), now())");
?>

<?php if(loggedin()){ 
	$latteParam["postId"] = $postId;
	
	// render to output
	$latte->render('templates/comment.latte', $latteParam);	

}
?>