<?php
/**
 * Schnittstelle für JavaScript, damit die Nachricht versendet werden.
 *
 * Jonas Witter
 * 1.0
 * 18.12.2017
 */
	require 'connectDB.php';
    $messageraw = mysqli_real_escape_string(connectDB(), $_POST['message']);
	$message = filter_var($messageraw,FILTER_SANITIZE_STRING);
	$userid = $_SESSION['userid'];
	$roomid = $_SESSION['roomid'];
	
	sendMessage($message,$userid,$roomid);
