$(document).ready(
    function () {
        $('.more').each(function () {
            $(this).click(function () {
                const id = $(this).parent().attr('s_num');
                const windowW = $(this).parent().children('span');
                $.ajax({
                    dataType: 'json',
                    url: 'getMoreInfo.php?item=' + id,
                    success: function (jsondata) {
                        let details = '';
                        for (let i = 0; i < jsondata.length; i++) {
                            details += '<div>' + jsondata[i]['name'] + ': ' + jsondata[i]['value'] + '</div>';
                        }
                        windowW.append(details);
                        windowW.slideDown();
                    }
                });
            })
        });
        $('.close').each(function () {
            $(this).click(function () {
                $(this).parent().slideUp();
                $(this).parent().children('div').remove()
            })
        })
    }
);