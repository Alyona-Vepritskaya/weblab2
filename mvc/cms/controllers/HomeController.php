<?php
include_once '../init.php';

class HomeController extends PageController
{
    public function __construct(){
        parent::__construct();
        ///////////////////////////////////////////////////////////////////////
        // Check is user have access to this page
        $user_id = Application::getUserSes();
        if ($user_id->checkUserAuth() == 0) {
            $this->goUrl(SITE_HOST.'cms/index.php');
            exit();
        }
    }

    public function action_default(){
        ////////////////////////////////////////////////////
        /// Format output
        $views = array('home');
        $this->view->buildView($views);
    }
}