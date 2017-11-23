<?php

class Auth_model extends CI_Model
{

    public function __construct()
    {
        parent::__construct();
    }

    public function registerVendor($post)
    {
        $input = array(
            'email' => trim($post['u_email']),
            'password' => password_hash($post['u_password'], PASSWORD_DEFAULT)
        );
        if (!$this->db->insert('vendors', $input)) {
            log_message('error', print_r($this->db->error(), true));
            show_error(lang('database_error'));
        }
    }

    public function countVendorsWithEmail($email)
    {
        $this->db->where('email', $email);
        return $this->db->count_all_results('vendors');
    }

    public function checkVendorExsists($post)
    {
        $this->db->where('email', $post['u_email']);
        $query = $this->db->get('vendors');
        $row = $query->row_array();
        if (empty($row) || !password_verify($post['u_password'], $row['password'])) {
            return false;
        }
        return true;
    }

}
