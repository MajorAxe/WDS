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

function markMessage(messid) {
    var xmlhttp = getXmlHttp();
    xmlhttp.open('POST', 'markMessage.php', false);
    xmlhttp.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded'); // Отправляем кодировку
    xmlhttp.send("messid=" + encodeURIComponent(messid)); // Отправляем POST-запрос
    var thisMessage = document.getElementById(messid);
    thisMessage.firstElementChild.id = 'PremoderatedArticleRead';
    thisMessage.removeAttribute('onclick');
}

function sendMessageWrapper(sender) {
    var receiver = document.getElementById('ReceiverName').value;
    var messageText = document.getElementById('messText').value;
    document.getElementById('messText').value = '';
    sendMessage(sender, receiver, messageText);
}


function sendMessage(sender, receiver, messageText) {
    var xmlhttp = getXmlHttp();
    xmlhttp.open('POST', 'sendMessage.php', false);
    xmlhttp.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded'); // Отправляем кодировку
    xmlhttp.send("receiver=" + encodeURIComponent(receiver) + "&messageText=" + encodeURIComponent(messageText)+ "&sender=" + encodeURIComponent(sender)); // Отправляем POST-запрос
}