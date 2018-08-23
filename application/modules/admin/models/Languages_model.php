<?php

class Languages_model extends CI_Model
{

    public function __construct()
    {
        parent::__construct();
    }

    public function deleteLanguage($id)
    {
        $this->db->select('abbr');
        $this->db->where('id', $id);
        $res = $this->db->get('languages');
        $row = $res->row_array();
        $this->db->trans_start();
        $this->db->query('DELETE FROM languages WHERE id = ' . $this->db->escape($id));
        $this->db->query('DELETE FROM products_translations WHERE abbr = "' . $row['abbr'] . '"');
        $this->db->query('DELETE FROM shop_categories_translations WHERE abbr = "' . $row['abbr'] . '"');
        $this->db->query('DELETE FROM textual_pages_tanslations WHERE abbr = "' . $row['abbr'] . '"');
        $this->db->query('DELETE FROM blog_translations WHERE abbr = "' . $row['abbr'] . '"');
        $this->db->query('DELETE FROM cookie_law_translations WHERE abbr = "' . $row['abbr'] . '"');
        $this->db->trans_complete();
        if ($this->db->trans_status() === FALSE) {
            return false;
        }
        return true;
    }

    public function countLangs($name = null, $abbr = null)
    {
        if ($name != null) {
            $this->db->where('name', $name);
        }
        if ($abbr != null) {
            $this->db->or_where('abbr', $abbr);
        }
        return $this->db->count_all_results('languages');
    }

    public function getLanguages()
    {
        $query = $this->db->query('SELECT * FROM languages');
        return $query->result();
    }

    public function setLanguage($post)
    {
        $post['name'] = strtolower($post['name']);
        $post['abbr'] = strtolower($post['abbr']);
        if (!$this->db->insert('languages', $post)) {
            log_message('error', print_r($this->db->error(), true));
            show_error(lang('database_error'));
        }
    }

}
