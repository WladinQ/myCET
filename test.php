<?php
	include 'core/init.php';
	protect_page();
	admin_protect();
	include 'includes/overall/header.php';
?>
	<?php
		if (has_access(AUTHENTIZATED_USER_ID, 1) === true) { ?>
		<div class="admin">
			<h1>Nahlásení profilu</h1>
			<?php
				$my_id = AUTHENTIZATED_USER_ID;
				
				$adminRequests = mysql_query("SELECT * FROM report_profile");
				$admin = mysql_num_rows($adminRequests);
				if ($admin == 0){
					echo "Vše v klidu. :-)";
				} else {
					while($getadmin = mysql_fetch_assoc($adminRequests)){
						$id 		= $getadmin['id'];
						$odKoho		= $getadmin['odKoho'];
						$kto		= $getadmin['kto'];
						$date		= $getadmin['date'];
						$date 		= strtotime($date);
						$date2 		= date ('d.m.Y', $date);
						$time		= $getadmin['time'];
						
						$Koho = getuser($odKoho, 'username');
						$Kto = getuser($kto, 'username');
						
						echo "dne $date2 o $time<br><br>Uživatel <b>$Koho</b> nahlásil profil uživatela <a href='$Kto?profil'>$Kto</a>.<hr/>";
					}
				}
			}
			?>
		</div>
	<div id="admin">
		<br>
		<h1>Admin sekce</h1>
		<a href="?send_mail">poslat všem e-mail</a> <a href="?type=user">Aktivace/Deaktivace</a> <a href="?ban_users">Blokovaný uživatelé</a>
	</div>

	<div id="a_d-users">
		<?php if(isset($_GET['type']) && !empty($_GET['type'])){ ?>
		<h1>Aktivace/Deaktivace</h1>
		<center>
			<table border="0px">
				<tr>
					<td width='150px'><h3>Užívatel</h3></td>
					<td><h3>Administrátor</h3></td>
					<td width='200px'></td>
					<td width='150px'><h3>Užívatel</h3></td>
					<td><h3>Moderátor</h3></td>
				</tr>
				<?php
					$list_query = mysql_query("SELECT user_id, username, type FROM users order by username");
					while($run_list = mysql_fetch_array($list_query)){
						$u_id = $run_list['user_id'];
						$u_username = $run_list['username'];
						$u_type_admin = $run_list['type'];
						$u_type_mod = $run_list['type'];
				?>
				<tr>
					<td><?php echo $u_username ?></td>
					<td>
						<?php
							if($u_type_admin == '1'){
								echo "<center><a class='a_d' href='option.php?user_id=$u_id&type=$u_type_admin'>Deaktivovat</a></center>";
							} else {
								echo "<center><a class='a_d' href='option.php?user_id=$u_id&type=$u_type_admin'>Aktivovat</a></center>";
							}
						?>
					</td>
					<td width='200px'></td>
					<td><?php echo $u_username ?></td>
					<td>
						<?php
							if($u_type_mod == '2'){
								echo "<center><a class='a_d' href='option.php?user_id=$u_id&type=$u_type_mod'>Deaktivovat</a></center>";
							} else {
								echo "<center><a class='a_d' href='option.php?user_id=$u_id&type=$u_type_mod'>Aktivovat</a></center>";
							}
						?>
					</td>
				</tr>
				<?php } ?>
			</table>
		</center>	
		<?php } else if(isset($_GET['send_mail'])) { ?>
			<div id="sendallmail">
				<h1>Poslat všem e-mail</h1>
				<?php if (isset($_GET['success']) === true && empty($_GET['success']) === true) { ?>
					<p>E-maily byly odeslány!</p>
				<?php
					} else {
						if (empty($_POST) === false) {
							if (empty($_POST['subject']) === true) {
								$errors[] = 'Je zapotřebí vyplňit předmět!';
							}
							
							if (empty($_POST['body']) === true) {
								$errors[] = 'Je zapotřebí vyplňit správu!';
							}
							
							if (empty($errors) === false) {
								echo output_errors($errors);
							} else {
								mail_users($_POST['subject'], $_POST['body']);
								header('Location: mail.php?success');
								exit();
							}
						}
						?>
						<form action="" method="post">
							<table border="0px">
								<tr>
									<td>Předmět:</td>
									<td><input type="text" name="subject" value="Oznámení"></td>
								</tr>
								<tr>
									<td>Správa:</td>
									<td><textarea name="body"></textarea></td>
								</tr>
								<tr>
									<td></td>
									<td><input class="inputsubmitbuttons" type="submit" value="Odeslat e-maily"></td>
								</tr>
							</table>
						</form>
				</div>
			<?php 
			}
			} else if(isset($_GET['ban_users'])) { ?>
				zabanovany uzivatelia
			<?php } ?>
	</div>
<?php include 'includes/overall/footer.php'; ?>
