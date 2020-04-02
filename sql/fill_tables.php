<?php
include_once "MyDB.php";
include_once "xml_parse.php";
function insert_data($products, $mysqli)
{
    global $products, $mysqli;
    $id_section = 1;
    $id_prod = 1;
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
            $price = number_format($item['PRICE'],2);
            $year = $item['PROD_YEAR'];
            $country = $item['PROD_COUNTRY'];
            $img = $item['IMAGE'];
            $sql1 = "insert into " . DBT_PRODUCTS . " (name, s_num, price, year, country, img, id_section)
            values ('$name','$s_num','$price','$year','$country','$img','$id_section');";
            if ($mysqli->query($sql1) !== TRUE) {
                echo "Error: " . $sql1 . "<br>" . $mysqli->error;
            }
            //img
            $sql6 = "insert into " . DBT_IMG . " (name, sort, id_product)
            values ('$img','1','$id_prod');";
            if ($mysqli->query($sql6) !== TRUE) {
                echo "Error: " . $sql6 . "<br>" . $mysqli->error;
            }
            $sort = 1;
            foreach ($item['PARAMS'] as $k => $v) {
                //param
                $nam = $v['name'];
                $val = $v['value'];
                $sql2 = "insert into " . DBT_PARAM . " ( name, value, sort, id_product)
                values ('$nam','$val','$sort','$id_prod');";
                if ($mysqli->query($sql2) !== TRUE) {
                    echo "Error: " . $sql2 . "<br>" . $mysqli->error;
                }
                $sort++;
            }
            $id_prod++;
        }
        $id_section++;
    }
}

$mysqli = MyDB::get_db_instance();
parseData();
insert_data($products,$mysqli);
