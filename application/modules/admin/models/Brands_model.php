<?php

class Brands_model extends CI_Model
{

    public function __construct()
    {
        parent::__construct();
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

}
