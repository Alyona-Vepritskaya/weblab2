window.onload = animateAll;

function animateAll() {
    const items = document.querySelectorAll('.item');
    document.querySelector('.bottom-img').style.marginTop = items.length * 25 + 'px';
    let shift = 147;
    let delay = items.length * 300;
    items.forEach((item) => {
        delay -= 300;
        shift += 25;
        animate(shift, item, delay);
    });
}

function animate(shift, el, delay) {
    setTimeout(() => {
        let start = Date.now(); // запомнить время начала
        let timer = setInterval(function () {
            // сколько времени прошло с начала анимации?
            let timePassed = Date.now() - start;
            if (timePassed >= 3000) {
                clearInterval(timer); // закончить анимацию через 3 секунды
                return;
            }
            // отрисовать анимацию на момент timePassed, прошедший с начала анимации
            draw(timePassed, el, shift);
        })
    }, delay);
}

function draw(timePassed, el, sh) {
    if (el.getBoundingClientRect().top > 168) {
        el.style.zIndex = '1';
    }
    if (el.getBoundingClientRect().top <= sh) {
        el.style.top = delta(timePassed) * 9 + 'px';
    }
}

function delta(timePassed) {
    return Math.pow(timePassed,0.5)
}