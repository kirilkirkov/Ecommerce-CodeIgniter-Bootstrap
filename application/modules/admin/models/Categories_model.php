<?php

class Categories_model extends CI_Model
{

    public function __construct()
    {
        parent::__construct();
    }

    public function categoriesCount()
    {
        return $this->db->count_all_results('shop_categories');
    }

    public function getShopCategories($limit = null, $start = null)
    {
        $limit_sql = '';
        if ($limit !== null && $start !== null) {
            $limit_sql = ' LIMIT ' . $start . ',' . $limit;
        }

        $query = $this->db->query('SELECT translations_first.*, (SELECT name FROM translations WHERE for_id = sub_for AND type="shop_categorie" AND abbr = translations_first.abbr) as sub_is, shop_categories.position FROM translations as translations_first INNER JOIN shop_categories ON shop_categories.id = translations_first.for_id WHERE type="shop_categorie" ORDER BY position ASC ' . $limit_sql);
        $arr = array();
        foreach ($query->result() as $shop_categorie) {
            $arr[$shop_categorie->for_id]['info'][] = array(
                'abbr' => $shop_categorie->abbr,
                'name' => $shop_categorie->name
            );
            $arr[$shop_categorie->for_id]['sub'][] = $shop_categorie->sub_is;
            $arr[$shop_categorie->for_id]['position'] = $shop_categorie->position;
        }
        return $arr;
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

    public function editShopCategorie($post)
    {
        $this->db->where('abbr', $post['abbr']);
        $this->db->where('for_id', $post['for_id']);
        $this->db->where('type', $post['type']);
        $this->db->update('translations', array(
            'name' => $post['name']
        ));
    }

    public function editShopCategoriePosition($post)
    {
        $this->db->where('id', $post['editid']);
        $result = $this->db->update('shop_categories', array(
            'position' => $post['new_pos']
        ));
    }

}
