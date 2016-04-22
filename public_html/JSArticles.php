<?php session_start(); ?>
<!DOCTYPE html>
<html>
<head>
    <link rel="stylesheet" href="shift.css">
    <link rel="stylesheet" href="MyBts.css">
    <link rel="stylesheet" href="main.css">
    <link rel="stylesheet" href="modalWindows.css">
    <link rel="stylesheet" href="LoginReg.css">
    <link rel="stylesheet" href="stdtheme.css">
    <meta charset="utf-8">
    <style>
        .nav {
            background-color: #97BF0D;
        }
        .nav li {
            color: #E3E3EB;
        }
    </style>
    <meta charset="utf-8">
</head>
<body>
<?php
require("topmenu.php");
?>
<div class="sectionTitle" style="left: -1em">JS</div>
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
        <div class="row">
            <?php
            $topic = 'JS';
            include('ShowArticles.php');
            ?>
        </div>
    </div>
</div>
</body>
</html>