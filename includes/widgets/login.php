<div class="widget">
	<form action='login.php' method='post'>
		<?php require_once("core/database/connect.php"); $sql = mysql_query("SELECT * FROM users"); ?>
		
		<table border="0px" width="100%">
			<tr>
				<td width="33%"><input tabindex=1 type="text" name="username" placeholder="Uživatelské jméno"></td>
				<td width="33%" rowspan="3" align="center"><a href="index.php"><img src="../images/logo.png"></a></td>
				<td style="padding-top: 10px" rowspan="2" valign="top" align="right" width="33%"><h3>Přidejte se ke skupině lidí<br>který na myČET našli známe,<br>nové přátele nebo třeba i nové lásky.</h3></td>
			</tr>
			<tr>
				<td><input tabindex=2 type="password" name="password" placeholder="Heslo">&nbsp;&nbsp;&nbsp;<a href="recover.php?mode=password">Zapomenuté heslo?</a></td>
			</tr>
			<tr>
				<td><input type="submit" name="submit" value="Přihlásit se"></td>
				<td valign="middle" align="right"><h3>Zaregistrujte se zdarma</h3></td>
			</tr>
		</table>
	</form>
</div>