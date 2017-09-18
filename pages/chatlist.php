neuen chat erstellen:<br>
	<form method="post" id="newchatform" action="connectDB.php">
		<input type="text" placeholder="Raumname" name="name" required />
		<button type="submit" name="newchat">ok</button>
	</form>

<h1>Offene Chats:</h1>
<?php
	getRoomList();
?>