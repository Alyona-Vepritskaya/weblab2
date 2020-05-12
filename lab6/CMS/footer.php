<!--<footer>
        <div class="des">
            Designed for labworks
        </div>
        <div>
            <span class="cp"><a href="" class="footer_link">:: Copyright 2002 - All Rights Received © Lithuanian-American Basketball Association::</a></span>
        </div>
        <script type="text/javascript" language="javascript">
        function createJson() {
            let objects = [
                {"name":"Ball","model":"Basketball","type":"sport","serial_number":"S2304","prod_year":"2019","prod_country":"USA"},
                {"name":"Ball","model":"Basketball","type":"sport","serial_number":"S2305","prod_year":"2019","prod_country":"USA"},
                {"name":"Ball","model":"Basketball","type":"sport","serial_number":"S2335","prod_year":"2019","prod_country":"USA"},
                {"name":"Ball","model":"Basketball","type":"sport","serial_number":"S2405","prod_year":"2019","prod_country":"USA"},
                {"name":"Ball","model":"Basketball","type":"sport","serial_number":"S4305","prod_year":"2019","prod_country":"USA"},
                {"name":"Ball","model":"Basketball","type":"sport","serial_number":"S2335","prod_year":"2019","prod_country":"China"},
                {"name":"Ball","model":"Basketball","type":"sport","serial_number":"S2345","prod_year":"2019","prod_country":"China"},
                {"name":"Ball","model":"Basketball","type":"sport","serial_number":"S2405","prod_year":"2019","prod_country":"China"},
                {"name":"Ball","model":"Basketball","type":"sport","serial_number":"S2444","prod_year":"2019","prod_country":"China"},
                {"name":"Ball","model":"Basketball","type":"sport","serial_number":"S2375","prod_year":"2019","prod_country":"China"}
            ];
            return objects;
        }

        function moreInfoAjax(el) {
            let index = 1;
            let els = document.getElementsByClassName("more-info-button")
            let divs = document.getElementsByClassName("more-info-div");
            let Elem;
            for (let i = 0; i < els.length; i++) {
            if (els[i] == el) {
              index = i;
              break;
            }
            }
            let xhr = new XMLHttpRequest();
            xhr.onreadystatechange = function() {
                if(this.readyState == 4 && this.status == 200) {
                    divs[index].style = "visibility:visible;"
                    divs[index].innerHTML = this.responseText;
                }
            };
            let objs = createJson();
            let obj = objs[index];
            obj = JSON.stringify(obj);
            xhr.open("GET","/more_info.php?&&obj="+obj,true);
            xhr.send(null);
        }
        </script>
</footer>
-->

</div>
</body>
</html>