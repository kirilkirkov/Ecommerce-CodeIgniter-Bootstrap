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

    public function deleteVendor($id)
    {
        $this->db->where('id', $id);
        if (!$this->db->delete('vendors')) {
            log_message('error', print_r($this->db->error(), true));
            show_error(lang('database_error'));
        }
    }

    public function setVendor($post)
    {
        $data = array(
            'name' => $post['name'],
            'email' => $post['email'],
            'url' => $post['url']
        );
        if (trim($post['password']) != '') {
            $data['password'] = password_hash($post['password'], PASSWORD_DEFAULT);
        }
        $this->db->where('id', $post['edit']);
        if (!$this->db->update('vendors', $data)) {
            log_message('error', print_r($this->db->error(), true));
            show_error(lang('database_error'));
        }
    }
}
