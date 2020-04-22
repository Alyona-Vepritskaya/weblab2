<?php
include_once '../init.php';

class LoginController extends PageController
{
    private $user_session;

    public function __construct() {
        parent::__construct();

        $this->user_session = Application::getUserSes();
    }

    public function action_default(){
        if($this->user_session->checkUserAuth()){
            $url = Controller::formatUrl('UsersController');
            $this->goUrl($url);
            return;
        }
        $this->view->buildView('login');
    }

    public function action_login(){

    }

    public function action_logout(){

    }

}