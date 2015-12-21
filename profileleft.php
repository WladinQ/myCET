<?php

require_once __DIR__ . '/core/init.php';


$latteParam["prihlasen"] = false;
$latteParam["smazanaFotka"] = false;
$latteParam["friendandmsg"] = false;
$latteParam["zapojenHlasovani"] = false;
$latteParam["odstranenHlasovani"] = false;
$latteParam["hlasovani"] = "";

if (!empty($user_data['profile']) && $user_id === $_SESSION['user_id']): /* viditelne len pre prihlaseny profil */
        $latteParam["prihlasen"] = true;
      	if(isset($_POST['smazat-foto']) && !empty($_POST['smazat-foto'])){
      		$profile = 'images/profile/imagenotfound.jpg'; 
	      	$my_id = AUTHENTIZATED_USER_ID;
		
      		mysql_query("UPDATE users SET profile = '$profile' WHERE user_id = '$my_id'");
      				
      		$latteParam["smazanaFotka"] = true;
    		}
endif;
   if (!empty($user_data['profile']) && $user_id != $_SESSION['user_id']): 

      $latteParam["friendandmsg"] = true;
				$my_id = AUTHENTIZATED_USER_ID;
				$friendReq = mysql_query("SELECT * FROM friend_requests WHERE user_to='$user_id' AND user_from='$my_id'");
				$Reqfriend = mysql_num_rows($friendReq);
				$friendsyes = mysql_query("SELECT myId, friendId FROM friends WHERE myId='$my_id'&&friendId='$user_id'");
					if ($Reqfriend == 0){ 
								if(isset($_POST['addfriend']) && !empty($_POST['addfriend'])){
								$my_id 		= AUTHENTIZATED_USER_ID;
									
								mysql_query("INSERT INTO friend_requests VALUES('', '$my_id', '$user_id', now(), now())");
								header("refresh:0");
								exit;
							}
					} else if ($Reqfriend != 0) {
					
				}
        $latteParam["Reqfriend"] = $Reqfriend;
			?>
		<?php endif ?>
	  <?php if (!empty($user_data['profile']) && $user_id === $_SESSION['user_id']): /* len na prihlasonom profile a len na mojom */ ?>
  	    <?php
    	    $mem_query_info = mysql_query("SELECT * FROM vote WHERE my_id = $user_id");
  			$numrows_info = mysql_num_rows($mem_query_info);
  				if ($numrows_info == 0){ 
      	        if(isset($_POST['create_vote']) && !empty($_POST['create_vote'])){
          				$my_id 		= AUTHENTIZATED_USER_ID;
              		$total    = 0;
              		$votes    = 0;
        
                  mysql_query("INSERT INTO vote(id,my_id,total,votes)  VALUES('','$my_id','$total','$votes')");
                  
          				$latteParam["zapojenHlasovani"] = true;
                  }
           } else if ($numrows_info != 0){ 
                if(isset($_POST['delete_vote']) && !empty($_POST['delete_vote'])){
                  $my_id    = AUTHENTIZATED_USER_ID;
        
                  mysql_query("DELETE FROM vote WHERE my_id = '$my_id'");
                  
                  $latteParam["odstranenHlasovani"] = true;
          		}
          }

          $latteParam["numrows_info"] = $numrows_info;
       endif ?>
    <?php
      $stavHlasovani = "";
      $data = mysql_query("SELECT * FROM vote WHERE my_id='$user_id'") or die(mysql_error());
      while($ratings = mysql_fetch_array( $data )) {
        if(isset($ratings['total']) and $ratings['votes']==0){
          $stavHlasovani .= "<center><br>Ještě nebylo hlasováno</center>"; 
        } else {
        $name 		= getuser($user_id, 'username');
        $current = $ratings['total'] / $ratings['votes']; 
          $stavHlasovani .= "<center><br>Počet bodů uživatele <b>" . $name . "</b> je:</center><h1>" . $ratings['total'] . "</h1><center>Počet lidí který bodovali: <b>" . $ratings['votes'] . "</b></center>";
        }
      }

      $latteParam["stavHlasovani"] = $stavHlasovani;
      if (!empty($user_data['profile']) && $user_id != $_SESSION['user_id']): /* len na inych profiloch a len pri prihlaseni */ ?>
			<?php
			  $mem_query_info = mysql_query("SELECT * FROM vote WHERE my_id = $user_id");
				$numrows_info = mysql_num_rows($mem_query_info);
  			  if ($numrows_info != 0){
          $hlasovat = "<br><center><a href='?mode=vote&voted=1&user_id=".$user_id."'>1</a> | ";
          $hlasovat .= "<a href='?mode=vote&voted=2&user_id=".$user_id."'>2</a> | ";
          $hlasovat .= "<a href='?mode=vote&voted=3&user_id=".$user_id."'>3</a> | ";
          $hlasovat .= "<a href='?mode=vote&voted=4&user_id=".$user_id."'>4</a> | ";
          $hlasovat .= "<a href='?mode=vote&voted=5&user_id=".$user_id."'>5</a></center>";
  			  } else if ($numrows_info == 0){
  			    $hlasovat = "";
  			  }

          $latteParam["hlasovat"] = $hlasovat;
			  
        if(isset($_GET['mode'])) {
  
		$my_id = AUTHENTIZATED_USER_ID;
        $user_id = intval($_GET['user_id']);
        $voted = $_GET['voted'];
         
        $cookie = "Mysite$my_id&&$user_id"; 
        if(isset($_COOKIE[$cookie])) { 
          $latteParam["hlasovani"] = "<div class='error_vote'>Omlouváme se, ale Váš hlas byl již zaznamenán.</div>"; 
        } else { 
          $month = 2592000 + time(); 
          setcookie($cookie, $voted, $month);     
          
          mysql_query("UPDATE vote SET total = total+$voted, votes = votes+1 WHERE my_id = $user_id") or die(mysql_error()); 

          $latteParam["hlasovani"] = "<div class='accepted_vote'>Váš hlas byl úspěšně zaznamenán.<br><br><a href='?profil'>Obnovit skóre</a></div>"; 
          }
        } 
			?>
			<?php ; endif ?>

<?php 

$latteParam["profile_data"] = $profile_data;
$latteParam["user_id"] = $user_id;

// render to output
$latte->render('templates/profileleft.latte', $latteParam);

 ?>