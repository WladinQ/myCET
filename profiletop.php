<?php
	if(isset($_POST['report']) && !empty($_POST['report'])){
		$odKoho 	= AUTHENTIZATED_USER_ID;
		$kto		= $user_id;
		mysql_query("INSERT INTO report_profile VALUES('', '$odKoho', '$kto', now(), now())");
	} else if(isset($_POST['cancelreport']) && !empty($_POST['cancelreport'])){
		$odKoho 	= AUTHENTIZATED_USER_ID;
		$kto		= $user_id;
		mysql_query("DELETE FROM report_profile WHERE kto=$kto");
	}
	$latteParam["mujProfil"] = (!empty($user_data['profile']) && $user_id === $_SESSION['user_id']); /* len na prihlasonom profile a len na mojom */


	$latteParam["prihlasen"] = false;
	if (!empty($user_data['profile']) && $user_id != $_SESSION['user_id']) { /* len na inych profiloch a len pri prihlaseni */
		$latteParam["prihlasen"] = true;
		$latteParam["zabanovat"] = (has_access(AUTHENTIZATED_USER_ID, 1) === true);
				$my_id = AUTHENTIZATED_USER_ID;
				
				$requests = mysql_query("SELECT kto FROM report_profile WHERE kto=$user_id");
				$latteParam["req"] = mysql_num_rows($requests);
	}
	$muz = 'Muž';
	$zena = 'Žena';
	$sex = 'muz';
	$sex = 'zena';
	$latteParam["sex"] = $$profile_data['sex'];

	$latteParam["vek"] = floor((strtotime(date('d-m-Y')) - strtotime($profile_data['bday']))/(60*60*24*365.2421896)); 

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
	
	$latteParam["okres"] = $$profile_data['okres'];
	$vztah = array(
		'free' => 'Svobodný/á',
		'notfree' => 'Zadaný/á');
	$latteParam["vztah"] = $vztah[$profile_data['vztah']];

	$latteParam["friends"] = mysql_num_rows(mysql_query("SELECT myId FROM friends WHERE myId=$user_id"));
	$latteParam["alba"] = mysql_num_rows(mysql_query("SELECT id_users FROM fotoalbumy WHERE id_users=$user_id"));

	$latteParam["profile_data"] = $profile_data;


// render to output
$latte->render('templates/profiletop.latte', $latteParam);

?>			