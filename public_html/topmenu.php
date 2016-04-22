<?php
include('connectDB.php');
$_SESSION['currentpage'] = $_SERVER['REQUEST_URI'];
?>
<div id="myfond_gris" opendiv=""></div>
<!--ОКНО ВХОДА-->
<div id="wrapper">
    <div id="loginWindow" class="mymagicoverbox_fenetre LoginWindow" style="left:-350px; width:700px;">
        <div class="mymagicoverbox_fenetreinterieur">
            <form  method="post" action="Login.php" autocomplete="on">
                <label for="username" class="uname"> Имя пользователя </label>
                <input id="log_username" name="username" required="required" type="text" placeholder="Введите ваше имя пользователя"/>
                <label for="password" class="youpasswd"> Пароль </label>
                <input id="log_password" name="password" required="required" type="password" placeholder="Введите ваш пароль" />
<!--                <input type="checkbox" name="loginkeeping" id="loginkeeping" value="loginkeeping" />-->
<!--                <label for="loginkeeping">Запомнить меня</label>-->
                <p class="login button">
                    <input type="submit" value="Войти" />
                </p>
            </form>
        </div>
    </div>
    <div id="registerWindow" class="mymagicoverbox_fenetre RegisterWindow" style="left:-350px; width:700px;">
        <div class="mymagicoverbox_fenetreinterieur">
            <form  method="post" action="Register.php" autocomplete="on">
                <label for="username" class="uname"> Имя пользователя </label><div id="RegLoginCheck" style="float: right">Проверка логина</div>
                <input id="username" name="username" required="required" type="text" placeholder="Введите ваше имя пользователя" oninput="checkLogin()"/>
                <label for="password" class="youpasswd" style="display: inline-block"> Пароль </label>
                <input id="password" name="password" required="required" type="password" placeholder="Введите ваш пароль" oninput="checkPasswords()" />
                <label for="password" class="youpasswd"> Опять пароль </label><div id="RegPassCheck" style="float: right">Проверка пароля</div>
                <input id="passwordrep" name="passwordrep" required="required" type="password" placeholder="Повторите пароль" oninput="checkPasswords()" />
                <label for="password" class="youpasswd"> Псевдоним </label>
                <input id="nickname" name="nickname" required="required" type="text" placeholder="Введите ваш псевдоним на сайте" />
                <label for="password" class="youpasswd"> Адрес электронной почты </label>
                <input id="email" name="email" required="required" type="text" placeholder="example@somemail.com" />
                <p class="login button">
                    <input type="submit" id="RegButton" value="Зарегистрироваться" />
                </p>
            </form>
        </div>
    </div>
    <?php
    if (isset($_SESSION['uid'])) {
        $uid = $_SESSION['uid'];
        $row = mysqli_fetch_row(mysqli_query($conn, "SELECT COUNT(*) FROM `articles` WHERE `Topic`='HTML'"));
        $HTMLArtCount = $row[0];
        $row = mysqli_fetch_row(mysqli_query($conn, "SELECT COUNT(*) FROM `articles` WHERE `Topic`='CSS'"));
        $CSSArtCount = $row[0];
        $row = mysqli_fetch_row(mysqli_query($conn, "SELECT COUNT(*) FROM `articles` WHERE `Topic`='JS'"));
        $JSArtCount = $row[0];
        $row = mysqli_fetch_row(mysqli_query($conn, "SELECT DISTINCT COUNT(*) FROM `articlesread` WHERE `uid`='$uid' AND `topic`='HTML'"));
        $HTMLArtRead = $row[0];
        $row = mysqli_fetch_row(mysqli_query($conn, "SELECT DISTINCT COUNT(*) FROM `articlesread` WHERE `uid`='$uid' AND `topic`='CSS'"));
        $CSSArtRead = $row[0];
        $row = mysqli_fetch_row(mysqli_query($conn, "SELECT DISTINCT COUNT(*) FROM `articlesread` WHERE `uid`='$uid' AND `topic`='JS'"));
        $JSArtRead = $row[0];
        $HTMLPercentage = round($HTMLArtRead*100/$HTMLArtCount);
        $CSSPercentage = round($CSSArtRead*100/$CSSArtCount);
        $JSPercentage = round($JSArtRead*100/$JSArtCount);
//        $_SESSION['MessageForUser'] = $row[0];

        echo "<div id='profileWindow' class='mymagicoverbox_fenetre ProfileWindow'>
        <div class='mymagicoverbox_fenetreinterieur' style='background-color: #e7e7e7'>
        <div class='col-md-6' >
            <table class = 'StaticticsTable' style='text-align: right; padding: 10px; margin-left: 40px; margin-bottom: 10px'>
                <tr>
                    <th colspan='4' style='text-align: center'>Прочитано статей</th>
                </tr>
                <tr style='background-color: coral'>
                    <td>HTML</td>
                    <td>$HTMLArtRead/$HTMLArtCount</td>
                    <td>
                        <progress max='100' value='$HTMLPercentage'></progress>
                    </td>
                    <td>$HTMLPercentage%</td>
                </tr>
                <tr style='background-color: deepskyblue'>
                    <td>CSS</td>
                    <td>$CSSArtRead/$CSSArtCount</td>
                    <td>
                        <progress max='100' value='$CSSPercentage'></progress>
                    </td>
                    <td>$CSSPercentage%</td>
                </tr>
                <tr style='background-color: #97BF0D'>
                    <td>Javascript</td>
                    <td>$JSArtRead/$JSArtCount</td>
                    <td>
                        <progress max='100' value='$JSPercentage'></progress>
                    </td>
                    <td>$JSPercentage%</td>
                </tr>
            </table>";?>
        <form method="post" name="messEditor" id="messEditor" style='border: groove #efefef; padding: 5px; margin: 5px;' action="<?php echo $_SERVER['PHP_SELF']; ?>">
            <div style="display: inline-block">Кому:</div>
            <select style="display: inline-block" name="ReceiverName" id="ReceiverName"><?php
                $query = "SELECT `uid`, `username` FROM `users` ORDER BY `username`";
                $resultusers = (mysqli_query($conn, $query));
                while ($row = mysqli_fetch_array($resultusers)) {
                    $receiverId = $row['uid'];
                    $receiverName = $row['username'];
                    echo "<option value='$receiverId'>$receiverName</option>";
                }
                ?>
            </select>
            <textarea rows="6" cols="51" name="messText" id="messText" style='margin-top: 7px'></textarea><br>
            <input type="button" name="messageSubmitBtn" id="messageSubmitBtn" value="Отправить сообщение" style="display: inline-block; font-weight: bold; margin-right: 20px; margin-bottom: 2px" onclick="sendMessageWrapper(<?php echo $uid; ?>)">
        </form>
    <?php
    echo "
            </div>
            <div class='col-md-6 messageBox'>";
        $query = "SELECT `id`, `senderId`, `message`, `date`, `read` FROM `messages` WHERE `receiverId`=$uid ORDER BY `date` DESC";
        $result = mysqli_query($conn, $query);
        while ($row = mysqli_fetch_array($result)) {
            $messid = $row['id'];
            $senderid = $row['senderId'];
            $resultinner = mysqli_fetch_array((mysqli_query($conn, "SELECT `username` FROM `users` WHERE `uid`='$senderid'")));
            $sendername = $resultinner['username'];
            $messagetext = $row['message'];
            $messagetext = str_replace('SECRETCODEFORUPPERCOMMA', '\'', $messagetext);
            $messdate = $row['date'];
            $messread = $row['read'];
            if ($messread) {
                $ArtStyle = 'PremoderatedArticleRead';
                echo "<li class='singleMessageBox' id='$messid'>";
            } else if ($sendername == 'Admin') {
                $ArtStyle = 'CSSButtonRead';
                echo "<li class='singleMessageBox' id='$messid' onclick='markMessage($messid)'>";
            } else {
                $ArtStyle = 'JSButtonRead';
                echo "<li class='singleMessageBox' id='$messid' onclick='markMessage($messid)'>";
            }
            echo "
                <div class='thumbnail' id='$ArtStyle' style='padding: 8px'>
                    <div class=''><div class='messagehead'>$sendername   $messdate</div><div class='messagecont'>$messagetext</div></div>
                </div>
            </li>";
        }
        echo "
            </div>

            <a href='Logout.php' style='display: block; margin-left: 47%; margin-top: 10px;'>ВЫХОД</a>
        </div>
    </div>";
    }
    ?>

