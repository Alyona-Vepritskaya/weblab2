window.onload = animateAll;

function animateAll() {
    const begin = 0;
    const duration = 3500;
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
    for (let i = 0; i < items.length; i++) {
        delay -= 300;
        shift += lastHeight[i];
        animate(begin, shift, items[i], duration, delay);
    }
}

function animate(begin, end, element, duration, delay) {
    setTimeout(function () {
        let start = new Date().getTime(); // Время старта
        setTimeout(function draw() {
            let now = (new Date().getTime()) - start; // Текущее время
            let progress = now / duration; // Прогресс анимации
            let result = (end - begin) * delta(progress) + begin; //На сколько необходимо сдвинуть в данный момент
            if (element.getBoundingClientRect().top > 168)
                element.style.zIndex = '1';
            element.style.top = result + "px";
            if (progress < 1) // Если анимация не закончилась, продолжаем
                setTimeout(draw);
        });
    }, delay)
}

function delta(progress) {
    function d(progress) {
        for (let a = 0, b = 1; 1; a += b, b /= 2) {
            if (progress >= (7 - 4 * a) / 11)
                return -Math.pow((11 - 6 * a - 11 * progress) / 4, 2) + Math.pow(b, 2);
        }
    }

    return 1 - d(1 - progress);
}