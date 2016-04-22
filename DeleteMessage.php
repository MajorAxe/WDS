<?php
include('connectDB.php');
$messId = $_POST['messId'];
$query = "DELETE FROM `messages` WHERE `id`='$messId'";
mysqli_query($conn, $query);
?>