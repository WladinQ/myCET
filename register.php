<?php
logged_in_redirect();

if (empty($_POST) === false) {
	$required_fields = array('username', 'password', 'password_recover', 'email');
	foreach($_POST as $key=>$value) {
		if (empty($value) && in_array($key, $required_fields) === true) {
			$errors_reg[] = '<div class="error_reg">Všechna pole jsou povinná!</div>';
			break 1;
		}
	}
	
	if (empty($errors_reg) === true) {
		if (user_exists($_POST['username']) === true) {
			$errors_reg[] = '<div class="error_reg">Omlouváme se, ale uživatelské jméno \'' . $_POST['username'] . '\' je již obsazeno.</div>';
		}
		if (preg_match("/\\s/", $_POST['username']) == true) {
			$errors_reg[] = '<div class="error_reg">Vaše uživatelské jméno nesmí obsahovat žádné mezery.</div>';
		}
		if (strlen($_POST['password']) < 6) {
			$errors_reg[] = '<div class="error_reg">Vaše heslo musí mít alespoň 6 znaků!</div>';
		}
		if ($_POST['password'] !== $_POST['password_recover']) {
			$errors_reg[] = '<div class="error_reg">Vaše hesla se neshodují!</div>';
		}
		if (filter_var($_POST['email'], FILTER_VALIDATE_EMAIL) === false) {
			$errors_reg[] = '<div class="error_reg">Je nutná platná e-mailová adresa.</div>';
		}
		if (email_exists($_POST['email']) === true) {
			$errors_reg[] = '<div class="error_reg">Je nám líto ,e-mail \'' . $_POST['email'] . '\' je již obsazeno.</div>';
		}
	}
}
?>
	<?php
		$latteParam["status"] = "";
		if (isset($_GET['success']) && empty($_GET['success'])) {
			$latteParam["status"] = '<div class="accepted_reg">Váš účet byl úspěšně zaregistrován! Prosím zkontrolujte svůj e-mail pro aktivaci vašeho účtu.</div>';
		} else {
			if (empty($_POST) === false && empty($errors_reg) === true) {
				$register_data = array(
					'username' 			=> $_POST['username'],
					'password' 			=> $_POST['password'],
					'profile'				=> $_POST['profile'],
					'status'				=> $_POST['status'],
					'email' 				=> $_POST['email'],
					'okres'				=> $_POST['okres'],
					'bday'				=> $_POST['bday'],
					'sex'					=> $_POST['sex'],
					'vztah'				=> $_POST['vztah'],
					'PaP'					=> $_POST['checkbox'],
					'email_code' 		=> md5($_POST['username'] + microtime())
				);
				
				register_user($register_data);
				header('Location: index.php?success');
				exit();
				
			} else if (empty($errors_reg) === false) {
				$latteParam["status"] = output_errors($errors_reg);
			}
			}
			/* doriešit zobrazenie output_errors */


			// render to output
			$latte->render('templates/register.latte', $latteParam);
	?>
