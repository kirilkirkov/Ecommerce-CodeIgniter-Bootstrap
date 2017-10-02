<?php

class Textual_pages_model extends CI_Model
{

    public function __construct()
    {
        parent::__construct();
    }

    public function getOnePageForEdit($pname)
    {
        $this->db->join('textual_pages_tanslations', 'textual_pages_tanslations.for_id = active_pages.id', 'left');
        $this->db->join('languages', 'textual_pages_tanslations.abbr = languages.abbr', 'left'); 
        $this->db->where('active_pages.enabled', 1);
        $this->db->where('active_pages.name', $pname);
        $query = $this->db->select('active_pages.id, textual_pages_tanslations.description, textual_pages_tanslations.abbr, textual_pages_tanslations.name, languages.name as lname, languages.flag')->get('active_pages');
        return $query->result_array();
    }

    public function setEditPageTranslations($post)
    {
        $i = 0;
        foreach ($post['translations'] as $abbr) {
            $this->db->where('abbr', $abbr);
            $this->db->where('for_id', $post['pageId']); 
            if (!$this->db->update('textual_pages_tanslations', array(
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
