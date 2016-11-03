<?php

class Articles_model extends CI_Model
{

    public function __construct()
    {
        parent::__construct();
    }

    public function productsCount($lang = null, $big_get)
    {
        if ($lang != null) {
            $this->db->join('translations', 'translations.for_id = products.id', 'left');
            $this->db->where('translations.abbr', $lang);
            $this->db->where('translations.type', 'product');
        }
        if (!empty($big_get) && isset($big_get['category'])) {
            $this->getFilter($big_get);
        }
        $this->db->where('visibility', 1);
        return $this->db->count_all_results('products');
    }

    public function getProducts($lang, $limit = null, $start = null, $big_get)
    {
        if ($limit !== null && $start !== null) {
            $this->db->limit($limit, $start);
        }
        if (!empty($big_get) && isset($big_get['category'])) {
            $this->getFilter($big_get);
        }
        $this->db->select('products.id,products.image, products.quantity, translations.title, translations.price, translations.old_price, products.url');
        $this->db->join('translations', 'translations.for_id = products.id', 'left');
        $this->db->where('translations.abbr', $lang);
        $this->db->where('translations.type', 'product');
        $this->db->where('visibility', 1);
        // $this->db->where('in_slider', 0); Show slider products in categories


        $query = $this->db->get('products');
        return $query->result_array();
    }

    private function getFilter($big_get)
    {

        if ($big_get['category'] != '') {
            (int) $big_get['category'];
            $findInIds = array();
            $findInIds[] = $big_get['category'];
            $query = $this->db->query('SELECT id FROM shop_categories WHERE sub_for = ' . $big_get['category']);
            foreach ($query->result() as $row)
                $findInIds[] = $row->id;
            $this->db->where_in('products.shop_categorie', $findInIds);
        }
        if ($big_get['in_stock'] != '') {
            if ($big_get['in_stock'] == 1)
                $sign = '>';
            else
                $sign = '=';
            $this->db->where('products.quantity ' . $sign, '0');
        }
        if ($big_get['search_in_title'] != '') {
            $this->db->like('translations.title', $big_get['search_in_title']);
        }
        if ($big_get['search_in_body'] != '') {
            $this->db->like('translations.description', $big_get['search_in_body']);
        }
        if ($big_get['order_price'] != '') {
            $this->db->order_by('CAST(price AS DECIMAL(10.2)) ' . $big_get['order_price']);
        }
        if ($big_get['order_procurement'] != '') {
            $this->db->order_by('products.procurement', $big_get['order_procurement']);
        }
        if ($big_get['order_new'] != '') {
            $this->db->order_by('products.id', $big_get['order_new']);
        } else {
            $this->db->order_by('products.id', 'DESC');
        }
        if ($big_get['quantity_more'] != '') {
            $this->db->where('products.quantity > ', $big_get['quantity_more']);
        }
        if ($big_get['quantity_more'] != '') {
            $this->db->where('products.quantity > ', $big_get['quantity_more']);
        }
        if ($big_get['added_after'] != '') {
            $time = strtotime($big_get['added_after']);
            $this->db->where('products.time > ', $time);
        }
        if ($big_get['added_before'] != '') {
            $time = strtotime($big_get['added_before']);
            $this->db->where('products.time < ', $time);
        }
        if ($big_get['price_from'] != '') {
            $this->db->where('translations.price >= ', $big_get['price_from']);
        }
        if ($big_get['price_to'] != '') {
            $this->db->where('translations.price <= ', $big_get['price_to']);
        }
    }

    public function getShopCategories($lang)
    {
        $this->db->select('shop_categories.sub_for, shop_categories.id, translations.name');
        $this->db->where('abbr', $lang);
        $this->db->where('type', 'shop_categorie');
        $this->db->join('shop_categories', 'shop_categories.id = translations.for_id', 'INNER');
        $query = $this->db->get('translations');
        $arr = array();
        if ($query !== false) {
            foreach ($query->result_array() as $row) {
                $arr[] = $row;
            }
        }
        return $arr;
    }

