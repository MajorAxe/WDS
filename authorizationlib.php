<?php
/*
Универсальный скрипт авторизации.
Используется сессии для хранения данных.
Скрипт типа "всё-в-одном" - его необходимо
включать в каждый файл для использования.
Распространяется по лицензии BSD.

+Требования:
+-Mysql & PHP5
+-Созданое подключение к MySQL и запущеная сессия =)

(c)2008 Vasilii B. Shpilchin
*/

##Определяем константы
define('USERS_TABLE','users');
define('SID',session_id());
##Определяем функции
//Функция выхода.
//Пользователь считается авторизированым, если в сессии присутствует uid
//см. "Действия - если пользователь авторизирован".
function logout() {
    unset($_SESSION['uid']); //Удаляем из сессии ID пользователя
    unset($_SESSION['username']);
    die(header('Location: '.$_SERVER['PHP_SELF']));
}

//Функция входа.
//Все выбраные поля записываются в сессию.
//Таким образом, при каждом просмотре страницы не надо выбирать их заново.
//Для обновления информации из БД можно пользоваться этой же функцией - имя и пароль
//хранятся в сессиях
function login($username,$password,$remember) {
    $result = mysqli_query($GLOBALS['conn'], "SELECT * FROM `".USERS_TABLE."` WHERE `username`='$username' AND `password`='$password';")
    or die(mysqli_error($GLOBALS['conn']));
    $USER = mysqli_fetch_array($result,1); //Генерирует удобный массив из результата запроса
    if(!empty($USER)) { //Если массив не пустой (это значит, что пара имя/пароль верная)
        $_SESSION = array_merge($_SESSION,$USER); //Добавляем массив с пользователем к массиву сессии
        $sql = "UPDATE `".USERS_TABLE."` " . "(sid,remember,online) VALUES ('SID', '$remember','1')";
        mysqli_query($GLOBALS['conn'], $sql)
//        mysqli_query($GLOBALS['conn'], "UPDATE `".USERS_TABLE."` SET `sid`='".SID."' WHERE `uid`='".$USER['uid']."';")
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

function regnew($username,$password,$nickname,$email) {
    $result = mysqli_query($GLOBALS['conn'], "SELECT * FROM `".USERS_TABLE."` WHERE `username`='$username' AND `password`='$password';")
    or die(mysqli_error($GLOBALS['conn']));
    $USER = mysqli_fetch_array($result,1);
    if(!empty($USER)) {
        return false;
    }
    else {
        $sql = "INSERT INTO `".USERS_TABLE."` " . "(username,password,nickname,email) VALUES ('$username', '$password','$nickname','$email')";
        mysqli_query($GLOBALS['conn'], $sql)
        or die(mysqli_error($GLOBALS['conn']));
        return true;
    }
}

//Функция проверки залогинности пользователя.
//При входе, ID сессии записывается в БД.
//Если ID текущей сессии и SID из БД не совпадают, производится logout.
//Благородя этому нельзя одновременно работать под одним ником с разных браузеров.
function check_user($uid) {
    $result = mysqli_query($GLOBALS['conn'], "SELECT `sid` FROM `".USERS_TABLE."` WHERE `uid`='$uid';") or die(mysqli_error($GLOBALS['conn']));
    $sid = mysqli_result($result,0);
    return $sid==SID ? true : false;
}

##Действия - если пользователь авторизирован
if(isset($_SESSION['uid'])) { //Если была произведена авторизация, то в сессии есть uid

    //Константу удобно проверять в любом месте скрипта
    define('USER_LOGGED',true);
    //Создаём удобные переменные
    //Все поля таблицы пользователей записываются в сесси (см. стр. 35-37)
    //Таким образом, после добавления нового поля в таблицу надо дописть лишь одну строку
    $UserName = $_SESSION['username'];
    $UserPass = $_SESSION['password'];
    $UserID = $_SESSION['uid'];
}
else {
    define('USER_LOGGED',false);
}

##Действия при попытке входа
if (isset($_POST['login'])) {

    if(get_magic_quotes_gpc()) { //Если слеши автоматически добавляются
        $_POST['user']=stripslashes($_POST['user']);
        $_POST['pass']=stripslashes($_POST['pass']);
    }
    $user = mysqli_real_escape_string($GLOBALS['conn'], $_POST['user']);
    $pass = mysqli_real_escape_string($GLOBALS['conn'], $_POST['pass']);
    $rem = $_POST['loginkeeping'];
    if(login($user,$pass,$rem)) {
        header('Refresh: 3');
        die('Вы успешно авторизировались!');
    }
    else {
        header('Refresh: 3;');
        die('Пароль неправильный!');
    }

}

##Действия при попытке регистрации
if (isset($_POST['reg'])) {

    if(get_magic_quotes_gpc()) { //Если слеши автоматически добавляются
        $_POST['username']=stripslashes($_POST['username']);
        $_POST['password']=stripslashes($_POST['password']);
        $_POST['nickname']=stripslashes($_POST['nickname']);
        $_POST['email']=stripslashes($_POST['email']);
    }
    $user = mysqli_real_escape_string($GLOBALS['conn'], $_POST['username']);
    $pass = mysqli_real_escape_string($GLOBALS['conn'], $_POST['password']);
    $nick = mysqli_real_escape_string($GLOBALS['conn'], $_POST['nickname']);
    $mail = mysqli_real_escape_string($GLOBALS['conn'], $_POST['email']);
    if(regnew($user,$pass,$nick,$mail)) {
        header('Refresh: 0');
//        die('Вы успешно добавили нового пользователя!');
    }
    else {
        header('Refresh: 0;');
//        die('Такой пользователь уже есть!');
    }

}

##Действия при попытке выхода
if(isset($_GET['logout'])) {
    logout();
}
?>