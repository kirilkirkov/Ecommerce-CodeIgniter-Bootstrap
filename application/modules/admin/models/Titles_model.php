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
                $this->db->where('type', 'page_' . $page);
                $this->db->where('abbr', $abbr);
                $num_rows = $this->db->count_all_results('translations');
                if ($num_rows == 0) {
                    if (!$this->db->insert('translations', array(
                                'type' => 'page_' . $page,
                                'abbr' => $abbr,
                                'title' => $post['title'][$i],
                                'description' => $post['description'][$i]
                            ))) {
                        log_message('error', print_r($this->db->error(), true));
                        show_error(lang('database_error'));
                    }
                } else {
                    $this->db->where('type', 'page_' . $page);
                    $this->db->where('abbr', $abbr);
                    if (!$this->db->update('translations', array(
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
        $this->db->like('type', 'page_');
        $result = $this->db->get('translations');
        $arr = array();
        foreach ($result->result_array() as $row) {
            $arr[$row['type']][$row['abbr']]['title'] = $row['title'];
            $arr[$row['type']][$row['abbr']]['description'] = $row['description'];
        }
        return $arr;
    }

    public function getSeoPages()
    {
        $result = $this->db->get('seo_pages');
        return $result->result_array();
    }

}
