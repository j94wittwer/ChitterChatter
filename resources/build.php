<?php
/**
 * Seite Builder. Wird vom Dispacher ausgeführt um die Seite zusammen zustellen.
 *
 * Robin Berberat
 * 1.0
 * 18.12.2017
 */
	function buildlink($file, $access = false, $title = 'Chatraum'){


	require 'resources/connectDB.php';
	if($access){ }//Überprüft, ob die Seite mittels $_SESSION  überprüft werden muss. falls 'true', wird nicht überprüft.
	else{
		if(!isset($_SESSION['userid'])){
			header ("Location: login");
		}
	}
?>
    <!doctype html>
	<html>
		<head>
			<?php require_once 'inc/head.inc'; ?>
		</head>
		<body>
			<header>
				<?php require_once 'inc/header.inc'; ?>
			</header>
			<nav>
				<?php require_once 'inc/nav.inc'; ?>
			</nav>
			<div class="content">
				<?php require_once 'pages/'.$file; ?>
			</div>
			<footer>
				<?php require_once 'inc/footer.inc'; ?>
			</footer>
		</body>
	</html>

<?php } //Klammer zum schliessen der buildlink Funktion
?> 