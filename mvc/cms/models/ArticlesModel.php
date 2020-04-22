<?php //+
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

    public function getArticles()
    {
        $this->articles = array();
        $sql_select = "select * from " . DBT_NEWS . ";";
        $result = $this->mysqli->query($sql_select);
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $article = array();
                $article['name'] = $row["name"];
                $article['id'] = $row["id"];
                $article['url'] = $row["url"];
                $article['content'] = $row["content"];
                $article['published_date'] = $row["published_date"];
                $this->articles[] = $article;
            }
        }
        return $this->articles;
    }

    public function getArticle($a_id)
    {
        $this->article = array();
        $sql_select = "select * from " . DBT_NEWS . " where id='" . $a_id . "';";
        $result = $this->mysqli->query($sql_select);
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $this->article['name'] = $row["name"];
                $this->article['url'] = $row["url"];
                $this->article['id'] = $row["id"];
                $this->article['content'] = $row["content"];
                $this->article['published_date'] = $row["published_date"];
            }
        }
        return $this->article;
    }

    public function updateArticle($id, $name, $content, $url)
    {
        $sql_update = "update " . DBT_NEWS . "
        set name   = '" . $name . "',
            url = '$url',
            content = '" . $content . "',
            published_date = CURDATE() 
        where id = $id;";
        if ($this->mysqli->query($sql_update) !== true) {
            echo "Error updating record: " . $this->mysqli->error;
        }
    }

    public function deleteArticle($id)
    {
        $sql_del = "delete from " . DBT_NEWS . " where id='" . $id . "';";
        if ($this->mysqli->query($sql_del) !== TRUE) {
            echo "Error: " . $sql_del . "<br>" . $this->mysqli->error;
        }
    }

    public function addArticle($name, $content, $url)
    {
        $sql_insert = "insert into " . DBT_NEWS . " (name,content,published_date,url)
         values ('$name','$content',CURDATE(),'$url');";
        if ($this->mysqli->query($sql_insert) !== TRUE) {
            echo "Error: " . $sql_insert . "<br>" . $this->mysqli->error;
        }
    }
}