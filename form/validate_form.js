let psw1 = "", psw2 = "", email = "", login = "";
document.querySelector('#psw1').addEventListener('change', function () {
    psw1 = document.querySelector('#psw1').value;
    incorrectValue(psw1, 4, '#psw1');
});
document.querySelector('#psw2').addEventListener('change', function () {
    psw2 = document.querySelector('#psw2').value;
    incorrectValue(psw2, 4, '#psw2');
});
document.getElementById('email').addEventListener('change', function () {
    email = document.getElementById('email').value;
    incorrectValue(email, 0, '#email', !emailIsValid(email));
});
document.getElementById('login').addEventListener('change', function () {
    login = document.querySelector('#login').value;
    incorrectValue(login, 0, '#login');
});

function emailIsValid(email) {
    return /^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(email);
}

function incorrectValue(value, originValue, formId, emailValue = false) {
    ((value.length <= originValue) || emailValue) ?
        document.querySelector(formId).classList.add('incorrect-input') :
        document.querySelector(formId).classList.remove('incorrect-input');
}

function isIncorrect(value, originValue) {
    return value.length > originValue;
}

function submitForm() {
    psw1 = document.querySelector('#psw1').value;
    psw2 = document.querySelector('#psw2').value;
    email = document.getElementById('email').value;
    login = document.querySelector('#login').value;
    if (!(isIncorrect(psw1, 0) && isIncorrect(psw2, 0) &&
        isIncorrect(login, 0) && emailIsValid(email))) {
        document.getElementById('pain').innerText = 'Запони форму правильно!!!';
        return false;
    } else {
        if (psw1 !== psw2) {
            document.getElementById('pain').innerText = 'Пароли не совпадают!!!';
            return false;
        }
        return true;
    }
}
