<?php
include_once '../init.php';

class PagesModel extends Model
{
    private $mysqli;
    private $page;
    private $pages;

    public function __construct($mysqli)
    {
        $this->mysqli = $mysqli;
    }

    public function getPages($fldname = "", $fldvalue = "", $fields = null, $sortby = "id", $pi = -1, $pn = 20)
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
        $sql = "SELECT " . $sql_fields . " FROM " . DBT_PAGES . " " . $sql_cond . " ORDER BY " . $sql_sort . " " . $sql_limit;

        $this->pages = MyDB::query($sql);

        return $this->pages;
    }

    public function getPage($id)
    {
        $this->page = $this->getPages('id', "'$id'");

        if(count($this->page)==1){
            $this->page = $this->page[0];
        }
        return $this->page;
    }

    public function getPageByUrl($url)
    {
        $this->page = $this->getPages('url', "'$url'");

        if(count($this->page)==1){
            $this->page = $this->page[0];
        }
        return $this->page;
    }

    public function updatePage($id, $name, $content, $url,$field_name='id')
    {
        $data = array('name' => "'$name'",'url'=>"'$url'",'content'=>"'$content'");

        $field_names_values = '';
        foreach ($data as $key => $value) {
            $field_names_values .= " $key = $value,";
        }
        $field_names_values = substr($field_names_values, 0, -1);
        $sql_update = "update ".DBT_PAGES." set $field_names_values  where $field_name = '$id';";

        MyDB::query_add_del_upd($sql_update);
    }

    public function deletePage($fldvalue,$fldname='id')
    {
        $sql_del = "delete from ".DBT_PAGES." where $fldname = '$fldvalue';";
        MyDB::query_add_del_upd($sql_del);
    }

    public function addPage($name, $content, $url)
    {
        $field_names = implode(", ", array('name','content','published_date','url'));
        $field_values = implode(", ", array("'$name'","'$content'",'CURDATE()',"'$url'"));

        $sql_insert = "insert into ".DBT_PAGES." ($field_names) values ($field_values);";

        MyDB::query_add_del_upd($sql_insert);
    }
}