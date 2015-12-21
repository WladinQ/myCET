<?php

	include 'core/init.php';

	protect_page();

	admin_protect();

	include 'includes/overall/header.php';

?>

<!--?php

	$zobraz_kategorie = mysql_query("SELECT * FROM mistnosti_kategorie");

		while($zobraz = mysql_fetch_array($zobraz_kategorie)){

			$id = $zobraz['id'];

			$jmeno_kategorie	= $zobraz['jmeno_kategorie'];

							

			$kat = '<table style="float:left" width="25%"><tr><td style="background-color: #4D68A1; color: #fff; padding: 5px;" colspan="2"><center><h3>' . $jmeno_kategorie . '</h3></center></td></tr><tr><td>nieco</td></tr></table>';

			

			echo "$kat";

		}

?-->

<?php 
$latteParam["foo"] = "bar";

// render to output
$latte->render('templates/mistnosti.latte', $latteParam);
?>


<?php include 'includes/overall/footer.php'; ?>