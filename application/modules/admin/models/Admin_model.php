<?php

class Admin_model extends CI_Model {

    public function __construct() {
        parent::__construct();
        $this->def_lang = $this->config->item('language_abbr');
    }
    
    private $def_lang;

    public function loginCheck($values) {
        $arr = array(
            'username' => $values['username'],
            'password' => md5($values['password']),
        );
        $this->db->where($arr);
        $result = $this->db->get('users');
        $res_arr = $result->row_array();
        return $res_arr;
    }
	
	public function getMaxProductId() {
		$this->db->select_max('product_id');
		$result = $this->db->get('articles');
		$obj = $result->row();
		return $obj->product_id;
	}

    public function articlesCount($search = null, $category = null) {
        if ($search !== null) {
            $search = $this->db->escape_like_str($search);
           $this->db->where("(translations.title LIKE '%$search%' OR translations.description LIKE '%$search%')");
        }
        if ($category !== null) {
            $this->db->where('category', $category);
        }
		 $this->db->join('translations', 'translations.for_id = articles.id', 'left');
        return $this->db->count_all_results('articles');
    }

    public function getLanguages() {
        $query = $this->db->query('SELECT * FROM languages');
        return $query;
    }
	
    public function getUsers($id = null) {
		if($id != null) {
			$this->db->where('id', $id);
		}
        $query = $this->db->query('SELECT * FROM users');
		if($id != null) return $query->row_array(); else 
        return $query;
    }
    
    public function numShopArticles() {
    	$this->db->where('category', 'shop');
    	return $this->db->count_all_results('articles');
    }

    public function setLanguage($post) {
    	$post['name'] = strtolower($post['name']);
        $result = $this->db->insert('languages', $post);
        return $result;
    }
	
	public function setUser($post) {
		$post['password'] = md5($post['password']);
		if($post['edit'] > 0) {
			if(strlen(trim($post['password'])) < 3) {
				unset($post['password']);
			}
			$this->db->where('id', $post['edit']);
			unset($post['id'], $post['edit']);
			$result = $this->db->update('users', $post);
		} else {
        $result = $this->db->insert('users', $post);
		}
        return $result;
    }

    public function deleteLanguage($id) {
        $this->db->where('id', $id);
        $result = $this->db->delete('languages');
        return $result;
    }
	
    public function deleteUser($id) {
        $this->db->where('id', $id);
        $result = $this->db->delete('users');
        return $result;
    }

    public function setArticle($post, $id = 0) {
        if ($id > 0) {
            $post['time_update'] = time();
            $result = $this->db->where('id', $id)->update('articles', $post);
        } else {
			if($post['category'] == 'shop') {
				$this->db->select_max('product_id');
				$query = $this->db->get('articles');
				$rr = $query->row_array();
				$post['product_id'] = $rr['product_id']+1;
			}
            $post['time'] = time();
            $result = $this->db->insert('articles', $post);
            $last_id = $this->db->insert_id();
        }
       if($result==false) return false;
       else {
       	if($id>0) return $id;
       	else return $last_id;
       }
    }
    
