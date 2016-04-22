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

function checkPasswords(){
    var passIndicator = document.getElementById('RegPassCheck');
    if (document.getElementById('password').value == document.getElementById('passwordrep').value) {
        passIndicator.innerHTML = 'Пароли совпадают';
        passIndicator.style.color = '#4cae4c';
        document.getElementById('RegButton').disabled = false;
    } else {
        passIndicator.innerHTML = 'Пароли не совпадают';
        passIndicator.style.color = '#d2322d';
        document.getElementById('RegButton').disabled = true;
    }
    //alert();
}

function checkLogin() {
    var xmlhttp = getXmlHttp();
    xmlhttp.open('POST', 'checkLogin.php', false);
    xmlhttp.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded'); // Отправляем кодировку
    xmlhttp.send("usernameWanted=" + encodeURIComponent(document.getElementById('username').value)); // Отправляем POST-запрос
    if(xmlhttp.status == 200) {
        var logIndicator = document.getElementById('RegLoginCheck');
        if (xmlhttp.responseText) {
            logIndicator.innerHTML = 'Логин свободен';
            logIndicator.style.color = '#4cae4c';
        } else {
            logIndicator.innerHTML = 'Логин занят';
            logIndicator.style.color = '#d2322d';
        }
    }
}



