<?php
include('connectDB.php');
$sender = $_POST['sender'];
$receiver = $_POST['receiver'];
$messageText = $_POST['messageText'];
$messageText = str_replace('\'','SECRETCODEFORUPPERCOMMA',$messageText);
$query = "INSERT INTO `messages`(`senderId`, `receiverId`, `message`) VALUES ('$sender','$receiver','$messageText')";
mysqli_query($conn, $query);
?>