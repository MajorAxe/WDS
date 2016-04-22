<?php
session_start();
include('connectDB.php');
define('USERS_TABLE','users');
define('SID',session_id());

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
    $_POST['nickname']=stripslashes($_POST['nickname']);
    $_POST['email']=stripslashes($_POST['email']);
}
$user = mysqli_real_escape_string($GLOBALS['conn'], $_POST['username']);
$pass = mysqli_real_escape_string($GLOBALS['conn'], $_POST['password']);
$nick = mysqli_real_escape_string($GLOBALS['conn'], $_POST['nickname']);
$mail = mysqli_real_escape_string($GLOBALS['conn'], $_POST['email']);
$whereto = $_SESSION['currentpage'];
if(regnew($user,$pass,$nick,$mail)) {
    login($user,$pass,'false');
    header("location: $whereto");
    $_SESSION['regerror'] = false;
    $_SESSION['MessageForUser'] = 'Новый пользователь зарегистрирован';
    $result = mysqli_fetch_array((mysqli_query($conn, "SELECT `uid` FROM `users` WHERE `username`='Admin'")));
    $admuid = $result['uid'];
    $result = mysqli_fetch_array((mysqli_query($conn, "SELECT `uid` FROM `users` WHERE `username`='$user'")));
    $receiver = $result['uid'];
    $messageText = "Добро пожаловать на сайт WebDevSchool.hol.es, онлайн-школу веб-разработки. Это приветственное сообщение от администратора, оно имеет синий цвет.
    В будущем в этой области будут появляться новые. Сообщения от обычных пользователей выделены зелёным. Вы можете отметить любое сообщение как прочитанное, кликнув по нему.
     Также вы можете сами отправить сообщение любому зарегистрированному пользователю.
     На сайте содеражатся статьи об HTML, CSS и JavaScript. Все материалы имеют цветовой код: оранжевый для HTML, синий для CSS и зелёный для JavaScript.
     Также, если вы попробуете сами добавить статью на сайт, вы можете увидеть статьи с рамкой серго цвета(находящиеся на рассмотрении)
     или с рамкой красного цвета(те, которым отказано в публикации). Такие статьи может видеть только их автор. При добавлении статей в их тексте можно и нужно использовать
     HTML-теги и JavaScript. Для добавления картинок разместите в статье ссылки на все необходимые изображения так, будто они находятся в директории ./images, и отправьте
     ссылку на архив с картинками администратору. После нажатия кнопки 'Добавить' ваша статья получит статус 'на рассмотрении', и через некоторое время будет рассмотрена администратором.
     Он может опубликовать её или отклонить. При любом изменении статуса вашей статьи вы получите сообщение, аналогичное этому. Желаем вам удачи в изучении веб-технологий и надеемся что время, проведённое на нашем сайте, принесёт вам пользу.";
    $messageText = str_replace('\'','SECRETCODEFORUPPERCOMMA',$messageText);
    $query = "INSERT INTO `messages`(`senderId`, `receiverId`, `message`) VALUES ('$admuid','$receiver','$messageText')";
    mysqli_query($conn, $query);
}
else {
    header("location: $whereto");
    $_SESSION['regerror'] = true;
    $_SESSION['MessageForUser'] = 'Ошибка регистрации';
}
?>
