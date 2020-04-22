<?php
include_once '../init.php';

class PagesController extends PageController
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

        $this->model = new PagesModel(MyDB::get_db_instance());
    }

    public function action_default(){
        ////////////////////////////////////////////////////
        /// Format output
        $this->view->list = $this->model->getPages();
        $views = array('list', 'add');
        $this->view->buildView($views);
    }

    public function action_delete(){
        ////////////////////////////////////////////////////
        /// Get data
        $id = filter_input_("id", 0);

        ////////////////////////////////////////////////////
        /// Delete page
        ($id != 0) ?
            $this->model->deletePage($id) :
            $this->view->error_message = "Can not delete page, incorrect id";


        ////////////////////////////////////////////////////
        /// Format output
        $this->view->list = $this->model->getPages();
        $views = array('list', 'add');
        $this->view->buildView($views);
    }

    public function action_add(){
        //////////////////////////////////////////
        /// Get data
        $name = filter_input_("name", "");
        $url = filter_input_("url", "");
        $content = filter_input_("content", "");

        ////////////////////////////////////////////////////
        /// Add page
        if(!empty($name) && !empty($content) && !empty($url)) {
            $this->model->addPage($name, $content, $url);
            $this->view->name = '';
            $this->view->url = '';
            $this->view->content = '';
        } else {
            $this->view->error_message = "Can not add page, incorrect input data";
            $this->view->name = $name;
            $this->view->url = $url;
            $this->view->content = $content;
        }

        ////////////////////////////////////////////////////
        /// Format output
        $this->view->list = $this->model->getPages();
        $views = array('list', 'add');
        $this->view->buildView($views);
    }

    public function action_edit(){
        ////////////////////////////////////////////////////
        /// Get data
        $id = filter_input_("id", 0);

        ////////////////////////////////////////////////////
        /// Format output
        $this->view->page = $this->model->getPage($id);
        $views = array('edit');
        $this->view->buildView($views);
    }

    public function action_update(){
        ////////////////////////////////////////////////////
        /// Get data
        $id = filter_input_("id", 0);
        $name = filter_input_("name", "");
        $url = filter_input_("url", "");
        $content = filter_input_("content", "");

        ////////////////////////////////////////////////////
        /// Update article
        if ($id != 0 && !empty($name) && !empty($content) && !empty($url)) {
            $this->model->updatePage($id, $name, $content, $url);

            ////////////////////////////////////////////////////
            /// Format output
            $this->view->list = $this->model->getPages();
            $views = array('list','add');
            $this->view->buildView($views);
        } else {
            $info['id'] = $id;
            $info['name'] = $name;
            $info['url'] = $url;
            $info['content'] = $content;

            ////////////////////////////////////////////////////
            /// Format output
            $this->view->error_message = "Can not update page, incorrect input data";
            $this->view->page = $info;
            $views = array('edit');
            $this->view->buildView($views);
        }
    }
}