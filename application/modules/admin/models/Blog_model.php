<?php

class Blog_model extends CI_Model
{

    public function __construct()
    {
        parent::__construct();
    }

    public function deletePost($id)
    {
        $this->db->trans_begin();
        $this->db->where('id', $id)->delete('blog_posts');
        $this->db->where('for_id', $id)->where('type', 'blog')->delete('translations');
        if ($this->db->trans_status() === FALSE) {
            $this->db->trans_rollback();
            show_error(lang('database_error'));
        } else {
            $this->db->trans_commit();
        }
    }

    public function postsCount($search = null)
    {
        if ($search !== null) {
            $this->db->like('translations.title', $search);
        }
        $this->db->join('translations', 'translations.for_id = blog_posts.id', 'left');
        $this->db->where('translations.abbr', MY_DEFAULT_LANGUAGE_ABBR);
        return $this->db->count_all_results('blog_posts');
    }

    public function getPosts($lang = null, $limit, $page, $search = null, $month = null)
    {
        if ($search !== null) {
            $search = $this->db->escape_like_str($search);
            $this->db->where("(translations.title LIKE '%$search%' OR translations.description LIKE '%$search%')");
        }
        if ($month !== null) {
            $from = $month['from'];
            $to = $month['to'];
            $this->db->where("time BETWEEN $from AND $to");
        }
        $this->db->join('translations', 'translations.for_id = blog_posts.id', 'left');
        $this->db->where('translations.type', 'blog');
        if ($lang == null) {
            $this->db->where('translations.abbr', MY_DEFAULT_LANGUAGE_ABBR);
        } else {
            $this->db->where('translations.abbr', $lang);
        }
        $query = $this->db->select('blog_posts.id, translations.title, translations.description, blog_posts.url, blog_posts.time, blog_posts.image')->get('blog_posts', $limit, $page);
        return $query->result_array();
    }

    public function setPost($post, $id)
    {
        $this->db->trans_begin();
        $is_update = false;
        if ($id > 0) {
            $is_update = true;
            $this->db->where('id', $id);
            if (!$this->db->update('blog_posts', array(
                        'image' => $post['image'] != null ? $_POST['image'] : $_POST['old_image']
                    ))) {
                log_message('error', print_r($this->db->error(), true));
            }
        } else {
            /*
             * Lets get what is default tranlsation number
             * in titles and convert it to url
             * We want our plaform public ulrs to be in default 
             * language that we use
             */
            $i = 0;
            foreach ($_POST['translations'] as $translation) {
                if ($translation == MY_DEFAULT_LANGUAGE_ABBR) {
                    $myTranslationNum = $i;
                }
                $i++;
            }
            if (!$this->db->insert('blog_posts', array(
                        'image' => $post['image'],
                        'time' => time()
                    ))) {
                log_message('error', print_r($this->db->error(), true));
            }
            $id = $this->db->insert_id();
            if (!$this->db->update('blog_posts', array(
                        'url' => except_letters($_POST['title'][$myTranslationNum]) . '_' . $id
                    ))) {
                log_message('error', print_r($this->db->error(), true));
            }
        }
        $this->setBlogTranslations($post, $id, $is_update);
        if ($this->db->trans_status() === FALSE) {
            $this->db->trans_rollback();
            show_error(lang('database_error'));
        } else {
            $this->db->trans_commit();
        }
    }

    private function setBlogTranslations($post, $id, $is_update)
    {
        $i = 0;
        $current_trans = $this->Home_admin_model->getTranslations($id, 'blog');
        foreach ($post['translations'] as $abbr) {
            $arr = array();
            $emergency_insert = false;
            if (!isset($current_trans[$abbr])) {
                $emergency_insert = true;
            }
            $post['title'][$i] = str_replace('"', "'", $post['title'][$i]);
            $arr = array(
                'title' => $post['title'][$i],
                'description' => $post['description'][$i],
                'abbr' => $abbr,
                'for_id' => $id,
                'type' => 'blog'
            );
            if ($is_update === true && $emergency_insert === false) {
                $abbr = $arr['abbr'];
                unset($arr['for_id'], $arr['abbr'], $arr['url']);
                if (!$this->db->where('abbr', $abbr)->where('for_id', $id)->where('type', 'blog')->update('translations', $arr)) {
                    log_message('error', print_r($this->db->error(), true));
                }
            } else {
                if (!$this->db->insert('translations', $arr)) {
                    log_message('error', print_r($this->db->error(), true));
                }
            }
            $i++;
        }
    }

    public function getOnePost($id)
    {
        $query = $this->db->where('id', $id)->get('blog_posts');
        if ($query->num_rows() > 0) {
            return $query->row_array();
        } else {
            return false;
        }
    }

}
