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
        $field_names = array('id', 'name','url','content','published_date');
        $this->pages = MyDB::global_select_me($this->mysqli, DBT_PAGES,$field_names);

        return $this->pages;
    }

    public function getPage($id)
    {
        $field_names = array('name', 'url','id','content','published_date');
        $this->page = MyDB::select_me($this->mysqli, DBT_PAGES, 'id', $id, $field_names);

        return $this->page;
    }

    public function getPageByUrl($url)
    {
        $field_names = array('name', 'url','id','content','published_date');
        $this->page = MyDB::select_me($this->mysqli, DBT_PAGES, 'url', $url, $field_names);

        return $this->page;
    }

    public function updatePage($id, $name, $content, $url)
    {
        $data = array('name' => $name,'url'=>$url,'content'=>$content);
        MyDB::update_me($this->mysqli, DBT_PAGES, $data,'id',$id);
    }

    public function deletePage($id)
    {
        MyDB::delete_me($this->mysqli, DBT_PAGES, 'id', $id);
    }

    public function addPage($name, $content, $url)
    {
        $data = array('name' => $name, 'content' => $content, 'published_date' => 'CURDATE()', 'url' => $url);
        MyDB::add_me($this->mysqli, DBT_PAGES, $data,'date');
    }
}