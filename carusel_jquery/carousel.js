/**
 *  Set up jcarousel
 */
$(document).ready(
    function () {
    /**
     * animateend - Triggered after the carousel has finished a animation.
     */
    $('.jcarousel').jcarousel().on('jcarousel:animateend', function (event, carousel) {
        var id = $(carousel._visible['0']).index();
        $('.jp-item').removeClass('active');
        $('.jp-item').eq(id).addClass('active');
    });
});

$(document).ready(function () {
    // set width of item
    $('.jcarousel li').width($('.jcarousel').width());

    // move slider
    $('body').on('click', '.jc-right', function (e) {
        e.preventDefault();
        $('.jcarousel').jcarousel('scroll', '+=1');
    });

    $('body').on('click', '.jc-left', function () {
        event.preventDefault();
        $('.jcarousel').jcarousel('scroll', '-=1');
    });

    $('body').on('click', '.jp-item', function () {
        event.preventDefault();
        var id = $(this).index();
        $('.jcarousel').jcarousel('scroll', id);
    });

});