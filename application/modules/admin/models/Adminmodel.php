<?php

class AdminModel extends CI_Model
{

    public function loginCheck($values)
    {
        $arr = array(
            'username' => $values['username'],
            'password' => md5($values['password']),
        );
        $this->db->where($arr);
        $result = $this->db->get('users');
        $res_arr = $result->row_array();
        return $res_arr;
    }

    public function getMaxProductId()
    {
        $this->db->select_max('id');
        $result = $this->db->get('products');
        $obj = $result->row();
        return $obj->id;
    }

    public function productsCount($search = null)
    {
        if ($search !== null) {
            $search = $this->db->escape_like_str($search);
            $this->db->where("(translations.title LIKE '%$search%' OR translations.description LIKE '%$search%')");
        }
        $this->db->join('translations', 'translations.for_id = products.id', 'left');
        $this->db->where('translations.type', 'product');
        $this->db->where('translations.abbr', MY_DEFAULT_LANGUAGE_ABBR);
        return $this->db->count_all_results('products');
    }

    public function getLanguages()
    {
        $query = $this->db->query('SELECT * FROM languages');
        return $query;
    }

    public function getSeoPages()
    {
        $result = $this->db->get('seo_pages');
        return $result->result_array();
    }

    public function setSeoPageTranslations($translations)
    {
        $i = 0;
        foreach ($translations['pages'] as $page) {
            foreach ($translations['abbr'] as $abbr) {
                $this->db->where('type', 'page_' . $page);
                $this->db->where('abbr', $abbr);
                $num_rows = $this->db->count_all_results('translations');
                if ($num_rows == 0) {
                    $this->db->insert('translations', array(
                        'type' => 'page_' . $page,
                        'abbr' => $abbr,
                        'title' => $translations['title'][$i],
                        'description' => $translations['description'][$i]
                    ));
                } else {
                    $this->db->where('type', 'page_' . $page);
                    $this->db->where('abbr', $abbr);
                    $this->db->update('translations', array(
                        'title' => $translations['title'][$i],
                        'description' => $translations['description'][$i]
                    ));
                }
                $i++;
            }
        }
    }

    public function getSeoTranslations()
    {
        $this->db->like('type', 'page_');
        $result = $this->db->get('translations');
        $arr = array();
        foreach ($result->result_array() as $row) {
            $arr[$row['type']][$row['abbr']]['title'] = $row['title'];
            $arr[$row['type']][$row['abbr']]['description'] = $row['description'];
        }
        return $arr;
    }

    public function countLangs($name = null, $abbr = null)
    {
        if ($name != null)
            $this->db->where('name', $name);
        if ($abbr != null)
            $this->db->or_where('abbr', $abbr);
        return $this->db->count_all_results('languages');
    }

    public function getAdminUsers($id = null)
    {
        if ($id != null) {
            $this->db->where('id', $id);
        }
        $query = $this->db->query('SELECT * FROM users');
        if ($id != null)
            return $query->row_array();
        else
            return $query;
    }

    public function numShopProducts()
    {
        return $this->db->count_all_results('products');
    }

    public function setLanguage($post)
    {
        $post['name'] = strtolower($post['name']);
        $post['abbr'] = strtolower($post['abbr']);
        $result = $this->db->insert('languages', $post);
        return $result;
    }

    public function setAdminUser($post)
    {
        if ($post['edit'] > 0) {
            if (trim($post['password']) == '') {
                unset($post['password']);
            } else {
                $post['password'] = md5($post['password']);
            }
            $this->db->where('id', $post['edit']);
            unset($post['id'], $post['edit']);
            $result = $this->db->update('users', $post);
        } else {
            unset($post['edit']);
            $post['password'] = md5($post['password']);
            $result = $this->db->insert('users', $post);
        }
        return $result;
    }

    public function deleteLanguage($id)
    {
        $this->db->where('id', $id);
        $result = $this->db->delete('languages');
        return $result;
    }

