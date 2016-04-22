<?php session_start(); ?>
<!DOCTYPE html>
<html lang="en-US">
<head>
    <title>Редактор кода</title>
    <meta name="viewport" content="width=device-width">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta charset="utf-8">
    <link rel="stylesheet" href="trystyle.css">
    <!--[if lt IE 8]>
    <style>
        .textareacontainer, .iframecontainer {width:48%;}
        .textarea, .iframe {height:800px;}
        #textareaCode, #iframeResult {height:700px;}
        .menu img {display:none;}
    </style>
    <![endif]-->
    <script type="text/javascript">
        function getXmlHttp() {
            var xmlhttp;
            try {
                xmlhttp = new ActiveXObject("Msxml2.XMLHTTP");
            } catch (e) {
                try {
                    xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
                } catch (E) {
                    xmlhttp = false;
                }
            }
            if (!xmlhttp && typeof XMLHttpRequest!='undefined') {
                xmlhttp = new XMLHttpRequest();
            }
            return xmlhttp;
        }

        function submitTryit()
        {
            var t = document.getElementById("textareaCode").value;
            var id = document.getElementById("userId").innerHTML;
            var fName = document.getElementById("fileName").innerHTML;
            document.getElementById("iframeResult").value = t;
            var xmlhttp = getXmlHttp();
            xmlhttp.open('POST', 'TryItFileWork.php', false);
            xmlhttp.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded'); // Отправляем кодировку
            xmlhttp.send("innerText=" + encodeURIComponent(t) + "&uid=" + encodeURIComponent(id) + "&fName=" + encodeURIComponent(fName)); // Отправляем POST-запрос
            location.reload();
            /*t=t.replace(/=/gi,"w3equalsign");
            var pos=t.search(/script/i)
            while (pos>0)
            {
                t=t.substring(0,pos) + "w3" + t.substr(pos,3) + "w3" + t.substr(pos+3,3) + "tag" + t.substr(pos+6);
                pos=t.search(/script/i);
            }
            if ( navigator.userAgent.match(/Safari/i) ) {
                t=escape(t);
                document.getElementById("bt").value="1";
            }
            document.getElementById("code").value=t;
            document.getElementById("tryitform").action="tryit_view.asp?x=" + Math.random();
            validateForm();
            document.getElementById("iframeResult").contentWindow.name = "view";
            document.getElementById("tryitform").submit();*/
        }
    </script>
</head>
<body>
<div id="userId" style="display: none"><?php
    if (!isset($_SESSION['uid'])) {
        $_SESSION['uid'] = 'Guest';
    }
    echo $_SESSION['uid'];
    ?></div>
<div id="fileName" style="display: none"><?php
    if (!isset($_GET['filename'])) {
        $_GET['filename'] = 'Empty';
    }
    echo $_GET['filename'];
    ?></div>
<div class="container">
    <div class="textareacontainer">
        <form class="textarea">
            <div style="overflow:auto;">
                <div class="headerText">Редактируйте это код:</div>
                <button class="seeResult" type="button" onclick="submitTryit()">Увидеть результат &raquo;</button>
            </div>
            <div class="textareawrapper">
        <textarea autocomplete="off" class="code_input" id="textareaCode" wrap="logical" spellcheck="false"><?php
            if (isset($_GET['filename'])) {
                $fName =  "./TryIt/UserTries/" . $_GET['filename'] . $_SESSION['uid'] . ".html";
                if (!file_exists($fName)) {
                    $fName = './TryIt/' . $_GET['filename'] . '.html';
                }
                $handle = fopen($fName, "r");
                if ($handle) {
                    while (($buffer = fgets($handle)) !== false) {
                        echo $buffer;
                    }
                    fclose($handle);
                }
            } else {
                echo 'Нет такого примера';
            }
            ?>
</textarea>
            </div>
        </form>
    </div>
    <div class="iframecontainer">
        <div class="iframe">
            <div style="overflow:auto;">
                <div class="headerText">Результат:</div>
            </div>
            <div class="iframewrapper">
                <iframe id="iframeResult" class="result_output" frameborder="0" name="view" src=<?php
                if (isset($_GET['filename']) && isset($_SESSION['uid'])) {
                    $fName =  "./TryIt/UserTries/" . $_GET['filename'] . $_SESSION['uid'] . ".html";
                    if (!file_exists($fName)) {
                        $fName = './TryIt/' . $_GET['filename'] . '.html';
                    }
                    echo $fName;
                } else {
                    echo 'Empty';
                }
                ?>></iframe>
            </div>
        </div>
    </div>
</div>
<?php
if (isset($_SESSION['uid']) && $_SESSION['uid'] == 'Guest') {
    unset($_SESSION['uid']);
}
unset($_GET['filename']);
?>
</body>
</html>