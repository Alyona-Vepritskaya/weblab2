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
        $field_names = array('id', 'name');
        $this->sections = MyDB::global_select_me($this->mysqli, DBT_SECTIONS,$field_names);

        return $this->sections;
    }

    function getSection($id)
    {
        $field_names = array('id', 'name');
        $this->section = MyDB::select_me($this->mysqli, DBT_SECTIONS, 'id', $id, $field_names);

        return $this->section;
    }

    function deleteSection($id)
    {
        MyDB::delete_me($this->mysqli, DBT_SECTIONS, 'id', $id);
    }

    function addSection($name)
    {
        $data = array('name' => $name);
        MyDB::add_me($this->mysqli, DBT_SECTIONS, $data);
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
        //Todo
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
        $field_names = array('id', 'name', 's_num');
        $this->products = MyDB::global_select_me($this->mysqli, DBT_PRODUCTS,$field_names);

        return $this->products;
    }

    function getProducts($section_id)
    {
        $field_names = array('id', 'name', 'year', 'country', 's_num', 'img', 'price');
        $this->products = MyDB::select_all_of_me($this->mysqli, DBT_PRODUCTS, 'id_section', $section_id, $field_names);

        return $this->products;
    }

    function getProduct($product_id)
    {
        $field_names = array('name', 'id_section', 'year', 'country', 's_num', 'img', 'price');
        $this->params = MyDB::select_me($this->mysqli, DBT_PRODUCTS, 'id', $product_id, $field_names);

        if (!is_null($this->params)) {
            $field_names = array('id', 'name', 'value');
            $tmp = MyDB::select_all_of_me($this->mysqli, DBT_PARAM, 'id_product', $product_id, $field_names);
            if (!is_null($tmp)) {
                $this->params['param'] = $tmp;
            }
            return $this->params;
        }

        return null;
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
    }

    function addProduct($name, $country, $price, $year, $img, $s_num, $id_section)
    {
        $data = array('name' => $name, 'country' => $country, 'price' => $price,
            'year' => $year, 'img' => $img, 's_num' => $s_num, 'id_section' => $id_section);
        MyDB::add_me($this->mysqli, DBT_PRODUCTS, $data);
    }

    function getProductBySNum($s_num)
    {

        $field_names = array('id');
        $product = MyDB::select_me($this->mysqli, DBT_PRODUCTS, 's_num', $s_num, $field_names);

        $id = (is_null($product))? 0 : $product['id'];

        return $id;
    }

    function deleteProduct($id)
    {
        MyDB::delete_me($this->mysqli, DBT_PRODUCTS, 'id', $id);

        $this->deleteParams($id);
    }

    //Params
    function deleteParams($id_product)
    {
        MyDB::delete_me($this->mysqli, DBT_PARAM, 'id_product', $id_product);
    }

    function deleteParam($id)
    {
        MyDB::delete_me($this->mysqli, DBT_PARAM, 'id', $id);
    }

    function addParam($product_id, $param_name, $param_value, $param_sort)
    {
        $data = array('name' => $param_name, 'value' => $param_value, 'id_product' => $product_id, 'sort' => $param_sort);
        MyDB::add_me($this->mysqli, DBT_PARAM, $data);
    }

    //Comments
    function getProductsReviews()
    {
        $field_names = array('id', 'id_product', 'name', 'email', 'comment');
        $this->comments = MyDB::global_select_me($this->mysqli, DBT_REVIEWS, $field_names);

        return $this->comments;
    }

    function getProductReviews($product_id)
    {
        $field_names = array('name', 'email', 'comment');
        $this->comments = MyDB::select_all_of_me($this->mysqli, DBT_REVIEWS, 'id_product', $product_id, $field_names);

        return $this->comments;
    }

    function addProductReviews($email, $product_id, $name, $comment)
    {
        $data = array('name' => $name, 'email' => $email, 'comment' => $comment, 'id_product' => $product_id);
        MyDB::add_me($this->mysqli, DBT_REVIEWS, $data);
    }

    function deleteProductReviews($id)
    {
        MyDB::delete_me($this->mysqli, DBT_REVIEWS, 'id', $id);
    }
}