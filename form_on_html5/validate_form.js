let psw1 = "", psw2 = "";

function submitForm() {
    psw1 = document.querySelector('#psw1').value;
    psw2 = document.querySelector('#psw2').value;
    if (psw1 !== psw2) {
        document.getElementById('pain').innerText = 'Пароли не совпадают!!!';
        return false;
    }
    return true;
}
