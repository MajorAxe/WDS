<?php
$loginDB = 'u740204175_wdevs';
$passwordDB = 'dt,ltdcrek';
$database = 'u740204175_wdevs';
$conn = mysqli_connect("localhost",$loginDB,$passwordDB);
mysqli_select_db($conn, $database);
?>