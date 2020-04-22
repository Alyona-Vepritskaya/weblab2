<?php
include "../init.php";

class PageView extends View
{
    protected $controller_name;
    protected $header_file;
    protected $footer_file;

    public function __construct($controller_name){
        parent::__construct();
        $this->controller_name = $controller_name;
        $this->header_file = "inc/header.php";
        $this->footer_file = "inc/footer.php";
    }

    public function setHeader($filepath){
        $this->header_file = $filepath;
    }

    public function setFooter($filepath){
        $this->footer_file = $filepath;
    }

    public function buildView($view_name = ""){

        include $this->header_file;

        ////////////////////////////////////////////////////////////
        /// Output data
        $ctrl = strtolower($this->controller_name);
        $ctrl = str_replace('controller','',$ctrl);

        if(is_array($view_name)){
            foreach ($view_name as $item){
                if(file_exists('views/'.$ctrl.'/'.$item.'.php'))
                    include_once 'views/'.$ctrl.'/'.$item.'.php';
            }
        } else
            if(!empty($view_name)){
            if(file_exists('views/'.$ctrl.'/'.$view_name.'.php'))
                include_once 'views/'.$ctrl.'/'.$view_name.'.php';
        } else {
            if(file_exists('views/'.$ctrl.'/index.php'))
                include_once 'views/'.$ctrl.'/index.php';
        }
        ////////////////////////////////////////////////////////////

        include $this->footer_file;
    }
}