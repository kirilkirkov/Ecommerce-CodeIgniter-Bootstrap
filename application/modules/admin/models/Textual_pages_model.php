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

    public function changePageStatus($id, $to_status)
    {
        $result = $this->db->where('id', $id)->update('active_pages', array('enabled' => $to_status));
        return $result;
    }

}
