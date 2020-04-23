<?php
include_once '../init.php';

class PageController extends Controller
{
    protected $view;
    public function __construct(){
        parent::__construct();
        $this->view = new PageView(get_class($this));
    }
}