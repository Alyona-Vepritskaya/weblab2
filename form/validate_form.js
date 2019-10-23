let psw1 = "", psw2 = "", email = "", login = "";
document.querySelector('#psw1').addEventListener('change', () => {
    psw1 = document.querySelector('#psw1').value;
    incorrectValue(psw1, 5, '#psw1', "Пароль должен содержать больше 4 символов");
});
document.querySelector('#psw2').addEventListener('change', () => {
    psw2 = document.querySelector('#psw2').value;
    incorrectValue(psw2, 5, '#psw2', "Пароль должен содержать больше 4 символов");
});
document.querySelector('.submit')
    .addEventListener('click', () => {
        if (psw1.length === 0 || email.length === 0 || login.length === 0) {
            alert("Будьте внимательнее, заполните ВСЕ поля!!!");
        } else {
            (psw1 === psw2) ? alert("Ура, Вы зарегистрированы!!!") : alert("Будьте внимательнее, пароли не совпадают!!!");
        }
    });
document.getElementById('email').addEventListener('change', () => {
    email = document.getElementById('email').value;
    incorrectValue(email, emailIsValid(email), '#email');
});
document.getElementById('login').addEventListener('change', () => {
    login = document.querySelector('#login').value;
    if (login.length === 0) {
        document.querySelector('#login').classList.add('incorrect-input');
    } else {
        document.querySelector('#login').classList.remove('incorrect-input');
    }
});
emailIsValid = (email) => {
    return /^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(email);
};
incorrectValue = (value, originValue, formId, innerText = '') => {
    if ((value.length < originValue) || !originValue) {
        document.querySelector(formId).classList.add('incorrect-input');
        document.querySelector('.help').textContent = innerText;
    } else {
        document.querySelector(formId).classList.remove('incorrect-input');
        document.querySelector('.help').textContent = '';
    }
};