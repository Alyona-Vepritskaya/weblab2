<?php
include_once '../init.php';

class NewsController extends PageController
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

        $this->model = new ArticlesModel(MyDB::get_db_instance());
    }

    public function action_default(){
        ////////////////////////////////////////////////////
        /// Form output
        $this->view->list = $this->model->getArticles();
        $views = array('list', 'add');
        $this->view->buildView($views);
    }

    public function action_delete(){
        ////////////////////////////////////////////////////
        /// Get data
        $id = Application::filter_input_("id", 0);

        ////////////////////////////////////////////////////
        /// Delete news
        ($id != 0) ?
            $this->model->deleteArticle($id) :
            $this->view->error_message = "Can not delete article, incorrect id";


        ////////////////////////////////////////////////////
        /// Form output
        $this->view->list = $this->model->getArticles();
        $views = array('list', 'add');
        $this->view->buildView($views);
    }

    public function action_add(){
        //////////////////////////////////////////
        /// Get data
        $name = Application::filter_input_("name", "");
        $url = Application::filter_input_("url", "");
        $content = Application::filter_input_("content", "");

        ////////////////////////////////////////////////////
        /// Add article
        if(!empty($name) && !empty($content)) {
            $this->model->addArticle($name, $content, $url);

            $this->view->name = '';
            $this->view->url = '';
            $this->view->content = '';
        } else {
            $this->view->error_message = "Can not add article, incorrect input data";
            $this->view->name = $name;
            $this->view->url = $url;
            $this->view->content = $content;
        }

        ////////////////////////////////////////////////////
        /// Form output
        $this->view->list = $this->model->getArticles();
        $views = array('list', 'add');
        $this->view->buildView($views);
    }

    public function action_edit(){
        ////////////////////////////////////////////////////
        /// Get data
        $id = Application::filter_input_("id", 0);

        ////////////////////////////////////////////////////
        /// Form output
        $this->view->article = $this->model->getArticle($id);
        $views = array('edit');
        $this->view->buildView($views);
    }

    public function action_update(){
        ////////////////////////////////////////////////////
        /// Get data
        $id = Application::filter_input_("id", 0);
        $name = Application::filter_input_("name", "");
        $url = Application::filter_input_("url", "");
        $content = Application::filter_input_("content", "");

        ////////////////////////////////////////////////////
        /// Update article
        if ($id != 0 && !empty($name) && !empty($content) && !empty($url)) {
            $this->model->updateArticle($id, $name, $content, $url);

            ////////////////////////////////////////////////////
            /// Form output
            $this->view->list = $this->model->getArticles();
            $views = array('list','add');
            $this->view->buildView($views);
        } else {
            $info['id'] = $id;
            $info['name'] = $name;
            $info['url'] = $url;
            $info['content'] = $content;

            ////////////////////////////////////////////////////
            /// Form output
            $this->view->error_message = "Can not update article, incorrect input data";
            $this->view->article = $info;
            $views = array('edit');
            $this->view->buildView($views);
        }
    }
}