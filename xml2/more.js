document.querySelectorAll('.more').forEach(function (item) {
    item.addEventListener('click', function (event) {
        let el = document.createElement('span');
        const xmlhttp = new XMLHttpRequest();
        if (xmlhttp !== undefined) {
            xmlhttp.onreadystatechange = function () {
                if (this.readyState == 4 && this.status == 200) {
                    try {
                        const jsonData = JSON.parse(this.responseText);
                        for (let i = 0; i < jsonData.length; i++) {
                            el.innerHTML += '<div>' + jsonData[i]['name'] + ': ' + jsonData[i]['value'] + '</div>';
                        }
                        el.innerHTML += '<input type="button" value="X" class="close" onclick="closePlease(this)">';
                        event.target.parentNode.appendChild(el);
                    } catch (e) {
                        console.log(e);
                    }
                }
            };
        }
        xmlhttp.open("GET", `getMoreInfo.php?qwerty=${Math.random()}&item=` + event.target.parentNode.attributes.getNamedItem('s_num').value, true);
        xmlhttp.send();
        item.disabled = true;
    })
});

function closePlease(element) {
    element.parentElement.parentElement.childNodes.forEach(it => {
        if (it.classList != undefined && it.classList.contains('buy-item')) {
            it.disabled = false;
        }
    });
    element.parentNode.style.display = 'none';
}
