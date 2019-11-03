window.onload = animateAll;

function makeEaseOut(timing) {
    return function (timeFraction) {
        return 1 - timing(1 - timeFraction);
    }
}

function bounce(timeFraction) {
    for (let a = 0, b = 1; 1; a += b, b /= 2) {
        if (timeFraction >= (7 - 4 * a) / 11) {
            return -Math.pow((11 - 6 * a - 11 * timeFraction) / 4, 2) + Math.pow(b, 2)
        }
    }
}

let bounceEaseOut = makeEaseOut(bounce);

function animateAll() {
    const items = document.querySelectorAll('.item');
    let generalHeight = 0;
    let lastHeight = [];
    items.forEach((item) => {
        generalHeight += item.getBoundingClientRect().height;
        lastHeight.push(item.getBoundingClientRect().height);
    });
    lastHeight.unshift(25);
    document.querySelector('.bottom-img').style.marginTop = generalHeight + 'px';
    let shift = 147;
    let delay = items.length * 300;
    for (let i = 0; i <= items.length - 1; i++) {
        delay -= 300;
        shift += lastHeight[i];
        animateItem(shift, items[i], delay);
    }
}

animateItem = function (shift, item, delay) {
    setTimeout(() => {
        animate({
            duration: 3500,
            timing: bounceEaseOut,
            draw: function (progress) {
                item.style.top = progress * shift + 'px';
                if (item.getBoundingClientRect().top > 168) {
                    item.style.zIndex = '1';
                }
            }
        })
    }, delay);
};

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