<nav id="left">
	<form action='login.php' method='post'>
		<?php
			// exit(var_dump($_SESSION));
			if (logged_in() === true){
				include 'includes/widgets/loggedin.php';
			} else {
				include 'includes/widgets/login.php';
			}
			
			include 'includes/widgets/user_count.php';
		?>
</nav>