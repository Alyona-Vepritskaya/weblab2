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

    public function getArticles()
    {
        $field_names = array('id', 'name','url','content','published_date');
        $this->articles = MyDB::global_select_me($this->mysqli, DBT_NEWS,$field_names);

        return $this->articles;
    }

    public function getArticle($a_id)
    {
        $field_names = array('name', 'url','id','content','published_date');
        $this->article = MyDB::select_me($this->mysqli, DBT_NEWS, 'id', $a_id, $field_names);

        return $this->article;
    }

    public function updateArticle($id, $name, $content, $url)
    {
        $data = array('name' => $name,'url'=>$url,'content'=>$content);
        MyDB::update_me($this->mysqli, DBT_NEWS, $data,'id',$id);
    }

    public function deleteArticle($id)
    {
        MyDB::delete_me($this->mysqli,DBT_NEWS,'id',$id);
    }

    public function addArticle($name, $content, $url)
    {
        $data = array('name' => $name, 'content' => $content, 'published_date' => 'CURDATE()', 'url' => $url);
        MyDB::add_me($this->mysqli, DBT_NEWS, $data,'date');
    }
}