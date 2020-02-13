$(document).ready(
    function () {
        $('#all').click(function () {
            $("input[type=checkbox]").prop('checked', true)
        });
        $('#no').click(function () {
            $("input[type=checkbox]").prop('checked', false);
        });
        $('#inv').click(function () {
            $("input[type=checkbox]").each(function () {
                ($(this).prop('checked')) ? $(this).prop('checked', false) : $(this).prop('checked', true);
            });
        });
        $("form").submit(function (event) {
                const login = $('#login').val().trim();
                const psw1 = $('#psw1').val().trim();
                const psw2 = $('#psw2').val().trim();
                const email = $('#email').val();
                if (!(isIncorrect(psw1, 4) && isIncorrect(psw2, 4) &&
                    isIncorrect(login, 3) && emailIsValid(email))) {
                    incorrectValue(login, 3, '#login');
                    incorrectValue(psw1, 4, '#psw1');
                    incorrectValue(psw2, 4, '#psw2');
                    incorrectValue(email, 4, '#email', !emailIsValid(email));
                    $('#psw2').val('');
                    $('#psw1').val('');
                    event.preventDefault();
                } else {
                    if (psw1 != psw2) {
                        $('#psw2').next().text('Passwords don\'t match !!!');
                        $('#psw2').addClass('incorrect-input');
                        $('#psw1').addClass('incorrect-input');
                        $('#psw2').val('');
                        $('#psw1').val('');
                        event.preventDefault();
                    }
                }
            }
        );
        $('#login').focusout(function () {
            const login = $('#login').val().trim();
            incorrectValue(login, 3, '#login');
        });
        $('#psw1').focusout(function () {
            const psw1 = $('#psw1').val().trim();
            incorrectValue(psw1, 4, '#psw1');
        });
        $('#psw2').focusout(function () {
            const psw2 = $('#psw2').val().trim();
            incorrectValue(psw2, 4, '#psw2');
        });
        $('#email').focusout(function () {
            const email = $('#email').val().trim();
            incorrectValue(email, 4, '#email', !emailIsValid(email));
        });
    });

function incorrectValue(value, originValue, formId, emailValue = false) {
    if ((value.length <= originValue) || emailValue) {
        $(formId).addClass('incorrect-input');
        switch (formId) {
            case '#login':
                $(formId).next().text('Login must have at least 4 character');
                break;
            case '#email':
                $(formId).next().text('Incorrect email format');
                break;
            case '#psw2':
            case 'psw1':
                $(formId).next().text('Password must have at least 5 character');
                break;
            default:
                break;
        }
    } else {
        $(formId).removeClass('incorrect-input');
        $(formId).next().text('');
    }
}

function emailIsValid(email) {
    return /^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(email);
}

function isIncorrect(value, originValue) {
    return value.length > originValue;
}