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

?>
<h1>Změnit osobní údaje:</h1><br>

<?php
if (isset($_GET['success']) === true && empty($_GET['success']) === true) {
	echo 'Osobní údaje byly změněny!';
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
	echo output_errors($errors);
}
?>

<form action="" method="post">
	<table id="setting" border="0px">
		<tr>
			<td colspan="8"><input type="checkbox" name="email_allow" <?php if ($user_data['email_allow'] == 1) { echo 'checked="checked"'; } ?>> Chci dostávat e-maily od myČETu</td>
		</tr>
		<tr height="20px">
			<td colspan="8"></td>
		</tr>
		<tr>
			<td width="100px">Partnerský stav:</td>
			<td>
				<select name="vztah">
					<option value="free">Svobodný/á</option>
					<option value="notfree">Zadaný/á</option>
				</select>
			</td>
			<td width="10px"></td>
			<td width="100px">Nový e-mail:</td>
			<td><input class="inputtextpasstextarea" type="text" name="email" value="<?php echo $user_data['email']; ?>"></td>
			<td width="10px"></td>
			<td width="100px">Kraj:</td>
			<td>
				<select name="okres">
					<option value="">
					<?php 
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
						
						echo $$user_data['okres'];
					?>
					</option>
					<option value="c0">Česká republika</option>
					<option value="c1">- Hlavní město Praha</option>
					<option value="c2">- Jihočeský kraj</option>
					<option value="c3">- Jihomoravský kraj</option>
					<option value="c4">- Karlovarský kraj</option>
					<option value="c5">- Královehradecký kraj</option>
					<option value="c6">- Liberecký kraj</option>
					<option value="c7">- Moravskoslezský kraj</option>
					<option value="c8">- Olomoucký kraj</option>
					<option value="c9">- Pardubický kraj</option>
					<option value="c10">- Plzeňský kraj</option>
					<option value="c11">- Středočeský kraj</option>
					<option value="c12">- Ústecký kraj</option>
					<option value="c13">- Vysočina</option>
					<option value="c14">- Zlínský kraj</option>
							
					<option value="s0">Slovenská republika</option>
					<option value="s1">- Banskobystrický kraj</option>
					<option value="s2">- Bratislavský kraj</option>
					<option value="s3">- Košický kraj</option>
					<option value="s4">- Nitriansky kraj</option>
					<option value="s5">- Prešovský kraj</option>
					<option value="s6">- Trnavský kraj</option>
					<option value="s7">- Trenčiansky kraj</option>
					<option value="s8">- Žilinský kraj</option>
				</select>
			</td>
		</tr>
		<tr height="20px">
			<td colspan="8"></td>
		</tr>
		<tr>
			<td colspan="8"><input class="inputsubmitbuttons" type="submit" value="Změnit"></td>
		</tr>
	</table>
</form>
Vyznačené pole (<font color="red">*</font>) jsou třeba vybrat znovu!
<?php
}
include 'includes/overall/footer.php';
?>