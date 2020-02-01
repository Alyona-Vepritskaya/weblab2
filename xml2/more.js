document.querySelectorAll('.more').forEach(item => {
    item.addEventListener('click', (event) => {
        if (event.target.value == 'More') {
            let el = document.createElement('span');
            const xmlhttp = new XMLHttpRequest();
            xmlhttp.onreadystatechange = function () {
                if (this.readyState === 4 && this.status === 200) {
                    const obj = JSON.parse(this.responseText);
                    el.innerHTML = obj.map(item => {
                        return '<div>' + item['name'] + ': ' + item['value'] + '</div>';
                    });
                    el.innerHTML = el.innerHTML.replace(/\,/g, '');
                    event.target.parentNode.insertBefore(el, item);
                }
            };
            xmlhttp.open("GET", "getMoreInfo.php?item=" + event.target.parentNode.attributes.getNamedItem('s_num').value, true);
            xmlhttp.send();
            event.target.value = 'Buy';
        }
    })
});
