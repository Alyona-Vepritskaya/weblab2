window.onload = animateAll;

function animateAll() {
    document.querySelector('body').classList.add('over');
    const items = document.querySelectorAll('.item');
    let generalHeight = 0;
    let lastHeight = [];
    items.forEach(function (item) {
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
        animate(shift, items[i], delay);
    }
    setTimeout(() => {
        document.querySelector('.bottom-img').style.marginTop = '0';
        document.querySelectorAll('.item').forEach((item) => {
            item.style.position = 'static';
        });
        document.querySelector('body').classList.remove('over');
    }, 2500);
}

function animate(shift, el, delay) {
    setTimeout(function () {
        let start = Date.now(); // запомнить время начала
        let timer = setInterval(function () {
            // сколько времени прошло с начала анимации?
            let timePassed = Date.now() - start;
            if (timePassed >= 2000) {
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