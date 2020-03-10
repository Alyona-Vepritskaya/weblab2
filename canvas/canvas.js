const X_AXIS = 445; // px
const Y_AXIS = 225; // px
const n = [10, 6, 3, 50, 35, 44, 30, 18, -90, 100];
/*const values = n.split(',');*/
const max = Math.max(...n);
console.log(max);

const canvas = document.getElementById('histogram');
const ctx = canvas.getContext('2d');
const step = max / 8;
let x = max;
for (let i = 0; i < 9; i++) {
    ctx.font = "13.5px inherit";
    ctx.fillText(Math.round(x).toString(), 5, (i + 1) * 28);
    x -= step;
    ctx.beginPath();
    ctx.moveTo(30, (i + 1) * 28);
    ctx.lineTo(480, (i + 1) * 28);
    ctx.stroke();
    ctx.closePath();
}
ctx.beginPath();
ctx.moveTo(35, 27);
ctx.lineTo(35, 257);
ctx.stroke();
ctx.closePath();

ctx.translate(35, 0);
const bottom_line = 252;
const width = 20;
let x_shift = (X_AXIS / n.length);
let last_shift = 0;
ctx.fillStyle = '#0AE0AE';
for (let i = 0; i < n.length; i++) {
    let height = (((n[i] * 100) / max) * Y_AXIS) / 100;
    ctx.fillRect(last_shift + ((x_shift / 2) - (width / 2)), bottom_line, width, -height);
    last_shift += x_shift;
    ctx.beginPath();
    ctx.moveTo(last_shift, 251);
    ctx.lineTo(last_shift, 257);
    ctx.stroke();
    ctx.closePath();
}

const drawLine = (x1,y1,x2,y2) => {
    ctx.beginPath();
    ctx.moveTo(x1, y1);
    ctx.lineTo(x2, y2);
    ctx.stroke();
    ctx.closePath();
};