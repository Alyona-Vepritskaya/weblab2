<?php
include_once '../init.php';

class SectionsController extends PageController
{
    protected $model;

    public function __construct(){
        parent::__construct();

        ///////////////////////////////////////////////////////////////////////
        // Check is user have access to this page
        $user_id = Application::getUserSes();
        if ($user_id->checkUserAuth() == 0) {
            $this->goUrl(SITE_HOST.'cms/index.php');
            exit();
        }

        $this->model = new ProductModel(MyDB::get_db_instance());
    }

    public function action_default(){
        ////////////////////////////////////////////////////
        /// Format output
        $this->view->list = $this->model->getSections();
        $views = array('list', 'add');
        $this->view->buildView($views);
    }

    public function action_delete(){
        ////////////////////////////////////////////////////
        /// Get data
        $id = filter_input_("id", 0);

        ////////////////////////////////////////////////////
        /// Delete sections
        ($id != 0) ?
            $this->model->deleteSection($id) :
            $this->view->error_message = "Can not delete sections, incorrect id";

        ////////////////////////////////////////////////////
        /// Format output
        $this->view->list = $this->model->getSections();
        $views = array('list', 'add');
        $this->view->buildView($views);
    }

    public function action_add(){
        //////////////////////////////////////////
        /// Get data
        $name = filter_input_("name", "");

        ////////////////////////////////////////////////////
        /// Add user
        if (!empty($name)) {
            $this->model->addSection($name);
            $this->view->name = '';
        } else {
            $this->view->name = $name;
            $this->view->error_message = "Can not add section, incorrect input data";
        }

        ////////////////////////////////////////////////////
        /// Format output
        $this->view->list = $this->model->getSections();
        $views = array('list', 'add');
        $this->view->buildView($views);
    }

    public function action_edit(){
        ////////////////////////////////////////////////////
        /// Get data
        $id = filter_input_("id", 0);

        ////////////////////////////////////////////////////
        /// Format output
        $this->view->section = $this->model->getSection($id);
        $views = array('edit');
        $this->view->buildView($views);
    }

    public function action_update(){
        ////////////////////////////////////////////////////
        /// Get data
        $id = filter_input_("id", 0);
        $name = filter_input_("name", "");

        ////////////////////////////////////////////////////
        /// Update user if possible
        if ($id != 0 && !empty($name)) {
            $this->model->updateSection($id, $name);

            ////////////////////////////////////////////////////
            /// Format output
            $this->view->list = $this->model->getSections();
            $views = array('list','add');
            $this->view->buildView($views);
        } else {
            $info['id'] = $id;
            $info['name'] = $name;

            ////////////////////////////////////////////////////
            /// Format output
            $this->view->error_message = "Can not update section, incorrect input data";
            $this->view->section = $info;
            $views = array('edit');
            $this->view->buildView($views);
        }
    }
}