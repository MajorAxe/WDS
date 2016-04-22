<?php
include('connectDB.php');
$messid = $_POST['messid'];
$query = "UPDATE `messages` SET `read`='1' WHERE `id`='$messid'";
mysqli_query($conn, $query);
?>