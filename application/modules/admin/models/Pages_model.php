<?php

class Pages_model extends CI_Model
{

    public function __construct()
    {
        parent::__construct();
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

    public function setPage($name)
    {
        $this->load->model('Languages_model');
        $name = strtolower($name);
        $name = str_replace(' ', '-', $name);
        $this->db->insert('active_pages', array('name' => $name, 'enabled' => 1));
        $thisId = $this->db->insert_id();
        $languages = $this->Languages_model->getLanguages();
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

}
