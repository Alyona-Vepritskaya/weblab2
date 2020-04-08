<?php
include_once '../../classes/MyDB.php';
include_once '../../inc/connect-inc.php';

class PagesModel
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

    public function getPage($a_id)
    {
        $this->page = array();
        $sql_select = "select * from " . DBT_PAGES . " where id='" . $a_id . "';";
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

    public function updatePage($a_id, $name, $content, $url)
    {
        $sql_update = "update " . DBT_PAGES . "
        set name   = '" . $name . "',
            url = '$url',
            content = '" . $content . "',
            published_date = CURDATE()
        where id = '" . $a_id . "';";
        if ($this->mysqli->query($sql_update) !== true) {
            echo "Error updating record: " . $this->mysqli->error;
        }
    }

    public function deletePage($a_id)
    {
        $sql_del = "delete from " . DBT_PAGES . " where id='" . $a_id . "';";
        if ($this->mysqli->query($sql_del) !== TRUE) {
            echo "Error: " . $sql_del . "<br>" . $this->mysqli->error;
        }
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