window.onload = animateAll;

function animateAll() {
    const begin = 0;
    const duration = 1500;
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

//elem.getBoundingClientRect() возвращает координаты в контексте окна
function animate(begin, end, element, duration, delay) {
    setTimeout(function () {
        let start = new Date().getTime(); // Время старта
        setTimeout(function draw() {
            let now = (new Date().getTime()) - start; // Текущее время
            let progress = now / duration; // Прогресс анимации
            if (progress > 1) {
                progress = 1;
            }
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
    return Math.pow(progress, 0.5);
}