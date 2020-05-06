<?php
include_once '../init.php';

class ArticlesModel extends Model
{
    private $mysqli;
    private $articles;
    private $article;

    public function __construct($mysqli)
    {
        $this->mysqli = $mysqli;
    }

    public function getArticles($fldname = "", $fldvalue = "", $fields = null, $sortby = "id", $pi = -1, $pn = 20)
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
        $sql = "SELECT " . $sql_fields . " FROM " . DBT_NEWS . " " . $sql_cond . " ORDER BY " . $sql_sort . " " . $sql_limit;

        $this->articles = MyDB::query($sql);

        return $this->articles;
    }

    public function getArticle($a_id)
    {
        $field_names = array('name', 'url','id','content','published_date');
        $this->article = $this->getArticles('id', "'$a_id'",$field_names);

        if(count($this->article)==1){
            $this->article = $this->article[0];
        }
        return $this->article;
    }

    public function updateArticle($id, $name, $content, $url, $field_name='id')
    {
        $data = array('name' => "'$name'",'url'=>"'$url'",'content'=>"'$content'");

        $field_names_values = '';
        foreach ($data as $key => $value) {
            $field_names_values .= " $key = $value,";
        }
        $field_names_values = substr($field_names_values, 0, -1);
        $sql_update = "update ".DBT_NEWS." set $field_names_values  where $field_name = '$id';";

        MyDB::query_add_del_upd($sql_update);
    }

    public function deleteArticle($fldvalue,$fldname='id')
    {
        $sql_del = "delete from ".DBT_NEWS." where $fldname = '$fldvalue';";
        MyDB::query_add_del_upd($sql_del);
    }

    public function addArticle($name, $content, $url)
    {
        $field_names = implode(", ", array('name','content','published_date','url'));
        $field_values = implode(", ", array("'$name'","'$content'",'CURDATE()',"'$url'"));

        $sql_insert = "insert into ".DBT_NEWS." ($field_names) values ($field_values);";

        MyDB::query_add_del_upd($sql_insert);
    }
}