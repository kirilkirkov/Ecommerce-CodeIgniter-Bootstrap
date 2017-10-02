<?php

class Titles_model extends CI_Model
{

    public function __construct()
    {
        parent::__construct();
    }

    public function setSeoPageTranslations($post)
    {
        $i = 0;
        foreach ($post['pages'] as $page) {
            foreach ($post['translations'] as $abbr) {
                $this->db->where('abbr', $abbr);
                $this->db->where('page_type', $page);
                $num_rows = $this->db->count_all_results('seo_pages_translations');
                if ($num_rows == 0) {
                    if (!$this->db->insert('seo_pages_translations', array(
                                'page_type' => $page,
                                'abbr' => $abbr,
                                'title' => $post['title'][$i],
                                'description' => $post['description'][$i]
                            ))) {
                        log_message('error', print_r($this->db->error(), true));
                        show_error(lang('database_error'));
                    }
                } else {
                    $this->db->where('abbr', $abbr);
                    $this->db->where('page_type', $page);
                    if (!$this->db->update('seo_pages_translations', array(
                                'title' => $post['title'][$i],
                                'description' => $post['description'][$i]
                            ))) {
                        log_message('error', print_r($this->db->error(), true));
                        show_error(lang('database_error'));
                    }
                }
                $i++;
            }
        }
    }

    public function getSeoTranslations()
    {
        $result = $this->db->get('seo_pages_translations');
        $arr = array();
        foreach ($result->result_array() as $row) {
            $arr[$row['page_type']][$row['abbr']]['title'] = $row['title'];
            $arr[$row['page_type']][$row['abbr']]['description'] = $row['description'];
        }
        return $arr;
    }

    public function getSeoPages()
    {
        $result = $this->db->get('seo_pages');
        return $result->result_array();
    }

}
