
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

function markArticleAsRead(aid, uid) {
    idstr = 'ArticleRead' + aid;
    var thisButton = document.getElementById(idstr);
    var WhatToDo = (thisButton.value == 'Отметить как прочитанную');
    if (WhatToDo) {
        thisButton.value = 'Отметить как не прочитанную';
    } else {
        thisButton.value = 'Отметить как прочитанную';
    }
    var xmlhttp = getXmlHttp();
    xmlhttp.open('POST', 'MarkingArticle.php', false);
    xmlhttp.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded'); // Отправляем кодировку
    xmlhttp.send("artId=" + encodeURIComponent(aid) + '&uid=' + encodeURIComponent(uid) + '&WhatToDo=' + encodeURIComponent(WhatToDo)); // Отправляем POST-запрос
    var idstr = 'ArticleButton' + aid;
    var ArtBtn = document.getElementById(idstr);
    var prevId = ArtBtn.firstElementChild.id;
    if (WhatToDo) {
        ArtBtn.firstElementChild.id = prevId + 'Read';
    } else {
        ArtBtn.firstElementChild.id = prevId.replace(/Read/,"");
    }
}

function  adjustHeights() {
    var ArticlesCont = document.getElementsByClassName('ArticleContent');
    for (var i = 0; i < ArticlesCont.length; i++) {
        ArticlesCont[i].style.height = String(window.innerHeight - 30) + 'px'
    }
}

$(document).ready(function(){
    adjustHeights();
});