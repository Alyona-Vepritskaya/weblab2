let psw1 = "", psw2 = "", email = "", login = "";
document.querySelector('#psw1').addEventListener('change', () => {
    psw1 = document.querySelector('#psw1').value;
    if (psw1.length < 8) {
        alert('Value must be more than 8 !!!1');
    }
});
document.querySelector('#psw2').addEventListener('change', () => {
    psw2 = document.querySelector('#psw2').value;
    if (psw2.length < 8) {
        alert('Value must be more than 8 !!!2');
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
    if (!emailIsValid(email)) {
        alert('Invalid email');
    }
});
document.getElementById('login').addEventListener('change', () => {
    login = document.querySelector('#login').value;
});
emailIsValid = (email) => {
    return /^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(email)
};