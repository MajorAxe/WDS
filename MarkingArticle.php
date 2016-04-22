<?php
include('connectDB.php');
$artId = $_POST['artId'];
$uid = $_POST['uid'];
$whatToDo = $_POST['WhatToDo'];
$query = "SELECT `Topic` FROM `articles` WHERE `id`='$artId'";
$row = mysqli_fetch_row(mysqli_query($conn, $query));
$topic = $row[0];
if ($whatToDo == 'true') {
    $query = "INSERT INTO `articlesread`(`uid`, `aid`, `read`,`topic`) VALUES ('$uid','$artId','1','$topic')";
} else {
    $query = "DELETE FROM `articlesread` WHERE `uid`='$uid' AND `aid`='$artId'";
}
mysqli_query($conn, $query);
?>