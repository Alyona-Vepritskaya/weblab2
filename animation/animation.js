document.onload = f();

function f() {
    const arr = document.querySelectorAll('.item');
    let a = 147;
    let x = 2100;
    arr.forEach((item) => {
        x -= 300;
        a += 25;
        t(a, item, x);
    });
}

function t(time, el, x) {
    setTimeout(() => {
        animate({
            duration: 2000,
            timing: function (timeFraction) {
                return Math.pow(timeFraction, 3);
            },
            draw: function (progress) {
                el.style.top = progress * time + 'px';
                if (+el.getBoundingClientRect().top > 165) {
                    el.style.zIndex = '1';
                } else {
                    el.style.zIndex = '-1';
                }
                //console.log(el.getBoundingClientRect().top);
            }
        });
    }, x);
}

function animate(options) {
    var start = performance.now();
    requestAnimationFrame(function animate(time) {
        // timeFraction от 0 до 1
        var timeFraction = (time - start) / options.duration;
        if (timeFraction > 1) timeFraction = 1;
        // текущее состояние анимации
        var progress = options.timing(timeFraction);
        options.draw(progress);
        if (timeFraction < 1) {
            requestAnimationFrame(animate);
        }
    });
}


/*
let start = Date.now(); // запомнить время начала

let timer = setInterval(function() {
    // сколько времени прошло с начала анимации?
    let timePassed = Date.now() - start;

    if (timePassed >= 1635) {
        clearInterval(timer); // закончить анимацию через 2 секунды
        return;
    }

    // отрисовать анимацию на момент timePassed, прошедший с начала анимации
    draw(timePassed);

}, 20);
start = Date.now(); // запомнить время начала
let timer2 = setInterval(function() {
    // сколько времени прошло с начала анимации?
    let timePassed = Date.now() - start;

    if (timePassed >= 1400) {
        clearInterval(timer2); // закончить анимацию через 2 секунды
        return;
    }

    // отрисовать анимацию на момент timePassed, прошедший с начала анимации
    draw2(timePassed);

}, 20);
// в то время как timePassed идёт от 0 до 2000
// left изменяет значение от 0px до 400px
function draw(timePassed) {
   document.querySelectorAll('.item').forEach((item)=>{
       item.style.top = timePassed / 5 + 'px'
   });
}
function draw2(timePassed) {
    document.querySelector('.item').style.top = timePassed / 5 + 'px';
}
*/

