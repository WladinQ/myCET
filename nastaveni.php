<?php
include 'core/init.php';
protect_page();
include 'includes/overall/header.php';

if (empty($_POST) === false) {
	$required_fields = array('email');
	foreach($_POST as $key=>$value) {
		if (empty($value) && in_array($key, $required_fields) === true) {
			$errors[] = 'Pole označené hvězdičkou jsou povinné.';
			break 1;
		}
	}
	
	if (empty($errors) === true) {
		if (filter_var($_POST['email'], FILTER_VALIDATE_EMAIL) === false) {
			$errors[] = 'Je nutná platná e-mailová adresa.';
		} else if (email_exists($_POST['email']) === true && $user_data['email'] !== $_POST['email']) {
			$errors[] = 'Je nám líto, e-mail \'' . $_POST['email'] . '\' je již v provozu.';
		}
	}
}


$latteParam["success"] = false;
$latteParam["errors"] = false;

if (isset($_GET['success']) === true && empty($_GET['success']) === true) {
	$latteParam["success"] = true;
} else {
if (empty($_POST) === false && empty($errors) === true) {
	
	$update_data = array(
		'email' 		=> $_POST['email'],
		'vztah'			=> $_POST['vztah'],
		'okres' 		=> $_POST['okres'],
		'email_allow'	=> ($_POST['email_allow'] == 'on') ? 1 : 0
	);
	
	update_user(AUTHENTIZATED_USER_ID, $update_data);
	header('Location: settings.php?success');
	exit();
	
} else if (empty($errors) === false) {
	$latteParam["errors"] = output_errors($errors);
}
						$c0 = 'Česká republika';
						$c1 = 'Hlavní město Praha';
						$c2 = 'Jihočeský kraj';
						$c3 = 'Jihomoravský kraj';
						$c4 = 'Karlovarský kraj';
						$c5 = 'Královehradecký kraj';
						$c6 = 'Liberecký kraj';
						$c7 = 'Moravskoslezský kraj';
						$c8 = 'Olomoucký kraj';
						$c9 = 'Pardubický kraj';
						$c10 = 'Plzeňský kraj';
						$c11 = 'Středočeský kraj';
						$c12 = 'Ústecký kraj';
						$c13 = 'Vysočina';
						$c14 = 'Zlínský kraj';
							
						$s0 = 'Slovenská republika';
						$s1 = 'Banskobystrický kraj';
						$s2 = 'Bratislavský kraj';
						$s3 = 'Košický kraj';
						$s4 = 'Nitriansky kraj';
						$s5 = 'Prešovský kraj';
						$s6 = 'Trnavský kraj';
						$s7 = 'Trenčiansky kraj';
						$s8 = 'Žilinský kraj';
						
						$okres = 'c0';
						$okres = 'c1';
						$okres = 'c2';
						$okres = 'c3';
						$okres = 'c4';
						$okres = 'c5';
						$okres = 'c6';
						$okres = 'c7';
						$okres = 'c8';
						$okres = 'c9';
						$okres = 'c10';
						$okres = 'c11';
						$okres = 'c12';
						$okres = 'c13';
						$okres = 'c14';
						
						$okres = 's0';
						$okres = 's1';
						$okres = 's2';
						$okres = 's3';
						$okres = 's4';
						$okres = 's5';
						$okres = 's6';
						$okres = 's7';
						$okres = 's8';
						
						$latteParam["okres"] = $$user_data['okres'];

}

$latteParam["user_data"] = $user_data;

// render to output
$latte->render('templates/nastaveni.latte', $latteParam);


include 'includes/overall/footer.php';
?>