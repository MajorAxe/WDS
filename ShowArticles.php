<?php
if (!empty($_SESSION['username'])){
    if ($_SESSION['username'] == 'Admin') {
        $query = "SELECT * FROM `articles` WHERE `Topic`='$topic' ORDER BY `id`";
    } else {
        $uid = $_SESSION['uid'];
        $query = "SELECT * FROM `articles` WHERE `Topic`='$topic' AND (`Published`='1' OR `Author`='$uid') ORDER BY `id`";
    }
} else {
    $query = "SELECT * FROM `articles` WHERE `Topic`='$topic' AND `Published`='1' ORDER BY `id`";
}
$result = mysqli_query($conn, $query);
while ($row = mysqli_fetch_array($result)){
    $id = $row['id'];
    $published = $row['Published'];
    switch ($published) {
        case 0:
            $ArtStyle = 'NotPublishedArticle';
            break;
        case 1:
            $ArtStyle = $topic . 'Button';
            break;
        case 2:
            $ArtStyle = 'PremoderatedArticle';
            break;
    }
    $name = $row['Name'];
    $preview = $row['Preview'];
    $content = $row['Content'];
    $name = str_replace('SECRETCODEFORUPPERCOMMA', '\'', $name);
    $preview = str_replace('SECRETCODEFORUPPERCOMMA', '\'', $preview);
    $content = str_replace('SECRETCODEFORUPPERCOMMA', '\'', $content);
    $content = str_replace('src="', 'src="./images/', $content);            //магия для подключения картинок
    $content = str_replace('images//', '', $content);
    if (!empty($_SESSION['username'])) {
        $uid = $_SESSION['uid'];
        $query = "SELECT 1 FROM `articlesread` WHERE `uid`='$uid' AND `aid`='$id'";
        $resultinner = mysqli_query($conn, $query);
        $read = mysqli_fetch_array($resultinner, 1);
        $ArtRead = false;
        if (!empty($read)) {
            $ArtStyle = $ArtStyle . 'Read';
            $ArtRead = true;
        }
    }
    echo "
    <div id='wrapper'>
        <div id='Article$id' class='mymagicoverbox_fenetre ArticleWindow'>
            <div class='mymagicoverbox_fenetreinterieur ArticleContent' style='height:600px;'>
             $content";
    if (!empty($_SESSION['username'])) {
        $uid = $_SESSION['uid'];
        $params = $id + $uid;
        $row = mysqli_fetch_row(mysqli_query($conn, "SELECT `rating` FROM `ratings` WHERE `uid`='$uid' AND `aid`='$id'"));
        $artR = $row[0];
        $artR1 = '☆';
        $artR2 = '☆';
        $artR3 = '☆';
        $artR4 = '☆';
        $artR5 = '☆';
        if ($artR > 0) $artR1 = '★';
        if ($artR > 1) $artR2 = '★';
        if ($artR > 2) $artR3 = '★';
        if ($artR > 3) $artR4 = '★';
        if ($artR > 4) $artR5 = '★';
        echo "<div id='rateBlock$id' class='rating'>
                <span id='mark5$id' onclick='rateArticle($uid,$id,5)'>$artR5</span>
                <span id='mark4$id' onclick='rateArticle($uid,$id,4)'>$artR4</span>
                <span id='mark3$id' onclick='rateArticle($uid,$id,3)'>$artR3</span>
                <span id='mark2$id' onclick='rateArticle($uid,$id,2)'>$artR2</span>
                <span id='mark1$id' onclick='rateArticle($uid,$id,1)'>$artR1</span>
                </div>";
        if ($ArtRead) {
            echo "<input type='button' id='ArticleRead$id' value='Отметить как не прочитанную' style='margin:10px; display: block' onclick='markArticleAsRead($id, $uid)'>";
        } else {
            echo "<input type='button' id='ArticleRead$id' value='Отметить как прочитанную' style='margin:10px; display: block' onclick='markArticleAsRead($id, $uid)'>";
        }
    }
    echo "
            </div>
        </div>
    </div>

    <div class='col-md-3' >
        <li id='ArticleButton$id' iddiv='Article$id' class='mymagicoverbox' style='color:#000000'>
            <div class='thumbnail' id='$ArtStyle'>
                <div class='artpreview'><div class='artpreviewhead'><h4>$name</h4></div><div class='artpreviewcont'>$preview</div></div>
            </div>
        </li>
    </div>";
}
?>
<script type='text/javascript' src="JS/MarkingArticles.js"></script>