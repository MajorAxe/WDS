<?php
session_start();
$whereto = $_SESSION['currentpage'];
unset($_SESSION['uid']); //Удаляем из сессии ID пользователя
unset($_SESSION['username']);
session_unset();
header("location: $whereto");
?>