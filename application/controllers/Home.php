<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Home extends MY_Controller {

    private $num_rows = 20;

    public function __construct() {
        parent::__construct();
        $this->load->helper(array('pagination'));
        $this->load->Model('Admin_model');
    }

    public function index($page = 0) {
        $data = array();
        $head = array();
        $head['title'] = 'Title information‎';
        $head['description'] = 'Description info';
        $head['keywords'] = 'key,words,for,seo';
        $all_categories = $this->Articles_model->getShopCategories($this->my_lang);
        
        function buildTree(array $elements, $parentId = 0) {
        	$branch = array();
        	foreach ($elements as $element) {
        		if($element['sub_for'] == $parentId) {
        			$children = buildTree($elements, $element['id']);
        			if($children) {
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
		$data['sliderArticles'] = $this->Articles_model->getSliderArticles($this->my_lang);

        $data['shop_articles'] = $this->Articles_model->getArticles('shop', $this->my_lang, $this->num_rows, $page, $_GET);
        $rowscount = $this->Articles_model->articlesCount('shop');
        $data['links_pagination'] = pagination('home', $rowscount, $this->num_rows);
        $this->render('home', $head, $data);
    }
	
	public function manageShoppingCart() { // called from add/delete to cart buttons
		if (!$this->input->is_ajax_request()) {
		   exit('No direct script access allowed');
		}
		if($_POST['action'] == 'add') {
			if(!isset($_SESSION['shopping_cart'])) $_SESSION['shopping_cart'] = array();
				@$_SESSION['shopping_cart'][] = (int)$_POST['article_id'];
		}
		if($_POST['action'] == 'remove') {
			if(($key = array_search($_POST['article_id'], $_SESSION['shopping_cart'])) !== false) {
				unset($_SESSION['shopping_cart'][$key]);
			}
		}
		@set_cookie('shopping_cart', serialize($_SESSION['shopping_cart']), 2678400); // 1 month expire time
		// get items from db and add him to cart from ajax
		$result = $this->getCartItems();
		loop_items($result, $this->currency, base_url($this->lang_link.'/'));
	}
}
