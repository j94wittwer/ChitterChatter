<?php
	/*
		$userid nimmt die ID des eingeloggten Benutzer. 
		Anschliessend wird der Name und die ID des Benutzer abgefragt und ausgegeben.
	*/
	$userid = $_SESSION['userid'];
	$abfrage = mysqli_query(connectDB(),"SELECT * FROM user WHERE u_id = '$userid'");
		while($ergebnis = mysqli_fetch_assoc($abfrage)){
			$name = $ergebnis["username"];
			$id = $ergebnis["U_ID"];
		}
?>
<h1>Hallo User : <?php echo $name ?> !</h1>
<?php
	if(isset($_GET['id'])){	?>
	<script>
		$(document).ready(function(){
			setTimeout(function(){
					$(".infodiv").fadeOut();
			},1000);
		});
	</script>
<?php 
	if($_GET['id'] == 'error'){ $info = 'Passwort konnte nicht geändert werden.'; }
	else if($_GET['id'] == 'success'){ $info = 'Passwort wurde erfolgreich geändert.'; }
?>
		<div class = "infodiv" style="display:block">
			<?php echo $info ?>
		</div>
<?php 
} ?>
<h2>Passwort ändern:</h2>

<div>
	<form method="post" id="changepwform" action="connectDB.php">
		<input type="hidden"  name="name" value="<?php echo $name; ?>" /><br />
		<input type="password" id="pass1" placeholder="Passwort" name="pass" required="required" /><br />
		<input type="password" id="pass2" placeholder="Passwort wiederholen" name="pass2" required="required" /><br />
		<button type="submit" name="changepw">Ändern</button>
	</form>
</div>