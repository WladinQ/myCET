<head>
<?php
	require_once('version.php');
	if(detect_mobile_device() == TRUE) {
		// Presmerovani na mobilni verzi
		header('Location: http://mycet.php5.sk/m/index.php');
		exit;
	};
?>
	<title>myČET | četuj a spoznej nové lidi</title>
	<link rel="shortcut icon" href="css/favicon.png" type="image/png">
	<meta charset="UTF-8">
	
	<link rel="stylesheet" href="css/screen.css" type="text/css">
	<link rel="stylesheet" href="css/thickbox.css" type="text/css" media="screen">
</head>