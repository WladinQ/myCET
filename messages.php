<?php
	ob_start();
	include 'core/init.php';
	protect_page();
	include 'includes/overall/header.php';


			$my_id = AUTHENTIZATED_USER_ID;
			$get_con = mysql_query("SELECT `id`, `user_one`, `user_two`, `hash` FROM message_group WHERE user_one='$my_id' OR user_two='$my_id'");

			$users = array();

			while($run_con = mysql_fetch_array($get_con)){
				$id = $run_con['id'];
				$hash = $run_con['hash'];
				$user_one = $run_con['user_one'];
				$user_two = $run_con['user_two'];
				
				if($user_one == $my_id){
					$select_id = $user_two;
				} else {
					$select_id = $user_one;
				}
					$user_get = mysql_query("SELECT username, profile FROM users WHERE user_id='$select_id'");
					$run_user = mysql_fetch_array($user_get);
					$run_con["select_username"] = $run_user['username'];
					$run_con["select_user_profile"] = $run_user['profile'];
					
					$vypocet = mysql_query("SELECT from_id, to_id FROM messages WHERE to_id='$select_id' OR from_id='$select_id'");
					$run_con["pocet"] = mysql_num_rows($vypocet);
					
					
					$users[] = $run_con;
			}
			$latteParam["users"] = $users;
			
			$messages = array();

			if(isset($_GET['hash']) && !empty($_GET['hash'])){
				$hash = $_GET['hash'];
				$message_query = mysql_query("SELECT id, from_id, to_id, message, date, time FROM messages WHERE group_hash='$hash' ORDER BY date DESC, time DESC");
				while($run_message = mysql_fetch_array($message_query)){
					$lastMsgId = $run_message['id'];
					$from_id 	= $run_message['from_id'];
					$to_id 		= $run_message['to_id'];
					$message 	= $run_message['message'];
					$date 		= $run_message['date'];
					$date		= strtotime($date);
					$run_message["date2"]		= date ('d.m.Y', $date);
					$time 		= $run_message['time'];
					
					$najst=array 
						(
						":-)",
						":)",
						":-(",
						":(",
						":-/",
//						":/",
						";-)",
						";)",
						":-P",
						":P",
						":-D",
						":D",
						":´-(",
						":´(",
						":-O",
						":O",
						":-X",
						":X",
						"B-)",
						"B)",
						":[",
//						">:-(",
//						">:(",
						":-*",
						":*",
						":-o",
						":´-|",
						"o_O",
						":-$",
						":$",
						"Z:-|",
//						">:-/",
//						">:/",
						"[:call:]",
						"[:zip:]",
						"<3",
						"</3",
						
						"",
						);

					$nahradit=array
						(
						"<img src=\"images/emotikony/smajl_1.png\" alt=\":-)\" />",
						"<img src=\"images/emotikony/smajl_1.png\" alt=\":)\" />",
						"<img src=\"images/emotikony/smajl_2.png\" alt=\":-(\" />",
						"<img src=\"images/emotikony/smajl_2.png\" alt=\":(\" />",
						"<img src=\"images/emotikony/smajl_3.png\" alt=\":-/\" />",
						/*
						"<img src=\"images/emotikony/smajl_3.png\" alt=\":/\" />",
						*/
						"<img src=\"images/emotikony/smajl_4.png\" alt=\";-)\" />",
						"<img src=\"images/emotikony/smajl_4.png\" alt=\";)\" />",
						"<img src=\"images/emotikony/smajl_5.png\" alt=\":-P\" />",
						"<img src=\"images/emotikony/smajl_5.png\" alt=\":P\" />",
						"<img src=\"images/emotikony/smajl_6.png\" alt=\":-D\" />",
						"<img src=\"images/emotikony/smajl_6.png\" alt=\":D\" />",
						"<img src=\"images/emotikony/smajl_7.png\" alt=\":´-(\" />",
						"<img src=\"images/emotikony/smajl_7.png\" alt=\":´(\" />",
						"<img src=\"images/emotikony/smajl_8.png\" alt=\":-O\" />",
						"<img src=\"images/emotikony/smajl_8.png\" alt=\":O\" />",
						"<img src=\"images/emotikony/smajl_9.png\" alt=\":-X\" />",
						"<img src=\"images/emotikony/smajl_9.png\" alt=\":X\" />",
						"<img src=\"images/emotikony/smajl_10.png\" alt=\"B-)\" />",
						"<img src=\"images/emotikony/smajl_10.png\" alt=\"B)\" />",
						"<img src=\"images/emotikony/smajl_11.png\" alt=\":[\" />",
						/*
						"<img src=\"images/emotikony/smajl_12.png\" alt=\">:-(\" />",
						"<img src=\"images/emotikony/smajl_12.png\" alt=\">:(\" />",
						*/
						"<img src=\"images/emotikony/smajl_13.png\" alt=\":-*\" />",
						"<img src=\"images/emotikony/smajl_13.png\" alt=\":*\" />",
						"<img src=\"images/emotikony/smajl_16.png\" alt=\":-o\" />",
						"<img src=\"images/emotikony/smajl_18.png\" alt=\":´-|\" />",
						"<img src=\"images/emotikony/smajl_19.png\" alt=\"o_O\" />",
						"<img src=\"images/emotikony/smajl_20.png\" alt=\":-$\" />",
						"<img src=\"images/emotikony/smajl_20.png\" alt=\":$\" />",
						"<img src=\"images/emotikony/smajl_21.png\" alt=\"Z:-|\" />",
						/*
						"<img src=\"images/emotikony/smajl_22.png\" alt=\">:-/\" />",
						"<img src=\"images/emotikony/smajl_22.png\" alt=\">:/\" />",
						*/
						"<img src=\"images/emotikony/smajl_24.png\" alt=\"[:call:]\" />",
						"<img src=\"images/emotikony/smajl_25.png\" alt=\"[:zip:]\" />",
						"<img src=\"images/emotikony/smajl_17.png\" alt=\"<3\" />",
						"<img src=\"images/emotikony/smajl_23.png\" alt=\"</3\" />",
						
						"",
						);
						
					$run_message["message2"]=str_replace($najst, $nahradit, $message);
					
					$user_query = mysql_query("SELECT username FROM users WHERE user_id='$from_id'");
					$run_user = mysql_fetch_array($user_query);
					$run_message["from_username"] = $run_user['username'];
					

					$messages[] = $run_message;
				}
			} else {
				
			}

			$latteParam["messages"] = $messages;

			if(isset($_POST['message']) && !empty($_POST['message'])){
				$new_message = $_POST['message'];
				mysql_query("INSERT INTO messages VALUES('', '$hash', '$my_id', '$from_id', '$new_message', now(), now())");
				header('Location: messages.php?hash='.$hash);
			}
		
// render to output
$latte->render('templates/messages.latte', $latteParam);

?>

<?php include 'includes/overall/footer.php'; ?>
<?php // include 'includes/chat.php';  NEEXISTUJE ?>
