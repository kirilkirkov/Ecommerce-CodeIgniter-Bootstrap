<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Home extends MY_Controller
{

    private $num_rows = 20;

    public function __construct()
    {
        parent::__construct();
        $this->load->helper(array('pagination'));
        $this->load->Model('Admin_model');
    }

    public function index($page = 0)
    {
        $data = array();
        $head = array();
        $arrSeo = $this->Articles_model->getSeo('page_home', $this->my_lang);
        $head['title'] = @$arrSeo['title'];
        $head['description'] = @$arrSeo['description'];
        $head['keywords'] = str_replace(" ", ",", $head['title']);
        $all_categories = $this->Articles_model->getShopCategories($this->my_lang);

        function buildTree(array $elements, $parentId = 0)
        {
            $branch = array();
            foreach ($elements as $element) {
                if ($element['sub_for'] == $parentId) {
                    $children = buildTree($elements, $element['id']);
                    if ($children) {
                        $element['children'] = $children;
                    }
                    $branch[] = $element;
                }
            }
            return $branch;
        }

        $data['home_categories'] = $tree = buildTree($all_categories);
        $data['countQuantities'] = $this->Articles_model->getCountQuantities();
        $data['bestSellers'] = $this->Articles_model->getbestSellers($this->my_lang);
        $data['sliderProducts'] = $this->Articles_model->getSliderProducts($this->my_lang);
        $data['shippingOrder'] = $this->Admin_model->getValueStore('shippingOrder');
        $data['products'] = $this->Articles_model->getProducts($this->my_lang, $this->num_rows, $page, $_GET);
        $rowscount = $this->Articles_model->productsCount('shop');
        $data['links_pagination'] = pagination('home', $rowscount, $this->num_rows);
        $this->render('home', $head, $data);
    }

    public function manageShoppingCart()
    { // called from add/delete to cart buttons
        if (!$this->input->is_ajax_request()) {
            exit('No direct script access allowed');
        }
        if ($_POST['action'] == 'add') {
            if (!isset($_SESSION['shopping_cart']))
                $_SESSION['shopping_cart'] = array();
            @$_SESSION['shopping_cart'][] = (int) $_POST['article_id'];
        }
        if ($_POST['action'] == 'remove') {
            if (($key = array_search($_POST['article_id'], $_SESSION['shopping_cart'])) !== false) {
                unset($_SESSION['shopping_cart'][$key]);
            }
        }
        @set_cookie('shopping_cart', serialize($_SESSION['shopping_cart']), 2678400); // 1 month expire time
        $result = 0;
        if (!empty($_SESSION['shopping_cart'])) {
            $result = $this->getCartItems();
        }
        // get items from db and add him to cart from ajax
        loop_items($result, $this->currency, base_url($this->lang_link . '/'));
    }

    public function viewProduct($id)
    {
        $data = array();
        $head = array();
        $data['product'] = $this->Articles_model->getOneProduct($id, $this->my_lang);
        $data['sameCagegoryProducts'] = $this->Articles_model->sameCagegoryProducts($this->my_lang, $data['product']['shop_categorie'], $id);
        if ($data['product'] === null) {
            show_404();
        }
        $head['title'] = $data['product']['title'];
        $description = url_title(character_limiter(strip_tags($data['product']['description']), 130));
        $description = str_replace("-", " ", $description) . '..';
        $head['description'] = $description;
        $head['keywords'] = str_replace(" ", ",", $data['product']['title']);
        $this->render('view_product', $head, $data);
    }

}
