<?php
include('connectDB.php');
$artId = $_POST['artId'];
$uid = $_POST['uid'];
$mark = $_POST['mark'];
$query = "SELECT 1 FROM `ratings` WHERE `uid`='$uid' AND `aid`='$artId'";
$resultinner = mysqli_query($conn, $query);
$marked = mysqli_fetch_array($resultinner, 1);
if (!empty($marked)) {
    $query = "UPDATE `ratings` SET `rating`='$mark' WHERE `uid`='$uid' AND `aid`='$artId'";
} else {
    $query = "INSERT INTO `ratings`(`uid`, `aid`, `rating`) VALUES ('$uid','$artId','$mark')";
}
mysqli_query($conn, $query);
?>