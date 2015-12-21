<?php

	include 'core/init.php';

	protect_page();

	include 'includes/overall/header.php';



		/* toto php na zobrazenie hlasovania obsahuje fotku = $photo meno = $users pocet bodov = $total a pocet hlasov = $votes */

		

		$sql = mysql_query("SELECT * FROM vote ORDER BY total DESC");

		$items = array();
		while($data = mysql_fetch_assoc($sql)){

			$my_id	= $data['my_id'];
			

			$data["users"] = getuser($my_id, 'username');

			$data["photo"] = getuser($my_id, 'profile');

			$items[] = $data;
		}

		$latteParam["items"] = $items;

		// render to output
		$latte->render('templates/setkani.latte', $latteParam);
?>

<?php include 'includes/overall/footer.php'; ?>

<?php include 'includes/chat.php'; ?>