<?php
include 'core/init.php';
protect_page();
moderator_protect();
include 'includes/overall/header.php';

$latteParam["has_access"] = (has_access(AUTHENTIZATED_USER_ID, 2) === true);
	
// render to output
$latte->render('templates/moderator.latte', $latteParam);
?>
<?php include 'includes/overall/footer.php'; ?>
<?php // include 'includes/chat.php'; ?>