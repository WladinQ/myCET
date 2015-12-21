<?php
	include 'core/init.php';
	include 'includes/overall/header.php';

    $latteParam['message'] = "";

    function validation($str){
            return ( ! preg_match("/^([a-z0-9\+_\-]+)(\.[a-z0-9\+_\-]+)*@([a-z0-9\-]+\.)+[a-z]{2,6}$/ix", $str)) ? FALSE : TRUE;
    }
    if(isset($_POST['submit']) && $_POST['control']==''){
        if($_POST['name']==''){
            $latteParam["message"] = 'Prosím, napište své jméno.';
        }
        else if($_POST['email']==''){
            $latteParam["message"] = 'Prosím, napište svou e-mailovou adresu.';
        }
        else if((validation($_POST['email']))==false){
            $latteParam["message"] = 'E-mail není platný.';
        }
        else if($_POST['subject']==''){
            $latteParam["message"] = 'Prosím, napište předmět své zprávy.';
        }
        else if($_POST['message']==''){
            $latteParam["message"] = 'Prosím, napište znění zprávy.';
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
            $mail = mail($recipient, $subject, $body, $mailheader);
             
            if(!$mail){      
                $latteParam['message'] = 'Promiňte, ale něco se stalo. Prosím, zkuste to později.';
            }
            else{
                $latteParam['message'] = 'Děkujeme Vám za Vaši zprávu. Odpovíme Vám na Vámi zadaný e-mail (' . $email . ') co nejdříve.';
            }
        }
    }
?>

<?php 

// render to output
$latte->render('templates/kontakt.latte', $latteParam);
?>


<?php include 'includes/overall/footer.php'; ?>