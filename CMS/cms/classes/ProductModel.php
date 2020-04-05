<?php
include_once '../../classes/MyDB.php';
include_once '../../inc/connect-inc.php';

class ProductModel
{
    private $sections;
    private $products;
    private $params;
    private $mysqli;
    private $comments;

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
        $sql_select = "select * from " . DBT_PRODUCTS . " where id_section =" . $section_id . ";";
        $result = $this->mysqli->query($sql_select);
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $item = array();
                $item['id'] = $row["id"];
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
        $this->params = array();
        $sql_select = "select * from " . DBT_PRODUCTS . " where id =" . $product_id . ";";
        $result = $this->mysqli->query($sql_select);
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $this->params['name'] = $row["name"];
                $this->params['id_section'] = $row["id_section"];
                $this->params['year'] = $row["year"];
                $this->params['country'] = $row["country"];
                $this->params['s_num'] = $row["s_num"];
                $this->params['img'] = $row["img"];
                $this->params['price'] = $row["price"];
            }
        }
        $sql_select2 = "select * from " . DBT_PARAM . " where id_product =" . $product_id . ";";
        $result2 = $this->mysqli->query($sql_select2);
        if ($result2->num_rows > 0) {
            while ($row = $result2->fetch_assoc()) {
                $item = array();
                $item['name'] = $row["name"];
                $item['value'] = $row["value"];
                $this->params['param'][] = $item;
            }
        }
        return $this->params;
    }

    function set_product_params($product_id, $name, $country, $price, $year, $img, $s_num)
    {
        $this->params = array();
        $sql_update = "update " . DBT_PRODUCTS . "
            set name = '" . $name . "',
            s_num ='" . $s_num . "',
            price ='" . $price . "',
            year ='" . $year . "',
            country ='" . $country . "',
            img ='" . $img . "',
            where id = '" . $product_id . "';";
        if ($this->mysqli->query($sql_update) !== true) {
            echo "Error updating record: " . $this->mysqli->error;
        }
        //TODO - update params
    }

    function get_product_reviews($product_id)
    {
        $this->comments = array();
        $sql_select = "select * from " . DBT_REVIEWS . " where id_product ='" . $product_id . "';";
        $result = $this->mysqli->query($sql_select);
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $item = array();
                $item['name'] = $row['name'];
                $item['email'] = $row['email'];
                $item['comment'] = $row['comment'];
                $this->comments[] = $item;
            }
        }
        return $this->comments;
    }

    function set_product_reviews($email, $product_id, $name, $comment)
    {
        $tmp = htmlspecialchars($comment);
        $sql_insert = "insert into " . DBT_REVIEWS . " (name, email, comment, id_product)
         values ('$name','$email','$tmp','$product_id');";
        if ($this->mysqli->query($sql_insert) !== TRUE) {
            echo "Error: " . $sql_insert . "<br>" . $this->mysqli->error;
        }
    }

    function delete_product_reviews($id)
    {
        $sql_del = "delete from " . DBT_REVIEWS . " where id='" . $id . "';";
        if ($this->mysqli->query($sql_del) !== TRUE) {
            echo "Error: " . $sql_del . "<br>" . $this->mysqli->error;
        }
    }
}