<?php
include('connectDB.php');
$usernameWanted = $_POST['usernameWanted'];
$query = "SELECT 1 FROM `users` WHERE `username`='$usernameWanted'";
$result = mysqli_query($conn, $query);
$USER = mysqli_fetch_array($result,1);
if(!empty($USER)) {
    echo false;
} else {
    echo true;
}