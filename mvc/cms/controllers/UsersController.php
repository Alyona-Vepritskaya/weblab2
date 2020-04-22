<?php
include_once '../init.php';

class UsersController extends PageController
{
    protected $userModel;
    protected $user_id;

    public function __construct(){
        parent::__construct();
        
        ///////////////////////////////////////////////////////////////////////
        // Check is user have access to this page
        $this->user_id = Application::getUserSes();
        if ($this->user_id->checkUserAuth() == 0) {
            $this->goUrl(SITE_HOST.'cms/index.php');
            exit();
        }

        $this->userModel = new UserModel(MyDB::get_db_instance());
    }

    public function action_default(){
        $this->view->ulist = $this->userModel->getUsers();
        $views = array('list', 'add');
        $this->view->buildView($views);
    }

    public function action_update(){
        ////////////////////////////////////////////////////
        /// Get data
        $id = filter_input_("id", 0);
        $login = filter_input_("login", "");
        $name = filter_input_("name", "");
        $password = filter_input_("password", "");
        $password2 = filter_input_("password2", "");

        ////////////////////////////////////////////////////
        /// Update user if possible
        if ($id != 0 && !empty($login) && !empty($password) && !empty($name) && ($password2 == $password)) {
            $this->userModel->updateUser($id, $login, $password, $name);

            ////////////////////////////////////////////////////
            /// Format output
            $this->view->ulist = $this->userModel->getUsers();
            $views = array('list','add');
            $this->view->buildView($views);
        } else {

            $info['id'] = $id;
            $info['login'] = $login;
            $info['name'] = $name;

            ////////////////////////////////////////////////////
            /// Format output
            $this->view->error_message = "Can not update user, incorrect input data";
            $this->view->user = $info;
            $views = array('edit');
            $this->view->buildView($views);
        }
    }

    public function action_edit(){
        ////////////////////////////////////////////////////
        /// Get data
        $id = filter_input_("id", 0);

        ////////////////////////////////////////////////////
        /// Format output
        $this->view->user = $this->userModel->getUser($id);
        $views = array('edit');
        $this->view->buildView($views);
    }

    public function action_delete(){
        ////////////////////////////////////////////////////
        /// Get data
        $id = filter_input_("id", 0);

        ////////////////////////////////////////////////////
        /// Delete user if possible
        if ($id == $this->user_id->getUserId()) {
            $this->view->error_message = "!!! Can not delete yourself !!!";
        } else {
            ($id != 0) ?
                $this->userModel->deleteUser($id) :
                $this->view->error_message = "Can not delete user, incorrect id";
        }

        ////////////////////////////////////////////////////
        /// Format output
        $this->view->ulist = $this->userModel->getUsers();
        $views = array('list', 'add');
        $this->view->buildView($views);
    }

    public function action_add(){
        //////////////////////////////////////////
        /// Get data
        $login = filter_input_("login", "");
        $name = filter_input_("name", "");
        $password = filter_input_("password", "");
        $password2 = filter_input_("password2", "");

        ////////////////////////////////////////////////////
        /// Add user
        if (!empty($login) && !empty($password) && !empty($name) && ($password2 == $password)) {
            $this->userModel->addUser($login, $password, $name);
            $this->view->name = '';
            $this->view->login = '';
        } else {
            $this->view->name = $name;
            $this->view->login = $login;
            $this->view->error_message = "Can not add user, incorrect input data";
        }

        ////////////////////////////////////////////////////
        /// Format output
        $this->view->ulist = $this->userModel->getUsers();
        $views = array('list', 'add');
        $this->view->buildView($views);
    }

}