<?php
include_once '../init.php';

class CommentsController extends PageController
{
    protected $model;
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

        $this->model = new ProductModel(MyDB::get_db_instance());
    }

    public function action_default(){
        ////////////////////////////////////////////////////
        /// Form output
        $this->view->list = $this->model->getProductsReviews();
        $views = array('list', 'add');
        $this->view->buildView($views);
    }

    public function action_delete(){
        ////////////////////////////////////////////////////
        /// Get data
        $id = filter_input_("id", 0);

        ////////////////////////////////////////////////////
        /// Delete comment
        ($id != 0) ?
            $this->model->deleteProductReviews($id) :
            $this->view->error_message = "Can not delete comment, incorrect id";


        ////////////////////////////////////////////////////
        /// Form output
        $this->view->list = $this->model->getProductsReviews();
        $views = array('list', 'add');
        $this->view->buildView($views);
    }

    public function action_add(){
        //////////////////////////////////////////
        /// Get data
        $id_prod = filter_input_("id_prod", "");
        $email = filter_input_("email", "");
        $name = filter_input_("name", "");
        $comment = filter_input_("comment", "");

        ////////////////////////////////////////////////////
        /// Add comment
        if ($this->model->getProduct($id_prod) != 0 && !empty($name) && !empty($comment) && !empty($email)) {
            $this->model->addProductReviews($email, $id_prod, $name, $comment);

            $this->view->id_prod = "";
            $this->view->email = "";
            $this->view->name = "";
            $this->view->comment = "";
        } else {
            $this->view->error_message = "Can not add comment, incorrect input data";
            $this->view->id_prod = $id_prod;
            $this->view->email = $email;
            $this->view->name = $name;
            $this->view->comment = $comment;
        }

        ////////////////////////////////////////////////////
        /// Form output
        $this->view->list = $this->model->getProductsReviews();
        $views = array('list', 'add');
        $this->view->buildView($views);
    }
}