<?php session_start(); ?>
<!DOCTYPE html>
<html>
<head>
    <link rel="stylesheet" href="CSS/shift.css">
    <link rel="stylesheet" href="CSS/MyBts.css">
    <link rel="stylesheet" href="CSS/main.css">
    <link rel="stylesheet" href="CSS/modalWindows.css">
    <link rel="stylesheet" href="CSS/LoginReg.css">
    <meta charset="utf-8">
    <style>
        .nav{
            background-color: #ffffff;
        }
    </style>
    <title>Справочник по веб-технологиям</title>
</head>
<body>
<?php
require("topmenu.php");
?>
<div class="nav">
    <div class="container" id="topmenu">
        <ul class="pull-left">
            <li class="icon-menu">Меню</li>
        </ul>
        <ul class="pull-right">
            <?php
            if (!isset($_SESSION['uid'])){
                ?>
                <li iddiv="loginWindow" class="mymagicoverbox">Войти</li>
                <li iddiv="registerWindow" class="mymagicoverbox">Зарегистрироваться</li>
            <?php } else {
                $nick = $_SESSION['nickname'];
                echo "<li iddiv = 'profileWindow' class='mymagicoverbox' > Добро пожаловать, $nick</li >";
            }
            ?>
        </ul>
    </div>
</div>

<div class="jumbotron" style="height: 130px">
    <div class="container" class="title" style="top: 60px">
        <a href="index.php"><h1>Справочник по веб-технологиям</h1></a>
    </div>
</div>

<div class="neighborhood-guides">
    <div class="container">
        <div class="row" style="margin-top: 22px">
            <div class="col-md-4" >
                <div class="thumbnail" id="HTMLMainButton">
                    <a href="HTMLArticles.php"><img class="menuimage" src="images/html5.svg"></a>
                </div>
            </div>
            <div class="col-md-4">
                <div class="thumbnail" id="CSSMainButton">
                    <a href="CSSArticles.php"><img class="menuimage" src="images/css3.svg"></a>
                </div>
            </div>
            <div class="col-md-4">
                <div class="thumbnail" id="JSMainButton">
                    <a href="JSArticles.php"><img class='menuimage' src="images/js.svg"></a>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="learn-more">
    <div class="container">
        <div class="row">
            <div class="col-md-6">
                <div class="thumbnail" id="PHPMainButton">
                    <a href="PHPArticles.php"><img class='menuimage' src="images/php7_logo.svg"></a>
                </div>
            </div>
            <div class="col-md-6">
                <div class="thumbnail" id="MySQLMainButton">
                    <a href="MySQLArticles.php"><img class='menuimage' src="images/MySQL.svg"></a>
                </div>
            </div>
        </div>
    </div>
</div>
</body>
</html>