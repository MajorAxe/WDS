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
        .nav {
            background-color: #393c3d;
        }
        .nav li {
            color: #E3E3EB;
        }
    </style>
    <meta charset="utf-8">
</head>
<body>
<?php
include('connectDB.php');
require("topmenu.php");
?>
<div class="sectionTitle" style="left: -8em">Статистика сайта</div>
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
<?php
$row = mysqli_fetch_row(mysqli_query($conn, "SELECT COUNT(*) FROM `articles` WHERE `Published`='1'"));
$artCount = $row[0];
$topicArtCount = mysqli_query($conn, "SELECT `topic`, COUNT(*) as artC FROM `articles` WHERE `Published`='1' GROUP BY topic ORDER BY artC DESC");
$topicRatings = mysqli_query($conn, "SELECT `articles`.`topic` as topic, AVG(rating) as rating FROM `ratings`, `articles` WHERE `articles`.`id`=`ratings`.`aid` GROUP BY topic ORDER BY rating DESC");
$nameRatings = mysqli_query($conn, "SELECT `articles`.`topic` as topic, `articles`.`Name` as name, AVG(rating) as rating FROM `ratings`, `articles` WHERE `articles`.`id`=`ratings`.`aid` GROUP BY name ORDER BY rating DESC");
$timesRead =  mysqli_query($conn, "SELECT `articles`.`topic` as topic, `articles`.`Name` as name, COUNT(*) as timesread FROM `articlesread`, `articles` WHERE `articles`.`id`=`articlesread`.`aid` GROUP BY name ORDER BY timesread DESC");
$row = mysqli_fetch_row(mysqli_query($conn, "SELECT COUNT(*) FROM `users`"));
$usersCount = $row[0];
$row = mysqli_fetch_row(mysqli_query($conn, "SELECT COUNT(*) FROM `users` WHERE `uid` IN (SELECT `uid` FROM `articlesread`)"));
$usersReadCount = $row[0];
$row = mysqli_fetch_row(mysqli_query($conn, "SELECT COUNT(*) FROM `users` WHERE `uid` IN (SELECT `uid` FROM `ratings`)"));
$usersRateCount = $row[0];
$row = mysqli_fetch_row(mysqli_query($conn, "SELECT COUNT(*) FROM `users` WHERE `uid` IN (SELECT `Author` FROM `articles`)"));
$usersWroteCount = $row[0];
$artsReadByUser =  mysqli_query($conn, "SELECT `users`.`username` as name, COUNT(*) as artsread FROM `articlesread`, `users` WHERE `users`.`uid`=`articlesread`.`uid` GROUP BY name ORDER BY artsread DESC");
$artsRatedByUser =  mysqli_query($conn, "SELECT `users`.`username` as name, COUNT(*) as artsrated FROM `ratings`, `users` WHERE `users`.`uid`=`ratings`.`uid` GROUP BY name ORDER BY artsrated DESC");
$bestAuthors = mysqli_query($conn, "SELECT `users`.`username` as name, `authors`.`rating` as rating FROM (SELECT `articles`.`Author` as author, AVG(rating) as rating FROM `ratings`, `articles` WHERE `articles`.`id`=`ratings`.`aid` GROUP BY author) as `authors`, `users` WHERE `users`.`uid`=`authors`.`author` ORDER BY `rating` DESC");
?>
<div class="neighborhood-guides">
    <div class="container">
        <div class="col-md-12">
        <h2>Статьи</h2>
        <table class="table">
            <thead>
            <tr>
                <th>Статей опубликовано на сайте</th>
                <th><?=$artCount?></th>
            </tr>
            </thead>
            <tbody>
            <tr>
                <td colspan="2">По разделам</td>
            </tr>
            <tr>
                <?php $row = mysqli_fetch_array($topicArtCount) ?>
                <td><?=$row['topic']?></td>
                <td><?=$row['artC']?></td>
            </tr>
            <tr>
                <?php $row = mysqli_fetch_array($topicArtCount) ?>
                <td><?=$row['topic']?></td>
                <td><?=$row['artC']?></td>
            </tr>
            <tr>
                <?php $row = mysqli_fetch_array($topicArtCount) ?>
                <td><?=$row['topic']?></td>
                <td><?=$row['artC']?></td>
            </tr>
            <tr>
                <?php $row = mysqli_fetch_array($topicArtCount) ?>
                <td><?=$row['topic']?></td>
                <td><?=$row['artC']?></td>
            </tr>
            <tr>
                <?php $row = mysqli_fetch_array($topicArtCount) ?>
                <td><?=$row['topic']?></td>
                <td><?=$row['artC']?></td>
            </tr>
            </tbody>
        </table>
            </div>
        <div class="col-md-4">
            <table class="table">
                <thead>
                <tr>
                    <th colspan="2">Средние оценки по разделам</th>
                </tr>
                </thead>
                <tbody>
                <tr>
                    <?php $row = mysqli_fetch_array($topicRatings) ?>
                    <td><?=$row['topic']?></td>
                    <td><?=$row['rating']?></td>
                </tr>
                <tr>
                    <?php $row = mysqli_fetch_array($topicRatings) ?>
                    <td><?=$row['topic']?></td>
                    <td><?=$row['rating']?></td>
                </tr>
                <tr>
                    <?php $row = mysqli_fetch_array($topicRatings) ?>
                    <td><?=$row['topic']?></td>
                    <td><?=$row['rating']?></td>
                </tr>
                <tr>
                    <?php $row = mysqli_fetch_array($topicRatings) ?>
                    <td><?=$row['topic']?></td>
                    <td><?=$row['rating']?></td>
                </tr>
                <tr>
                    <?php $row = mysqli_fetch_array($topicRatings) ?>
                    <td><?=$row['topic']?></td>
                    <td><?=$row['rating']?></td>
                </tr>
                </tbody>
            </table>
        </div>
        <div class="col-md-4">
            <table class="table">
                <thead>
                <tr>
                    <th colspan="2">Лучшие статьи</th>
                </tr>
                </thead>
                <tbody>
                <tr>
                    <?php $row = mysqli_fetch_array($nameRatings) ?>
                    <td><?=$row['topic']?> <?=$row['name']?></td>
                    <td><?=$row['rating']?></td>
                </tr>
                <tr>
                    <?php $row = mysqli_fetch_array($nameRatings) ?>
                    <td><?=$row['topic']?> <?=$row['name']?></td>
                    <td><?=$row['rating']?></td>
                </tr>
                <tr>
                    <?php $row = mysqli_fetch_array($nameRatings) ?>
                    <td><?=$row['topic']?> <?=$row['name']?></td>
                    <td><?=$row['rating']?></td>
                </tr>
                <tr>
                    <?php $row = mysqli_fetch_array($nameRatings) ?>
                    <td><?=$row['topic']?> <?=$row['name']?></td>
                    <td><?=$row['rating']?></td>
                </tr>
                <tr>
                    <?php $row = mysqli_fetch_array($nameRatings) ?>
                    <td><?=$row['topic']?> <?=$row['name']?></td>
                    <td><?=$row['rating']?></td>
                </tr>
                </tbody>
            </table>
        </div>
        <div class="col-md-4">
            <table class="table">
                <thead>
                <tr>
                    <th colspan="2">Самые читаемые</th>
                </tr>
                </thead>
                <tbody>
                <tr>
                    <?php $row = mysqli_fetch_array($timesRead) ?>
                    <td><?=$row['topic']?> <?=$row['name']?></td>
                    <td><?=$row['timesread']?></td>
                </tr>
                <tr>
                    <?php $row = mysqli_fetch_array($timesRead) ?>
                    <td><?=$row['topic']?> <?=$row['name']?></td>
                    <td><?=$row['timesread']?></td>
                </tr>
                <tr>
                    <?php $row = mysqli_fetch_array($timesRead) ?>
                    <td><?=$row['topic']?> <?=$row['name']?></td>
                    <td><?=$row['timesread']?></td>
                </tr>
                <tr>
                    <?php $row = mysqli_fetch_array($timesRead) ?>
                    <td><?=$row['topic']?> <?=$row['name']?></td>
                    <td><?=$row['timesread']?></td>
                </tr>
                <tr>
                    <?php $row = mysqli_fetch_array($timesRead) ?>
                    <td><?=$row['topic']?> <?=$row['name']?></td>
                    <td><?=$row['timesread']?></td>
                </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>
