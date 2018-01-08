<?php
session_start();

/**
 * Baut eine SQL Verbindung zur Datenbank auf. Verarbeitet anfragen, Speichert Dateien...
 *
 * Silas Meier
 * 1.0
 * 18.12.2017
 */

	function connectDB(){
		$servername = "localhost";
		$username = "root";
		$password = "root";
		$dbname = "lindseyj";
		do {
			try {
				$conn = @mysqli_connect ( $servername, $username, $password, $dbname );
			} catch (Exception $e) {
				
			}
		} while (mysqli_connect_errno());

		mysqli_set_charset ( $conn, "utf8" );
		return $conn;
	}

/**
 * Sucht mittels ID einen User aus der Datenbank
 * @return Username
 */
	function findUserName() {
		$conn = connectDB();
		$userid = $_SESSION['userid'];
		$stmt = mysqli_stmt_init($conn);
		$stmt = mysqli_prepare($conn, "SELECT username FROM user WHERE U_ID=?;");
		mysqli_stmt_bind_param($stmt, 'i', $userid);
		mysqli_stmt_execute($stmt);
		mysqli_stmt_bind_result($stmt, $userName);
		mysqli_stmt_fetch($stmt);
		mysqli_stmt_close($stmt);
		mysqli_close($conn);
		return $userName;
	}

/**
 * Mittels RoomId in der Session wird der Raumname gesucht
 * @return Roomname
 */
	function findRoomName(){
		$conn = connectDB();
		$roomid = $_SESSION['roomid'];
		$stmt = mysqli_stmt_init($conn);
		$stmt = mysqli_prepare($conn, "SELECT roomname FROM room WHERE R_ID=?;");
		mysqli_stmt_bind_param($stmt, 'i', $roomid);
		mysqli_stmt_execute($stmt);
		mysqli_stmt_bind_result($stmt, $roomName);
		mysqli_stmt_fetch($stmt);
		mysqli_stmt_close($stmt);
		mysqli_close($conn);
		return $roomName;
	}

