<hr>
<a href="home">Home</a>
<?php
	if(isset($_SESSION['userid'])){
		echo'
		<a href="account">Mein Account</a>
		<a href="chatlist">Chaträume</a>
		<a href="#" class="openinfodiv">Logout</a>
		<div class = "infodiv" style="z-index:3">
			Bist du dir sicher? Es werden alle offenen Chatfenster geschlossen.<br>
			<a href="logout"><button class="logout">Ja</button></a>
			<a href="#"><button class="back">Nein</button></a>
		</div>
		';
	}else{
		echo '<a href="login">Login</a>';
	}
?>
<hr>