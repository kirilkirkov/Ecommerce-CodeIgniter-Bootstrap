<?php

/*
 * @Author:    Kiril Kirkov
 *  Gitgub:    https://github.com/kirilkirkov
 */
if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

class BlogPublish extends ADMIN_Controller
{

    public function index($id = 0)
    {
        $this->login_check();
        $trans_load = null;
        $is_update = false;
        if ($id > 0)
            $is_update = true;
        if ($id > 0 && $_POST == null) {
            $_POST = $this->AdminModel->getOnePost($id);
            $trans_load = $this->AdminModel->getTranslations($id, 'blog');
        }
        if (isset($_POST['submit'])) {
            unset($_POST['submit']);
            $config['upload_path'] = '.' . DIRECTORY_SEPARATOR . 'attachments' . DIRECTORY_SEPARATOR . 'blog_images' . DIRECTORY_SEPARATOR;
            $config['allowed_types'] = 'gif|jpg|png|jpeg';
            $this->load->library('upload', $config);
            $this->upload->initialize($config);
            if (!$this->upload->do_upload('userfile')) {
                log_message('error', 'Image Upload Error: ' . $this->upload->display_errors());
            }
            $img = $this->upload->data();
            if ($img['file_name'] != null) {
                $_POST['image'] = $img['file_name'];
            }
            $translations = array(
                'abbr' => $_POST['translations'],
                'title' => $_POST['title'],
                'description' => $_POST['description']
            );

            $flipped = array_flip($_POST['translations']);
            $_POST['title'] = $_POST['title'][$flipped[MY_DEFAULT_LANGUAGE_ABBR]];
            unset($_POST['description'], $_POST['translations']);
            $result = $this->AdminModel->setPost($_POST, $id);
            if ($result !== false) {
                $this->AdminModel->setBlogTranslations($translations, $result, $is_update);
                $this->session->set_flashdata('result_publish', 'Successful published!');
                redirect('admin/blog');
            } else {
                $this->session->set_flashdata('result_publish', 'Blog post publish error!');
            }
        }

        $data = array();
        $head = array();
        $data['id'] = $id;
        $head['title'] = 'Administration - Publish Blog Post';
        $head['description'] = '!';
        $head['keywords'] = '';
        $data['languages'] = $this->AdminModel->getLanguages();
        $data['trans_load'] = $trans_load;
        $this->load->view('_parts/header', $head);
        $this->load->view('blog/blogpublish', $data);
        $this->load->view('_parts/footer');
        $this->saveHistory('Go to Blog Publish');
    }

}
