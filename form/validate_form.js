let psw1 = "", psw2 = "", email = "", login = "";
document.querySelector('#psw1').addEventListener('change', () => {
    psw1 = document.querySelector('#psw1').value;
    incorrectValue(psw1, 4, '#psw1');
});
document.querySelector('#psw2').addEventListener('change', () => {
    psw2 = document.querySelector('#psw2').value;
    incorrectValue(psw2, 4, '#psw2');
});
document.getElementById('email').addEventListener('change', () => {
    email = document.getElementById('email').value;
    incorrectValue(email, 0, '#email', !emailIsValid(email));
});
document.getElementById('login').addEventListener('change', () => {
    login = document.querySelector('#login').value;
    incorrectValue(login, 0, '#login');
});
emailIsValid = (email) => {
    return /^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(email);
};
incorrectValue = (value, originValue, formId, emailValue = false) => {
    if ((value.length <= originValue) || emailValue) {
        document.querySelector(formId).classList.add('incorrect-input');
    } else {
        document.querySelector(formId).classList.remove('incorrect-input');
    }
};
submitForm = () => {
    if (document.getElementById('psw1').classList.contains('incorrect-input') ||
        document.getElementById('psw2').classList.contains('incorrect-input') ||
        document.getElementById('login').classList.contains('incorrect-input') ||
        document.getElementById('email').classList.contains('incorrect-input') ||
        psw1.length === 0 || psw2.length === 0 || login.length === 0 || email.length === 0) {
        document.getElementById('pain').innerText = 'ДУРАЧЕК, запони форму правильно!!!';
        return false;
    } else {
        if (psw1 !== psw2) {
            document.getElementById('pain').innerText = 'ДУРАЧЕК, пароли не совпадают!!!';
            return false;
        }
        return true;
    }
};
