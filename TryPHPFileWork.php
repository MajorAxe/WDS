<?php
$text = $_POST['innerText'];
$uid = $_POST['uid'];
$fName = $_POST['fName'];
$fullName = "./TryPHP/UserTries/" . $uid . $fName . ".php";
$fp = fopen($fullName, 'w');
fwrite($fp, $text);
fclose($fp);
?>