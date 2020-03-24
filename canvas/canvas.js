window.onload = init_histogram("histogram");

function init_histogram(id_canvas) {
    const xmlhttp = new XMLHttpRequest();
    if (xmlhttp !== undefined) {
        xmlhttp.onreadystatechange = function () {
            if (this.readyState == 4 && this.status == 200) {
                try {
                    const jsonData = JSON.parse(this.responseText);
                    console.log(jsonData);
                    draw(jsonData, id_canvas);
                } catch (e) {
                    console.log(e);
                }
            }
        };
    }
    xmlhttp.open("GET", `getInfo.php?qwerty=${Math.random()}`, true);
    xmlhttp.send();
}

const drawLine = (ctx, x1, y1, x2, y2) => {
    ctx.beginPath();
    ctx.moveTo((x1 + 0.5), (y1 + 0.5));
    ctx.lineTo((x2 + 0.5), (y2 + 0.5));
    ctx.stroke();
    ctx.closePath();
};

const draw = (n, id_canvas) => {
    document.getElementById('numbers').innerHTML = `${n}`;
    const max = Math.ceil(Math.max(...n) / 100) * 100;
    //Create canvas item
    const canvas = document.getElementById(id_canvas);
    const canvas_height = canvas.height;
    const canvas_width = canvas.width;
    const ctx = canvas.getContext('2d');
    ctx.font = "14px inherit";
    const step = max / 8; //average value
    let label = max;
    //space between grid
    const space = canvas_height / 10;
    //draw 9 lines
    for (let i = 0; i < 9; i++) {
        ctx.fillText(Math.round(label).toString(), (5 + 0.5), ((i + 1) * space + 0.5));
        label -= step;
        drawLine(ctx, 30, (i + 1) * space, canvas_width - 20, (i + 1) * space);
    }
    drawLine(ctx, 35, space - 3, 35, canvas_height - space); //vertical line
    ctx.translate(35, 0);
    const X_AXIS = canvas_width - 65;
    const Y_AXIS = canvas_height - space * 2 + 1;
    const bottom_line = canvas_height - space;
    const width = 20; // column width
    const x_shift = (X_AXIS / n.length);
    let last_shift = 0;
    for (let i = 0; i < n.length; i++) {
        let height = -(((n[i] * 100) / max) * Y_AXIS) / 100;
        let randomColor = Math.floor(Math.random() * 16777215).toString(16);
        ctx.fillStyle = `#${randomColor}`;
        ctx.fillRect((last_shift + ((x_shift / 2) - (width / 2)) + 0.5), (bottom_line + 0.5), (width + 0.5), (height + 0.5));
        drawLine(ctx, last_shift, canvas_height - space - 1, last_shift, canvas_height - space + 5); //short lines
        ctx.fillStyle = "#000";
        ctx.fillText((i + 1).toString(), (last_shift + (x_shift / 2) - 3 + 0.5), (bottom_line + 20 + 0.5));
        last_shift += x_shift;
    }
};

const reset = () => {
    const canvas = document.getElementById('histogram');
    const ctx = canvas.getContext('2d');
    ctx.translate(-35, 0);
    ctx.clearRect(0, 0, canvas.width, canvas.height);
};

document.getElementById('generate').addEventListener("click", () => {
    reset();
    const n = [];
    for (let i = 0; i < Math.floor(Math.random() * 10 + 3); i++)
        n.push(Math.floor(Math.random() * 200));
    draw(n, 'histogram');
});