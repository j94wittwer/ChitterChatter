<?php

/**
 * Diese Seite wird geöffnet, wenn ein neuer chat geöffnet wird. Sie beinhaltet 2 Forms für das veschicken von nachrichten und Files
 *
 * Silas Meier
 * 1.0
 * 18.12.2017
 */
	include "../resources/connectDB.php";
	if (!isset($_SESSION['userid'])){
		header("Location: login");
	}

    if($_GET['roomid'] == '') {
        $_SESSION['roomid'] = $_POST['roomid'];
    } else {
        $_SESSION['roomid'] = $_GET['roomid'];
    }
    $_SESSION['lastmessageid'] = 0;

		
?>
<!DOCTYPE html>
<html>
<head>
	<link href="https://fonts.googleapis.com/css?family=Cabin+Condensed" rel="stylesheet">
	<link rel="stylesheet" type="text/css" href="../css/chat.css" />
	<!--<link rel="icon" type="image/png" sizes="32x32" href="/img/WLM_logo.svg.png">-->
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
	<script src="../js/chat.js"></script>
	
	<title>Chatraum: <?php echo findRoomName(); ?></title>
</head>
<body>
	<div class="chatheader">
			<b>User: </b> <?php echo checkForUmlaut(findUserName()); ?> 
			<b>Raum: </b><?php echo checkForUmlaut(findRoomName()); ?> 
			<b>Besitzer: </b> <?php echo checkForUmlaut(findOwnerName()); ?><br />
			<ul><li>Raum-Mitglieder:
			<?php 
					getUserList();
				?>
			</li></ul>
        <?php echo htmlspecialchars($_GET['result']); var_dump($_GET['result'])?>
	</div>
	<div class="chatbody" id="chat">

	<img id="arrow" alt="arrow_down" src="../img/arrow_down.png">
	</div>
	<div class="chatfooter">
		<form method="post" id="chatform" action="../resources/upload.php" enctype="multipart/form-data">
			<input type="text" id="message" name="chatinput" placeholder="Nachricht eingeben..." autocomplete="off"/>
            <button  type="button" name="chatten" id="sendmessage">Send</button>
            <span style="float:right">
                <input type="file" name="fileToUpload" id="fileToUpload"/>
                <button type="submit" id="sendfile" name="openchat">Send File</button>
            </span>
		</form>
	</div>
</body>
</html>