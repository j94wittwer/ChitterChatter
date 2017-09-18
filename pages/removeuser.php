<h1>Benutzer vom Raum entfernen</h1>
<?php
		if (isset($_POST['roomid'])){
			$roomid = $_POST['roomid'];
			getRemovableUserList($roomid);
		} else {
			header("Location: chatlist");
		}	
?>