<?php

class Articles_model extends CI_Model {

    public function __construct() {
        parent::__construct();
    }

    public function articlesCount($category, $lang = null) {
        if ($lang != null) {
            $this->db->join('translations', 'translations.for_id = articles.id', 'left');
            $this->db->where('translations.abbr', $lang);
            $this->db->where('translations.type', 'article');
        }
        
        $this->db->where('category', $category);
        $this->db->where('visibility', 1);
        return $this->db->count_all_results('articles');
    }

    public function getArticles($category, $lang, $limit = null, $start = null, $big_get) {
        if ($limit !== null && $start !== null) {
            $this->db->limit($limit, $start);
        }
		$this->db->select('articles.id,articles.image, articles.quantity, translations.title, translations.price, translations.old_price, translations.url');
		$this->db->join('translations', 'translations.for_id = articles.id', 'left');
		$this->db->where('translations.abbr', $lang);
		$this->db->where('translations.type', 'article');
        $this->db->where('category', $category);
        $this->db->where('visibility', 1);
		$this->db->where('in_slider', 0);
		
		if(!empty($big_get) && isset($big_get['category'])){
			if($big_get['category'] != '') {
				(int)$big_get['category'];
				$findInIds = array();
				$findInIds[] = $big_get['category'];
				$query = $this->db->query('SELECT id FROM shop_categories WHERE sub_for = ' . $big_get['category']);
				foreach ($query->result() as $row) $findInIds[] = $row->id;
				$this->db->where_in('articles.shop_categorie', $findInIds);
			}
			if($big_get['in_stock'] != '') {
				if($big_get['in_stock'] == 1) $sign = '>'; else $sign = '=';
				$this->db->where('articles.quantity '.$sign, '0');
			}
			if($big_get['search_in_title'] != '') {
				$this->db->like('translations.title', $big_get['search_in_title']);
			}
			if($big_get['search_in_body'] != '') {
				$this->db->like('translations.body', $big_get['search_in_body']);
			}
			if($big_get['order_new'] != '') {
				$this->db->order_by('articles.id', $big_get['order_new']);
			} else {
				$this->db->order_by('articles.id', 'DESC');
			}
			if($big_get['order_price'] != '') {
				$this->db->order_by('translations.price', $big_get['order_price']);
			}
			if($big_get['order_procurement'] != '') {
				$this->db->order_by('articles.procurement', $big_get['order_procurement']);
			}
			if($big_get['quantity_more'] != '') {
				$$this->db->where('articles.quantity > ', $big_get['quantity_more']);
			}
			if($big_get['quantity_more'] != '') {
				$$this->db->where('articles.quantity > ', $big_get['quantity_more']);
			}
			if($big_get['added_after'] != '') {
				$time = strtotime($big_get['added_after']);
				$$this->db->where('articles.time > ', $time);
			}
			if($big_get['added_before'] != '') {
				$time = strtotime($big_get['added_before']);
				$$this->db->where('articles.time < ', $time);
			}
			if($big_get['price_from'] != '') {
				$$this->db->where('translations.price >= ', $big_get['price_from']);
			}
			if($big_get['price_to'] != '') {
				$$this->db->where('translations.price <= ', $big_get['price_to']);
			}
		}				
		
        $query = $this->db->get('articles');
        return $query->result_array();
    }
    
    public function getShopCategories($abbr) {
    	$this->db->select('shop_categories.sub_for, shop_categories.id, translations.name');
    	$this->db->where('abbr', $abbr);
    	$this->db->where('type', 'shop_categorie');
    	$this->db->join('shop_categories', 'shop_categories.id = translations.for_id', 'INNER');
    	$query = $this->db->get('translations');
    	$arr = array();
    	if($query !== false) {
    		foreach($query->result_array() as $row){
    			$arr[] = $row;
    		}
    	}
    	return $arr;
    }

