<?php

class Discounts_model extends CI_Model
{

    public function __construct()
    {
        parent::__construct();
    }

    public function getDiscountCodeInfo($id)
    {
        $this->db->where('id', $id);
        $result = $this->db->get('discount_codes');
        return $result->row_array();
    }

    public function changeCodeDiscountStatus($codeId, $toStatus)
    {
        $this->db->where('id', $codeId);
        if (!$this->db->update('discount_codes', array(
                    'status' => $toStatus
                ))) {
            log_message('error', print_r($this->db->error(), true));
            show_error(lang('database_error'));
        }
    }

    public function discountCodesCount()
    {
        return $this->db->count_all_results('discount_codes');
    }

    public function getDiscountCodes($limit, $page)
    {
        $result = $this->db->get('discount_codes', $limit, $page);
        return $result->result_array();
    }

    public function setDiscountCode($post)
    {
        if (!$this->db->insert('discount_codes', array(
                    'type' => $post['type'],
                    'code' => trim($post['code']),
                    'amount' => $post['amount'],
                    'valid_from_date' => strtotime($post['valid_from_date']),
                    'valid_to_date' => strtotime($post['valid_to_date'])
                ))) {
            log_message('error', print_r($this->db->error(), true));
            show_error(lang('database_error'));
        }
    }

    public function updateDiscountCode($post)
    {
        $this->db->where('id', $post['update']);
        if (!$this->db->update('discount_codes', array(
                    'type' => $post['type'],
                    'code' => trim($post['code']),
                    'amount' => $post['amount'],
                    'valid_from_date' => strtotime($post['valid_from_date']),
                    'valid_to_date' => strtotime($post['valid_to_date'])
                ))) {
            log_message('error', print_r($this->db->error(), true));
            show_error(lang('database_error'));
        }
    }

    public function discountCodeTakenCheck($post)
    {
        if ($post['update'] > 0) {
            $this->db->where('id !=', $post['update']);
        }
        $this->db->where('code', $post['code']);
        $num_rows = $this->db->count_all_results('discount_codes');
        if ($num_rows == 0) {
            return true;
        }
        return false;
    }

}
