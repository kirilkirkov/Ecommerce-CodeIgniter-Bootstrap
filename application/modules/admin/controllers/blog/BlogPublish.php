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

    public function __construct()
    {
        parent::__construct();
        $this->load->model(array('Blog_model', 'Languages_model'));
    }

    public function index($id = 0)
    {
        $this->login_check();
        $trans_load = null;
        if ($id > 0 && $_POST == null) {
            $_POST = $this->Blog_model->getOnePost($id);
            $trans_load = $this->Blog_model->getTranslations($id);
        }
        if (isset($_POST['submit'])) {
            $_POST['image'] = $this->uploadImage();
            $this->Blog_model->setPost($_POST, $id);
            $this->session->set_flashdata('result_publish', 'Successful published!');
            redirect('admin/blog');
        }
        $data = array();
        $head = array();
        $data['id'] = $id;
        $head['title'] = 'Administration - Publish Blog Post';
        $head['description'] = '!';
        $head['keywords'] = '';
        $data['languages'] = $this->Languages_model->getLanguages();
        $data['trans_load'] = $trans_load;
        $this->load->view('_parts/header', $head);
        $this->load->view('blog/blogpublish', $data);
        $this->load->view('_parts/footer');
        $this->saveHistory('Go to Blog Publish');
    }

    private function uploadImage()
    {
        $config['upload_path'] = '.' . DIRECTORY_SEPARATOR . 'attachments' . DIRECTORY_SEPARATOR . 'blog_images' . DIRECTORY_SEPARATOR;
        $config['allowed_types'] = 'gif|jpg|png|jpeg';
        $this->load->library('upload', $config);
        $this->upload->initialize($config);
        if (!$this->upload->do_upload('userfile')) {
            log_message('error', 'Image Upload Error: ' . $this->upload->display_errors());
        }
        $img = $this->upload->data();
        return $img['file_name'];
    }

}
