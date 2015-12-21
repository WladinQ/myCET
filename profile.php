<?php
 
if(!count($_GET) || (count($_GET) === 1 && isset($_GET['username']))) {
    header('Location: ?profil', true, 301);
    exit;
}

// print_r($_GET); exit;



include __DIR__ . '/core/init.php';
include __DIR__ . '/includes/overall/header.php';

if (isset($_GET['username']) && !empty($_GET['username'])) {
	$username		= $_GET['username'];
	
	if (user_exists($username) === true) {
		$user_id		= user_id_from_username($username);
		$profile_data	= call_user_func_array('user_data', [$user_id, 'username', 'profile', 'status', 'email', 'okres', 'bday', 'sex', 'vztah']);
		
?>
<div id="container">
<div class="profile2">
	<script type="text/javascript" src="js/jquery.js"></script>
	<script type="text/javascript" src="js/thickbox.js"></script>
		
	<?php include('profileleft.php') ?>
		
	<div class="profile2info">
			
		<?php include('profiletop.php') ?>
		
		<div id="info">
	
		<?php if(isset($_GET['profil'])) {  // prerobit profil ?>
			<div class="status-text">
				<?php echo $profile_data['status']; ?> 
				
				<?php if (!empty($user_data['profile']) && $user_id === $_SESSION['user_id']): ?>
				<?php
					if (empty($user_data['profile']) === false) {
							echo '<a href="?zmena-statusu" name="zmena-statusu" class="profilestatus">Změnit status</a>';
					} else {
							echo '';
					}
				?>
				<?php ; endif ?>
			</div>
			<?php if (!empty($user_data['profile']) && $user_id === $_SESSION['user_id']): ?>
			<?php
				$mem_query_info = mysql_query("SELECT * FROM users_info WHERE info_id = $user_id");
				$numrows_info = mysql_num_rows($mem_query_info);
				if ($numrows_info == 0){
					echo "<a href='$username?pridat-info' class='profilinfobutton'>Přidat informace o sobě</a>";
				} else { ?>
				  <form method="post">
  				  <?php
  				    if(isset($_POST['delete-info']) && !empty($_POST['delete-info'])){
        				$my_id = AUTHENTIZATED_USER_ID;
  		
        				mysql_query("DELETE FROM users_info WHERE info_id = '$my_id'");
        				
        				echo "<div class='accepted'>Informace byli úspěšně smazány. <a href='$username'>Obnovit stránku</a></div>";
        		  }
  				  ?>
					  <input type="submit" name="delete-info" value="Smazat informace">
					</form>
				<?php
					echo "<a href='$username?upravit-info' class='profilinfobutton'>Upravit informace</a>";
				?>
				<?php }
			?>
			<?php ; endif ?>
			<?php
				$mem_query = mysql_query("SELECT * FROM users_info WHERE info_id = $user_id");
				$numrows = mysql_num_rows($mem_query);
				if ($numrows == 0){
					echo "Uživatel <b>$username</b> nemá vyplněné žádné informace.";
				} else {
				while($run_mem = mysql_fetch_array($mem_query)){
					$vyska 					= $run_mem['vyska'];
					$vaha 					= $run_mem['vaha'];
					$typPostavy				= $run_mem['typPostavy'];
					$barvaOci				= $run_mem['barvaOci'];
					$barvaVlasu				= $run_mem['barvaVlasu'];
					$znameniZverokruhu	= $run_mem['znameniZverokruhu'];
					
					?>
						<h1>O mně:</h1>
						
						<table border='0px' width='100%'>
							<tr>
								<td><font size='2px'>Typ postavy:</font><font size='2px' style='float:right'><?php echo $typPostavy; ?></font><hr/></td>
							</tr>
							<tr>
								<td><font size='2px'>Barva očí:</font><font size='2px' style='float:right'><?php echo $barvaOci; ?></font><hr/></td>
							</tr>
							<tr>
								<td><font size='2px'>Barva vlasů:</font><font size='2px' style='float:right'><?php echo $barvaVlasu; ?></font><hr/></td>
							</tr>
						</table>
						<?php if (!empty($user_data['profile']) && $user_id === $_SESSION['user_id']): ?>
						  <?php
						    $my_id  = AUTHENTIZATED_USER_ID;
						    $check  = mysql_query("SELECT my_id FROM povolenie_komentovat_profil WHERE my_id='$my_id'");
						    $checknum = mysql_num_rows($check);
						    
						    if ($checknum == 0){ ?>
					        <div id="povoleni">
					          <form method="post">
					            <?php
              			    if(isset($_POST['povolitkomenty']) && !empty($_POST['povolitkomenty'])){
                    				$my_id = AUTHENTIZATED_USER_ID;
              		
                    				mysql_query("INSERT INTO povolenie_komentovat_profil(id,my_id)  VALUES('','$my_id')");
                    				
                    				echo "<div class='accepted_comment'>Komentováni profilu povoleno. <a href='$username'>Obnovit profil</a></div>";
                    		}
              			  ?>
						          <input type="submit" name="povolitkomenty" value="Povolit komentováni profilu">
						        </form>
						      </div>
				        <?php } else if ($checknum != 0) { ?>
				          <div id="povoleni">
					          <form method="post">
					            <?php
              			    if(isset($_POST['zrusitkomenty']) && !empty($_POST['zrusitkomenty'])){
                    				$my_id = AUTHENTIZATED_USER_ID;
              		
                    				mysql_query("DELETE FROM povolenie_komentovat_profil WHERE my_id='$my_id'");
                    				
                    				echo "<div class='accepted_comment'>Komentováni profilu zrušeno. <a href='$username'>Obnovit profil</a></div>";
                    		}
              			  ?>
						          <input type="submit" name="zrusitkomenty" value="Zrusit povolení komentovat">
						        </form>
						      </div>
				      <?php } ?>
			      <?php ; endif ?>
			      <div id="comment_profile">
			         <?php
			          /* komentare zobrazovat len ak sa nachadza my_id v comment_profile */
			         ?>
				      <h1>Komentáře</h1>
				    </div>
					<?php
				}
			?>
			<?php } ?>
			<?php } else if(isset($_GET['pridat-info'])) { 
			protect_page();
			?>
			<form method="post">
			  <?php
			    if(isset($_POST['submit']) && !empty($_POST['submit'])){
      				$my_id 						= AUTHENTIZATED_USER_ID;
          		$vyska 						= $_POST['vyska'];
          		$vaha 						= $_POST['vaha'];
          		$typPostavy 				= $_POST['typPostavy'];
          		$barvaOci 					= $_POST['barvaOci'];
          		$barvaVlasu 				= $_POST['barvaVlasu'];
          		$znameniZverokruhu 			= $_POST['znameniZverokruhu'];
		
      				mysql_query("INSERT INTO users_info(id,info_id,vyska,vaha,typPostavy,barvaOci,barvaVlasu,znameniZverokruhu)  VALUES('','$my_id','$vyska','$vaha','$typPostavy','$barvaOci','$barvaVlasu','$znameniZverokruhu')");
      				
      				echo "<div class='accepted'>Informace o vás byly úspěšně přidané. <a href='$username'>Zpět na profil</a></div>";
      		}
			  ?>
				<table id="settings-info" border="0px" width="100%">
					<tr>
						<td colspan="3"><h1>Základní informace</h1></td>
					</tr>
					<tr height="10px"><td colspan="3"></td></tr>
					<tr>
						<td width="22%">Výška:</td>
						<td><input style="text-align: right;" type="text" name="vyska" maxlength="3"></td>
						<td width="14%">cm</td>
					</tr>
					<tr>
						<td>Váha:</td>
						<td><input style="text-align: right;" type="text" name="vaha" maxlength="3"></td>
						<td>kg</td>
					</tr>
					<tr>
						<td>Typ postavy:</td>
						<td><input style="text-align: right;" type="text" name="typPostavy" maxlength="70"></td>
						<td>(max. 70 znaků)</td>
					</tr>
					<tr>
						<td>Barva očí:</td>
						<td><input style="text-align: right;" type="text" name="barvaOci" maxlength="70"></td>
						<td>(max. 70 znaků)</td>
					</tr>
					<tr>
						<td>Barva vlasů:</td>
						<td><input style="text-align: right;" type="text" name="barvaVlasu" maxlength="70"></td>
						<td>(max. 70 znaků)</td>
					</tr>
					<tr>
						<td>Znamení ve zvěrokruhu:</td>
						<td><input style="text-align: right;" type="text" name="znameniZverokruhu" maxlength="70"></td>
						<td>(max. 70 znaků)</td>
					</tr>
					<tr height="10px"><td colspan="3"></td></tr>
					<tr>
						<td></td>
						<td><input class="inputsubmitbuttons" name="submit" type="submit" value="Uložit informace"></td>
						<td></td>
					</tr>
				</table>
			</form>
			<?php } else if(isset($_GET['upravit-info'])) { 
			protect_page();
			?>
			<?php
				$mem_query_info = mysql_query("SELECT * FROM users_info WHERE info_id = $user_id");
				$numrows = mysql_num_rows($mem_query_info);
				
				while($run_mem = mysql_fetch_array($mem_query_info)){
					$vyska 					= $run_mem['vyska'];
					$vaha 					= $run_mem['vaha'];
					$typPostavy				= $run_mem['typPostavy'];
					$barvaOci				= $run_mem['barvaOci'];
					$barvaVlasu				= $run_mem['barvaVlasu'];
					$znameniZverokruhu	= $run_mem['znameniZverokruhu'];
				}
				?>
				<form method="post">
				  <?php
      			if(isset($_POST['submit']) && !empty($_POST['submit'])){
      				$my_id 						= AUTHENTIZATED_USER_ID;
          		$vyska 						= $_POST['vyska'];
          		$vaha 						= $_POST['vaha'];
          		$typPostavy 				= $_POST['typPostavy'];
          		$barvaOci 					= $_POST['barvaOci'];
          		$barvaVlasu 				= $_POST['barvaVlasu'];
          		$znameniZverokruhu 		= $_POST['znameniZverokruhu'];
		
      				mysql_query("UPDATE users_info SET vyska='$vyska', vaha='$vaha', typPostavy='$typPostavy', barvaOci='$barvaOci', barvaVlasu='$barvaVlasu', znameniZverokruhu='$znameniZverokruhu' WHERE info_id='$my_id'");
      				
      				echo "<div class='accepted'>Informace o vás byly úspěšně aktualizovány. <a href='$username'>Zpět na profil</a></div>";
      		}
      		?>
					<table border="0px" id="settings-info" width="100%">
						<tr>
						<td colspan="3"><h1>Základní informace</h1></td>
					</tr>
					<tr height="10px"><td colspan="3"></td></tr>
					<tr>
						<td width="22%">Výška:</td>
						<td><input style="text-align: right;" type="text" name="vyska" maxlength="3" value="<?php echo "$vyska"; ?>"></td>
						<td width="14%">cm</td>
					</tr>
					<tr>
						<td>Váha:</td>
						<td><input style="text-align: right;" type="text" name="vaha" maxlength="3" value="<?php echo "$vaha"; ?>"></td>
						<td>kg</td>
					</tr>
					<tr>
						<td>Typ postavy:</td>
						<td><input style="text-align: right;" type="text" name="typPostavy" maxlength="70" value="<?php echo "$typPostavy"; ?>"></td>
						<td>(max. 70 znaků)</td>
					</tr>
					<tr>
						<td>Barva očí:</td>
						<td><input style="text-align: right;" type="text" name="barvaOci" maxlength="70" value="<?php echo "$barvaOci"; ?>"></td>
						<td>(max. 70 znaků)</td>
					</tr>
					<tr>
						<td>Barva vlasů</td>
						<td><input style="text-align: right;" type="text" name="barvaVlasu" maxlength="70" value="<?php echo "$barvaVlasu"; ?>"></td>
						<td>(max. 70 znaků)</td>
					</tr>
					<tr>
						<td>Znamení ve zvěrokruhu:</td>
						<td><input style="text-align: right;" type="text" name="znameniZverokruhu" maxlength="70" value="<?php echo "$znameniZverokruhu"; ?>"></td>
						<td>(max. 70 znaků)</td>
					</tr>
					<tr height="10px"><td colspan="3"></td></tr>
					<tr>
						<td></td>
						<td><input class="inputsubmitbuttons" name="submit" type="submit" value="Aktualizovat informace"></td>
						<td></td>
					</tr>
					</table>
				</form>
			<?php } else if(isset($_GET['zmena-statusu'])) { 
			protect_page();
			?>
			<div class="status">
				<form method="post">
				  <?php
    		    if(isset($_POST['zmena-statusu']) && !empty($_POST['zmena-statusu'])){
      				$status = $_POST['status'];
	          	$my_id = AUTHENTIZATED_USER_ID;
		
      				mysql_query("UPDATE users SET status = '$status' WHERE user_id = '$my_id'");
      				
      				echo "<div class='accepted'>Status úspěšně aktualizován. <a href='$username'>Zpět na profil</a></div>";
    		    }
    		  ?>
					<input type="text" name="status" id="statusmsglimiter" value="<?php echo $user_data['status']; ?>" maxlength="50" autocomplete='off'><input class="inputsubmitbuttons" type="submit" name="zmena-statusu" value="Uložit status">
				</form>
			</div>
			<?php
				$mem_query = mysql_query("SELECT * FROM users_info WHERE info_id = $user_id");
				$numrows = mysql_num_rows($mem_query);
				if ($numrows == 0){
					echo "Uživatel <b>$username</b> nemá vyplněné žádné informace.";
				} else {
				while($run_mem = mysql_fetch_array($mem_query)){
					$vyska 					= $run_mem['vyska'];
					$vaha 					= $run_mem['vaha'];
					$typPostavy				= $run_mem['typPostavy'];
					$barvaOci				= $run_mem['barvaOci'];
					$barvaVlasu				= $run_mem['barvaVlasu'];
					$znameniZverokruhu	= $run_mem['znameniZverokruhu'];
					
					echo "
						<h1>Základní informace</h1><br>
						<table border='0px' width='100%'>
							<tr>
								<td><font size='2px'>Výška:</font><font size='2px' style='float:right'>$vyska cm</font><hr/></td>
							</tr>
							<tr>
								<td><font size='2px'>Váha:</font><font size='2px' style='float:right'>$vaha kg</font><hr/></td>
							</tr>
							<tr>
								<td><font size='2px'>Typ postavy:</font><font size='2px' style='float:right'>$typPostavy</font><hr/></td>
							</tr>
							<tr>
								<td><font size='2px'>Barva očí:</font><font size='2px' style='float:right'>$barvaOci</font><hr/></td>
							</tr>
							<tr>
								<td><font size='2px'>Barva vlasů:</font><font size='2px' style='float:right'>$barvaVlasu</font><hr/></td>
							</tr>
							<tr>
								<td><font size='2px'>Znamení ve zvěrokruhu:</font><font size='2px' style='float:right'>$znameniZverokruhu</font><hr/></td>
							</tr>
						</table>
					";
				}
			?>
			<?php } ?>
			<?php } else if(isset($_GET['nastenka'])) { ?>
			<div id="nastenka">
				<?php if(loggedin()){ ?>
					<form method="post">
						<?php
							if(isset($_POST['message']) && !empty($_POST['message'])){
								$odKoho = AUTHENTIZATED_USER_ID;
								$preKoho = $user_id;
								$message = $_POST['message'];
							mysql_query("INSERT INTO post VALUES('', '$odKoho', '$preKoho', '$message', now(), now())");
							}
						?>
						<input type="text" name="message" placeholder="Přidat příspěvek..."><input class="inputsubmitbuttons" type="submit" value="Přidat">
					</form>
				<?php } ?>
					<?php
						$post_query = mysql_query("SELECT id, odKoho, preKoho, message, date, time_post FROM post WHERE preKoho = $user_id ORDER BY date DESC, time_post DESC");
						$numrows = mysql_num_rows($post_query);
						if ($numrows == 0){
							echo "<br>Uživatel <b>$username</b> nemá žádné příspěvky.";
						} else {
						while($run_post = mysql_fetch_array($post_query)){
							$post_id 		= $run_post['id'];
							$post_odKoho 	= $run_post['odKoho'];
							$post_preKoho 	= $run_post['preKoho'];
							$post_message 	= $run_post['message'];
							$post_date		= $run_post['date'];
							$post_date 		= strtotime($post_date);
							$post_date2 	= date ('d.m.Y', $post_date);
							$post_time 		= $run_post['time_post'];
							
							$odKoho = getuser($post_odKoho, 'username');
						?>
							<div id="post">
								<a href="<?php echo $odKoho; ?>"><?php echo $odKoho; ?></a> | dne <?php echo $post_date2; ?> o <?php echo $post_time; ?>
								<div class="like">
								  <?php
								    $my_id = AUTHENTIZATED_USER_ID;
								    
								    $chceck_like_num = mysql_num_rows(mysql_query("SELECT id_post FROM like_post WHERE id_post = $post_id"));
								    
								    $chceck = mysql_query("SELECT * FROM like_post");
								    $chceck_like_post = mysql_query("SELECT id_post FROM like_post WHERE id_post = $post_id");
								    $chceck_like = mysql_num_rows($chceck_like_post);
								    if ($chceck_like == 0){
								      echo "like";
								    } if ($chceck_like != 0){
								      echo "like ($chceck_like_num)";
								    }
								  ?>
								</div>
								<div class="post_message">
									<?php echo $post_message; ?>
								</div>
								<!--div class="comment">
								  <form method="post">
								    <?php
								      if(isset($_POST['comment']) && !empty($_POST['comment'])){
        								$postId = $_POST['idcommentpost'];
        								$odKoho = AUTHENTIZATED_USER_ID;
        								$comment = $_POST['comment'];
        							mysql_query("INSERT INTO comment VALUES('', '$postId', '$odKoho', '$comment', now(), now())");
        							}
								    ?>
								    <input type="text" name="comment" placeholder="Přidat komentář..."> <input type="hidden" name="idcommentpost" value="<?php echo $post_id; ?>">
								  </form>
								</div-->
							</div>
						<?php
							}
						}
					?>
			</div>
			<?php } else if(isset($_GET['pratele'])) { ?>
				<div id="friends">
					<?php
						$my_id = AUTHENTIZATED_USER_ID;
						$friends_query = mysql_query("SELECT * FROM friends WHERE friendId='$user_id'");
						$friends_numrows = mysql_num_rows($friends_query);
  						if ($friends_numrows == 0){
  							echo "Uživatel <b>$username</b> nemá žádné přátelé.";
  						} else {
						?>
						<?php if(loggedin()){ ?>
							<input type="text" name="searchfriends" placeholder="Hledat přítele...">
						<?php } ?>
						<?php
							while($friends_post = mysql_fetch_array($friends_query)){
							$friends_id 				= $friends_post['id'];
							$friends_myId				= $friends_post['myId'];
							$friends_friendId			= $friends_post['friendId'];
							$friends_friendDate		= $friends_post['friendDate'];
							$friends_friendDate		= strtotime($friends_friendDate);
							$friends_friendDate2		= date ('d.m.Y', $friends_friendDate);
							
							$friends 		= getuser($friends_myId, 'username');
							$friendsphoto 	= getuser($friends_myId, 'profile');
							
							$friends_num = mysql_num_rows(mysql_query("SELECT myId FROM friends WHERE myId=$friends_myId"));
							$alba = mysql_num_rows(mysql_query("SELECT id_users FROM fotoalbumy WHERE id_users=$friends_myId"));
							
							echo	"
  									<table border='0px'>
  										<tr>
  											<td rowspan='2' width='50px' valign='middle'><a href='$friends'><img src='$friendsphoto'></a></td>
  											<td rowspan='2' width='10px'></td>
  											<td valign='top'><a href='$friends'>$friends</a> (přátelé od $friends_friendDate2)</td>
  											<td rowspan='2' width='50px'><input type='submit' name='addfriend' value='Přidat přítele'></td>
  										</tr>
  										<tr>
  											<td valign='bottom'><a href='$friends?nastenka'>Nástěnka</a> | <a href='$friends?pratele'>Přátelé ($friends_num)</a> | <a href='$friends?fotoalbumy'>Fotoalbumy ($alba)</a> | <a href='$friends?videoalbumy'>Videoalbumy</a></td>
  										</tr>
  									</table>
  								  ";
							}
						}
					?>
				</div>
			<?php } else if(isset($_GET['fotoalbumy'])) { ?>
				<div id="fotoalbumy">
					<?php if (!empty($user_data['profile']) && $user_id === $_SESSION['user_id']): ?>
						<?php
							$my_id = AUTHENTIZATED_USER_ID;
							
							$hash = md5($my_id);
							
							$album = mysql_query("SELECT * FROM fotoalbumy WHERE id_users='$my_id'");
							$alb = mysql_num_rows($album);
							if ($alb == 0){
						?>
							<a href='<?php $username; ?>?create_fotoalbum=<?php echo $hash; ?>' name='create'>Vytvořit album</a>
						<?php
							} else if ($alb != 0) { ?>
							<form method="post">
								<?php
									if(isset($_POST['deleteall']) && !empty($_POST['deleteall'])){
										$my_id = AUTHENTIZATED_USER_ID;
										mysql_query("DELETE FROM fotoalbumy WHERE id_users=$my_id");
									}
								?>
								<input type='submit' name='deleteall' value='Smazat všechna alba'>
							</form>
							<a href='<?php $username; ?>?create_fotoalbum=<?php echo $hash; ?>' name='create'>Přidat album</a>
						<?php	} ?>
					<?php ; endif ?>
					<?php
						$my_id = AUTHENTIZATED_USER_ID;
						
						$albumReq = mysql_query("SELECT * FROM fotoalbumy WHERE id_users='$user_id'");
						$Reqalb = mysql_num_rows($albumReq);
						if ($Reqalb == 0){
							echo "Užívatel <b>$username</b> nemá žádne alba.<br><br>";
						} else if ($Reqalb != 0) {
							$albumreq = mysql_query("SELECT * FROM fotoalbumy WHERE id_users='$user_id' ORDER BY date DESC");
							while($albumrow = mysql_fetch_assoc($albumreq)){
								$id			= $albumrow['id'];
								$id_users	= $albumrow['id_users'];
								$name		= $albumrow['name'];
								$password	= $albumrow['password'];
								$cesta		= $albumrow['cesta'];
								$date		= $albumrow['date'];
								$date 		= strtotime($date);
								$date2 		= date ('d.m.Y', $date);
								
								?>
								<table border='0px' width='100%' style='border-collapse: collapse; border-spacing: 0px;'>
									<tr>
										<td width='100px' rowspan='2'><a href=''><img src='<?php echo $cesta; ?>'></a></td>
										<td valign='top' style='background-color: #4D68A1; color: #fff; padding: 5px 0 0 5px;'><a href='' name='name'><h3><?php echo $name; ?></h3></a></td>
										<td valign='top' align='right' style='background-color: #4D68A1; color: #fff; padding: 5px 5px 0 0;'>
											<?php if (!empty($user_data['profile']) && $user_id != $_SESSION['user_id']): /* len na inych profiloch a len pri prihlaseni */ ?>
												<!--form method="post">
													<?php
														if(isset($_POST['favorite']) && !empty($_POST['favorite'])){
															$my_id 			= AUTHENTIZATED_USER_ID;
															$idAlbum 		= $_POST['idalbum'];
															$authorAlbum 	= $id_users;
															$nameAlbum 		= $name;
															$password 		= $password;
															$cesta 			= $cesta;
															$note			= '';
															$date 			= $date;
															
															mysql_query("INSERT INTO favorites_album VALUES('', '$my_id', '$idAlbum', '$authorAlbum', '$nameAlbum', '$password', '$cesta', '$note', now())");
															echo "uspech";
														}
													?>
													<input type="submit" name="favorite" value="Přidat k oblíbeným"> <input type="hidden" name="idalbum" value="<?php echo $id; ?>"> <font color="#425691"> | </font> <input type="submit" name="reportalbum" value="Nahlásit album">
												</form-->
											<?php ; endif ?>
											<?php if (!empty($user_data['profile']) && $user_id === $_SESSION['user_id']): /* len na prihlasonom profile */ ?>
												
												<form method="post">
													<?php
														if(isset($_POST['delete'.$id]) && !empty($_POST['delete'.$id])){
															$my_id = AUTHENTIZATED_USER_ID;
															
															$message = '<div class="message">Album úspěšne smazán. <a href="?fotoalbumy">Obnovit</a></div>';
															
															mysql_query("DELETE FROM fotoalbumy WHERE id='$id'&&id_users='$my_id'");
															echo "$message<br>";
														}
													?>
													<a href=''>Upravit album</a> <font color="#425691"> | </font> <input type='submit' name='delete<?php echo $id ?>' value='Smazat album'>
												</form>
											<?php ; endif ?>
										</td>
									</tr>
									<tr>
										<?php
											
										?>
										<td valign='bottom' style='background-color: #4D68A1; color: #fff; padding: 0 0 5px 5px;'>Počet fotek (0)</td>
										<td valign='bottom' align='right' style='background-color: #4D68A1; color: #fff; padding: 0 5px 5px 0;'>Vytvořeno <?php echo $date2; ?></td>
									</tr>
								</table><br>
								<?php
							}
						}
					?>
					<?php if (!empty($user_data['profile']) && $user_id === $_SESSION['user_id']): /* len na prihlasonom profile a len na mojom */ ?>
						<?php
							$my_id = AUTHENTIZATED_USER_ID;
							
							$fav = mysql_num_rows(mysql_query("SELECT myId FROM favorites_album WHERE myId=$my_id"));
							
							$fav_albumReq = mysql_query("SELECT * FROM favorites_album WHERE myId='$my_id'");
							$favorites_alb = mysql_num_rows($fav_albumReq);
							if ($favorites_alb == 0){
								echo "";
							} else if ($favorites_alb != 0) {
								echo "<h1>Oblíbené alba ($fav)</h1>";
							}
						?>
					<?php ; endif ?>
				</div>
			<?php } else if(isset($_GET['create_fotoalbum'])) { 
			protect_page();
			?>
				<h1>Vytvořit album</h1>
				<div id="createalbum">
					<form method="post">
						<?php
							if(isset($_POST['createalbum']) && !empty($_POST['createalbum'])){
								$my_id 		= AUTHENTIZATED_USER_ID;
								
								$name 		= $_POST['name'];
								$password 	= $_POST['password'];
								$cesta 		= 'images/photoalbum/photoalbumnotfound.jpg';
								$message 	= '<div class="accepted">Album úspěšne vytvořen. <a href="?fotoalbumy">Zpět na alba</a></div>';
								mysql_query("INSERT INTO fotoalbumy VALUES('', '$my_id', '$name', '$password', '$cesta', now())");
								echo $message;
							}
						?>
						<table border="0px" width="100%">
							<tr>
								<td>Jméno alba:</td>
								<td width="20px"></td>
								<td><input type="text" name="name" maxlength="20" autocomplete="off" required></td>
								<td width="20px"></td>
								<td>(max. 20 znaků)</td>
							</tr>
							<tr>
								<td>Heslo:</td>
								<td width="20px"></td>
								<td><input type="password" name="password"></td>
							</tr>
							<tr>
								<td></td>
								<td></td>
								<td>
									<?php if(loggedin()){ ?>
										<input type="submit" name="createalbum" value="Vytvořit">
									<?php } ?>
								</td>
							</tr>
						</table>
					</form>
				</div>
			<?php } else if(isset($_GET['videoalbumy'])) { ?>
				Videoalbumy se připravují
			<?php } else if(isset($_GET['mode'])) { ?>
				hlasovanie
			<?php } ?>
		</div>
	</div>
	<div class="clear"></div>
</div>
		
<?php
	} else {
		echo 'Je nám líto, tento uživatel neexistuje!';
	}
} else {
	header('Location: index.php');
	exit();
}

include 'includes/overall/footer.php';