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
        $this->db->trans_begin();
        if (!$this->db->insert('active_pages', array('name' => $name, 'enabled' => 1))) {
            log_message('error', print_r($this->db->error(), true));
        }
        $thisId = $this->db->insert_id();
        $languages = $this->Languages_model->getLanguages();
        foreach ($languages as $language) {
            if (!$this->db->insert('textual_pages_tanslations', array(
                        'for_id' => $thisId,
                        'abbr' => $language->abbr
                    ))) {
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

    public function deletePage($id)
    {
        $this->db->trans_begin();
        $this->db->where('id', $id);
        if (!$this->db->delete('active_pages')) {
            log_message('error', print_r($this->db->error(), true));
        }

        $this->db->where('for_id', $id);
        if (!$this->db->delete('textual_pages_tanslations')) {
            log_message('error', print_r($this->db->error(), true));
        }

        if ($this->db->trans_status() === FALSE) {
            $this->db->trans_rollback();
            show_error(lang('database_error'));
        } else {
            $this->db->trans_commit();
        }
    }

}
