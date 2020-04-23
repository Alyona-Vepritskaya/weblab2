<?php
include_once '../init.php';

class ProductsController extends PageController
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
        $this->view->list = $this->model->getAllProducts();
        $this->view->sections = $this->model->getSections();
        $views = array('list', 'add');
        $this->view->buildView($views);
    }

    public function action_add(){
        //////////////////////////////////////////
        /// Get data
        $name = filter_input_("name", "");
        $country = filter_input_("country", "");
        $price = filter_input_("price", "");
        $year = filter_input_("year", "");
        $s_num = filter_input_("s_num", "");
        $id_section = filter_input_("select", "");
        $img_name = $this->get_image();

        ////////////////////////////////////////////////////
        /// Add product
        if (!empty($name) && !empty($country) && !empty($price) && !empty($year) && !empty($s_num) && !empty($img_name)) {
            $this->model->addProduct($name, $country, $price, $year, $img_name, $s_num, $id_section);
            $this->view->id = $this->model->getProductBySNum($s_num);
            $this->view->name = '';
            $this->view->country = '';
            $this->view->price = '';
            $this->view->year = '';
            $this->view->s_num = '';
            $this->view->img_name = '';
            $this->view->id_section = '';
        } else {
            $this->view->error_message = "Can not add product, incorrect input data";
            $this->view->name = $name;
            $this->view->year = $year;
            $this->view->s_num = $s_num;
            $this->view->country = $country;
            $this->view->price = $price;
            $this->view->id_section = $id_section;
        }

        ////////////////////////////////////////////////////
        /// Format output
        $this->view->list = $this->model->getAllProducts();
        $this->view->sections = $this->model->getSections();
        $views = array('list', 'add');
        $this->view->buildView($views);
    }

    public function action_delete(){
        ////////////////////////////////////////////////////
        /// Get data
        $id = filter_input_("id", 0);

        ////////////////////////////////////////////////////
        /// Delete product
        ($id != 0) ?
            $this->model->deleteProduct($id) :
            $this->view->error_message = "Can not delete product, incorrect id";


        ////////////////////////////////////////////////////
        /// Format output
        $this->view->list = $this->model->getAllProducts();
        $this->view->sections = $this->model->getSections();
        $views = array('list', 'add');
        $this->view->buildView($views);
    }

    public function action_update_product(){
        ////////////////////////////////////////////////////
        /// Get data
        $id = filter_input_("id", 0);
        $name = filter_input_("name", "");
        $country = filter_input_("country", "");
        $price = filter_input_("price", "");
        $year = filter_input_("year", "");
        $s_num = filter_input_("s_num", "");
        $img_name = $this->get_image();
        $info = $this->model->getProduct($id);

        ////////////////////////////////////////////////////
        /// Update product
        if ($id != 0 && !empty($name) && !empty($country) && !empty($price) && !empty($year) && !empty($s_num)) {
            $this->model->updateProduct($id, $name, $country, $price, $year, $img_name, $s_num);

            ////////////////////////////////////////////////////
            /// Format output
            $this->view->list = $this->model->getAllProducts();
            $views = array('list','add');
            $this->view->buildView($views);
        } else {

            $info['id'] = $this->model->getProductBySNum($s_num);
            $info['name'] = $name;
            $info['year'] = $year;
            $info['s_num'] = $s_num;
            $info['country'] = $country;
            $info['price'] = $price;

            ////////////////////////////////////////////////////
            /// Format output
            $this->view->id = $id;
            $this->view->info = $info;
            $this->view->info_params = $this->model->getProduct($id);
            $this->view->error_message = "Can not update product, incorrect input data";
            $views = array('editMainInfo','editParams');
            $this->view->buildView($views);
        }
    }

    public function action_edit(){
        ////////////////////////////////////////////////////
        /// Get data
        $id = filter_input_("id", 0);

        ////////////////////////////////////////////////////
        /// Format output
        $this->view->info = $this->model->getProduct($id);
        $this->view->info_params = $this->model->getProduct($id);
        $this->view->id = $id;
        $views = array('editMainInfo','editParams');
        $this->view->buildView($views);
    }

    public function action_delete_param(){
        /////////////////////////////////////////////////////
        /// Get data
        $id_p = filter_input_("id_p", 0);
        $id = filter_input_("id", 0);

        ////////////////////////////////////////////////////
        /// Delete param
        if ($id_p != 0) {
            $this->model->deleteParam($id_p);
        } else {
            $this->view->error_message = "Can not delete param, incorrect id";
        }

        ////////////////////////////////////////////////////
        /// Format output
        $this->view->id = $id;
        $this->view->info_params = $this->model->getProduct($id);
        $this->view->info = $this->model->getProduct($id);
        $views = array('editMainInfo','editParams');
        $this->view->buildView($views);
    }

    public  function action_add_extra_info(){
        /////////////////////////////////////////////////////
        /// Get data
        $id = filter_input_("id", 0);
        $n = filter_input_("param_name", "");
        $v = filter_input_("param_value", "");
        $sort = filter_input_("param_sort", "");

        ////////////////////////////////////////////////////
        /// Add param
        if(!empty($n) && !empty($v) && !empty($sort)) {
            $this->model->addParam($id, $n, $v, $sort);
            $this->view->n = '';
            $this->view->v = '';
            $this->view->sort = '';
        }else {
            $this->view->n = $n;
            $this->view->v = $v;
            $this->view->sort = $sort;
            $this->view->error_message = "Can not add param, incorrect input data";
        }

        ////////////////////////////////////////////////////
        /// Format output
        $this->view->id = $id;
        $this->view->info = $this->model->getProduct($id);
        $this->view->info_params = $this->model->getProduct($id);
        $views = array('editMainInfo','editParams');
        $this->view->buildView($views);
    }

    private function get_image()
    {
        $path = str_replace('controllers','img/',__DIR__);
        $submit = filter_input_('input_submit', '');
        if (!empty($submit) && (!empty($_FILES['file']['tmp_name']))) {
            $loaded_file = $_FILES['file'];
            move_uploaded_file($loaded_file['tmp_name'], trim($path . $loaded_file['name']));
            return $loaded_file['name'];
        }
        return '';
    }

}