<?php session_start(); ?>
<!DOCTYPE html>
<html>
<head>
    <link rel="stylesheet" href="shift.css">
    <link rel="stylesheet" href="MyBts.css">
    <link rel="stylesheet" href="main.css">
    <link rel="stylesheet" href="modalWindows.css">
    <link rel="stylesheet" href="LoginReg.css">
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
if(isset($_POST['addarticle'])){
    $topic = $_POST['topic'];
    $artname = $_POST['artnameEdit'];
    $artpreview = $_POST['artpreview'];
    $artcontent = $_POST['artcontent'];
    $artname = str_replace('\'','SECRETCODEFORUPPERCOMMA',$artname);
    $artpreview = str_replace('\'','SECRETCODEFORUPPERCOMMA',$artpreview);
    $artcontent = str_replace('\'','SECRETCODEFORUPPERCOMMA',$artcontent);
    if (!empty($_SESSION['username']) && ($_SESSION['username'] == 'Admin')) {
        $published = $_POST['artStatus'];
    } else {
        $published = 2;
    }
    $author = $_SESSION['uid'];
    $query = "INSERT INTO `articles`(`Name`,`Preview`,`Content`, `Topic`,`Published`,`Author`) VALUES ('$artname','$artpreview','$artcontent','$topic','$published','$author')";
    mysqli_query($conn, $query);
    $_SESSION['MessageForUser'] = 'Статья успешно добавлена';
}
if(isset($_POST['editArticle'])){
    $id = $_POST['artname'];
    $artname = $_POST['artnameEdit'];
    $artpreview = $_POST['artpreview'];
    $artcontent = $_POST['artcontent'];
    $artname = str_replace('\'','SECRETCODEFORUPPERCOMMA',$artname);
    $artpreview = str_replace('\'','SECRETCODEFORUPPERCOMMA',$artpreview);
    $artcontent = str_replace('\'','SECRETCODEFORUPPERCOMMA',$artcontent);
    if (!empty($_SESSION['username']) && ($_SESSION['username'] == 'Admin')) {
        $published = $_POST['artStatus'];
        $result = mysqli_fetch_array((mysqli_query($conn, "SELECT `Author`,`Published` from `articles` WHERE `id`='$id'")));
        $prevPublished = $result['Published'];
        $authorid = $result['Author'];
        $result = mysqli_fetch_array((mysqli_query($conn, "SELECT `uid` FROM `users` WHERE `username`='Admin'")));
        $admuid = $result['uid'];
        if (($prevPublished != $published) && ($authorid != $admuid)) {
            switch ($published) {
                case 0:
                    $messageForAuthor = "Ваша статья '$artname' снята с публикации";
                    break;
                case 1:
                    $messageForAuthor = "Ваша статья '$artname' опубликована";
                    break;
                case 2:
                    $messageForAuthor = "Ваша статья '$artname' снова на рассмотрении";
                    break;
            }
            $messageForAuthor = str_replace('\'','SECRETCODEFORUPPERCOMMA',$messageForAuthor);
            $messquery = "INSERT INTO `messages`(`senderId`, `receiverId`, `message`) VALUES ('$admuid','$authorid','$messageForAuthor')";
            mysqli_query($conn, $messquery);
        }
        $query = "UPDATE `articles` SET `Name`='$artname',`Preview`='$artpreview',`Content`='$artcontent', `Published`='$published' WHERE `id`=$id";
    } else {
        $query = "UPDATE `articles` SET `Name`='$artname',`Preview`='$artpreview',`Content`='$artcontent',`Published`='2' WHERE `id`=$id";
    }
    mysqli_query($conn, $query);
    $_SESSION['MessageForUser'] = 'Статья успешно изменена';
}
if(isset($_POST['deleteArticle'])){
    $id = $_POST['artname'];
    $query = "DELETE FROM `articles` WHERE `id`=$id";
    mysqli_query($conn, $query);
    $_SESSION['MessageForUser'] = 'Статья удалена';
}
require("topmenu.php");
?>
<div class="sectionTitle" style="left: -8em">Редактировать статьи</div>
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
        <div class="col-md-6" >
            <?php
            if (!empty($_SESSION['username'])) { ?>
            <form method="post" name="artEditor" id="artEditor" action="<?php echo $_SERVER['PHP_SELF']; ?>">
                <br><br><br>
                Раздел: <select name="topic" id="topicEdit" onchange="fillArticleSelect()">
                    <option value="HTML">HTML</option>
                    <option value="CSS">CSS</option>
                    <option value="JS">Javascript</option>
                </select><br>
                Название: <br>
                <select name="artname" id="editArtSelect" onchange="fillArticle()">
                </select>
                <input type="button" id='ArtNameEditBtn' value="Редактировать" onclick="EditArtName()">
                <input type="text" name="artnameEdit" id="artnameEdit">
                <?php
                if ($_SESSION['username'] == 'Admin') {
                    echo "
                    <select name='artStatus' id='artStatus'>
                        <option value='0' style='background-color: #d2322d; color:#ffffff'>Не опубликована</option>
                        <option value='1' style='background-color: #4cae4c; color:#ffffff'>Опубликована</option>
                        <option value='2' style='background-color: #636366; color:#ffffff'>На рассмотрении</option>
                    </select>
                    ";
                } else {
                    echo "
                    <div name='artStatusForUser' id='artStatusForUser' style='float: right; margin-right: 40px'>Статус</div>
                    ";
                }
                ?>
                <br>
                Превью: <div id="symbCounter" style="float: right; margin-right: 40px">Длина превью</div><br>
                <textarea rows="5" cols="70" name="artpreview" id="artpreview" oninput="checkPreviewLength()"></textarea><br>
                Содержание:<br>
                <textarea rows="25" cols="70" name="artcontent" id="artcontent"></textarea><br>
                <input type="submit" name="addarticle" id="addarticle" value="Добавить статью" style="display: inline-block">
                <input type="submit" name="editArticle" id="editArticle" value="Редактировать статью">
                <input type="submit" name="deleteArticle" id="deleteArticle" value="Удалить статью">
            </form>
            <?php } else {
                echo "<div>Добавлять статьи могут только зарегистрированные пользователи</div>"; //TODO: сделать стиль
            }
            ?>
        </div>
    </div>
