$(function () {
    $('#all').click(() => {
        $("input[type=checkbox]").prop('checked', true);

    });
    $('#no').click(() => {
        $("input[type=checkbox]").prop('checked', false);
    });
    $('#invert').click(() => {
        $("input[type=checkbox]").each(() => {
            ($(this).prop('checked')) ? $(this).prop('checked', false) : $(this).prop('checked', true);
        });
    });
    $("form").submit(function (event) {
            const login = $('#login').val().trim();
            const psw1 = $('#psw1').val().trim();
            const psw2 = $('#psw2').val().trim();
            const email = $('#email').val();
            if (!(isIncorrect(psw1, 4) && isIncorrect(psw2, 4) &&
                isIncorrect(login, 0) && emailIsValid(email))) {
                incorrectValue(login,0,'#login');
                incorrectValue(psw1,4,'#psw1');
                incorrectValue(psw2,4,'#psw2');
                incorrectValue(email,4,'#email');
                event.preventDefault();
            } else {
                if (psw1 !== psw2) {
                    event.preventDefault();
                }
            }
        }
    );
    function incorrectValue(value, originValue, formId, emailValue = false) {
        ((value.length <= originValue) || emailValue) ?
            $(formId).addClass('incorrect-input') :
            $(formId).removeClass('incorrect-input');
    }
    function emailIsValid(email) {
        return /^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(email);
    }
    function isIncorrect(value, originValue) {
        return value.length > originValue;
    }
});


/*let psw1 = "", psw2 = "", email = "", login = "";
document.querySelector('#psw1').addEventListener('change', function () {
    psw1 = document.querySelector('#psw1').value.trim();
    incorrectValue(psw1, 4, '#psw1');
});
document.querySelector('#psw2').addEventListener('change', function () {
    psw2 = document.querySelector('#psw2').value.trim();
    incorrectValue(psw2, 4, '#psw2');
});
document.getElementById('email').addEventListener('change', function () {
    email = document.getElementById('email').value.trim();
    incorrectValue(email, 0, '#email', !emailIsValid(email));
});
document.getElementById('login').addEventListener('change', function () {
    login = document.querySelector('#login').value.trim();
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
    if (!(isIncorrect(psw1, 4) && isIncorrect(psw2, 4) &&
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
}*/