</div>
<div class="menu">
    <!-- Menu icon -->
    <div class="icon-close">
        <img src="images/close.png">
    </div>
    <!-- Menu -->
    <ul>
        <?php
        if (!empty($_SESSION['username'])) { ?>
            <li><a href="AddArticle.php">Редактировать статьи</a></li>
        <?php } ?>
        <li><a href="HTMLArticles.php">HTML</a></li>
        <li><a href="CSSArticles.php">CSS</a></li>
        <li><a href="JSArticles.php">JS</a></li>
    </ul>
</div>
<link href='http://fonts.googleapis.com/css?family=Roboto:100,400,300,500,700' rel='stylesheet' type='text/css'>
<script src="jQuery.js"></script>
<script type="text/javascript" src="topmenuanim.js"></script>
<script type="text/javascript" src="RegisterChecks.js"></script>
<script src="MessageWork.js"></script>
<?php
if (isset($_SESSION['MessageForUser'])) {
    $message = $_SESSION['MessageForUser'];
    $message = str_replace('SECRETCODEFORUPPERCOMMA','\'',$message);
    $_SESSION['MessageForUser'] = '';
    unset($_SESSION['MessageForUser']);
    ?>
    <script type='text/javascript'>alert("<?php echo $message; ?>");</script>
<?php
}
?>

