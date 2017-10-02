<?php

/*
 * @Author:    Kiril Kirkov
 *  Gitgub:    https://github.com/kirilkirkov
 */
if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

class Titles extends ADMIN_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->model(array('Titles_model', 'Languages_model'));
    }

    public function index()
    {
        $this->login_check();
        $data = array();
        $head = array();
        $head['title'] = 'Administration - Titles / Descriptions';
        $head['description'] = '!';
        $head['keywords'] = '';

        if (isset($_POST['save'])) {
            $this->Titles_model->setSeoPageTranslations($_POST);
            $this->saveHistory('Changed Titles / Descriptions');
            $this->session->set_flashdata('result_publish', 'Saved successful!');
            redirect('admin/titles');
        }

        $data['seo_trans'] = $this->Titles_model->getSeoTranslations();
        $data['languages'] = $this->Languages_model->getLanguages();
        $data['seo_pages'] = $this->Titles_model->getSeoPages();
        $this->load->view('_parts/header', $head);
        $this->load->view('settings/titles', $data);
        $this->load->view('_parts/footer');
        $this->saveHistory('Go to Titles / Descriptions page');
    }

}
