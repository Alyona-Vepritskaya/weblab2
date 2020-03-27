<?php
include_once 'MyDB.php';
include_once 'connect-inc.php';

class ProductModel
{
    private $sections;
    private $products;
    private $params;
    private $mysqli;

    public function __construct($mysqli)
    {
        $this->mysqli = $mysqli;
    }

    function get_sections()
    {
        $this->sections = array();
        $sql_select = "select * from " . DBT_SECTIONS . ";";
        $result = $this->mysqli->query($sql_select);
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $this->sections[$row["id"]] = $row["name"];
            }
        }
        return $this->sections;
    }

    function get_products($section_id)
    {
        $this->products = array();
        $sql_select = "select * from " . DBT_PRODUCTS . " where id_section=" . $section_id . ";";
        $result = $this->mysqli->query($sql_select);
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $item = array();
                $item['name'] = $row["name"];
                $item['year'] = $row["year"];
                $item['country'] = $row["country"];
                $item['s_num'] = $row["s_num"];
                $item['img'] = $row["img"];
                $item['price'] = $row["price"];
                $this->products[] = $item;
            }
        }
        return $this->products;
    }

    function get_product_params($product_id)
    {
    }

    function get_product_reviews($product_id)
    {
    }
}