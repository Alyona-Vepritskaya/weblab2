<?php
include_once '../init.php';

class UsersController extends PageController
{
    protected $user_model;
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

        $this->user_model = new UserModel(MyDB::get_db_instance());
    }

    public function action_default(){
        ////////////////////////////////////////////////////
        /// Form output
        $this->view->ulist = $this->user_model->getUsers();
        $views = array('list', 'add');
        $this->view->buildView($views);
    }

    public function action_update(){
        ////////////////////////////////////////////////////
        /// Get data
        $id = Application::filter_input_("id", 0);
        $login = Application::filter_input_("login", "");
        $name = Application::filter_input_("name", "");
        $password = Application::filter_input_("password", "");
        $password2 = Application::filter_input_("password2", "");

        ////////////////////////////////////////////////////
        /// Update user if possible
        if ($id != 0 && !empty($login) && !empty($password) && !empty($name) && ($password2 == $password)) {
            $this->user_model->updateUser($id, $login, $password, $name);

            ////////////////////////////////////////////////////
            /// Form output
            $this->view->ulist = $this->user_model->getUsers();
            $views = array('list','add');
            $this->view->buildView($views);
        } else {

            $info['id'] = $id;
            $info['login'] = $login;
            $info['name'] = $name;

            ////////////////////////////////////////////////////
            /// Form output
            $this->view->error_message = "Can not update user, incorrect input data";
            $this->view->user = $info;
            $views = array('edit');
            $this->view->buildView($views);
        }
    }

    public function action_edit(){
        ////////////////////////////////////////////////////
        /// Get data
        $id = Application::filter_input_("id", 0);

        ////////////////////////////////////////////////////
        /// Form output
        $this->view->user = $this->user_model->getUser($id);
        $views = array('edit');
        $this->view->buildView($views);
    }

    public function action_delete(){
        ////////////////////////////////////////////////////
        /// Get data
        $id = Application::filter_input_("id", 0);

        ////////////////////////////////////////////////////
        /// Delete user if possible
        if ($id == $this->user_id->getUserId()) {
            $this->view->error_message = "!!! Can not delete yourself !!!";
        } else {
            ($id != 0) ?
                $this->user_model->deleteUser($id) :
                $this->view->error_message = "Can not delete user, incorrect id";
        }

        ////////////////////////////////////////////////////
        /// Form output
        $this->view->ulist = $this->user_model->getUsers();
        $views = array('list', 'add');
        $this->view->buildView($views);
    }

    public function action_add(){
        //////////////////////////////////////////
        /// Get data
        $login = Application::filter_input_("login", "");
        $name = Application::filter_input_("name", "");
        $password = Application::filter_input_("password", "");
        $password2 = Application::filter_input_("password2", "");

        ////////////////////////////////////////////////////
        /// Add user
        if (!empty($login) && !empty($password) && !empty($name) && ($password2 == $password)) {
            $this->user_model->addUser($login, $password, $name);
            $this->view->name = '';
            $this->view->login = '';
        } else {
            $this->view->name = $name;
            $this->view->login = $login;
            $this->view->error_message = "Can not add user, incorrect input data";
        }

        ////////////////////////////////////////////////////
        /// Form output
        $this->view->ulist = $this->user_model->getUsers();
        $views = array('list', 'add');
        $this->view->buildView($views);
    }

}