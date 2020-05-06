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

    public function getSth($table, $fldname = "", $fldvalue = "", $fields = null, $sortby = "id", $pi = -1, $pn = 20)
    {

        $sql_sort = " id ";

        switch ($sortby) {
            case "name":
                $sql_sort = "name";
                break;

            case "add":
                $sql_sort = "add_date";
                break;
        }

        $sql_fields = " * ";

        if ($fields != null) {
            $sql_fields = implode(", ", $fields);
        }

        $sql_limit = "";

        if ($pi >= 0) {
            $sql_limit = " LIMIT " . ($pi * $pn) . ", " . $pn . " ";
        }

        $sql_cond = "";
        if ($fldname != "") {
            $sql_cond = " WHERE $fldname = $fldvalue";
        }
        $sql = "SELECT " . $sql_fields . " FROM " . $table . " " . $sql_cond . " ORDER BY " . $sql_sort . " " . $sql_limit;

        $tmp = MyDB::query_select($sql);

        return $tmp;
    }

    function getSections()
    {
        $this->sections = $this->getSth(DBT_SECTIONS);

        return $this->sections;
    }


    function getSection($id)
    {
        $this->section = $this->getSth(DBT_SECTIONS,'id',$id);

        if(count($this->section)==1){
        $this->section = $this->section[0];
        }
        return $this->section;
    }

    function deleteSection($fldvalue,$fldname='id')
    {
        $sql_del = "delete from ".DBT_SECTIONS." where $fldname = '$fldvalue';";
        MyDB::query_add_del_upd($sql_del);
    }

    function addSection($name)
    {
        $field_names = implode(", ", array('name'));
        $field_values = implode(", ", array("'$name'"));

        $sql_insert = "insert into ".DBT_SECTIONS." ($field_names) values ($field_values);";

        MyDB::query_add_del_upd($sql_insert);
    }

    public function updateSection($id, $name,$field_name='id')
    {
        $data = array('name' => "'$name'");

        $field_names_values = '';
        foreach ($data as $key => $value) {
            $field_names_values .= " $key = $value,";
        }
        $field_names_values = substr($field_names_values, 0, -1);
        $sql_update = "update ".DBT_SECTIONS." set $field_names_values  where $field_name = '$id';";

        MyDB::query_add_del_upd($sql_update);
    }

    function getAllProducts()
    {
        $this->products = $this->getSth(DBT_PRODUCTS);

        return $this->products;
    }

    function getProducts($section_id)
    {
        $this->products = $this->getSth(DBT_PRODUCTS,'id_section',$section_id);


           /* $this->section = $this->section[0];*/

        return $this->products;
        /*$field_names = array('id', 'name', 'year', 'country', 's_num', 'img', 'price');
        $this->products = MyDB::select_all_of_me($this->mysqli, DBT_PRODUCTS, 'id_section', $section_id, $field_names);

        return $this->products;*/
    }

    function getProduct($product_id)
    {
        /*$this->params = MyDB::select_me($this->mysqli, DBT_PRODUCTS, 'id', $product_id, $field_names);*/
        $this->params = $this->getSth(DBT_PRODUCTS,'id',$product_id);
        if(count($this->params)==1){
            $this->params = $this->params[0];
        }
        if (!is_null($this->params)) {
            $tmp = $this->getSth(DBT_PARAM,'id_product',$product_id);
           /* $tmp = MyDB::select_all_of_me($this->mysqli, DBT_PARAM, 'id_product', $product_id, $field_names);*/
            if (!is_null($tmp)) {
                $this->params['param'] = $tmp;
            }
            return $this->params;
        }

        return null;
    }

    function updateProduct($product_id, $name, $country, $price, $year, $img, $s_num,$field_name='id')
    {
        if (!empty($img)) {
            $data = array('name' => "'$name'",'s_num'=>"'$s_num'",'price'=>"'$price'",'year'=>"'$year'",'country'=>"'$country'",'img'=>"'$img'");

            $field_names_values = '';
            foreach ($data as $key => $value) {
                $field_names_values .= " $key = $value,";
            }
            $field_names_values = substr($field_names_values, 0, -1);
            $sql_update = "update ".DBT_PRODUCTS." set $field_names_values  where $field_name = '$product_id';";

            MyDB::query_add_del_upd($sql_update);
        } else {
            $data = array('name' => "'$name'",'s_num'=>"'$s_num'",'price'=>"'$price'",'year'=>"'$year'",'country'=>"'$country'");

            $field_names_values = '';
            foreach ($data as $key => $value) {
                $field_names_values .= " $key = $value,";
            }
            $field_names_values = substr($field_names_values, 0, -1);
            $sql_update = "update ".DBT_PRODUCTS." set $field_names_values  where $field_name = '$product_id';";

            MyDB::query_add_del_upd($sql_update);
        }
    }

    function addProduct($name, $country, $price, $year, $img, $s_num, $id_section)
    {
        $field_names = implode(", ", array('name','country','price','year','img','s_num','id_section'));
        $field_values = implode(", ", array("'$name'","'$country'","'$price'","'$year'","'$img'","'$s_num'","'$id_section'"));

        $sql_insert = "insert into ".DBT_PRODUCTS." ($field_names) values ($field_values);";

        MyDB::query_add_del_upd($sql_insert);
    }

    function getProductBySNum($s_num)
    {
        $product = $this->getSth(DBT_PRODUCTS,'s_num',$s_num);

        if(count($product)==1){
            $product = $product[0];
        }

       /* $field_names = array('id');
        $product = MyDB::select_me($this->mysqli, DBT_PRODUCTS, 's_num', $s_num, $field_names);*/

        $id = (is_null($product))? 0 : $product['id'];

        return $id;
    }

    function deleteProduct($fldvalue,$fldname='id')
    {
        $sql_del = "delete from ".DBT_PRODUCTS." where $fldname = '$fldvalue';";
        MyDB::query_add_del_upd($sql_del);

        $this->deleteParams($fldvalue);
    }

    //Params
    function deleteParams($id_product)
    {
        $fldname = 'id_product';
        $sql_del = "delete from ".DBT_PARAM." where $fldname = '$id_product';";
        MyDB::query_add_del_upd($sql_del);
    }

    function deleteParam($fldvalue,$fldname='id')
    {
        $sql_del = "delete from ".DBT_PARAM." where $fldname = '$fldvalue';";
        MyDB::query_add_del_upd($sql_del);
    }

    function addParam($product_id, $param_name, $param_value, $param_sort)
    {
        $field_names = implode(", ", array('name','value','sort','id_product'));
        $field_values = implode(", ", array("'$param_name'","'$param_value'","'$param_sort'","'$product_id'"));

        $sql_insert = "insert into ".DBT_PARAM." ($field_names) values ($field_values);";

        MyDB::query_add_del_upd($sql_insert);
    }

    //Comments
    function getProductsReviews()
    {
        $this->comments = $this->getSth(DBT_REVIEWS);
        return $this->comments;
    }

    function getProductReviews($product_id)
    {
        $this->comments = $this->getSth(DBT_REVIEWS,'id_product',$product_id);
        return $this->comments;
    }

    function addProductReviews($email, $product_id, $name, $comment)
    {
        $field_names = implode(", ", array('name','email','comment','id_product'));
        $field_values = implode(", ", array("'$name'","'$email'","'$comment'","'$product_id'"));

        $sql_insert = "insert into ".DBT_REVIEWS." ($field_names) values ($field_values);";

        MyDB::query_add_del_upd($sql_insert);
    }

    function deleteProductReviews($fldvalue,$fldname='id')
    {
        $sql_del = "delete from ".DBT_REVIEWS." where $fldname = '$fldvalue';";
        MyDB::query_add_del_upd($sql_del);
    }
}