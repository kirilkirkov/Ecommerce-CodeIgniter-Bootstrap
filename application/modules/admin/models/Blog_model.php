<?php

class Blog_model extends CI_Model
{

    public function __construct()
    {
        parent::__construct();
    }

    public function deletePost($id)
    {
        $this->db->where('id', $id)->delete('blog_posts');
        $this->db->where('for_id', $id)->where('type', 'blog')->delete('translations');
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
        if ($id > 0) {
            return $id;
        } else {
            $post['time'] = time();
            $title = str_replace('"', "'", $post['title']);
            unset($post['title']);
            $result = $this->db->insert('blog_posts', $post);
            $last_id = $this->db->insert_id();

            $arr = array();

            $arr['url'] = str_replace(' ', '-', except_letters($title)) . '_' . $last_id . '';
            $this->db->where('id', $last_id);
            $this->db->update('blog_posts', $arr);

            if ($result === true)
                $result = $last_id;
        }
        return $result;
    }

    public function setBlogTranslations($post, $id, $is_update)
    {
        $i = 0;
        $current_trans = $this->getTranslations($id, 'blog');
        foreach ($post['abbr'] as $abbr) {
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
                $this->db->where('abbr', $abbr)->where('for_id', $id)->where('type', 'blog')->update('translations', $arr);
            } else
                $this->db->insert('translations', $arr);
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
