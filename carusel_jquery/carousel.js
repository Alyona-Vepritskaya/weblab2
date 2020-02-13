$(document).ready(
    function () {

        const jCarousel = '.jcarousel';
        const jItem = '.jp-item';

        // set width of item
        const wrapperWidth = $(jCarousel).width();
        $('.jcarousel li').width(wrapperWidth);

        // move slider ->
        $('.jc-right').click(function () {
            //+=offset
            // Scrolls the carousel forward by the given offset relatively from the current position.
            $(jCarousel).jcarousel('scroll', '+=1');
        });

        // move slider <-
        $('.jc-left').click(function () {
            $(jCarousel).jcarousel('scroll', '-=1');
        });

        $('.jp-item').click(function () {
            let id = $(this).index();
            $(jCarousel).jcarousel('scroll', id);
        });

        $(jCarousel).jcarousel().on('jcarousel:animateend', function (event, carousel) {
            // "this" refers to the root element
            // "carousel" is the jCarousel instance
            // visible() - Returns all visible items as jQuery object
            let id_visible = $(carousel.visible()).index();
            $(jItem).removeClass('active');
            $(jItem).eq(id_visible).addClass('active');
        });
    }
);

