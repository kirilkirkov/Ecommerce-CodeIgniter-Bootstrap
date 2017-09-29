<?php

class Products_model extends CI_Model
{

    public function __construct()
    {
        parent::__construct();
    }

    public function deleteProduct($id)
    {
        $this->db->where('for_id', $id);
        $this->db->where('type', 'product');
        $this->db->delete('translations');

        $this->db->where('id', $id);
        $result = $this->db->delete('products');
        return $result;
    }

    public function productsCount($search_title = null, $category = null)
    {
        if ($search_title != null) {
            $search_title = trim($this->db->escape_like_str($search_title));
            $this->db->where("(translations.title LIKE '%$search_title%')");
        }
        if ($category != null) {
            $this->db->where('shop_categorie', $category);
        }
        $this->db->join('translations', 'translations.for_id = products.id', 'left');
        $this->db->where('translations.type', 'product');
        $this->db->where('translations.abbr', MY_DEFAULT_LANGUAGE_ABBR);
        return $this->db->count_all_results('products');
    }

    public function getProducts($limit, $page, $search_title = null, $orderby = null, $category = null)
    {
        if ($search_title != null) {
            $search_title = trim($this->db->escape_like_str($search_title));
            $this->db->where("(translations.title LIKE '%$search_title%')");
        }
        if ($orderby !== null) {
            $ord = explode('=', $orderby);
            if (isset($ord[0]) && isset($ord[1])) {
                $this->db->order_by('products.' . $ord[0], $ord[1]);
            }
        } else {
            $this->db->order_by('products.position', 'asc');
        }
        if ($category != null) {
            $this->db->where('shop_categorie', $category);
        }
        $this->db->join('translations', 'translations.for_id = products.id', 'left');
        $this->db->where('translations.type', 'product');
        $this->db->where('translations.abbr', MY_DEFAULT_LANGUAGE_ABBR);
        $query = $this->db->select('products.*, translations.title, translations.description, translations.price, translations.old_price, translations.abbr, products.url, translations.for_id, translations.type, translations.basic_description')->get('products', $limit, $page);
        return $query;
    }

    public function numShopProducts()
    {
        return $this->db->count_all_results('products');
    }

    public function getOneProduct($id)
    {
        $this->db->where('id', $id);
        $query = $this->db->get('products');
        if ($query->num_rows() > 0) {
            return $query->row_array();
        } else {
            return false;
        }
    }

    public function productStatusChange($id, $to_status)
    {
        $this->db->where('id', $id);
        $result = $this->db->update('products', array('visibility' => $to_status));
        return $result;
    }

    public function setProduct($post, $id = 0)
    {
        if ($id > 0) {
            unset($post['title_for_url']);
            $post['time_update'] = time();
            $result = $this->db->where('id', $id)->update('products', $post);
        } else {
            if (trim($post['title_for_url']) != '') {
                $url_fr = except_letters($post['title_for_url']);
            } else {
                $url_fr = 'shop-product';
            }
            unset($post['title_for_url']);
            $this->db->select_max('id');
            $query = $this->db->get('products');
            $rr = $query->row_array();
            $post['id'] = $rr['id'] + 1;
            $post['url'] = str_replace(' ', '_', $url_fr . '_' . $post['id']);
            $post['time'] = time();
            unset($post['id']);
            $result = $this->db->insert('products', $post);
            $last_id = $this->db->insert_id();
        }
        if ($result == false)
            return false;
        else {
            if ($id > 0)
                return $id;
            else
                return $last_id;
        }
    }

    public function setProductTranslation($post, $id, $is_update)
    {
        $i = 0;
        $current_trans = $this->getTranslations($id, 'product');
        foreach ($post['abbr'] as $abbr) {
            $arr = array();
            $emergency_insert = false;
            if (!isset($current_trans[$abbr])) {
                $emergency_insert = true;
            }
            $post['title'][$i] = str_replace('"', "'", $post['title'][$i]);
            $post['price'][$i] = str_replace(' ', '', $post['price'][$i]);
            $post['price'][$i] = str_replace(',', '', $post['price'][$i]);
            $arr = array(
                'title' => $post['title'][$i],
                'basic_description' => $post['basic_description'][$i],
                'description' => $post['description'][$i],
                'price' => $post['price'][$i],
                'old_price' => $post['old_price'][$i],
                'abbr' => $abbr,
                'for_id' => $id,
                'type' => 'product'
            );
            if ($is_update === true && $emergency_insert === false) {
                $abbr = $arr['abbr'];
                unset($arr['for_id'], $arr['abbr'], $arr['url']);
                $this->db->where('abbr', $abbr)->where('for_id', $id)->where('type', 'product')->update('translations', $arr);
            } else
                $this->db->insert('translations', $arr);
            $i++;
        }
    }

}
