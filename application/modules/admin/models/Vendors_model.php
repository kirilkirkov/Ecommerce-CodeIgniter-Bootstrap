<?php

class Vendors_model extends CI_Model
{

    public function __construct()
    {
        parent::__construct();
    }

    public function getVendors($id = null)
    {
        if($id !== null && (int)$id > 0) {
            $this->db->where('id', $id);
        }
        $query = $this->db->get('vendors');
        return $query;
    }

    public function getVendorOrders($vendor_id)
    {
        $this->db->from('vendors');
        $this->db->where('vendors.id', $vendor_id);
        $this->db->join('vendors_orders', 'vendors_orders.vendor_id = vendors.id');
        $query = $this->db->get();
        return $query->result_array();
    }
}
