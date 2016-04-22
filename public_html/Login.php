<?php
session_start();
include('connectDB.php');
define('USERS_TABLE','users');
define('SID',session_id());

function login($username,$password,$remember) {
    $result = mysqli_query($GLOBALS['conn'], "SELECT * FROM `".USERS_TABLE."` WHERE `username`='$username' AND `password`='$password';")
    or die(mysqli_error($GLOBALS['conn']));
    $USER = mysqli_fetch_array($result,1); //Генерирует удобный массив из результата запроса
    if(!empty($USER)) { //Если массив не пустой (это значит, что пара имя/пароль верная)
        $_SESSION = array_merge($_SESSION,$USER); //Добавляем массив с пользователем к массиву сессии
//        $sql = "UPDATE `".USERS_TABLE."` " . "(sid,remember,online) VALUES (`".SID."`, `$remember``,`1`)";
//        mysqli_query($GLOBALS['conn'], $sql)
        mysqli_query($GLOBALS['conn'], "UPDATE `".USERS_TABLE."` SET `sid`='".SID."', `remember`='".$remember."', `online`='1' WHERE `uid`='".$USER['uid']."';")
        or die(mysqli_error($GLOBALS['conn']));
        if ($remember){
            setcookie('remember_me', SID, time()+2592000);
        }
        return true;
    }
    else {
        return false;
    }
}

if(get_magic_quotes_gpc()) { //Если слеши автоматически добавляются
    $_POST['username']=stripslashes($_POST['username']);
    $_POST['password']=stripslashes($_POST['password']);
}
$user = mysqli_real_escape_string($GLOBALS['conn'], $_POST['username']);
$pass = mysqli_real_escape_string($GLOBALS['conn'], $_POST['password']);
if (isset($_POST['loginkeeping'])){
    $rem = true;
}
else{
    $rem = false;
}
$whereto = $_SESSION['currentpage'];
if(login($user,$pass,$rem)) {
    header("location: $whereto");
    $_SESSION['autorerror'] = false;
//    $_SESSION['MessageForUser'] = 'Выполнен вход';
}
else {
    header("location: $whereto");
    $_SESSION['autorerror'] = true;
    $_SESSION['MessageForUser'] = 'Ошибка входа';
}

