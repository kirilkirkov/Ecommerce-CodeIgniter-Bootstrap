<?php

class Products_model extends CI_Model
{

    public function __construct()
    {
        parent::__construct();
    }

    public function getOneProduct($id, $vendor_id)
    {
        $this->db->where('id', $id);
        $this->db->where('vendor_id', $vendor_id);
        $query = $this->db->get('products');
        if ($query->num_rows() > 0) {
            return $query->row_array();
        } else {
            return false;
        }
    }

    public function setProduct($post, $id = 0)
    {
        $this->db->trans_begin();
        $is_update = false;
        if ($id > 0) {
            $is_update = true;
            if (!$this->db->where('id', $id)->where('vendor_id', $post['vendor_id'])->update('products', array(
                        'image' => $post['image'] != null ? $_POST['image'] : @$_POST['old_image'],
                        'shop_categorie' => $post['shop_categorie'],
                        'quantity' => $post['quantity'],
                        'position' => $post['position'],
                        'brand_id' => isset($post['brand_id']) ? $post['brand_id'] : null,
                        'time_update' => time()
                    ))) {
                log_message('error', print_r($this->db->error(), true));
            }
        } else {
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
                        'position' => $post['position'],
                        'brand_id' => $post['brand_id'],
                        'folder' => $post['folder'],
                        'vendor_id' => $post['vendor_id'],
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
        }
        $this->setProductTranslation($post, $id, $is_update);
        if ($this->db->trans_status() === FALSE) {
            $this->db->trans_rollback();
            show_error(lang('database_error'));
            return false;
        } else {
            $this->db->trans_commit();
            return true;
        }
    }

    private function setProductTranslation($post, $id, $is_update = false)
    {
        $i = 0;
        $current_trans = $this->getTranslations($id, 'product');
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
                'description' => $post['description'][$i],
                'price' => $post['price'][$i],
                'old_price' => $post['old_price'][$i],
                'abbr' => $abbr,
                'for_id' => $id
            );
            if ($is_update === true && $emergency_insert === false) {
                $abbr = $arr['abbr'];
                unset($arr['for_id'], $arr['abbr'], $arr['url']);
                if (!$this->db->where('abbr', $abbr)->where('for_id', $id)->update('products_translations', $arr)) {
                    log_message('error', print_r($this->db->error(), true));
                }
            } else {
                if (!$this->db->insert('products_translations', $arr)) {
                    log_message('error', print_r($this->db->error(), true));
                }
            }
            $i++;
        }
    }

    public function getTranslations($id)
    {
        $this->db->where('for_id', $id);
        $query = $this->db->get('products_translations');
        $arr = array();
        foreach ($query->result() as $row) {
            $arr[$row->abbr]['title'] = $row->title;
            $arr[$row->abbr]['description'] = $row->description;
            $arr[$row->abbr]['price'] = $row->price;
            $arr[$row->abbr]['old_price'] = $row->old_price;
        }
        return $arr;
    }

    public function getProducts($limit, $page, $vendor_id)
    {
        $this->db->order_by('products.position', 'asc');
        $this->db->join('products_translations', 'products_translations.for_id = products.id', 'left');
        $this->db->where('products_translations.abbr', MY_DEFAULT_LANGUAGE_ABBR);
        $this->db->where('vendor_id', $vendor_id);
        $query = $this->db->select('products.*, products_translations.title, products_translations.description, products_translations.price')->get('products', $limit, $page);
        return $query->result();
    }

    public function productsCount($vendor_id)
    {
        $this->db->where('vendor_id', $vendor_id);
        return $this->db->count_all_results('products');
    }

    public function deleteProduct($id)
    {
        $this->db->trans_begin();

        $this->db->where('id', $id);
        $this->db->where('vendor_id', $vendor_id);
        if (!$this->db->delete('products')) {
            log_message('error', print_r($this->db->error(), true));
        } else {
            $this->db->where('for_id', $id);
            if (!$this->db->delete('products_translations')) {
                log_message('error', print_r($this->db->error(), true));
            }
        }
        if ($this->db->trans_status() === FALSE) {
            $this->db->trans_rollback();
            show_error(lang('database_error'));
        } else {
            $this->db->trans_commit();
        }
    }

}
