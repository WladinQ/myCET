<?php
include 'core/init.php';
protect_page();
include 'includes/overall/header.php';
			
			$latteParam = array();
			$latteParam["status"] = false;

			if (isset($_FILES['profile']) === true) {
				if (empty($_FILES['profile']['name']) === true) {
					$latteParam["status"] = 'Prosím, vyberte soubor!';
				} else {
					$allowed = array('jpg', 'jpeg', 'gif', 'png');
					
					$file_name = $_FILES['profile']['name'];
					$file_extn = strtolower(end(explode('.', $file_name)));
					$file_temp = $_FILES['profile']['tmp_name'];
					
					if (in_array($file_extn, $allowed) === true) {
						change_profile_image(AUTHENTIZATED_USER_ID, $file_temp, $file_extn);
						
						$latteParam["status"] = 'Profilová fotka úspěšně aktualizována.';
						/*header('Location: ' . $current_file);
						exit();*/
						
					} else {
						$latteParam["status"] = 'Nesprávný typ souboru! Povolený typ: ' . implode(', ', $allowed);
					}
				}
			}


			// render to output
			$latte->render('templates/change-avatar.latte', $latteParam);
			
			?>

<?php include 'includes/overall/footer.php'; ?>