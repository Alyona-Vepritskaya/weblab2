<?php // + -
include_once '../init.php';

class UsersController extends PageController
{
    protected $userModel;

    public function __construct(){
        parent::__construct();
        
        ///////////////////////////////////////////////////////////////////////
        // Check is user have access to this page
        $u = Application::getUserSes();
        if ($u->checkUserAuth() == 0) {
            $this->goUrl(SITE_HOST.'cms/index.php');
            exit();
        }
        $this->userModel = new UserModel();
    }

    public function action_default(){ // check
        $this->view->ulist = $this->userModel->getUsers();
        $views = array('list', 'add');
        $this->view->buildView($views);
    }
    public function action_edit(){
        //Todo
    }
    public function action_delete(){
        //Todo
    }
    public function action_add(){
        //Todo
    }

}