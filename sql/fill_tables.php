<?php
function insert_data($products, $mysqli)
{
    global $products, $mysqli;
    $id_section = 1;
    foreach ($products as $itemsType => $items) {
        // section
        $sql = "insert into " . DBT_SECTIONS . " (name) value ('$itemsType');";
        if ($mysqli->query($sql) !== TRUE) {
            echo "Error: " . $sql . "<br>" . $mysqli->error;
        }
        foreach ($items as $key => $item) {
            //product
            $name = $item['NAME'];
            $s_num = $item['ID'];
            $price = $item['PRICE'];
            $year = $item['PROD_YEAR'];
            $country = $item['PROD_COUNTRY'];
            $img = $item['IMAGE'];
            $sql1 = "insert into " . DBT_PRODUCTS . " (name, s_num, price, year, country, img, id_section)
            values ('$name','$s_num','$price','$year','$country','$img','$id_section');";
            if ($mysqli->query($sql1) !== TRUE) {
                echo "Error: " . $sql1 . "<br>" . $mysqli->error;
            }
            foreach ($item['PARAMS'] as $k => $v) {
                //params
                $nam = $v['name'];
                $val = $v['value'];
                $sql2 = "insert into " . DBT_PARAM . " ( name, value, id_product)
                values ('$nam','$val','$s_num');";
                if ($mysqli->query($sql2) !== TRUE) {
                    echo "Error: " . $sql2 . "<br>" . $mysqli->error;
                }
            }
        }
        $id_section++;
    }
}