    public function getSeo($page, $abbr)
    {
        $this->db->where('type', $page);
        $this->db->where('abbr', $abbr);
        $query = $this->db->get('translations');
        $arr = array();
        if ($query !== false) {
            foreach ($query->result_array() as $row) {
                $arr['title'] = $row['title'];
                $arr['description'] = $row['description'];
            }
        }
        return $arr;
    }

    public function getOneProduct($id, $lang)
    {
        $this->db->where('products.product_id', $id);

        $this->db->select('products.*, translations.title,translations.description, translations.price, translations.old_price, products.url, trans2.name as categorie_name');

        $this->db->join('translations', 'translations.for_id = products.id', 'left');
        $this->db->where('translations.abbr', $lang);
        $this->db->where('translations.type', 'product');

        $this->db->join('translations as trans2', 'trans2.for_id = products.shop_categorie', 'inner');
        $this->db->where('trans2.abbr', $lang);

        $this->db->where('visibility', 1);
        $query = $this->db->get('products');
        return $query->row_array();
    }

    public function getCountQuantities()
    {
        $query = $this->db->query('SELECT SUM(IF(quantity<=0,1,0)) as out_of_stock, SUM(IF(quantity>0,1,0)) as in_stock FROM products WHERE visibility = 1');
        return $query->row_array();
    }

    public function setToCart($post)
    {
        if (!is_numeric($post['article_id'])) {
            return false;
        }
        $query = $this->db->insert('shopping_cart', array(
            'session_id' => session_id(),
            'article_id' => $post['article_id'],
            'time' => time()
        ));
        return $query;
    }

    public function getShopItems($array_items, $lang)
    {
        $this->db->select('products.id, products.product_id, products.image, products.url, translations.price, translations.title');
        $this->db->from('products');
        if (count($array_items) > 1) {
            $i = 1;
            $where = '';
            foreach ($array_items as $id) {
                $i == 1 ? $open = '(' : $open = '';
                $i == count($array_items) ? $or = '' : $or = ' OR ';
                $where .= $open . 'products.id = ' . $id . $or;
                $i++;
            }
            $where .= ')';
            $this->db->where($where);
        } else {
            $this->db->where('products.id =', current($array_items));
        }
        $this->db->join('translations', 'translations.for_id = products.id', 'inner');
        $this->db->where('translations.abbr', $lang);
        $this->db->where('translations.type', 'product');
        $query = $this->db->get();
        return $query->result_array();
    }

    public function getNotifyUsers()
    { // users for notification by email
        $result = $this->db->query('SELECT email FROM users WHERE notify = 1');
        $arr = array();
        foreach ($result->result_array() as $email) {
            $arr[] = $email['email'];
        }
        return $arr;
    }

    public function setOrder($post)
    {
        $q = $this->db->query('SELECT MAX(order_id) as order_id FROM orders');
        $rr = $q->row_array();
        if ($rr['order_id'] == 0) {
            $rr['order_id'] = 1233;
        }
        $post['order_id'] = $rr['order_id'] + 1;

        $i = 0;
        $post['products'] = array();
        foreach ($post['product_id'] as $product) {
            $post['products'][$product] = $post['quantity'][$i];
            $i++;
        }
        unset($post['product_id'], $post['quantity']);
        $post['date'] = time();
        $post['products'] = serialize($post['products']);
        $result = $this->db->insert('orders', $post);
        if ($result == true) {
            return $post['order_id'];
        }
        return false;
    }

    public function getSliderProducts($lang)
    {
        $this->db->select('products.id, products.quantity, products.product_id, products.image, products.url, translations.price, translations.title, translations.basic_description, translations.old_price');
        $this->db->join('translations', 'translations.for_id = products.id', 'left');
        $this->db->where('translations.abbr', $lang);
        $this->db->where('translations.type', 'product');
        $this->db->where('visibility', 1);
        $this->db->where('in_slider', 1);
        $query = $this->db->get('products');
        return $query->result_array();
    }

