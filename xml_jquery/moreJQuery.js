function getPar(id, callback) {
    $.ajax({
        dataType: 'json',
        url: jsHost+'getMoreInfo.php',
        data: {item: id},
        success: function (jsondata) {
            let details = '';
            for (let i = 0; i < jsondata.length; i++) {
                details += '<div>' + jsondata[i]['name'] + ': ' + jsondata[i]['value'] + '</div>';
            }
            callback.call(details);
        }
    });
}

$(document).ready(
    function () {
        $('.more').click(function () {
            const id = $(this).parent().attr('s_num');
            const windowW = $(this).parent().children('span');
            getPar(id, function () {
                windowW.append(this);
                windowW.slideDown();
            });

        });
        $('.close').each(function () {
            $(this).click(function () {
                $(this).parent().slideUp();
                $(this).parent().children('div').remove()
            })
        })
    }
);