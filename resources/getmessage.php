<?php
/**
 * Schnittstelle für JavaScript, damit die Nachrichte geladen werden
 *
 * Jonas Witter
 * 1.0
 * 18.12.2017
 */
	require 'connectDB.php';
	$roomid = $_SESSION['roomid'];
	if (!isset($_SESSION['roomid'])){
		echo "<script>window.close();</script>";
	}
	if (!isset($_SESSION['lastmessageid'])){
		$lastmessageid = 0;
	} else if ($_SESSION['lastmessageid'] == 0) {
		$lastmessageid = 0;
	} else {	
		$lastmessageid = $_SESSION['lastmessageid'];
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
		$colorarray = ["Blue", "BlueViolet", "#1ad049", "Chocolate", "Red", "DarkGoldenRod", "Darkgreen", "DarkOrange"];
		$color = $colorarray[$userid % 8];
		if ($_SESSION['date'] != date('Y-m-d', strtotime($ergebnis['time']))){
			$_SESSION['date'] = date('Y-m-d', strtotime($ergebnis['time']));
			echo "<br /><div style='color: black;'>---DATUM: ".date('Y-m-d', strtotime($ergebnis['time']))."!</div><br />";
		}
        if (file_exists($message)) {
            echo
                "<div style='color: $color;margin-bottom:2px;'><div style='min-width:180px; display: inline-block;'>$time - ".checkForUmlaut($username).":</div>
                    <a href=".$message." download>Download link</a>
                </div>"
            ;
        } else {
            echo
                "<div style='color: $color;margin-bottom:2px;'><div style='min-width:180px; display: inline-block;'>$time - " . checkForUmlaut($username) . ":</div>" . checkForEmoji(checkForUmlaut($message)) . "</div>";
        }
	}
	return 0;

/**
 * Übersetzt die eingegebene Strings, damit die Emojis als Foto angezeigt werden.
 * @param $message Nachricht, welche auf emojis überprüft.
 * @return Neue Nachricht welche eventuell <img> tags enthält.
 */
	function checkForEmoji($message){
			
	$emojiarray = [
			';P' => 'emoji.png',
			':D' => 'laughemoji.png',
			':PATS:' => 'patriots.png',
			':HUGGING:' => 'HuggingEmoji.png',
			':FU:' => 'fucku.png',
			':THINKING:' => 'thinking.png',
			':YB:' => 'YB.svg.png',
			':POOP:' => 'poop.png',
			':TRUMP:' => 'trumphair.png',
			':JC:' => 'johncena.png',
			':CRY:' => 'crying.png',
			':GIBB:' => 'gibb.png',
			':LOVE:' => 'gibb.png',
			':LIFE:' => 'gibb.png',
			':AT:' => 'adventuretime.gif',
			':SIMON:' => 'pepegrof.gif',
			':SAUSAGE:' => 'sausage.gif',
			':NYAN:' => 'nyan_cat.gif',
			':DWI:' => 'deal_with_it.gif',
			':MEME:' => 'meme.png',
			':FBM:' => 'feelsbadman.png',
			':LAUCH:' => 'lauch.png',
			':NICE:' => 'thumb.png',
			':BEER:' => 'beer.png',
			':ARNO:' => 'arno.jpg',
			':DHL:' => 'post.png',
			':POST:' => 'post.png',
		];
		
		$newmessage = '';
		$words = explode(' ', $message);
		if(count($words) == 1){
			if($words[0] == '!emojis'){
				$allEmojis = '';
				foreach($emojiarray as $key => $value){
					$allEmojis = $allEmojis.$key.' / ';
				}
				return $allEmojis;
			}
		}
		foreach($words as $word){
			$isEmoji = false;
			foreach($emojiarray as $key => $value){
				if(strtoupper($word) == $key){
					$newmessage = $newmessage.' <img style="max-height:50px" alt="'.$key.'" title="'.$key.'" src="../img/emojis/'.$emojiarray[$key].'">';
					$isEmoji = true;
				}
			}
			if(strpos($word, 'www.youtube.com')){
				$embedlink = str_replace('watch?v=','embed/', $word);
				$embedlinkUnfiltered = '<iframe width="320" height="180" src="'.$embedlink.'" frameborder="0" allowfullscreen></iframe>';
				$newmessage = str_replace('?autoplay=1','', $embedlinkUnfiltered);
				$isEmoji = true;
			}
			else if (!filter_var($word, FILTER_VALIDATE_URL) === false) {
				$newmessage = '<a target="_blank" href="'.$word.'">'.$word.'</a>';
				$isEmoji = true;
			}
			
			if($isEmoji){} //true, weil das Wort bereits hinzugefügt wurde und damit es nicht doppelt erscheint.
			else{
				$newmessage = $newmessage.' '.$word;
			}
		}
	
		return $newmessage;
	}
?>