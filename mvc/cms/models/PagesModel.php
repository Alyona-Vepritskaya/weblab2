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

    public function getPages()
    {
        $this->pages = array();
        $sql_select = "select * from " . DBT_PAGES . ";";
        $result = $this->mysqli->query($sql_select);
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $article = array();
                $article['name'] = $row["name"];
                $article['id'] = $row["id"];
                $article['url'] = $row["url"];
                $article['content'] = $row["content"];
                $article['published_date'] = $row["published_date"];
                $this->pages[] = $article;
            }
        }
        return $this->pages;
    }

    public function getPage($id)
    {
        $this->page = array();
        $sql_select = "select * from " . DBT_PAGES . " where id='" . $id . "';";
        $result = $this->mysqli->query($sql_select);
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $this->page['name'] = $row["name"];
                $this->page['url'] = $row["url"];
                $this->page['id'] = $row["id"];
                $this->page['content'] = $row["content"];
                $this->page['published_date'] = $row["published_date"];
            }
        }
        return $this->page;
    }

    public function getPageByUrl($url)
    {
        $this->page = array();
        $sql_select = "select * from " . DBT_PAGES . " where url='" . $url . "';";
        $result = $this->mysqli->query($sql_select);
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $this->page['name'] = $row["name"];
                $this->page['url'] = $row["url"];
                $this->page['id'] = $row["id"];
                $this->page['content'] = $row["content"];
                $this->page['published_date'] = $row["published_date"];
            }
        }
        return $this->page;
    }

    public function updatePage($id, $name, $content, $url)
    {
        $sql_update = "update " . DBT_PAGES . "
        set name   = '" . $name . "',
            url = '$url',
            content = '" . $content . "',
            published_date = CURDATE()
        where id = '" . $id . "';";
        if ($this->mysqli->query($sql_update) !== true) {
            echo "Error updating record: " . $this->mysqli->error;
        }
    }

    public function deletePage($id)
    {
        MyDB::delete_me($this->mysqli,DBT_PAGES,'id',$id);
    }

    public function addPage($name, $content, $url)
    {
        $sql_insert = "insert into " . DBT_PAGES . " (name,content,published_date,url)
         values ('$name','$content',CURDATE(),'$url');";
        if ($this->mysqli->query($sql_insert) !== TRUE) {
            echo "Error: " . $sql_insert . "<br>" . $this->mysqli->error;
        }
    }
}