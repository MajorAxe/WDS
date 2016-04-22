function fillArticleSelect () {
    var TopicList = document.getElementById('topicEdit');
    var SelectedTopic = TopicList[TopicList.selectedIndex].value + 'ArtList';
    var ArticleList = document.getElementById(SelectedTopic).innerHTML;
    document.getElementById('editArtSelect').innerHTML = ArticleList;
    fillArticle();
}

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

function fillArticle() {
    var ArticlesList = document.getElementById('editArtSelect');
    var SelectedArticle = ArticlesList[ArticlesList.selectedIndex];
    if (SelectedArticle.value == 'NewArticle') {
        document.getElementById('ArtNameEditBtn').style.display = 'none';
        var artNameEdit = document.getElementById('artnameEdit');
        artNameEdit.value = 'Введите заголовок';
        artNameEdit.style.display = 'inline-block';
        document.getElementById('addarticle').style.display = 'inline-block';
        document.getElementById('editArticle').style.display = 'none';
        document.getElementById('deleteArticle').style.display = 'none';
        document.getElementById('artpreview').value = '';
        document.getElementById('artcontent').value = '';
        var ArtStatus = document.getElementById('artStatusForUser');
        if (ArtStatus != null) {
            ArtStatus.innerHTML = '';
        }
    } else {
        document.getElementById('ArtNameEditBtn').style.display = 'inline-block';
        document.getElementById('artnameEdit').style.display = 'none';
        document.getElementById('artnameEdit').value = SelectedArticle.innerHTML;
        document.getElementById('addarticle').style.display = 'none';
        document.getElementById('editArticle').style.display = 'inline-block';
        document.getElementById('deleteArticle').style.display = 'inline-block';
        var xmlhttp = getXmlHttp();
        xmlhttp.open('POST', 'fillArticle.php', false);
        xmlhttp.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded'); // Отправляем кодировку
        xmlhttp.send("artId=" + encodeURIComponent(SelectedArticle.value)); // Отправляем POST-запрос
        if(xmlhttp.status == 200) {
            var response = xmlhttp.responseText;
            var pos = response.indexOf('PreviewContentSeparator');
            var published = response.slice(0,1);
            var preview = response.slice(2,pos - 1);
            var content = response.slice(pos + 24);
            document.getElementById('artpreview').value = preview;
            document.getElementById('artcontent').value = content;
            var ArtStatus = document.getElementById('artStatus');  //статус статьи для админа
            if (ArtStatus != null) {
                ArtStatus.value = published;
            }
            ArtStatus = document.getElementById('artStatusForUser');  //статус статьи для пользователя
            if (ArtStatus != null) {
                switch(published) {
                    case '0':
                        ArtStatus.innerHTML = 'Отклонена';
                        ArtStatus.style.color = '#d2322d';
                        break;
                    case '1':
                        ArtStatus.innerHTML = 'Опубликована';
                        ArtStatus.style.color = '#4cae4c';
                        break;
                    case '2':
                        ArtStatus.innerHTML = 'На рассмотрении';
                        ArtStatus.style.color = '#636366';
                        break;
                }
            }
        }
    }
}

function checkPreviewLength() {
    var LENGTHCAP = 160;
    var preview = document.getElementById('artpreview');
    document.getElementById('symbCounter').innerHTML = preview.value.length.toString() + ' символов';
    if (preview.value.length>LENGTHCAP) {
        preview.value = preview.value.substr(0,LENGTHCAP);
        alert('Длина превью не должна превышать ' + LENGTHCAP + ' символов');
    }
}

function EditArtName() {
    document.getElementById('artnameEdit').style.display = 'inline-block';
    document.getElementById('ArtNameEditBtn').style.display = 'none';
}

$(document).ready(function(){
    fillArticleSelect ();
    fillArticle();
});