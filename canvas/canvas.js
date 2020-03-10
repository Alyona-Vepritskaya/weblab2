const X_AXIS = 445; // px
const Y_AXIS = 225; // px

const drawLine = (ctx, x1, y1, x2, y2) => {
    ctx.beginPath();
    ctx.moveTo(x1, y1);
    ctx.lineTo(x2, y2);
    ctx.stroke();
    ctx.closePath();
};

const draw = (n) => {
    const max = Math.max(...n);
    const canvas = document.getElementById('histogram');
    const ctx = canvas.getContext('2d');
    ctx.font = "14.5px inherit";
    const step = max / 8;
    let x = max;
    for (let i = 0; i < 9; i++) {
        ctx.fillText(Math.round(x).toString(), 5, (i + 1) * 28);
        x -= step;
        drawLine(ctx, 30, (i + 1) * 28, 480, (i + 1) * 28);
    }
    drawLine(ctx, 35, 27, 35, 257);
    ctx.translate(35, 0);
    const bottom_line = 252;
    const width = 20;
    let x_shift = (X_AXIS / n.length);
    let last_shift = 0;
    for (let i = 0; i < n.length; i++) {
        let height = (((n[i] * 100) / max) * Y_AXIS) / 100;
        ctx.fillStyle = "#10106c";
        ctx.fillRect(last_shift + ((x_shift / 2) - (width / 2)), bottom_line, width, -height);
        drawLine(ctx, last_shift, 251, last_shift, 257);
        ctx.fillStyle = "#000";
        ctx.fillText((i + 1).toString(), last_shift + (x_shift / 2) - 3, bottom_line + 20);
        last_shift += x_shift;
    }
};

const n = [10, 6, 3, 50, 35, 44, 30, 18, 80, 100];
let el = document.getElementById('numbers');
el.innerHTML = `${n}`;
draw(n);

const reset = () => {
    const canvas = document.getElementById('histogram');
    const ctx = canvas.getContext('2d');
    ctx.translate(-35, 0);
    ctx.clearRect(0, 0, canvas.width, canvas.height);
};

document.getElementById('generate').addEventListener("click", () => {
    reset();
    const n = [];
    for (let i = 0; i < Math.floor(Math.random() * 10 + 3); i++) {
        n.push(Math.floor(Math.random() * 500));
    }
    draw(n);
    let el = document.getElementById('numbers');
    el.innerHTML = `${n}`;
});



