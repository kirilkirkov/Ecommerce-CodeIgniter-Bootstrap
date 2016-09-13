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
			if (in_array($_POST['article_id'], $_SESSION['shopping_cart'])) {
				 echo '1';
			 } else { // get item from db and add to cart from ajax
				 $result = $this->Articles_model->getShopItems(array(0=>$_POST['article_id']), $this->my_lang);
					 $newItem = '			  
				   <li class="shop-item" data-artticle-id="'.$result[0]['id'].'">
					<span class="num_added hidden">1</span>
					<div class="item">
						<div class="item-in">
							<div class="left-side">
							<img src="'.base_url('/attachments/shop_images/'.$result[0]['image']).'" alt="" />
							</div>
							 <div class="right-side">
							<a href="'.$result[0]['url'].'" class="item-info">
								<span>'.$result[0]['title'].'GOLD</span>
								<span class="prices">'.$result[0]['price'].'</span>
							<span class="currency">'.$this->currency.'</span>
							</a>
							</div>
						</div>
						<div class="item-x-absolute">
							<button class="btn btn-xs btn-danger pull-right" onclick="removeArticle('.$result[0]['id'].')">x</button>
						</div>
					</div>
				</li>
				  ';
				  echo $newItem;
			 }
			@$_SESSION['shopping_cart'][] = (int)$_POST['article_id'];
			@set_cookie('shopping_cart', serialize($_SESSION['shopping_cart']), 2678400); // 1 month expire time
		}
		if($_POST['action'] == 'remove') {
			if(($key = array_search($_POST['article_id'], $_SESSION['shopping_cart'])) !== false) {
				unset($_SESSION['shopping_cart'][$key]);
			}
		}
	}
}