    public function setTranslation($post, $id, $is_update, $is_shop) {
    	$i=0;
    	$current_trans = $this->getTranslations($id, 'article'); 
    	foreach($post['abbr'] as $abbr) {
    		$arr = array();
    		$emergency_insert = false;
    		if(!isset($current_trans[$abbr])) {
    			$emergency_insert = true;
    		}
    		$post['title'][$i] = str_replace('"', "'", $post['title'][$i]);
    		if(($abbr == 'en' || $abbr == 'bg') && trim($post['title'][$i]) != '') {
    			$url_fr = except_letters($post['title'][$i]);
    		} else {
    			$url_fr = 'shop-article'; 
    		}
    		if($is_shop) {
    			$url = str_replace(' ', '_', $url_fr . '_' . $id);
    		} else {
    			$url = str_replace(' ', '_', $url_fr . '_pageid_' . $id);
    		}
			$post['price'][$i] = str_replace(' ', '', $post['price'][$i]); 
			$post['price'][$i] = str_replace(',', '', $post['price'][$i]); 
    		$arr = array(
    			'title' => $post['title'][$i],
    			'basic_description' => $post['basic_description'][$i],
    			'description' => $post['description'][$i],
    			'price' => $post['price'][$i],
				'old_price' => $post['old_price'][$i],
    			'url' => $url,
    			'abbr' => $abbr,
    			'for_id' => $id,
    			'type' => 'article'
    		);
    		if($is_update === true && $emergency_insert === false) {
    			$abbr = $arr['abbr'];
    			unset($arr['for_id'], $arr['abbr'], $arr['url']);
    			$this->db->where('abbr', $abbr)->where('for_id', $id)->where('type', 'article')->update('translations', $arr);
    		}
    		else  $this->db->insert('translations', $arr);
    		$i++;
    	}
    }
    
    public function getShopCategories() {
    	$query = $this->db->query('SELECT translations_first.*, (SELECT name FROM translations WHERE for_id = sub_for AND type="shop_categorie" AND abbr = translations_first.abbr) as sub_is FROM translations as translations_first INNER JOIN shop_categories ON shop_categories.id = translations_first.for_id WHERE type="shop_categorie"');
    	$arr = array();
    	foreach ($query->result() as $shop_categorie) {
    		$arr[$shop_categorie->for_id]['info'][] = array(
    				'abbr' => $shop_categorie->abbr,
    				'name' => $shop_categorie->name
    		);
    		$arr[$shop_categorie->for_id]['sub'][] = $shop_categorie->sub_is;
    	}
    	return $arr;
    }
    
    public function setShopCategorie($post) {
    	$this->db->insert('shop_categories', array('sub_for' => $post['sub_for']));
    	$id = $this->db->insert_id();
    	
    	$i=0;
    	foreach($post['translations'] as $abbr) {
    		$arr = array();
    		$arr['abbr'] = $abbr;
    		$arr['type'] = 'shop_categorie';
    		$arr['name'] = $post['categorie_name'][$i];
    		$arr['for_id'] = $id;
    		$result = $this->db->insert('translations', $arr);
    		$i++;
    	}
    	return $result;
    }
    
    public function deleteShopCategorie($id) {
      $this->db->where('for_id', $id);
      $this->db->where('type', 'shop_categorie');
      $this->db->delete('translations');
      
      $this->db->where('id', $id);
      $this->db->or_where('sub_for', $id);
      $result = $this->db->delete('shop_categories');
      return $result;
    }

    public function historyCount() {
        return $this->db->count_all_results('history');
    }

    public function setHistory($activity, $user) {
        $this->db->insert('history', array('activity' => $activity, 'username' => $user, 'time' => time()));
    }

    public function getHistory($limit, $page) {
        $this->db->order_by('id', 'desc');
        $query = $this->db->select('*')->get('history', $limit, $page);
        return $query;
    }

    public function getArticles($limit, $page, $search = null, $category = null, $orderby = null) {
        if ($search !== null) {
            $search = $this->db->escape_like_str($search);
            $this->db->where("(translations.title LIKE '%$search%' OR translations.description LIKE '%$search%')");
        }
        if ($category !== null) {
            $this->db->where('articles.category', $category);
        }
        if ($orderby !== null) {
            $this->db->order_by('articles.id', $orderby);
        } else {
            $this->db->order_by('articles.id', 'desc');
        }
        $this->db->join('translations', 'translations.for_id = articles.id', 'left');
        $this->db->where('translations.type', 'article');
        $this->db->where('translations.abbr', $this->def_lang);
        $query = $this->db->select('articles.*, translations.title, translations.description, translations.price, translations.old_price, translations.abbr, translations.url, translations.for_id, translations.type, translations.basic_description')->get('articles', $limit, $page);
        return $query;
    }

