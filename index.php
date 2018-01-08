<?php
/**
 * Dispatcher der Webseite, Auf dem .htaccess werden alle Aufrufe hierhin umgeleitet und über ein Switchstatement verarbeitet
 *
 * Robin Berberat
 * 1.0
 * 18.12.2017
 */
	require_once 'resources/build.php';
	$url = explode('/', trim($_SERVER['REQUEST_URI'], '/'));
	
	if(!empty($url)) {
		$url[count($url)-1] = strtolower($url[count($url)-1]);
		dispatch($url);
	} 
	//Ist der Wert nicht gesetzt wird die Standardseite (home) aufgerufen.
	else {
		buildlink('home.php', true, '- Home');
	}
	function dispatch($url){
		if(!empty($url)) {
			switch($url[count($url)-1]) { //buildlink($filename, true = muss nicht eingeloggt sein/false = muss eingeloggt sein, title attribut
				case 'account':
					buildlink('account.php', false, ' - Mein Account');
					break;
				case 'account?id=error':
					buildlink('account.php', false, ' - Mein Account');
					break;
				case 'account?id=success':
					buildlink('account.php', false, ' - Mein Account');
					break;
				case 'logout':
					buildlink('logout.php', false, ' - Logout');
					break;
				case 'chatlist':
					buildlink('chatlist.php', false, ' - Chatlisten');
					break;
				case 'login':
					buildlink('login.php', true,' - Login');
					break;
				case 'login?id=error':
					buildlink('login.php', true,' - Login');
					break;
				case 'login?id=existing':
					buildlink('login.php', true,' - Login');
					break;
				case 'adduser':
					buildlink('adduser.php', false,' - Add User');
					break;
				case 'removeuser':
					buildlink('removeuser.php', false,' - Remove User');
					break;
				case 'impressum':
					buildlink('impressum.php', true, ' - Impressum');
					break;
				default:
					array_splice($url, 0, 1);//den URL Array an der 0-Stelle entfernen und neuindexieren.
					dispatch($url); /* Anschliessend wird die Funktion rekursiv wieder aufgerufen und überprüft, ob die nächste Stelle ein akzeptierter Link ist.*/
					break;
			}
		} else {
			buildlink('home.php', true, '- Home');
		}
	}
?>