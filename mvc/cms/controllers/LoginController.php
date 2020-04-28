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
        ///////////////////////////////////////////////////////////////////////
        // Check is user have access to this page
        if($this->user_session->checkUserAuth()){
            $url = Controller::formatUrl('HomeController');
            $this->goUrl($url);
            return;
        }

        $this->showAdminPage();
    }

    public function action_login(){
        $password = Application::filter_input_('pwd', '');
        $login = Application::filter_input_('login', '');
        $user = new UserModel(MyDB::get_db_instance());

        ///////////////////////////////////////////////////////////////////////
        //Create record in session table if user is admin
        if (!empty($password) && !empty($login)) {
            if ($user->getUserByLogin($login) != 0) {
                $u_id = $user->checkUser($login, $password);
                if ($u_id != 0) {
                    $this->user_session->makeUserAuth($u_id, $this->user_session->getSesId());
                    $url = Controller::formatUrl('HomeController');
                    $this->goUrl($url);
                    return;
                } else {
                    $this->view->error_message = 'Incorrect password';
                    $this->view->login = $login;
                }
            } else {
                $this->view->error_message = 'Permission denied';
            }
        }

        $this->showAdminPage();
    }

    public function action_logout(){
        $this->user_session->deleteUserAuth($this->user_session->getSesId());

        $this->showAdminPage();
    }

    private function showAdminPage(){
        $this->view->setHeader(null);
        $this->view->buildView('login');
        $this->view->setFooter(null);
    }

}