    public function getCategories($lang = null) {
        if ($lang != null) {
            $where = " AND language = '$lang'";
        }
        $query = $this->db->query('SELECT categories.*, (SELECT COUNT(id) FROM articles WHERE articles.category = name) as num FROM `categories` WHERE categories.name != "shop" ORDER BY `id` DESC ');
        return $query;
    }

    public function getOneArticle($id) {
        $query = $this->db->where('id', $id)
                ->get('articles');
        if ($query->num_rows() > 0) {
            return $query->row_array();
        } else {
            return false;
        }
    }

    public function setCategorie($post) {
        $id = $post['id'];
        unset($post['id']);
        if ($id == 0) {
            $result = $this->db->insert('categories', $post);
        } else {
            if (isset($post['rename_all'])) {
                $this->db->where('category', $post['rename_all']);
                unset($post['rename_all']);
                $this->db->update('articles', array('category' => $post['name']));
            }
            $this->db->where('id', $id);
            $result = $this->db->update('categories', $post);
        }
        return $result;
    }

    public function deleteCategorie($id) {
        $this->db->where('id', $id);
        $result = $this->db->delete('categories');
        return $result;
    }

    public function deleteArticle($id) {
    	$this->deleteTranslations($id, 'article');
        $this->db->where('id', $id);
        $result = $this->db->delete('articles');
        return $result;
    }
    
    private function deleteTranslations($id, $type) {
    	$this->db->where('for_id', $id);
    	$this->db->where('type', $type);
    	$this->db->delete('translations');
    }
    
    public function getTranslations($id, $type) {
    	$this->db->where('for_id', $id);
    	$this->db->where('type', $type);
    	$query = $this->db->select('*')->get('translations');
    	$arr = array();
    	foreach ($query->result() as $row) { 
    		$arr[$row->abbr]['title'] = $row->title;
    		$arr[$row->abbr]['basic_description'] = $row->basic_description;
    		$arr[$row->abbr]['description'] = $row->description;
    		$arr[$row->abbr]['price'] = $row->price;
			$arr[$row->abbr]['old_price'] = $row->old_price;
    	}
    	return $arr;
    }

    public function articleStatusChagne($id, $to_status) {
        $this->db->where('id', $id);
        $result = $this->db->update('articles', array('visibility' => $to_status));
        return $result;
    }
	
	public function changeOrderStatus($id, $to_status) {
        $this->db->where('id', $id);
        $result = $this->db->update('orders_cash_on_delivery', array('processed' => $to_status));
		if($result == true) {
			$this->manageQuantitiesAndProcurement($id, $to_status);
		}
        return $result;
    }
	
	private function manageQuantitiesAndProcurement($id, $to_status) {
		if($to_status == 0) { $operator = '+'; $operator_pro = '-'; }
	    else { $operator = '-'; $operator_pro = '+'; }
		$this->db->select('products');
		$this->db->where('id', $id);
		$result = $this->db->get('orders_cash_on_delivery');
		$arr = $result->row_array();
		$products = unserialize($arr['products']);
		foreach($products as $product_id=>$quantity) {
			$this->db->query('UPDATE articles SET quantity=quantity'.$operator.$quantity.' WHERE product_id='.$product_id);
			$this->db->query('UPDATE articles SET procurement=procurement'.$operator_pro.$quantity.' WHERE product_id='.$product_id);
		}
	}

    public function changePass($new_pass, $username) {
        $this->db->where('username', $username);
        $result = $this->db->update('users', array('password' => md5($new_pass)));
        return $result;
    }
	
	public function getCashOnDeliveryOrders($order_by) {
		if($order_by != null) {
			if($order_by == 'id') $type = 'DESC'; else $type = 'ASC';
			$this->db->order_by($order_by, $type);
		}
		$this->db->select('*');
		$result = $this->db->get('orders_cash_on_delivery');
		return $result->result_array();
	}

}
