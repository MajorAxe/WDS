<?php
include('connectDB.php');
$artId = $_POST['artId'];
$query = "SELECT `Preview`,`Content`,`Published` from `articles` WHERE `id`='$artId'";
$result = mysqli_query($conn, $query);
$row = mysqli_fetch_assoc($result);
$published = $row['Published'];
$preview = $row['Preview'];
$content = $row['Content'];
echo "$published $preview PreviewContentSeparator $content";
?>