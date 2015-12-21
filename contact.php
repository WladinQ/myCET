<?php
	include 'core/init.php';
	include 'includes/overall/header.php';
?>
<?php
    function validation($str){
            return ( ! preg_match("/^([a-z0-9\+_\-]+)(\.[a-z0-9\+_\-]+)*@([a-z0-9\-]+\.)+[a-z]{2,6}$/ix", $str)) ? FALSE : TRUE;
    }
    if(isset($_POST['submit']) && $_POST['control']==''){
        if($_POST['name']==''){
            $message = '<h3>Prosím, napište své jméno.</h3>';
        }
        else if($_POST['email']==''){
            $message = '<h3>Prosím, napište svou e-mailovou adresu.</h3>';
        }
        else if((validation($_POST['email']))==false){
            $message = '<h3>E-mail není platný.</h3>';
        }
        else if($_POST['subject']==''){
            $message = '<h3>Prosím, napište předmět své zprávy.</h3>';
        }
        else if($_POST['message']==''){
            $message = '<h3>Prosím, napište znění zprávy.</h3>';
        }
        else{
            $_POST['name'] = preg_replace("/\r|\n|bcc:/", " ", $_POST['name']);
            $_POST['email'] = preg_replace("/\r|\n|bcc:/", " ", $_POST['email']);
            $_POST['subject'] = preg_replace("/\r|\n|bcc:/", " ", $_POST['subject']);
            $_POST['message'] = preg_replace("/\r|\n|bcc:/", " ", $_POST['message']);
 
            $name = $_POST['name'];
            $email = $_POST['email'];
            $subject = $_POST['subject'];
            $message = $_POST['message'];
            $body='
            <html>
                <header>
                    <style>
                        body{font-family:segoe ui; color:#2b2b2b;}
                        h1{font-weight:normal; color:#6a0605; font-family:segoe ui light; border-bottom:1px solid #beafaf;}
                        a{color:#ad201f; text-decoration:none;}
                    </style>
                </header>
                <body>
                    <h1>Kontaktní formulář z myČET.cz</h1>
                    <p><h3>' . $name . '
                        (' . $email . ')</h3>
                    </p>
                    <p><b>Předmnět: </b>' . $subject . '
                        <br><br><h3>Zpráva:</h3>' . $message . '
                    </p>
                </body>
            </html>';
            $recipient = "info.mycet@gmail.com";
            $mailheader = 'From: ' . $email . ' \r\n' .
                        'Reply-To:'. $email . "\r\n" .
                        'Content-type: text/html; charset=UTF-8;' . "\r\n" .
                        'X-Mailer: PHP/' . phpversion();
            mail($recipient, $subject, $body, $mailheader);
             
            if(!mail){      
                $message = '<h3>Promiňte, ale něco se stalo. Prosím, zkuste to později.</h3>';
            }
            else{
                $message = '<h3>Děkujeme Vám za Vaši zprávu. Odpovíme Vám na Vámi zadaný e-mail (' . $email . ') co nejdříve.</h3>';
            }
        }
    }
?>

     <h1>Kontaktní formulář</h1>

    <form name="contact-form" method="post" action="">
		<table id="contactform" border="0px">
			<tr>
				<td>Celé jméno</td>
				<td width="20px"></td>
				<td><input type="text" name="name" value=""/></td>
			</tr>
			<tr>
				<td>E-mail</td>
				<td width="20px"></td>
				<td><input type="email" name="email" value=""/></td>
			</tr>
			<tr>
				<td>Předmnět</td>
				<td width="20px"></td>
				<td>
					<select name="subject" required>
						<option value="">Vyberte typ otázky</option>
						<option value="Potřebuji poradit">Potřebuji poradit</option>
						<option value="Technický problém">Technický problém</option>
						<option value="Návrh na vylepšení">Návrh na vylepšení</option>
						<option value="Jiné">Jiné</option>
					</select>
				</td>
			</tr>
			<tr>
				<td>Zpráva</td>
				<td width="20px"></td>
				<td><textarea name="message"></textarea></td>
			</tr>
			<tr>
				<td><input type="text" name="control" style="display:none;" /></td>
				<td width="20px"></td>
				<td><input class="inputsubmitbuttons" type="submit" name="submit" value="Odeslat" /></td>
			</tr>
		</table>
    </form>
                 
        <?php if(isset($message)){ ?>
			<div class="message"><br><?php echo $message; ?></div>
        <?php }?>
<?php include 'includes/overall/footer.php'; ?>