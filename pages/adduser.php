<h1>Benutzer zum Raum hinzuf&uuml;gen</h1>
<?php
		if (isset($_POST['roomid'])){
			$roomid = $_POST['roomid'];
			getAddableUserList($roomid);
		} else {
			header("Location: chatlist");
		}	
?>