    public function getOneArticle($id, $lang) {
        if (is_numeric($id))
            $this->db->where('articles.id', $id);
        else
			$this->db->where('category', $id);
		
		$this->db->select('articles.*, translations.title,translations.description, translations.price, translations.old_price, translations.url, trans2.name as categorie_name');
		
		$this->db->join('translations', 'translations.for_id = articles.id', 'left');
		$this->db->where('translations.abbr', $lang);
		$this->db->where('translations.type', 'article');
		
		$this->db->join('translations as trans2', 'trans2.for_id = articles.shop_categorie', 'inner');
		$this->db->where('trans2.abbr', $lang);
  
        $this->db->where('visibility', 1);
        $query = $this->db->get('articles');
        return $query->row_array();
    }
    
    public function getCountQuantities() {
    	$query = $this->db->query('SELECT SUM(IF(quantity<=0,1,0)) as out_of_stock, SUM(IF(quantity>0,1,0)) as in_stock FROM articles WHERE visibility = 1');
    	return $query->row_array();
    }
	
	public function setToCart($post) {
		if(!is_numeric($post['article_id'])) {
			return false;
		}
		$query = $this->db->insert('shopping_cart', array(
			'session_id' => session_id(),
			'article_id' => $post['article_id'],
			'time' => time()
		));
		return $query;
	}
	
	public function getShopItems($array_items, $lang) {
		$this->db->select('articles.id, articles.product_id, articles.image, translations.url, translations.price, translations.title');
		$this->db->from('articles');
		if(count($array_items) > 1) {
			$i=1;
			$where = '';
			foreach($array_items as $id) {
				$i == 1 ? $open = '(' : $open = '';
				$i == count($array_items) ? $or = '' : $or = ' OR ';
				$where .= $open.'articles.id = '.$id.$or;
				$i++;
			}
			$where .= ')';
			$this->db->where($where);
		}else {
			$this->db->where('articles.id =', current($array_items));
		}
		$this->db->join('translations', 'translations.for_id = articles.id', 'inner');
		$this->db->where('translations.abbr', $lang);
        $query = $this->db->get();
        return $query->result_array();
	}
	
	public function getNotifyUsers() { // users for notification by email
		$result = $this->db->query('SELECT email FROM users WHERE notify = 1');
		$arr = array();
		foreach($result->result_array() as $email) {
			$arr[] = $email['email'];
		}
		return $arr;
	}
	
	public function setOrder($post) {
		if($post['payment_type'] == 1) { 
			$i = 0;
			$post['products'] = array();
			foreach($post['product_id'] as $product) {
				$post['products'][$product] = $post['quantity'][$i];
				$i++;
			}
			unset($post['product_id'], $post['payment_type'], $post['quantity']);
			$post['date'] = time();
			$post['products'] = serialize($post['products']);
			$this->db->insert('orders_cash_on_delivery', $post);
		}
	} 
	
	public function getSliderArticles($lang) { //Slider articles only
		$this->db->select('articles.id, articles.quantity, articles.product_id, articles.image, translations.url, translations.price, translations.title, translations.basic_description, translations.old_price');
		$this->db->join('translations', 'translations.for_id = articles.id', 'left');
		$this->db->where('translations.abbr', $lang);
		$this->db->where('translations.type', 'article');
        $this->db->where('visibility', 1);
		 $this->db->where('in_slider', 1);
        $query = $this->db->get('articles');
        return $query->result_array();
	}
	
	public function getbestSellers($lang, $categorie = 0) { //best sellers and for categorie..
		$this->db->select('articles.id, articles.quantity, articles.product_id, articles.image, translations.url, translations.price, translations.title, translations.old_price');
		$this->db->join('translations', 'translations.for_id = articles.id', 'left');
		$this->db->where('translations.abbr', $lang);
		$this->db->where('translations.type', 'article');
        $this->db->where('visibility', 1);
		$this->db->order_by('articles.procurement', 'desc');
		$this->db->limit(5);
        $query = $this->db->get('articles');
        return $query->result_array();
	}

}