/**
 * Findet den Owner vom chatraum mittels Roomid
 * @return OwnerName
 */
	function findOwnerName(){
		$conn = connectDB();
		$roomid = $_SESSION['roomid'];
		$stmt = mysqli_stmt_init($conn);
		$stmt = mysqli_prepare($conn, 
			"SELECT username FROM user
			RIGHT JOIN room ON U_ID = owner
			WHERE R_ID=?;");
		mysqli_stmt_bind_param($stmt, 'i', $roomid);
		mysqli_stmt_execute($stmt);
		mysqli_stmt_bind_result($stmt, $ownerName);
		mysqli_stmt_fetch($stmt);
		mysqli_stmt_close($stmt);
		mysqli_close($conn);
		return $ownerName;
	}

/**
 * Listet alle Chaträume auf. Je nachdem, ob er User der Owner ist, werden zwei weiter Formulare mitgegeben.
 */
	function getRoomList(){
		$conn = connectDB();
		$userid = $_SESSION['userid'];
		$stmt = mysqli_stmt_init($conn);
		$stmt = mysqli_prepare($conn, 
			"SELECT R_ID, roomname, username, time, owner FROM room
			LEFT JOIN user ON U_ID = owner
			WHERE R_ID IN (
			SELECT ID_R FROM room_user
			WHERE ID_U =?);");
		mysqli_stmt_bind_param($stmt, 'i', $userid);
		mysqli_stmt_execute($stmt);
		mysqli_stmt_bind_result($stmt, $roomid, $roomname, $owner, $time, $ownerid);
		while (mysqli_stmt_fetch($stmt)){
			echo "
				<div class='chatrooms'>
				$roomname erstellt von $owner  <span style='font-size:60%'>um $time</span>
				<form method='post' action='pages/chat.php' class='listedroom' target='_blank'>
					<input type='hidden' name='roomid' value=$roomid />
					<button type='submit' name='openchat'>&Ouml;ffnen</button>
				</form>
			";
			if ($ownerid == $userid){
				echo "
					<form method='post' action='adduser' class='listedroom'>
						<input type='hidden' name='roomid' value=$roomid />
						<button type='submit' name='adduserlist'>User hinzuf&uuml;gen</button>
					</form>
				";
				echo "
					<form method='post' action='removeuser' class='listedroom'>
						<input type='hidden' name='roomid' value=$roomid />
						<button type='submit' name='removeuserlist'>User entfernen</button>
					</form>
				";
			}
			echo "
				</div><br />
			";
		}
		mysqli_stmt_close($stmt);
		mysqli_close($conn);
	}

/**
 * Funktion zum verschicken einer neuen Nachricht
 * @param $message Nachricht zum verschicken
 * @param $userid UserId vom user, welcher die Nachricht verschickt.
 * @param $roomid Roomid in welchem eine Nachricht verschickt wurde.
 */
	function sendMessage($message, $userid, $roomid){
		$conn = connectDB();
		if ($message != ""){
			$stmt = mysqli_stmt_init($conn);
			$stmt = mysqli_prepare($conn, "INSERT INTO message (message, ID_R, ID_U) VALUES (?,?,?);");
			mysqli_stmt_bind_param($stmt, 'sii', $message, $roomid, $userid);
			mysqli_stmt_execute($stmt);
			mysqli_stmt_close($stmt);
		}
		mysqli_close($conn);
	}

/**
 * Lädt einen user von der Datenbank, und überprüft, ob das Passwort übereinstimmt. Falls ja wird die Session gesetzt.
 * und der User wird weitergeleitet.
 * @param $name Name vom user
 * @param $pass Passwort vom User
 */
    function setSession($name, $pass){
        $conn = connectDB();
        $stmt = mysqli_stmt_init($conn);
        $stmt = mysqli_prepare($conn, "SELECT U_ID, password FROM user WHERE username=?;");
        mysqli_stmt_bind_param($stmt, 's', $name);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_bind_result($stmt, $userid, $userpass);
        mysqli_stmt_fetch($stmt);
        if ($userid !== false &&  password_verify($pass, $userpass)){
            $_SESSION['userid'] = $userid;
            header("Location: account");
        } else {
            header("Location: login?id=error");
        }
        mysqli_stmt_close($stmt);
        mysqli_close($conn);
    }

/**
 * Fängt die Login Anfrage ab.
 */
    if (isset ($_REQUEST['login'])){
        $conn = connectDB();
        $name = $_POST['name'];
        $pass = $_POST['pass'];
        setSession($name, $pass);
    }

/**
 * Fängt eine Registration ab und fügt sie in die Datbank ein.
 */
	if (isset ($_REQUEST['register'])){
		$conn = connectDB();
		$name = filter_var((mysqli_real_escape_string(connectDB(), $_POST['name'])),FILTER_SANITIZE_STRING);
		$pass = filter_var((mysqli_real_escape_string(connectDB(), $_POST['pass'])),FILTER_SANITIZE_STRING);
		$pass2 = filter_var((mysqli_real_escape_string(connectDB(), $_POST['pass2'])),FILTER_SANITIZE_STRING);

		if ($pass == $pass2){
			$stmt = mysqli_stmt_init($conn);
			$stmt = mysqli_prepare($conn, "INSERT INTO user (username, password) VALUES (?,?);");
			mysqli_stmt_bind_param($stmt, 'ss', $name, password_hash($pass, PASSWORD_DEFAULT));
			if (mysqli_stmt_execute($stmt)){
				header("Location: login");
				setSession($name, $pass);
			} else {
				header("Location: login?id=existing");
			}
		} else {
			header("Location: login?id=error");
		}
		mysqli_stmt_close($stmt);	
		mysqli_close($conn);
	}

/**
 * Fängt die Abfrage für die Änderung vom Passwort ab.
 */
	if (isset ($_REQUEST['changepw'])){
		$conn = connectDB();
		$name = filter_var((mysqli_real_escape_string(connectDB(), $_POST['name'])),FILTER_SANITIZE_STRING);
		$pass = filter_var((mysqli_real_escape_string(connectDB(), $_POST['pass'])),FILTER_SANITIZE_STRING);
		$pass2 = filter_var((mysqli_real_escape_string(connectDB(), $_POST['pass2'])),FILTER_SANITIZE_STRING);
		if ($pass == $pass2){
			$stmt = mysqli_stmt_init($conn);
			$stmt = mysqli_prepare($conn, "UPDATE user SET password = ? WHERE U_ID = ?;");
			mysqli_stmt_bind_param($stmt, 'si', password_hash($pass, PASSWORD_DEFAULT), $_SESSION['userid']);
			if (mysqli_stmt_execute($stmt)){
				header("Location: account?id=success");
			} else {
				header("Location: account?id=error");
			}
		} else {
			header("Location: account?id=error");
		}
		mysqli_stmt_close($stmt);	
		mysqli_close($conn);
	}

/**
 * Fängt die Abfrage für das Erstellen eines neue Chat ab und erstellt diesen, sollte alles korrekt sein.
 */
	if (isset ($_REQUEST['newchat'])){
		$conn = connectDB();
		$roomname = $_POST['name'];
		$owner = $_SESSION['userid'];
		$stmt = mysqli_stmt_init($conn);
		$stmt = mysqli_prepare($conn, "INSERT INTO room (roomname, owner) VALUES (?,?);");
		mysqli_stmt_bind_param($stmt, 'si', $roomname, $owner);
		if (mysqli_stmt_execute($stmt)){
			$stmt2 = mysqli_prepare($conn, "INSERT INTO room_user (ID_R, ID_U) VALUES ((SELECT MAX(R_ID) FROM room),?);");
			mysqli_stmt_bind_param($stmt2, 'i', $owner);
			if (mysqli_stmt_execute($stmt2)){
				header("Location: chatlist");
			} else {
				header("Location: chatlist");
			}
		} else {
			header("Location: chatlist");
		}
		mysqli_stmt_close($stmt);
		mysqli_stmt_close($stmt2);		
		mysqli_close($conn);
	}

/**
 * Gibt alle user zurück, welche hinzugefügt werden können. Bereits hinzugefügt User werden beispielsweise nicht angezeigt
 * @param $roomid Roomid, bei welcher Users hinzugefügt werden sollen.
 */
	function getAddableUserList($roomid){
		$conn = connectDB();
		$stmt = mysqli_stmt_init($conn);
		$stmt = mysqli_prepare($conn, "SELECT username, U_ID FROM user WHERE U_ID NOT IN (SELECT ID_U FROM room_user WHERE ID_R =?);");
		mysqli_stmt_bind_param($stmt, 'i', $roomid);
		mysqli_stmt_execute($stmt);
		mysqli_stmt_bind_result($stmt, $username, $userid);
		while (mysqli_stmt_fetch($stmt)){
			echo "
				<div class='chatrooms'>
				$username
				<form method='post' action='adduser' class='listedroom'>
					<input type='hidden' name='userid' value='$userid' />
					<input type='hidden' name='roomid' value='$roomid' />
					<button type='submit' name='adduser'>hinzuf&uuml;gen</button>
				</form>
				</div><br />
			"; 
		}
		mysqli_stmt_close($stmt);
		mysqli_close($conn);
	}

/**
 * Gibt alle user zurück, welche entfernt werden können. Bereits entfernte User werden beispielsweise nicht angezeigt
 * @param $roomid Roomid, bei welcher Users entfernt werden sollen.
 */
	function getRemovableUserList($roomid){
		$conn = connectDB();
		$userid = $_SESSION['userid'];
		$stmt = mysqli_stmt_init($conn);
		$stmt = mysqli_prepare($conn, "SELECT username, U_ID FROM user WHERE U_ID IN (SELECT ID_U FROM room_user WHERE ID_R = ?) AND U_ID != ?;");
		mysqli_stmt_bind_param($stmt, 'ii', $roomid, $userid);
		mysqli_stmt_execute($stmt);
		mysqli_stmt_bind_result($stmt, $username, $userid);
		while (mysqli_stmt_fetch($stmt)){
			echo "
				<div class='chatrooms'>
				$username
				<form method='post' action='removeuser' class='listedroom'>
					<input type='hidden' name='userid' value='$userid' />
					<input type='hidden' name='roomid' value='$roomid' />
					<button type='submit' name='removeuser'>entfernen</button>
				</form>
				</div><br />
			"; 
		}
		mysqli_stmt_close($stmt);
		mysqli_close($conn);
	}

/**
 * Fängt die Anfrage ab, welche einen neuen User hinzufügt, überprüft alles und fügt ihn anschliessend hinzu.
 */
	if (isset ($_REQUEST['adduser'])) {
		$conn = connectDB();
		$roomid = $_POST['roomid'];
		$userid = $_POST['userid'];
		$stmt = mysqli_stmt_init($conn);
		$stmt = mysqli_prepare($conn, "INSERT INTO room_user (ID_R, ID_U) VALUES (?,?);");
		mysqli_stmt_bind_param($stmt, 'ii', $roomid, $userid);
		mysqli_stmt_execute($stmt);
		mysqli_stmt_close($stmt);
		mysqli_close($conn);
	}

/**
 * Fängt die Anfrage ab, welche einen User entfernt. überprüft alles und entfernt den User anschliessend.
 */
	if (isset ($_REQUEST['removeuser'])) {
		$conn = connectDB();
		$roomid = $_POST['roomid'];
		$userid = $_POST['userid'];
		$stmt = mysqli_stmt_init($conn);
		$stmt = mysqli_prepare($conn, "DELETE FROM room_user WHERE ID_R = ? AND ID_U = ?;");
		mysqli_stmt_bind_param($stmt, 'ii', $roomid, $userid);
		mysqli_stmt_execute($stmt);
		mysqli_stmt_close($stmt);
		mysqli_close($conn);
	}

/**
 * Zeigt alle User an, welche im Chatraum sind mittels Session.
 */
	function getUserList(){
		$conn = connectDB();
		$stmt = mysqli_stmt_init($conn);
		$stmt = mysqli_prepare($conn, "SELECT username FROM user RIGHT JOIN room_user ON U_ID = ID_U WHERE ID_R = ?;");
		mysqli_stmt_bind_param($stmt, 'i', $_SESSION['roomid']);
		mysqli_stmt_execute($stmt);
		mysqli_stmt_bind_result($stmt, $username);
		while (mysqli_stmt_fetch($stmt)){
			$user = checkForUmlaut($username);
			echo " \ $user"; 
		}
		mysqli_stmt_close($stmt);
		mysqli_close($conn);
	}

/**
 * Gibt eine neue Nachricht zurück
 * @param $roomid Chatraum, bei welchem auf neue Nachrichten überprüft wird.
 * @param $lastmessageid Id von der letzt erhalten Message
 * @return int Gibt 0 zurück, sollte es keine neue Nachricht geben.
 */
	function getMessage($roomid, $lastmessageid) {
		if (!isset($roomid)){
		echo "<script>window.close();</script>";
		}
		if (!isset($lastmessageid)){
			$lastmessageid = 0;
		}
		
		$abfrage = mysqli_query(connectDB(),"SELECT M_ID, message, username, time, U_ID FROM message 
			JOIN user on U_ID = ID_U
			WHERE ID_R = '$roomid' AND M_ID > '$lastmessageid'
			ORDER BY time;");
		while($ergebnis = mysqli_fetch_assoc($abfrage)){
			$_SESSION['lastmessageid'] = $ergebnis["M_ID"];
			$userid = $ergebnis["U_ID"];
			$username = $ergebnis["username"];
			$message = $ergebnis["message"];
			$time = date('h:i', strtotime($ergebnis['time']));
			$colorarray = ["Blue", "BlueViolet", "FireBrick", "Chocolate", "Red", "DarkGoldenRod", "Darkgreen", "DarkOrange"];
			$color = $colorarray[$userid % 8];
			if ($_SESSION['date'] != date('Y-m-d', strtotime($ergebnis['time']))){
				$_SESSION['date'] = date('Y-m-d', strtotime($ergebnis['time']));
				echo "<br /><div style='color: black;'>Heute ist der ".date('Y-m-d', strtotime($ergebnis['time']))."!</div><br />";
			}
			echo 
			"<div style='color: $color;margin-bottom:2px;max-width:100%'><div style='min-width:180px; display: inline-block;'>$time - ".checkForUmlaut($username).":</div>".checkForEmoji(checkForUmlaut($message))."</div>"
			;
		}
		return 0;
	}

/**
 * Damit Umlaute korrekt dargestllt werden, überprüft diese Funktion auf Umlaute und ersetzt diese mit der html kompatiblen Zeichen.
 * @param $message Die zu überprüfende Nachricht
 * @return Angepasste Nachricht.
 */
	function checkForUmlaut($message){
		$newmessage = $message;
		$umlautarray = [
			'Ö' => '&Ouml;',
			'Ä' => '&Auml;',
			'Ü' => '&Uuml;',
			'ö' => '&ouml;',
			'ä' => '&auml;',
			'ü' => '&uuml;',
		];
		foreach($umlautarray as $key => $value){
			$newmessage = str_replace($key,$value,$newmessage);
		}
		return $newmessage;
	}

?>