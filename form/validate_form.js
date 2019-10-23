let psw1 = "", psw2 = "", email = "", login = "";
document.querySelector('#psw1').addEventListener('change', () => {
    psw1 = document.querySelector('#psw1').value;
    if (psw1.length < 8) {
        document.querySelector('#psw1').classList.add('incorrect-input');
        document.querySelector('.help').textContent = 'Пароль должен содержать больше 8 символов';
    } else {
        document.querySelector('#psw1').classList.remove('incorrect-input');
        document.querySelector('.help').textContent = '';
    }
});
document.querySelector('#psw2').addEventListener('change', () => {
    psw2 = document.querySelector('#psw2').value;
    if (psw2.length < 8) {
        document.querySelector('#psw2').classList.add('incorrect-input');
        document.querySelector('.help').textContent = 'Пароль должен содержать больше 8 символов';
    } else {
        document.querySelector('#psw2').classList.remove('incorrect-input');
        document.querySelector('.help').textContent = '';
    }
});
document.querySelector('.submit')
    .addEventListener('click', () => {
        if (psw1.length === 0 || email.length === 0 || login.length === 0) {
            alert("Будьте внимательнее, заполните ВСЕ поля!!!");
        } else {
            if (psw1 === psw2) {
                alert("Ура, Вы зарегистрированы!!!")
            } else {
                alert("Будьте внимательнее, пароли не совпадают!!!");
            }
        }
    });
document.getElementById('email').addEventListener('change', () => {
    email = document.getElementById('email').value;
    if (!emailIsValid(email) || email.length === 0) {
        document.querySelector('#email').classList.add('incorrect-input');
    } else {
        document.querySelector('#email').classList.remove('incorrect-input');
    }

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