<?php
include_once '../init.php';

class ProductModel extends Model
{
    private $sections;
    private $section;
    private $products;
    private $params;
    private $mysqli;
    private $comments;

    public function __construct($mysqli)
    {
        $this->mysqli = $mysqli;
    }

    function getSections()
    {
        $this->sections = array();
        $sql_select = "select * from " . DBT_SECTIONS . ";";
        $result = $this->mysqli->query($sql_select);
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $tmp = array();
                $tmp["id"] = $row["id"];
                $tmp["name"] = $row["name"];
                $this->sections[] = $tmp;
            }
        }
        return $this->sections;
    }

    function getSection($id)
    {
        $sql_select = "select * from " . DBT_SECTIONS . " where id='" . $id . "';";
        $result = $this->mysqli->query($sql_select);
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $this->section["id"] = $row["id"];
                $this->section["name"] = $row["name"];
            }
        }
        return $this->section;
    }

    function deleteSection($id)
    {
        $sql_del = "delete from " . DBT_SECTIONS . " where id='" . $id . "';";
        if ($this->mysqli->query($sql_del) !== TRUE) {
            echo "Error: " . $sql_del . "<br>" . $this->mysqli->error;
        }
        $this->deleteParams($id);
    }

    function addSection($name)
    {
        $sql_insert = "insert into " . DBT_SECTIONS . " (name)
         values ('$name');";
        if ($this->mysqli->query($sql_insert) !== TRUE) {
            echo "Error: " . $sql_insert . "<br>" . $this->mysqli->error;
        }
    }

    public function updateSection($id, $name)
    {
        $sql_update = "update " . DBT_SECTIONS . "
        set name   = '" . $name . "'
        where id = '" . $id . "';";
        if ($this->mysqli->query($sql_update) !== true) {
            echo "Error updating record: " . $this->mysqli->error;
        }
    }

    function getSectionsNames()
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

    function getAllProducts()
    {
        $this->products = array();
        $sql_select = "select * from " . DBT_PRODUCTS . ";";
        $result = $this->mysqli->query($sql_select);
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $item = array();
                $item['id'] = $row["id"];
                $item['name'] = $row["name"];
                $item['s_num'] = $row["s_num"];
                $this->products[] = $item;
            }
        }
        return $this->products;
    }

    function getProducts($section_id)
    {
        $this->products = array();
        $sql_select = "select * from " . DBT_PRODUCTS . " where id_section ='" . $section_id . "';";
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

    function getProduct($product_id)
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
        } else
            return 0;
        $sql_select2 = "select * from " . DBT_PARAM . " where id_product =" . $product_id . ";";
        $result2 = $this->mysqli->query($sql_select2);
        if ($result2->num_rows > 0) {
            while ($row = $result2->fetch_assoc()) {
                $item = array();
                $item['id'] = $row["id"];
                $item['name'] = $row["name"];
                $item['value'] = $row["value"];
                $this->params['param'][] = $item;
            }
        }
        return $this->params;
    }

    function updateProduct($product_id, $name, $country, $price, $year, $img, $s_num)
    {
        if (!empty($img)) {
            $this->params = array();
            $sql_update = "update " . DBT_PRODUCTS . "
            set name = '" . $name . "',
            s_num ='" . $s_num . "',
            price ='" . $price . "',
            year ='" . $year . "',
            country ='" . $country . "',
            img ='" . $img . "'
            where id = $product_id;";
            if ($this->mysqli->query($sql_update) !== true) {
                echo "Error updating record: " . $this->mysqli->error;
            }
        } else {
            $this->params = array();
            $sql_update = "update " . DBT_PRODUCTS . "
            set name = '" . $name . "',
            s_num ='" . $s_num . "',
            price ='" . $price . "',
            year ='" . $year . "',
            country ='" . $country . "'
            where id = '" . $product_id . "';";
            if ($this->mysqli->query($sql_update) !== true) {
                echo "Error updating record: " . $this->mysqli->error;
            }
        }
        /*$this->deleteParams($product_id);*/
    }

    function addProduct($name, $country, $price, $year, $img, $s_num, $id_section)
    {
        $sql_insert = "insert into " . DBT_PRODUCTS . " (name, country, price, year, img, s_num, id_section)
         values ('$name','$country','$price','$year','$img','$s_num','$id_section');";
        if ($this->mysqli->query($sql_insert) !== TRUE) {
            echo "Error: " . $sql_insert . "<br>" . $this->mysqli->error;
        }
    }

    function getProductBySNum($s_num)
    {
        $id = 0;
        $sql_select = "select * from " . DBT_PRODUCTS . " where s_num ='" . $s_num . "';";
        $result = $this->mysqli->query($sql_select);
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $id = $row['id'];
            }
        }
        return $id;
    }

    function deleteProduct($id)
    {
        $sql_del = "delete from " . DBT_PRODUCTS . " where id='" . $id . "';";
        if ($this->mysqli->query($sql_del) !== TRUE) {
            echo "Error: " . $sql_del . "<br>" . $this->mysqli->error;
        }
        $this->deleteParams($id);
    }

    //Params
    function deleteParams($id_product)
    {
        $sql_del = "delete from " . DBT_PARAM . " where id_product='" . $id_product . "';";
        if ($this->mysqli->query($sql_del) !== TRUE) {
            echo "Error: " . $sql_del . "<br>" . $this->mysqli->error;
        }
    }

    function deleteParam($id)
    {
        $sql_del = "delete from " . DBT_PARAM . " where id='" . $id . "';";
        if ($this->mysqli->query($sql_del) !== TRUE) {
            echo "Error: " . $sql_del . "<br>" . $this->mysqli->error;
        }
    }

    function addParam($product_id, $param_name, $param_value, $param_sort)
    {
        $sql_insert = "insert into " . DBT_PARAM . " (name, value, id_product,sort)
         values ('$param_name','$param_value','$product_id','$param_sort');";
        if ($this->mysqli->query($sql_insert) !== TRUE) {
            echo "Error: " . $sql_insert . "<br>" . $this->mysqli->error;
        }
    }

    //Comments
    function getProductsReviews()
    {
        $this->comments = array();
        $sql_select = "select * from " . DBT_REVIEWS . ";";
        $result = $this->mysqli->query($sql_select);
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $item = array();
                $item['id'] = $row['id'];
                $item['id_product'] = $row['id_product'];
                $item['name'] = $row['name'];
                $item['email'] = $row['email'];
                $item['comment'] = $row['comment'];
                $this->comments[] = $item;
            }
        }
        return $this->comments;
    }

    function getProductReviews($product_id)
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

    function addProductReviews($email, $product_id, $name, $comment)
    {
        $tmp = htmlspecialchars($comment);
        $sql_insert = "insert into " . DBT_REVIEWS . " (name, email, comment, id_product)
         values ('$name','$email','$tmp','$product_id');";
        if ($this->mysqli->query($sql_insert) !== TRUE) {
            echo "Error: " . $sql_insert . "<br>" . $this->mysqli->error;
        }
    }

    function deleteProductReviews($id)
    {
        $sql_del = "delete from " . DBT_REVIEWS . " where id='" . $id . "';";
        if ($this->mysqli->query($sql_del) !== TRUE) {
            echo "Error: " . $sql_del . "<br>" . $this->mysqli->error;
        }
    }
}