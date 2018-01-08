<?php
/**
 * Upload von Files werden hier verarbeitet und gespeichert.
 *
 * Marc Liechti
 * 1.0
 * 18.12.2017
 */
    require 'connectDB.php';
    $target_dir = "../files/";
    $target_file = $target_dir . basename($_FILES["fileToUpload"]["name"]);
    $uploadOk = 1;
    $imageFileType = pathinfo($target_file,PATHINFO_EXTENSION);

    $result;
    $userid = $_SESSION['userid'];
    $roomid = $_SESSION['roomid'];

    // Check if file already exists
    if (file_exists($target_file)) {
        $result= "Sorry, file already exists.";
        $uploadOk = 1;
    }
    if ($uploadOk == 0) {
        $result= "Sorry, your file was not uploaded.";
    } else {
        if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {
            sendMessage($target_file, $userid, $roomid);
            $result= "The file ". basename( $_FILES["fileToUpload"]["name"]). " has been uploaded.";
        } else {
            $result= "Sorry, there was an error uploading your file.";
        }
    }

    header('Location: ../pages/chat.php?roomid='.$roomid.'?result='.$result.'', false);