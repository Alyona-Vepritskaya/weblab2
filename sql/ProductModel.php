<?php
include_once 'MyDB.php';
include_once 'connect-inc.php';

class ProductModel
{
    private $sections;

    function get_sections($mysqli)
    {
        $this->sections = array();
        $sql_select = "select (name) from " . DBT_SECTIONS . ";";
        $result = $mysqli->query($sql_select);
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $this->sections[] = $row["name"];
            }
        }
        return $this->sections;
    }

    function get_products($section_id)
    {
    }

    function get_product_params($product_id)
    {
    }
}