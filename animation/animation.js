window.onload = animateAll;

function animateAll() {
    const items = document.querySelectorAll('.item');
    document.querySelector('.bottom-img').style.marginTop = items.length * 25 + 'px';
    let shift = 147;
    let delay = items.length * 300;
    items.forEach((item) => {
        delay -= 300;
        shift += 25;
        animateItem(shift, item, delay);
    });
}

function animateItem(shift, el, delay) {
    setTimeout(() => {
        animate({
            duration: 2200,
            timing: function (timeFraction) {
                return Math.pow(timeFraction, 0.5);
            },
            draw: function (progress) {
                el.style.top = progress * shift + 'px';
                if (el.getBoundingClientRect().top > 168) {
                    el.style.zIndex = '1';
                }
            }
        });
    }, delay);
}

function animate(options) {
    let start = performance.now();
    requestAnimationFrame(function animate(time) {
        // timeFraction от 0 до 1
        let timeFraction = (time - start) / options.duration;
        if (timeFraction > 1) timeFraction = 1;
        // текущее состояние анимации
        let progress = options.timing(timeFraction);
        options.draw(progress);
        if (timeFraction < 1) {
            requestAnimationFrame(animate);
        }
    });
}