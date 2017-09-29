<?php

class Admin_users_model extends CI_Model
{

    public function __construct()
    {
        parent::__construct();
    }

    public function deleteAdminUser($id)
    {
        $this->db->where('id', $id);
        $result = $this->db->delete('users');
        return $result;
    }

    public function getAdminUsers($user = null)
    {
        if ($user != null && is_numeric($user)) {
            $this->db->where('id', $user);
        } else if ($user != null && is_string($user)) {
            $this->db->where('username', $user);
        }
        $query = $this->db->get('users');
        if ($user != null) {
            return $query->row_array();
        } else {
            return $query;
        }
    }

    public function setAdminUser($post)
    {
        if ($post['edit'] > 0) {
            if (trim($post['password']) == '') {
                unset($post['password']);
            } else {
                $post['password'] = md5($post['password']);
            }
            $this->db->where('id', $post['edit']);
            unset($post['id'], $post['edit']);
            $result = $this->db->update('users', $post);
        } else {
            unset($post['edit']);
            $post['password'] = md5($post['password']);
            $result = $this->db->insert('users', $post);
        }
        return $result;
    }

}