    public function getbestSellers($lang, $categorie = 0, $noId = 0)
    { //best sellers and for categorie..
        $this->db->select('products.id, products.quantity, products.product_id, products.image, products.url, translations.price, translations.title, translations.old_price');
        $this->db->join('translations', 'translations.for_id = products.id', 'left');
        if ($noId > 0) {
            $this->db->where('products.id !=', $noId);
        }
        $this->db->where('translations.abbr', $lang);
        if ($categorie != 0) {
            $this->db->where('products.shop_categorie !=', $categorie);
        }
        $this->db->where('translations.type', 'product');
        $this->db->where('visibility', 1);
        $this->db->order_by('products.procurement', 'desc');
        $this->db->limit(5);
        $query = $this->db->get('products');
        return $query->result_array();
    }

    public function sameCagegoryProducts($lang, $categorie, $noId)
    { //same categorie products
        $this->db->select('products.id, products.quantity, products.product_id, products.image, products.url, translations.price, translations.title, translations.old_price');
        $this->db->join('translations', 'translations.for_id = products.id', 'left');
        $this->db->where('products.id !=', $noId);
        $this->db->where('products.shop_categorie =', $categorie);
        $this->db->where('translations.abbr', $lang);
        $this->db->where('translations.type', 'product');
        $this->db->where('visibility', 1);
        $this->db->order_by('products.id', 'desc');
        $this->db->limit(5);
        $query = $this->db->get('products');
        return $query->result_array();
    }

    public function getOnePost($lang, $id)
    {
        $this->db->select('translations.title, translations.description, blog_posts.image, blog_posts.time');
        $this->db->where('blog_posts.id', $id);
        $this->db->join('translations', 'translations.for_id = blog_posts.id', 'left');
        $this->db->where('translations.abbr', $lang);
        $query = $this->db->get('blog_posts');
        return $query->row_array();
    }

    public function getArchives()
    {
        $result = $this->db->query("SELECT DATE_FORMAT(FROM_UNIXTIME(time), '%M %Y') as month, MAX(time) as maxtime, MIN(time) as mintime FROM blog_posts GROUP BY MONTH(FROM_UNIXTIME(time))");
        if ($result->num_rows() > 0) {
            return $result->result_array();
        }
        return false;
    }

    public function getFooterCategories($lang)
    {
        $this->db->select('shop_categories.id, translations.name');
        $this->db->where('abbr', $lang);
        $this->db->where('shop_categories.sub_for =', 0);
        $this->db->where('type', 'shop_categorie');
        $this->db->join('shop_categories', 'shop_categories.id = translations.for_id', 'INNER');
        $this->db->limit(10);
        $query = $this->db->get('translations');
        $arr = array();
        if ($query !== false) {
            foreach ($query->result_array() as $row) {
                $arr[$row['id']] = $row['name'];
            }
        }
        return $arr;
    }

    public function setSubscribe($array)
    {
        $num = $this->db->where('email', $arr['email'])->count_all_results('subscribed');
        if ($num == 0) {
            $this->db->insert('subscribed', $array);
        }
    }

    public function getDynPagesLangs($dynPages, $forLang)
    {
        if (!empty($dynPages)) {
            $this->db->join('translations', 'translations.for_id = active_pages.id', 'left');
            $this->db->where_in('active_pages.name', $dynPages);
            $this->db->where('translations.abbr', $forLang);
            $this->db->where('translations.type', 'page');
            $result = $this->db->select('translations.name as lname, active_pages.name as pname')->get('active_pages');
            $ar = array();
            $i = 0;
            foreach ($result->result_array() as $arr) {
                $ar[$i]['lname'] = $arr['lname'];
                $ar[$i]['pname'] = $arr['pname'];
                $i++;
            }
            return $ar;
        } else
            return $dynPages;
    }

    public function getOnePage($page, $forLang)
    {
        $this->db->join('translations', 'translations.for_id = active_pages.id', 'left');
        $this->db->where('translations.abbr', $forLang);
        $this->db->where('translations.type', 'page');
        $this->db->where('active_pages.name', $page);
        $result = $this->db->select('translations.description as content, translations.name')->get('active_pages');
        return $result->row_array();
    }

    public function changePaypalOrderStatus($id, $status)
    {
        $processed = 0;
        if ($status == 'canceled') {
            $processed = 2;
        }
        $this->db->where('order_id', $id);
        $this->db->update('orders', array(
            'paypal_status' => $status,
            'processed' => $processed
        ));
    }

}
