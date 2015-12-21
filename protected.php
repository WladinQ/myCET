<?php
include 'core/init.php';
include 'includes/overall/header.php';

// render to output
$latte->render('templates/protected.latte');

include 'register.php'; 
include 'includes/overall/footer.php';