</div>
<div id="editArtList" style="display: none">
    <?php
    if (!empty($_SESSION['username'])) {
        $uid = $_SESSION['uid'];
        $result = mysqli_fetch_array((mysqli_query($conn, "SELECT `uid` from `users` WHERE `username`='Admin'")));
        $admuid = $result['uid'];
        echo "<div id='HTMLArtList'>";
        $query = "SELECT `id`,`Name`,`Author` from `articles` WHERE `Topic`='HTML' ORDER BY `id`";
        $result = mysqli_query($conn, $query);
        while ($row = mysqli_fetch_array($result)) {
            if (($uid == $row['Author']) || ($uid == $admuid)) {
                $name = $row['Name'];
                $id = $row['id'];
                echo "<option value='$id'>$name</option>";
            }
        }
        echo "<option value='NewArticle'>...Добавить статью...</option>";
        echo "</div>";
        echo "<div id='CSSArtList'>";
        $query = "SELECT `id`,`Name`,`Author` from `articles` WHERE `Topic`='CSS' ORDER BY `id`";
        $result = mysqli_query($conn, $query);
        while ($row = mysqli_fetch_array($result)) {
            if (($uid == $row['Author']) || ($uid == $admuid)) {
                $name = $row['Name'];
                $id = $row['id'];
                echo "<option value='$id'>$name</option>";
            }
        }
        echo "<option value='NewArticle'>...Добавить статью...</option>";
        echo "</div>";
        echo "<div id='JSArtList'>";
        $query = "SELECT `id`,`Name`,`Author` from `articles` WHERE `Topic`='JS' ORDER BY `id`";
        $result = mysqli_query($conn, $query);
        while ($row = mysqli_fetch_array($result)) {
            if (($uid == $row['Author']) || ($uid == $admuid)) {
                $name = $row['Name'];
                $id = $row['id'];
                echo "<option value='$id'>$name</option>";
            }
        }
        echo "<option value='NewArticle'>...Добавить статью...</option>";
        echo "</div>";
    }
    ?>
</div>
<script type="text/javascript" src="AddArticle.js"></script>
</body>
</html>