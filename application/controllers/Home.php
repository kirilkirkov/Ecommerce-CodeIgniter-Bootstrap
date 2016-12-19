<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Home extends MY_Controller
{

    private $num_rows = 10;

    public function __construct()
    {
        parent::__construct();
        $this->load->helper(array('pagination'));
        $this->load->Model('AdminModel');
    }

    public function index($page = 0)
    {
        $data = array();
        $head = array();
        $arrSeo = $this->Publicmodel->getSeo('page_home');
        $head['title'] = @$arrSeo['title'];
        $head['description'] = @$arrSeo['description'];
        $head['keywords'] = str_replace(" ", ",", $head['title']);
        $all_categories = $this->Publicmodel->getShopCategories();

        /*
         * Tree Builder for categories menu
         */

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
        $data['countQuantities'] = $this->Publicmodel->getCountQuantities();
        $data['bestSellers'] = $this->Publicmodel->getbestSellers();
        $data['sliderProducts'] = $this->Publicmodel->getSliderProducts();
        $data['shippingOrder'] = $this->AdminModel->getValueStore('shippingOrder');
        $data['products'] = $this->Publicmodel->getProducts($this->num_rows, $page, $_GET);
        $data['showOutOfStock'] = $this->AdminModel->getValueStore('outOfStock');
        $rowscount = $this->Publicmodel->productsCount($_GET);
        $data['links_pagination'] = pagination('home', $rowscount, $this->num_rows);
        $this->render('home', $head, $data);
    }

    /*
     * Called to add/remove quantity from cart
     * If is ajax request send POST'S to class ShoppingCart
     */

    public function manageShoppingCart()
    {
        if (!$this->input->is_ajax_request()) {
            exit('No direct script access allowed');
        }
        $this->shoppingcart->manageShoppingCart();
    }

    /*
     * Called to remove product from cart
     * If is ajax request and send $_GET variable to the class
     */

    public function removeFromCart()
    {
        $backTo = $_GET['back-to'];
        $this->shoppingcart->removeFromCart();
        $this->session->set_flashdata('deleted', lang('deleted_product_from_cart'));
        redirect(LANG_URL . '/' . $backTo);
    }

    public function clearShoppingCart()
    {
        $this->shoppingcart->clearShoppingCart();
    }

    public function viewProduct($id)
    {
        $data = array();
        $head = array();
        $data['product'] = $this->Publicmodel->getOneProduct($id);
        $data['sameCagegoryProducts'] = $this->Publicmodel->sameCagegoryProducts($data['product']['shop_categorie'], $id);
        if ($data['product'] === null) {
            show_404();
        }
        $vars['publicDateAdded'] = $this->AdminModel->getValueStore('publicDateAdded');
        $this->load->vars($vars);
        $head['title'] = $data['product']['title'];
        $description = url_title(character_limiter(strip_tags($data['product']['description']), 130));
        $description = str_replace("-", " ", $description) . '..';
        $head['description'] = $description;
        $head['keywords'] = str_replace(" ", ",", $data['product']['title']);
        $this->render('view_product', $head, $data);
    }

}
