<?php
$text = $_POST['innerText'];
$uid = $_POST['uid'];
$fName = $_POST['fName'];
$fullName = "./TryIt/UserTries/" . $fName . $uid . ".html";
$fp = fopen($fullName, 'w');
fwrite($fp, $text);
fclose($fp);
?>