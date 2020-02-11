$(document).ready(
    function () {
        $('#all').click(function () {
            $("input[type=checkbox]").prop('checked', true);

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
                    isIncorrect(login, 0) && emailIsValid(email))) {
                    incorrectValue(login, 0, '#login');
                    incorrectValue(psw1, 4, '#psw1');
                    incorrectValue(psw2, 4, '#psw2');
                    incorrectValue(email, 4, '#email');
                    event.preventDefault();
                } else {
                    if (psw1 !== psw2) {
                        $('#psw2').next().text('Passwords don\'t match !!!');
                        $('#psw2').addClass('incorrect-input');
                        $('#psw1').addClass('incorrect-input');
                        event.preventDefault();
                    }
                }
            }
        );
        $('#login').change(function () {
            const login = $('#login').val().trim();
            incorrectValue(login, 4, '#login');
        });
        $('#psw1').change(function () {
            const login = $('#psw1').val().trim();
            incorrectValue(login, 4, '#psw1');
        });
        $('#psw2').change(function () {
            const login = $('#psw2').val().trim();
            incorrectValue(login, 4, '#psw2');
        });
        $('#email').change(function () {
            const login = $('#email').val().trim();
            incorrectValue(login, 4, '#email');
        });

    });

function incorrectValue(value, originValue, formId, emailValue = false) {
    if ((value.length <= originValue) || emailValue) {
        $(formId).addClass('incorrect-input');
        switch (formId) {
            case '#login':
                $(formId).next().text('Login must have at least 3 character');
                break;
            case '#email':
                $(formId).next().text('Incorrect email format');
                break;
            case '#psw2':
            case 'psw1':
                $(formId).next().text('Password must have at least 3 character');
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