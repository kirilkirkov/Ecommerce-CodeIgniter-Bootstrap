<?php

class Settings_model extends CI_Model
{

    public function __construct()
    {
        parent::__construct();
    }

    public function getValueStores()
    {
        $query = $this->db->get('value_store');
        return $query->result_array();
    }

}
