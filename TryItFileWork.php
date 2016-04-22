<?php
$text = $_POST['innerText'];
$uid = $_POST['uid'];
$fName = $_POST['fName'];
$fullName = "./TryIt/UserTries/" . $uid . $fName . ".html";
$fp = fopen($fullName, 'w');
fwrite($fp, $text);
fclose($fp);
?>