    public function deleteAdminUser($id)
    {
        $this->db->where('id', $id);
        $result = $this->db->delete('users');
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

    public function setPage($name)
    {
        $name = strtolower($name);
        $name = str_replace(' ', '-', $name);
        $this->db->insert('active_pages', array('name' => $name, 'enabled' => 1));
        $thisId = $this->db->insert_id();
        $languages = $this->getLanguages();
        foreach ($languages->result() as $language) {
            $this->db->insert('translations', array(
                'type' => 'page',
                'for_id' => $thisId,
                'abbr' => $language->abbr
            ));
        }
    }

    public function deletePage($id)
    {
        $this->db->where('id', $id);
        $this->db->delete('active_pages');

        $this->db->where('for_id', $id);
        $this->db->where('type', 'page');
        $this->db->delete('translations');
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

    public function getShopCategories()
    {
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

    public function setShopCategorie($post)
    {
        $this->db->insert('shop_categories', array('sub_for' => $post['sub_for']));
        $id = $this->db->insert_id();

        $i = 0;
        foreach ($post['translations'] as $abbr) {
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

    public function editShopCategorieSub($post)
    {
        if ($post['editSubId'] != $post['newSubIs']) {
            $this->db->where('id', $post['editSubId']);
            $result = $this->db->update('shop_categories', array(
                'sub_for' => $post['newSubIs']
            ));
        } else {
            $result = false;
        }
        return $result;
    }

    public function deleteShopCategorie($id)
    {
        $this->db->where('for_id', $id);
        $this->db->where('type', 'shop_categorie');
        $this->db->delete('translations');

        $this->db->where('id', $id);
        $this->db->or_where('sub_for', $id);
        $result = $this->db->delete('shop_categories');
        return $result;
    }

    public function historyCount()
    {
        return $this->db->count_all_results('history');
    }

    public function ordersCount()
    {
        return $this->db->count_all_results('orders');
    }

    public function emailsCount()
    {
        return $this->db->count_all_results('subscribed');
    }

    public function setHistory($activity, $user)
    {
        $this->db->insert('history', array('activity' => $activity, 'username' => $user, 'time' => time()));
    }

    public function getHistory($limit, $page)
    {
        $this->db->order_by('id', 'desc');
        $query = $this->db->select('*')->get('history', $limit, $page);
        return $query;
    }

    public function getProducts($limit, $page, $search = null, $orderby = null)
    {
        if ($search !== null) {
            $search = $this->db->escape_like_str($search);
            $this->db->where("(translations.title LIKE '%$search%' OR translations.description LIKE '%$search%')");
        }
        if ($orderby !== null) {
            $ord = explode('=', $orderby);
            if (isset($ord[0]) && isset($ord[1])) {
                $this->db->order_by('products.' . $ord[0], $ord[1]);
            }
        } else {
            $this->db->order_by('products.id', 'desc');
        }
        $this->db->join('translations', 'translations.for_id = products.id', 'left');
        $this->db->where('translations.type', 'product');
        $this->db->where('translations.abbr', MY_DEFAULT_LANGUAGE_ABBR);
        $query = $this->db->select('products.*, translations.title, translations.description, translations.price, translations.old_price, translations.abbr, products.url, translations.for_id, translations.type, translations.basic_description')->get('products', $limit, $page);
        return $query;
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

    public function deleteproduct($id)
    {
        $this->deleteTranslations($id, 'product');
        $this->db->where('id', $id);
        $result = $this->db->delete('products');
        return $result;
    }

    private function deleteTranslations($id, $type)
    {
        $this->db->where('for_id', $id);
        $this->db->where('type', $type);
        $this->db->delete('translations');
    }

    public function getTranslations($id, $type)
    {
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

    public function setBlogTranslations($post, $id, $is_update)
    {
        $i = 0;
        $current_trans = $this->getTranslations($id, 'blog');
        foreach ($post['abbr'] as $abbr) {
            $arr = array();
            $emergency_insert = false;
            if (!isset($current_trans[$abbr])) {
                $emergency_insert = true;
            }
            $post['title'][$i] = str_replace('"', "'", $post['title'][$i]);
            $arr = array(
                'title' => $post['title'][$i],
                'description' => $post['description'][$i],
                'abbr' => $abbr,
                'for_id' => $id,
                'type' => 'blog'
            );
            if ($is_update === true && $emergency_insert === false) {
                $abbr = $arr['abbr'];
                unset($arr['for_id'], $arr['abbr'], $arr['url']);
                $this->db->where('abbr', $abbr)->where('for_id', $id)->where('type', 'blog')->update('translations', $arr);
            } else
                $this->db->insert('translations', $arr);
            $i++;
        }
    }

    public function setEditPageTranslations($post, $id)
    {
        $i = 0;
        foreach ($post['abbr'] as $abbr) {
            $arr = array(
                'name' => $post['name'][$i],
                'description' => $post['description'][$i]
            );
            $this->db->where('abbr', $abbr)->where('for_id', $id)->where('type', 'page')->update('translations', $arr);
            $i++;
        }
    }

    public function productStatusChange($id, $to_status)
    {
        $this->db->where('id', $id);
        $result = $this->db->update('products', array('visibility' => $to_status));
        return $result;
    }

    public function changeOrderStatus($id, $to_status)
    {
        $this->db->where('id', $id);
        $this->db->select('processed');
        $result1 = $this->db->get('orders');
        $res = $result1->row_array();

        if ($res['processed'] != $to_status) {
            $this->db->where('id', $id);
            $result = $this->db->update('orders', array('processed' => $to_status, 'viewed' => '1'));
            if ($result == true) {
                $this->manageQuantitiesAndProcurement($id, $to_status, $res['processed']);
            }
        } else {
            $result = false;
        }
        return $result;
    }

    private function manageQuantitiesAndProcurement($id, $to_status, $current)
    {
        if (($to_status == 0 || $to_status == 2) && $current == 1) {
            $operator = '+';
            $operator_pro = '-';
        }
        if ($to_status == 1) {
            $operator = '-';
            $operator_pro = '+';
        }
        $this->db->select('products');
        $this->db->where('id', $id);
        $result = $this->db->get('orders');
        $arr = $result->row_array();
        $products = unserialize($arr['products']);
        foreach ($products as $product_id => $quantity) {
            if (isset($operator))
                $this->db->query('UPDATE products SET quantity=quantity' . $operator . $quantity . ' WHERE id = ' . $product_id);
            if (isset($operator_pro))
                $this->db->query('UPDATE products SET procurement=procurement' . $operator_pro . $quantity . ' WHERE id = ' . $product_id);
        }
    }

    public function changePass($new_pass, $username)
    {
        $this->db->where('username', $username);
        $result = $this->db->update('users', array('password' => md5($new_pass)));
        return $result;
    }

    public function orders($limit, $page, $order_by)
    {
        if ($order_by != null) {
            $this->db->order_by($order_by, 'DESC');
        } else {
            $this->db->order_by('id', 'DESC');
        }
        $this->db->select('*');
        $result = $this->db->get('orders', $limit, $page);
        return $result->result_array();
    }

    public function getPages($active = null, $advanced = false)
    {
        if ($active != null) {
            $this->db->where('enabled', $active);
        }
        if ($advanced == false) {
            $this->db->select('name');
        } else {
            $this->db->select('*');
        }
        $result = $this->db->get('active_pages');
        if ($result != false) {
            $array = array();
            if ($advanced == false) {
                foreach ($result->result_array() as $arr)
                    $array[] = $arr['name'];
            } else {
                $array = $result->result_array();
            }
            return $array;
        }
    }

    public function getOnePageForEdit($pname)
    {
        $this->db->join('translations', 'translations.for_id = active_pages.id', 'left');
        $this->db->join('languages', 'translations.abbr = languages.abbr', 'left');
        $this->db->where('translations.type', 'page');
        $this->db->where('active_pages.enabled', 1);
        $this->db->where('active_pages.name', $pname);
        $query = $this->db->select('active_pages.id, translations.description, translations.abbr, translations.name, languages.name as lname, languages.flag')->get('active_pages');
        return $query->result_array();
    }

    public function getOnePost($id)
    {
        $query = $this->db->where('id', $id)->get('blog_posts');
        if ($query->num_rows() > 0) {
            return $query->row_array();
        } else {
            return false;
        }
    }

    public function setPost($post, $id)
    {
        if ($id > 0) {
            return $id;
        } else {
            $post['time'] = time();
            $title = str_replace('"', "'", $post['title']);
            unset($post['title']);
            $result = $this->db->insert('blog_posts', $post);
            $last_id = $this->db->insert_id();

            $arr = array();

            $arr['url'] = str_replace(' ', '-', except_letters($title)) . '_' . $last_id . '';
            $this->db->where('id', $last_id);
            $this->db->update('blog_posts', $arr);

            if ($result === true)
                $result = $last_id;
        }
        return $result;
    }

    public function postsCount($search = null)
    {
        if ($search !== null) {
            $this->db->like('translations.title', $search);
        }
        $this->db->join('translations', 'translations.for_id = blog_posts.id', 'left');
        $this->db->where('translations.abbr', MY_DEFAULT_LANGUAGE_ABBR);
        return $this->db->count_all_results('blog_posts');
    }

    public function getPosts($lang = null, $limit, $page, $search = null, $month = null)
    {
        if ($search !== null) {
            $search = $this->db->escape_like_str($search);
            $this->db->where("(translations.title LIKE '%$search%' OR translations.description LIKE '%$search%')");
        }
        if ($month !== null) {
            $from = $month['from'];
            $to = $month['to'];
            $this->db->where("time BETWEEN $from AND $to");
        }
        $this->db->join('translations', 'translations.for_id = blog_posts.id', 'left');
        $this->db->where('translations.type', 'blog');
        if ($lang == null) {
            $this->db->where('translations.abbr', MY_DEFAULT_LANGUAGE_ABBR);
        } else {
            $this->db->where('translations.abbr', $lang);
        }
        $query = $this->db->select('blog_posts.id, translations.title, translations.description, blog_posts.url, blog_posts.time, blog_posts.image')->get('blog_posts', $limit, $page);
        return $query->result_array();
    }

    public function deletePost($id)
    {
        $this->db->where('id', $id)->delete('blog_posts');
        $this->db->where('for_id', $id)->where('type', 'blog')->delete('translations');
    }

    public function changePageStatus($id, $to_status)
    {
        $result = $this->db->where('id', $id)->update('active_pages', array('enabled' => $to_status));
        return $result;
    }

    public function setValueStore($key, $value)
    {
        $this->db->where('thekey', $key);
        $query = $this->db->get('valueStore');
        if ($query->num_rows() > 0) {
            $this->db->where('thekey', $key);
            $this->db->update('valueStore', array('value' => $value));
        } else {
            $this->db->insert('valueStore', array('value' => $value, 'thekey' => $key));
        }
    }

    public function getValueStore($key)
    {
        $query = $this->db->query("SELECT value FROM valueStore WHERE thekey = '$key'");
        $img = $query->row_array();
        return $img['value'];
    }

    public function getSuscribedEmails($limit, $page)
    {
        $this->db->order_by('id', 'desc');
        $query = $this->db->select('*')->get('subscribed', $limit, $page);
        return $query;
    }

    public function deleteEmail($id)
    {
        $this->db->where('id', $id)->delete('subscribed');
    }

    public function newOrdersCheck()
    {
        $result = $this->db->query("SELECT count(id) as num FROM `orders` WHERE viewed = 0");
        $row = $result->row_array();
        return $row['num'];
    }

    public function setCookieLaw($post)
    {
        $query = $this->db->query('SELECT id FROM cookie_law');
        if ($query->num_rows() == 0) {
            $id = 1;
        } else {
            $result = $query->row_array();
            $id = $result['id'];
        }

        $this->db->replace('cookie_law', array(
            'id' => $id,
            'link' => $post['link'],
            'theme' => $post['theme'],
            'visibility' => $post['visibility']
        ));
        $for_id = $this->db->insert_id();

        $i = 0;
        foreach ($post['translations'] as $translate) {
            $this->db->replace('cookie_law_translations', array(
                'message' => htmlspecialchars($post['message'][$i]),
                'button_text' => htmlspecialchars($post['button_text'][$i]),
                'learn_more' => htmlspecialchars($post['learn_more'][$i]),
                'abbr' => $translate,
                'for_id' => $for_id
            ));
            $i++;
        }
    }

    public function getCookieLaw()
    {
        $arr = array('cookieInfo' => null, 'cookieTranslate' => null);
        $query = $this->db->query('SELECT * FROM cookie_law');
        if ($query->num_rows() > 0) {
            $arr['cookieInfo'] = $query->row_array();
            $query = $this->db->query('SELECT * FROM cookie_law_translations');
            $arrTrans = $query->result_array();
            foreach ($arrTrans as $trans) {
                $arr['cookieTranslate'][$trans['abbr']] = array(
                    'message' => $trans['message'],
                    'button_text' => $trans['button_text'],
                    'learn_more' => $trans['learn_more']
                );
            }
        }
        return $arr;
    }

    public function setBankAccountSettings($post)
    {
        $query = $this->db->query('SELECT id FROM bank_accounts');
        if ($query->num_rows() == 0) {
            $id = 1;
        } else {
            $result = $query->row_array();
            $id = $result['id'];
        }
        $post['id'] = $id;
        $this->db->replace('bank_accounts', $post);
    }

    public function getBankAccountSettings()
    {
        $result = $this->db->query("SELECT * FROM bank_accounts LIMIT 1");
        return $result->row_array();
    }

    public function getBrands()
    {
        $result = $this->db->get('brands');
        return $result->result_array();
    }

    public function setBrand($name)
    {
        $this->db->insert('brands', array('name' => $name));
    }

    public function deleteBrand($id)
    {
        $this->db->where('id', $id)->delete('brands');
    }

    public function editShopCategorie($post)
    {
        $this->db->where('abbr', $post['abbr']);
        $this->db->where('for_id', $post['for_id']);
        $this->db->where('type', $post['type']);
        $this->db->update('translations', array(
            'name' => $post['name']
        ));
    }

}
