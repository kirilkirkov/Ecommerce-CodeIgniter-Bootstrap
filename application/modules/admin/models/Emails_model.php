<?php

class Emails_model extends CI_Model
{

    public function __construct()
    {
        parent::__construct();
    }

    public function emailsCount()
    {
        return $this->db->count_all_results('subscribed');
    }

    public function getSuscribedEmails($limit, $page)
    {
        $this->db->order_by('id', 'desc');
        $query = $this->db->select('*')->get('subscribed', $limit, $page);
        return $query;
    }

    public function deleteEmail($id)
    {
        $this->db->where('id', $id)->delete('subscribed');
    }

}
