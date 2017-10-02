<?php

class Textual_pages_model extends CI_Model
{

    public function __construct()
    {
        parent::__construct();
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

    public function setEditPageTranslations($post)
    {
        $i = 0;
        foreach ($post['translations'] as $abbr) {
            $this->db->where('abbr', $abbr);
            $this->db->where('for_id', $post['pageId']);
            $this->db->where('type', 'page');
            if (!$this->db->update('translations', array(
                        'name' => $post['name'][$i],
                        'description' => $post['description'][$i]
                    ))) {
                log_message('error', print_r($this->db->error(), true));
                show_error(lang('database_error'));
            }
            $i++;
        }
    }

    public function changePageStatus($id, $to_status)
    {
        $result = $this->db->where('id', $id)->update('active_pages', array('enabled' => $to_status));
        return $result;
    }

}