</div>
<div class="learn-more">
    <div class="container">
        <div class="col-md-12">
            <h2>Пользователи</h2>
            <table class="table">
                <thead>
                <tr>
                    <th>Пользователей зарегистрировано</th>
                    <th><?=$usersCount?></th>
                </tr>
                </thead>
                <tbody>
                <tr>
                    <td>Из них читали статьи</td>
                    <td><?=$usersReadCount?></td>
                </tr>
                <tr>
                    <td>Из них оценивали статьи</td>
                    <td><?=$usersRateCount?></td>
                </tr>
                <tr>
                    <td>Из них писали статьи</td>
                    <td><?=$usersWroteCount?></td>
                </tr>
                </tbody>
            </table>
        </div>
        <div class="col-md-4">
            <table class="table">
                <thead>
                <tr>
                    <th colspan="2">Больше всего статей прочитано</th>
                </tr>
                </thead>
                <tbody>
                <tr>
                    <?php $row = mysqli_fetch_array($artsReadByUser) ?>
                    <td><?=$row['name']?></td>
                    <td><?=$row['artsread']?></td>
                </tr>
                <tr>
                    <?php $row = mysqli_fetch_array($artsReadByUser) ?>
                    <td><?=$row['name']?></td>
                    <td><?=$row['artsread']?></td>
                </tr>
                <tr>
                    <?php $row = mysqli_fetch_array($artsReadByUser) ?>
                    <td><?=$row['name']?></td>
                    <td><?=$row['artsread']?></td>
                </tr>
                <tr>
                    <?php $row = mysqli_fetch_array($artsReadByUser) ?>
                    <td><?=$row['name']?></td>
                    <td><?=$row['artsread']?></td>
                </tr>
                <tr>
                    <?php $row = mysqli_fetch_array($artsReadByUser) ?>
                    <td><?=$row['name']?></td>
                    <td><?=$row['artsread']?></td>
                </tr>
                </tbody>
            </table>
        </div>
        <div class="col-md-4">
            <table class="table">
                <thead>
                <tr>
                    <th colspan="2">Больше всего оценок статьям</th>
                </tr>
                </thead>
                <tbody>
                <tr>
                    <?php $row = mysqli_fetch_array($artsRatedByUser) ?>
                    <td><?=$row['name']?></td>
                    <td><?=$row['artsrated']?></td>
                </tr>
                <tr>
                    <?php $row = mysqli_fetch_array($artsRatedByUser) ?>
                    <td><?=$row['name']?></td>
                    <td><?=$row['artsrated']?></td>
                </tr>
                <tr>
                    <?php $row = mysqli_fetch_array($artsRatedByUser) ?>
                    <td><?=$row['name']?></td>
                    <td><?=$row['artsrated']?></td>
                </tr>
                <tr>
                    <?php $row = mysqli_fetch_array($artsRatedByUser) ?>
                    <td><?=$row['name']?></td>
                    <td><?=$row['artsrated']?></td>
                </tr>
                <tr>
                    <?php $row = mysqli_fetch_array($artsRatedByUser) ?>
                    <td><?=$row['name']?></td>
                    <td><?=$row['artsrated']?></td>
                </tr>
                </tbody>
            </table>
        </div>
        <div class="col-md-4">
            <table class="table">
                <thead>
                <tr>
                    <th colspan="2">Лучшие авторы</th>
                </tr>
                </thead>
                <tbody>
                <tr>
                    <?php $row = mysqli_fetch_array($bestAuthors) ?>
                    <td><?=$row['name']?></td>
                    <td><?=$row['rating']?></td>
                </tr>
                <tr>
                    <?php $row = mysqli_fetch_array($bestAuthors) ?>
                    <td><?=$row['name']?></td>
                    <td><?=$row['rating']?></td>
                </tr>
                <tr>
                    <?php $row = mysqli_fetch_array($bestAuthors) ?>
                    <td><?=$row['name']?></td>
                    <td><?=$row['rating']?></td>
                </tr>
                <tr>
                    <?php $row = mysqli_fetch_array($bestAuthors) ?>
                    <td><?=$row['name']?></td>
                    <td><?=$row['rating']?></td>
                </tr>
                <tr>
                    <?php $row = mysqli_fetch_array($bestAuthors) ?>
                    <td><?=$row['name']?></td>
                    <td><?=$row['rating']?></td>
                </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>
</body>
</html>