<?php

	include 'core/init.php';

	include 'includes/overall/header.php';

?>

<?php 

$latteParam["foo"] = "bar";

// render to output
$latte->render('templates/souteze.latte', $latteParam);
?>



<?php include 'includes/overall/footer.php'; ?>