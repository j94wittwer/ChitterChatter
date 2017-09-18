<h1>Log dich ein!</h1>
<div>
	<form method="post" id="loginform" action="connectDB.php">
		<input type="text" placeholder="Username" name="name" required="required" />
		<input type="password" placeholder="Passwort" name="pass" required="required" />
		<button type="submit" name="login">Login</button>
	</form>
</div>
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
	if($_GET['id'] == 'error'){ $info = 'Falsche Angaben'; }
	else if($_GET['id'] == 'existing'){ $info = 'Benutzername bereits vorhanden.'; }
?>
		<div class = "infodiv" style="display:block">
			<?php echo $info ?>
		</div>
<?php 
} ?>
<h1>Neu Registrieren!</h1>
<div>
	<form method="post" id="registerform" action="connectDB.php">
		<input type="text" placeholder="Username" name="name" required><br />
		<input type="password" id="pass1" placeholder="Passwort" name="pass" required><br />
		<input type="password" id="pass2" placeholder="Passwort wiederholen" name="pass2"><br />
		<button type="submit" id="submit" name="register" >Registrieren</button>
	</form>
</div>