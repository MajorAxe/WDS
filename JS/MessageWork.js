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
    messidStr = 'Message' + messid;
    var xmlhttp = getXmlHttp();
    xmlhttp.open('POST', 'markMessage.php', false);
    xmlhttp.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded'); // Отправляем кодировку
    xmlhttp.send("messid=" + encodeURIComponent(messid)); // Отправляем POST-запрос
    var thisMessage = document.getElementById(messidStr);
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
    if (messageText != '') {
        var xmlhttp = getXmlHttp();
        xmlhttp.open('POST', 'sendMessage.php', false);
        xmlhttp.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded'); // Отправляем кодировку
        xmlhttp.send("receiver=" + encodeURIComponent(receiver) + "&messageText=" + encodeURIComponent(messageText) + "&sender=" + encodeURIComponent(sender)); // Отправляем POST-запрос
    }
}

function deleteMessage(messId) {
    var messIdStr = 'Message' + messId;
    var message = document.getElementById(messIdStr);
    message.parentNode.removeChild(message);
    var xmlhttp = getXmlHttp();
    xmlhttp.open('POST', 'DeleteMessage.php', false);
    xmlhttp.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded'); // Отправляем кодировку
    xmlhttp.send("messId=" + encodeURIComponent(messId)); // Отправляем POST-запрос
}