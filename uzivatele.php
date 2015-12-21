<?php
	include 'core/init.php';
	protect_page();
	include 'includes/overall/header.php';

	$users = array();
			$my_id = AUTHENTIZATED_USER_ID;
			$mem_query = mysql_query("SELECT user_id, profile, sex, bday, okres, vztah, status FROM users WHERE not user_id = $my_id ORDER BY username");
			while($run_mem = mysql_fetch_array($mem_query)){
				$user_id = $run_mem['user_id'];
				$sendmsg = $run_mem['user_id'];
				$profile = $run_mem['profile'];
				
				$sex = array(
					'muz' => "Muž",
					'zena' => "Žena"
					);
				$run_mem['sex'] = $sex[$run_mem['sex']];
				
				$vztah = array(
					'free' => "Svobodný/á",
					'notfree' => "Zadaný/á"
					);

				$run_mem['vztah'] = $vztah[$run_mem['vztah']];
				
				$run_mem["bday"] = floor((strtotime(date('d-m-Y')) - strtotime($run_mem['bday']))/(60*60*24*365.2421896));
				
				$okresy = array(
					"c0" => 'Česká republika',
					"c1" => 'Hlavní město Praha',
					"c2" => 'Jihočeský kraj',
					"c3" => 'Jihomoravský kraj',
					"c4" => 'Karlovarský kraj',
					"c5" => 'Královehradecký kraj',
					"c6" => 'Liberecký kraj',
					"c7" => 'Moravskoslezský kraj',
					"c8" => 'Olomoucký kraj',
					"c9" => 'Pardubický kraj',
					"c10" => 'Plzeňský kraj',
					"c11" => 'Středočeský kraj',
					"c12" => 'Ústecký kraj',
					"c13" => 'Vysočina',
					"c14" => 'Zlínský kraj',
					"s0" => 'Slovenská republika',
					"s1" => 'Banskobystrický kraj',
					"s2" => 'Bratislavský kraj',
					"s3" => 'Košický kraj',
					"s4" => 'Nitriansky kraj',
					"s5" => 'Prešovský kraj',
					"s6" => 'Trnavský kraj',
					"s7" => 'Trenčiansky kraj',
					"s8" => 'Žilinský kraj'
				);
					
					
				$run_mem['okres'] = $okresy[$run_mem['okres']];
				
				$status = $run_mem['status'];
				
				$namycet = 'registrován před: 2 týdny';

				$run_mem["username"] = getuser($user_id, 'username');

				$users[] = $run_mem;
			}

			$latteParam["users"] = $users;

			// render to output
			$latte->render('templates/uzivatele.latte', $latteParam);

		?>

<?php include 'includes/overall/footer.php'; ?>
