<?php
include 'core/init.php';
protect_page();

if (empty($_POST) === false) {
	$required_fields = array('current_password', 'password', 'password_again');
	foreach($_POST as $key=>$value) {
		if (empty($value) && in_array($key, $required_fields) === true) {
			$errors[] = 'Pole označené hvězdičkou jsou povinná.';
			break 1;
		}
	}
	
	if (md5($_POST['current_password']) === $user_data['password']) {
		if (trim($_POST['password']) !== trim($_POST['password_again'])) {
			$errors[] = 'Vaše nové heslá se neshodují!';
		} else if (strlen($_POST['password']) < 6) {
			$errors[] = 'Vaše heslo musí mít alespoň 6 znaků!';
		}
	} else {
		$errors[] = 'Vaše aktuální heslo je nesprávné!';
	}
}

include 'includes/overall/header.php';
?>	
<h1>Změna hesla</h1>

<?php
if (isset($_GET['success']) === true && empty($_GET['success']) === true) {
	echo 'Vaše heslo bylo změněno.';
} else {

	if (isset($_GET['force']) === true && empty($_GET['force']) === true) {
	?>
		<p>You must change your password now that you've requested.</p>
	<?php
	}
	
	if (empty($_POST) === false && empty($errors) === true) {
		change_password(AUTHENTIZATED_USER_ID, $_POST['password']);
		header('Location: change-password.php?success');
	} else if (empty($errors) === false) {
		echo output_errors($errors);
	}
	?>

	<form action="" method="post">
		<table border="0px">
			<tr>
				<td>Staré heslo</td>
				<td width="20px"></td>
				<td><input class="inputtextpasstextarea" type="text" name="current_password"></td>
			</tr>
			<tr>
				<td>Nové heslo</td>
				<td width="20px"></td>
				<td><input class="inputtextpasstextarea" type="text" name="password"></td>
			</tr>
			<tr>
				<td>Nové heslo (pro kontrolu)</td>
				<td width="20px"></td>
				<td><input class="inputtextpasstextarea" type="text" name="password_again"></td>
			</tr>
			<tr>
				<td></td>
				<td width="20px"></td>
				<td><input class="inputsubmitbuttons" type="submit" value="Změnit heslo"></td>
			</tr>
		</table>
	</form>
<?php
}
include 'includes/overall/footer.php';
?>