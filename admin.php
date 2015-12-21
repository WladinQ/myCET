<?php
	include 'core/init.php';
	protect_page();
	admin_protect();
	include 'includes/overall/header.php';
				
$latteParam["typ"] = false;
$latteParam["uspech"] = false;
$latteParam["nahlaseni"] = false;
$latteParam["success"] = false;
$latteParam["errors"] = false;


				$latteParam["pocet_nahlaseni"] = mysql_num_rows(mysql_query("SELECT * FROM report_profile"));
				

if(isset($_GET['aktivace-deaktivace'])) { 
	$latteParam["typ"] 	= "aktivace";
 } else if(isset($_GET['blokovany-uzivatele'])) { 
 	$latteParam["typ"] 	= "blokovany";
 } else if(isset($_GET['chat'])) {

 	$latteParam["typ"] 	= "chat";
	$latteParam["pocet_kategorii"] = mysql_num_rows(mysql_query("SELECT * FROM mistnosti_kategorie"));


					$zobraz_kategorie = mysql_query("SELECT * FROM mistnosti_kategorie");
					$kategorie = array();
						while($zobraz = mysql_fetch_array($zobraz_kategorie)){
							$kategorie[] = $zobraz;
						}

						$latteParam["kategorie"] 	= $kategorie;

						if(isset($_POST['submit_k']) && !empty($_POST['submit_k'])){
							
						$jmeno_kategorie = $_POST['jmeno_kategorie'];
						
						mysql_query("INSERT INTO mistnosti_kategorie(id,jmeno_kategorie)  VALUES('','$jmeno_kategorie')");
						
						$latteParam["uspech"] 	=  "Kategorie úspěšně přidána.<br>";
						
						}


					$latteParam["pocet_mistnosti"] = mysql_num_rows(mysql_query("SELECT * FROM mistnosti"));

						if(isset($_POST['submit_m']) && !empty($_POST['submit_m'])){
							
						$jmeno_mistnosti = $_POST['jmeno_mistnosti'];
						$kategorie_mistnosti = $_POST['kategorie_mistnosti'];
						
						mysql_query("INSERT INTO mistnosti(id_mistnosti,kategorie_mistnosti,jmeno_mistnosti)  VALUES('','$kategorie_mistnosti','$jmeno_mistnosti')");
						
						$latteParam["uspech"] = "Místnost úspěšně přidána.<br><br>";
						
						}

					$zobraz_mistnosti = mysql_query("SELECT * FROM mistnosti");
						$kategorieMistnosti = array();
						while($zobraz = mysql_fetch_array($zobraz_mistnosti)){
							$kategorieMistnosti[] = $zobraz;
						}
						$latteParam["kategorieMistnosti"] 	= $kategorieMistnosti;
} else if(isset($_GET['nahlaseni-profilu'])) { 

	$latteParam["typ"] 	= "nahlaseni";

	?>
		<?php if (has_access(AUTHENTIZATED_USER_ID, 1) === true) {
			$latteParam["opravnenyAdmin"] 	= true;

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
    						$getadmin["date"] 		= date ('d.m.Y', $date);
    						$time		= $getadmin['time'];
    						
    						$Koho = getuser($odKoho, 'username');
    						$Kto = getuser($kto, 'username');

    						$getadmin["kto"] = $Kto;
    						$getadmin["koho"] = $Koho;
    						
    						$nahlaseni[] = $getadmin;
    					}
    					$latteParam["nahlaseni"] 	= $nahlaseni;
    				}
    			}
			} else if(isset($_GET['poslat-vsem-email'])) { 

				$latteParam["typ"] 	= "poslat";

			 if (isset($_GET['success']) === true && empty($_GET['success']) === true) {
			 $latteParam["success"] 	= true;
			  } else {
			if (empty($_POST) === false) {
			if (empty($_POST['subject']) === true) {
				$errors[] = '<div class="error_mail">Je zapotřebí vyplnit předmět!</div>';
			}
			if (empty($_POST['body']) === true) {
				$errors[] = '<div class="error_mail">Je zapotřebí vyplnit správu!</div>';
			}
			if (empty($errors) === false) {
				echo output_errors($errors);
			} else {
				mail_users($_POST['subject'], $_POST['body']);
				$latteParam["success"] = true;
			}
		}
		}
	}

	// render to output
	$latte->render('templates/admin.latte', $latteParam);
	 ?>
<?php include 'includes/overall/footer.php'; ?>