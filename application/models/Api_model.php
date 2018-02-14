<?php

class Api_model extends CI_Model
{

    public function getProducts($lang)
    {
        $this->db->join('vendors', 'vendors.id = products.vendor_id', 'left');
        $this->db->join('products_translations', 'products_translations.for_id = products.id', 'left');
        $this->db->where('products_translations.abbr', $lang);
        $query = $this->db->select('vendors.name as vendor_name, vendors.id as vendor_id, products.id as product_id, products.image as product_image, products.time as product_time_created, products.time_update as product_time_updated, products.visibility as product_visibility, products.shop_categorie as product_category, products.quantity as product_quantity_available, products.procurement as product_procurement, products.url as product_url, products.virtual_products, products.brand_id as product_brand_id, products.position as product_position , products_translations.title, products_translations.description, products_translations.price, products_translations.old_price, products_translations.basic_description')->get('products');
        return $query->result_array();
    }

    public function getProduct($lang, $id)
    {
        $this->db->join('vendors', 'vendors.id = products.vendor_id', 'left');
        $this->db->join('products_translations', 'products_translations.for_id = products.id', 'left');
        $this->db->where('products_translations.abbr', $lang);
        $this->db->where('products.id', $id);
        $this->db->limit(1);
        $query = $this->db->select('vendors.name as vendor_name, vendors.id as vendor_id, products.id as product_id, products.image as product_image, products.time as product_time_created, products.time_update as product_time_updated, products.visibility as product_visibility, products.shop_categorie as product_category, products.quantity as product_quantity_available, products.procurement as product_procurement, products.url as product_url, products.virtual_products, products.brand_id as product_brand_id, products.position as product_position , products_translations.title, products_translations.description, products_translations.price, products_translations.old_price, products_translations.basic_description')->get('products');
        return $query->row_array();
    }

    public function setProduct($post)
    {
        if (!isset($post['brand_id'])) {
            $post['brand_id'] = null;
        }
        if (!isset($post['virtual_products'])) {
            $post['virtual_products'] = null;
        }
        $this->db->trans_begin();
        $i = 0;
        foreach ($_POST['translations'] as $translation) {
            if ($translation == MY_DEFAULT_LANGUAGE_ABBR) {
                $myTranslationNum = $i;
            }
            $i++;
        }
        if (!$this->db->insert('products', array(
                    'image' => $post['image'],
                    'shop_categorie' => $post['shop_categorie'],
                    'quantity' => $post['quantity'],
                    'in_slider' => $post['in_slider'],
                    'position' => $post['position'],
                    'virtual_products' => $post['virtual_products'],
                    'folder' => time(),
                    'brand_id' => $post['brand_id'],
                    'time' => time()
                ))) {
            log_message('error', print_r($this->db->error(), true));
        }
        $id = $this->db->insert_id();

        $this->db->where('id', $id);
        if (!$this->db->update('products', array(
                    'url' => except_letters($_POST['title'][$myTranslationNum]) . '_' . $id
                ))) {
            log_message('error', print_r($this->db->error(), true));
        }
        $this->setProductTranslation($post, $id);
        if ($this->db->trans_status() === FALSE) {
            $this->db->trans_rollback();
            return false;
        } else {
            $this->db->trans_commit();
            return true;
        }
    }

    private function setProductTranslation($post, $id)
    {
        $i = 0;
        $current_trans = $this->getTranslations($id);
        foreach ($post['translations'] as $abbr) {
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
                'for_id' => $id
            );

            if (!$this->db->insert('products_translations', $arr)) {
                log_message('error', print_r($this->db->error(), true));
            }
            $i++;
        }
    }

    private function getTranslations($id)
    {
        $this->db->where('for_id', $id);
        $query = $this->db->get('products_translations');
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

    public function deleteProduct($id)
    {
        $this->db->trans_begin();
        $this->db->where('for_id', $id);
        if (!$this->db->delete('products_translations')) {
            log_message('error', print_r($this->db->error(), true));
        }

        $this->db->where('id', $id);
        if (!$this->db->delete('products')) {
            log_message('error', print_r($this->db->error(), true));
        }
        if ($this->db->trans_status() === FALSE) {
            $this->db->trans_rollback();
        } else {
            $this->db->trans_commit();
        }
    }

}
