<div class="widget">
	<div class="inner">
		<div class="profile">
			</form>
		</div>
		<div class="vyhledavac">
			<span id="box">
				<input type="text" name="vyhledavac" id="search_box" placeholder="Vyhledávač uživatelů...">
			</span>
			<div id="vyhledavac_result">
	
			</div>
			<script src="http://code.jquery.com/jquery-1.10.2.js"></script>
			<script src="js/searchusers.js"></script>
		</div>
		<div id="navigation">
			<a href="index.php">Domov</a>
			
			<a href="<?php echo $user_data['username']; ?>"><b><?php echo $user_data['username']; ?></b></a><font color="#425691"> |</font>
			
			<?php if (has_access(AUTHENTIZATED_USER_ID, 1) === true) { ?>
				<a href="admin.php">admin sekce</a><font color="#425691"> |</font>
			<?php } ?>
			
			<?php if (has_access(AUTHENTIZATED_USER_ID, 2) === true) { ?>
				<a href="">moderátor sekce</a><font color="#425691"> |</font>
			<?php } ?>
			
			<?php
				$my_id = AUTHENTIZATED_USER_ID;
				$notices = mysql_num_rows(mysql_query("SELECT * FROM friend_requests WHERE user_to='$my_id'"));
				
				$my_like_post = mysql_num_rows(mysql_query("SELECT * FROM like_post WHERE id_users_post='$my_id'"));
		
				$celkovo = $notices + $my_like_post;
			?>
			<a href="oznameni.php">oznámení (<?php echo $celkovo; ?>)</a><font color="#425691"> |</font>
				
			<a href="mistnosti.php">místnosti</a><font color="#425691"> |</font>
			
			<a href="uzivatele.php">užívatelé</a><font color="#425691"> |</font>
			
			<a href="setkani.php">setkání</a><font color="#425691"> |</font>
			
			<a href="souteze.php">soutěže</a><font color="#425691"> |</font>
			
			<a href="messages.php">zprávy</a><font color="#425691"> |</font>
	
			<a href="logout.php">odhlásit se</a>
		</div>
	</div>
</div>
<aside id="users_online"> <!-- panel na zobrazenie uzivatelov -->
	<?php
		$my_id = AUTHENTIZATED_USER_ID;
		
		$friends_query = mysql_query("SELECT * FROM friends WHERE myId='$my_id'");
		$friends_numrows = mysql_num_rows($friends_query);
  			if ($friends_numrows == 0){
  				echo "Pro spuštění chatu je potřeba mít přátele.";
  			} else {	
				while($friends_post = mysql_fetch_array($friends_query)){
					$friends_id 				= $friends_post['id'];
					$friends_myId				= $friends_post['myId'];
					$friends_friendId			= $friends_post['friendId'];
					$friends_friendDate		= $friends_post['friendDate'];
					$friends_friendDate		= strtotime($friends_friendDate);
					$friends_friendDate2		= date ('d.m.Y', $friends_friendDate);
							
					$friends 		= getuser($friends_friendId, 'username');
					$friendsphoto 	= getuser($friends_friendId, 'profile');
							
					echo	'
							<ul>
								<li id="">
									<div class="imgSmall"><img src="../../'.$friendsphoto.'" border="0"></div>
									<a href="#" id="'.$friends_friendId.'" class="comecar">'.$friends.'</a>
									<span id="" class="status offline"></span>
								</li>
							</ul>
							';
				}
			}
	?>
</aside>